<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: get_clients
#	DATE CREATED: 28/06/2018
#
##############################

class get_clients
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($clients as $client)
		{
			if($client['client_platform']!='ServerQuery')
			{
				$check = $db->query("SELECT * FROM `clients` WHERE `client_database_id`='".$client['client_database_id']."'");
				if($check->rowCount()<=0)
				{
					$client_info = $ts->getElement('data',$ts->clientInfo($client['clid']));
					$db->prepare("INSERT INTO `clients` (client_database_id,client_unique_identifier,client_nickname,time_spent,connections,connection_time,idle_time,time_spent_level,level,client_servergroups,points,points_time,last_nicks) VALUES (:cldbid,:cluid,:clnick,:timespent,:conn,:conntime,:idletime,:timespentlevel,:level,:client_servergroups,:points,:points_time,:last_nicks)")->execute([
						'cldbid' => $client['client_database_id'],
						'cluid' => $client['client_unique_identifier'],
						'clnick' => $client['client_nickname'],
						'timespent' => 0,
						'conn' => $client_info['client_totalconnections'],
						'conntime' => 0,
						'idletime' => 0,
						'timespentlevel' => 0,
						'level' => 0,
						'client_servergroups' => $client_info['client_servergroups'],
						'points' => 0,
						'points_time' => 0,
						'last_nicks' => '',
					]);
				}
				else
				{
					$row = $check->fetch(PDO::FETCH_ASSOC);
					$client_info = $ts->getElement('data',$ts->clientInfo($client['clid']));
					$cldbid = $client['client_database_id'];
					$connection_time = $client_info['connection_connected_time'];
					$connections = $client_info['client_totalconnections'];
					$server_groups = $client_info['client_servergroups'];

					if($row['connections']<$connections)
						$db->query("UPDATE `clients` SET `connections`='$connections' WHERE `client_database_id`=$cldbid");

					if($row['connection_time']<$connection_time)
						$db->query("UPDATE `clients` SET `connection_time`='$connection_time' WHERE `client_database_id`=$cldbid");

					$time_spent = $row['time_spent']+($sbot::interval($cfg['interval'])*1000);
					$db->query("UPDATE `clients` SET `time_spent`='$time_spent' WHERE `client_database_id`='$cldbid'");

					$points_time = $row['points_time']+($sbot::interval($cfg['interval'])*1000);
					$db->query("UPDATE `clients` SET `points_time`='$points_time' WHERE `client_database_id`='$cldbid'");

					$time_spent_level = $row['time_spent_level']+($sbot::interval($cfg['interval'])*1000);
					$db->query("UPDATE `clients` SET `time_spent_level`='$time_spent_level' WHERE `client_database_id`='$cldbid'");

					if(($client_info['client_away']==1) || ($client_info['client_idle_time'] >= 1800000) || ($client_info['client_output_muted']==1))
					{
						$idle_time = $row['idle_time']+($sbot::interval($cfg['interval'])*1000);
						$db->query("UPDATE `clients` SET `idle_time`='$idle_time' WHERE `client_database_id`='$cldbid'");
					}

					if($client_info['client_nickname']!=$row['client_nickname'])
					{
						$last = json_decode($row['last_nicks'],1);
						if((is_array($last) && count($last)>=10) || $last=='')
						{
							$last = [];
						}
						$db->query("UPDATE `clients` SET `client_nickname`='".$client_info['client_nickname']."' WHERE `client_database_id`='$cldbid'");
						$last[] = $client_info['client_nickname'];
						$db->query("UPDATE `clients` SET `last_nicks`='".json_encode($last)."' WHERE `client_database_id`='$cldbid'");
						unset($last);
					}

					if($row['client_servergroups']!=$server_groups)
					{
						$db->query("UPDATE `clients` SET `client_servergroups`='$server_groups' WHERE `client_database_id`='$cldbid'");
					}
				}
			}
		}
		unset($row,$client_info,$cldbid,$connections,$connection_time,$time_spent,$time_spent_level,$check,$points_time);
	}

	private function in_group($groups,$cl)
	{
		foreach($groups as $group)
		{
			if(in_array($group, explode(',',$cl)))
			{
				return true;
			}
		}
		return false;
	}
	
}



?>