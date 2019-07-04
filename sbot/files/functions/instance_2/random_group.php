<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: random_group
#	DATE CREATED: 11/07/2018
#
##############################

class random_group
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','last_actions');
		$sbot::check_ids($ts,$cfg['group_award_id'],'group','random_group');
		#$desc = '[center][size=20][b]Ostatnio wylosowane osoby[/b][/size][/center][size=10]\n';
		$desc = $descriptions['random_group']['header'];
		$count = 0;
		foreach(array_reverse($db->query("SELECT * FROM `random_group`")->fetchAll(PDO::FETCH_ASSOC)) as $user)
		{
			if(isset($user['client_nickname']) && $count++<=$cfg['view_in_desc'])
			{
				$desc .= str_replace(['[CLIENT_URL]','[WIN_DATE]'], ['[url=client://0/'.$user['client_unique_identifier'].']'.$user['client_nickname'].'[/url]', $user['date_get']], $descriptions['random_group']['client_row']);
			}
		}
		$desc .= '[/size]'.$lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc]);

		foreach($db->query("SELECT * FROM `random_group`")->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			if($row['date_get']==date('d/m/Y'))
				return;
		}
		foreach($clients as $clientt)
		{
			$row = $db->query("SELECT * FROM `random_group` ORDER BY `last_win` DESC");
			foreach($row->fetchAll(PDO::FETCH_ASSOC) as $data)
			{
				if($data['last_win']==1 && $clientt['client_database_id']==$data['client_database_id'])
				{
					if($data['time_remove']>time())
					{
						return;
					}
					if(in_array($cfg['group_award_id'],explode(',', $clientt['client_servergroups'])) && ($data['date_get']!=date('d/m/Y')) && ($data['time_remove']<time()))
					{
						$ts->serverGroupDeleteClient($cfg['group_award_id'],$clientt['client_database_id']);
						$db->query("UPDATE `random_group` SET `last_win`='0' WHERE `client_database_id`='".$clientt['client_database_id']."'");
						break;
					}
				}
			}
		}

		$i = rand(0,count($clients)-1);
		$client= $clients[$i];
		if(!($sbot::in_group($cfg['needed_groups'],$client['client_servergroups']) && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups'])))
		{
			$i = rand(0,count($clients)-1);
			$client= $clients[$i];
		}
		if($client['client_database_id']==1)
		{
			$i = rand(0,count($clients)-1);
			$client= $clients[$i];
		}

		if($clientt['client_database_id']!=$client['client_database_id'])
		{
			$ts->serverGroupAddClient($cfg['group_award_id'],$client['client_database_id']);
			$db->prepare("INSERT INTO `random_group` (`client_database_id`,`client_unique_identifier`,`client_nickname`,`date_get`,`time_remove`,`last_win`) VALUES (:cldbid,:cluid,:clnick,:date,:time_to_remove,:last)")->execute([
				'cldbid' => $client['client_database_id'],
				'cluid' => $client['client_unique_identifier'],
				'clnick' => $client['client_nickname'],
				'date' => date('d/m/Y'),
				'time_to_remove' => strtotime(($cfg['for_time']==1 ? '1 day' : $cfg['for_time'].' days')),
				'last' => 1,
			]);
			$ts->sendMessage(1,$client['clid'],$lang['random_group']['message_get']);
			$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] został wylosowany i otrzymał nagrodę!');
		}
		unset($clientt,$client,$user,$check,$row,$data,$desc,$count);
	}
}


?>