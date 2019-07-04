<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: new_clients_today
#	DATE CREATED: 11/07/2018
#
##############################

class new_clients_today
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','last_actions');
		foreach($clients as $client)
		{
			if(date('d/m/Y',$client['client_created'])==date('d/m/Y'))
			{
				$check = $db->query("SELECT * FROM `new_clients_today` WHERE `client_database_id`='".$client['client_database_id']."'");
				if($check->rowCount()<=0)
				{
					$db->prepare("INSERT INTO `new_clients_today` (client_database_id,client_nickname,client_unique_identifier,date) VALUES (:cldbid,:clnick,:cluid,:date)")->execute([
						'cldbid' => $client['client_database_id'],
						'clnick' => $client['client_nickname'],
						'cluid' => $client['client_unique_identifier'],
						'date' => date('d/m/Y'),
					]);
				}
				unset($check);
			}
		}
		foreach($db->query("SELECT * FROM `new_clients_today`")->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			if($row['date']!=date('d/m/Y'))
			{
				$db->query("DELETE FROM `new_clients_today` WHERE `client_database_id`='".$row['client_database_id']."'");
			}
		}

		#$desc = '[center][size=20][b]Lista nowych użytkowników[/b][/size][/center][size=11]\n';
		$desc = $descriptions['new_clients_today']['header'];
		$count =0;
		$data = $db->query("SELECT * FROM `new_clients_today`")->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($data))
		{
			foreach($data as $client)
			{
				$desc .= str_replace('[CLIENT_URL]', '[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url]', $descriptions['new_clients_today']['client_row']);
				$count++;
			}
		}
		else
		{
			$desc .= $descriptions['new_clients_today']['empty_list'];
		}
		
		$desc .= '[/size]'.$lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc,'channel_name'=>str_replace('[COUNT]', $count, $cfg['channel_name'])]);
	}
	
}



?>