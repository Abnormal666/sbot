<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: server_hostmessage
#	DATE CREATED: 23/06/2018
#
##############################

class server_hostmessage
{
	
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$count = 0;
		foreach ($clients as $client)
		{
			if($client['client_platform']!='ServerQuery' && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
				$count++;
		}
		$ts->serverEdit(['virtualserver_hostmessage'=>self::replace($cfg['message'],$ts,$sbot,$count)]);
	}

	private function replace($msg,$ts,$sbot,$count)
	{
		$server_info = $ts->getElement('data',$ts->serverInfo());
		$replace = [
			'[ONLINE]' => $count,
			'[MAX]' => $server_info['virtualserver_maxclients'],
			'[UPTIME]' => $sbot::convert_time($server_info['virtualserver_uptime'],true,true),
			'[RECORD]' => explode('-',file_get_contents('files/cache/record.txt'))[0],
		];
		unset($server_info);
		return str_replace(array_keys($replace), array_values($replace), $msg);
	}
	
}


?>