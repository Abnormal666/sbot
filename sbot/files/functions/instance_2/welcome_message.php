<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: welcome_message
#	DATE CREATED: 26/06/2018
#
##############################

class welcome_message
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		global $diff;
		
		if(!empty($diff))
		{
			foreach($diff as $clid)
			{
				foreach($cfg['messages'] as $msg)
				{
					$ts->sendMessage(1,$clid,self::replace($msg,$clid,$ts,$sbot,$db,$cfg['ignored_groups']));
				}
			}
		}
	}
	
	private function replace($msg,$clid,$ts,$sbot,$db,$ginored)
	{
		$server_info = $ts->getElement('data',$ts->serverInfo());

		$online = 0;
		foreach ($ts->clientList('-info -groups')['data'] as $client)
		{
			if($client['client_platform']!='ServerQuery' && !$sbot::in_group($ginored,$client['client_servergroups']))
				$online++;
		}
		unset($client);
		//$online = $server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'];
		$slots = $server_info['virtualserver_maxclients'];
		$percent = floor((($online/$slots)*100))."%";

		$client = $ts->getElement('data',$ts->clientInfo($clid));
		$record = explode('-',file_get_contents('files/cache/record.txt'));

		$data = $db->query("SELECT * FROM `clients` WHERE `client_database_id`='".$client['client_database_id']."'")->fetch(PDO::FETCH_ASSOC);

		$replace = [
			// CLIENT
			'[NICKNAME]' => $client['client_nickname'],
			'[UID]' => $client['client_unique_identifier'],
			'[IP]' => $client['connection_client_ip'],
			'[PLATFORM]' => $client['client_platform'],
			'[VERSION]' => $client['client_version'],
			'[DBID]' => $client['client_database_id'],
			'[LASTCONNECTED]' => $sbot::convert_time($client['client_lastconnected']/1000),
			'[ONLINE_FOR]' => $sbot::convert_time($client['client_lastconnected'] - $client['client_created']),
			'[CREATED]' => date('d/m/Y G:i:s',$client['client_created']),
			'[COUNTY]' => $client['client_country'],
			'[TOTAL_CONNECTIONS]' => $client['client_totalconnections'],
			
			// FROM DATABASE/FILE
			'[TIME_SPENT]' => ($data['time_spent']!=0 ? $sbot::convert_time($data['time_spent']/1000) : 'Brak danych'),
			'[TIME_IDLE]' => ($data['idle_time']!=0 ? $sbot::convert_time($data['idle_time']/1000) : 'Brak danych'),
			'[TIME_CONNECTED]' => ($data['connection_time']!=0 ? $sbot::convert_time($data['connection_time']/1000) : 'Brak danych'),
			'[LEVEL]' => ($data['level']!=0 ? $data['level'] : '0'),
			'[RECORD]' => $record[0],
			'[RECORD_DATE]' => $record[1],
			
			// SERVER
			'[SERVER_NAME]' => $server_info['virtualserver_name'],
			'[ONLINE]' => $online,
			'[%]' => $percent,
			'[SLOTS]' => $slots,
			'[SERVER_VERSION]' => $server_info['virtualserver_version'],
			'[SERVER_PORT]' => $server_info['virtualserver_port'],
			'[SERVER_ID]' => $server_info['virtualserver_id'],
			'[SERVER_PLATFORM]' => $server_info['virtualserver_platform'],
			'[SERVER_UPTIME]' => $sbot::convert_time($server_info['virtualserver_uptime'],true,true),
			'[SERVER_UID]' => $server_info['virtualserver_unique_identifier'],
		];
		unset($slots,$online,$percent,$server_info,$client,$record,$data);
		return str_replace(array_keys($replace),array_values($replace),$msg);
	}
	
}


?>