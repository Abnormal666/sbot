<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: client_levels
#	DATE CREATED: 30/06/2018
#
##############################

class client_levels
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$cl_level = [];
		$cl_level_delete= [];

		foreach($cfg['levels'] as $num => $more)
		{
			$sbot::check_ids($ts,$more['group_id'],'group','client_levels');
			foreach($clients as $client)
			{
				if($sbot::in_group($cfg['needed_groups'],$client['client_servergroups']) && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']) && $client['client_platform']!='ServerQuery')
				{
					$data = $db->query("SELECT * FROM `clients` WHERE `client_database_id`='".$client['client_database_id']."'")->fetch(PDO::FETCH_ASSOC);
					if($data['level']!=0 && !in_array($cfg['levels'][$data['level']]['group_id'], explode(',', $client['client_servergroups'])))
					{
						$ts->serverGroupAddClient($cfg['levels'][$data['level']]['group_id'],$client['client_database_id']);
					}
					if(($data['time_spent_level']/1000)>($more['time']*60) && !$sbot::in_group($cfg['ignored_groups'],$data['client_servergroups']) && $num==$data['level']+1)
					{
						$cl_level[$client['client_database_id']] = [
							'group_add' => $more['group_id'],
							'new_level' => $num,
							'clid' => $client['clid'],
							'old' => $num-1,
							'next' => ($cfg['levels'][$num+1]['time']?:'BRAK NASTĘPNEGO POZIOMU!'),
						];
						$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] awansował na kolejny poziom! [i]('.$num.')[/i]');
					}
					if(in_array($more['group_id'],explode(',', $client['client_servergroups'])) && $num!=$data['level'])
					{
						$cl_level_delete[$client['client_database_id']] = $more['group_id'];
					}
				}
			}
		}
		unset($num,$more,$client,$data);
		if(!empty($cl_level))
		{
			foreach($cl_level as $cldbid => $info)
			{
				$ts->serverGroupAddClient($info['group_add'],$cldbid);
				$db->query("UPDATE `clients` SET `level`='".$info['new_level']."', `time_spent_level`='0' WHERE client_database_id='".$cldbid."'");
				$ts->sendMessage(1,$info['clid'],str_replace(['[OLD_LEVEL]','[NEW_LEVEL]','[TIME_NEXT]'], [$info['old'],$info['new_level'],$info['next']], $lang['client_levels']['message']));
				if(isset($cfg['levels'][$info['old']]['group_id']))
					$ts->serverGroupDeleteClient($cfg['levels'][$info['old']]['group_id'],$cldbid);

			}
		}
		if(!empty($cl_level_delete))
		{
			foreach($cl_level_delete as $cldbid => $sgid)
				$ts->serverGroupDeleteClient($sgid,$cldbid);
		}
		unset($cl_level,$cl_level_delete);
	}
	
}



?>