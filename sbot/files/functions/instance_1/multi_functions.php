<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: online_from_group
#	DATE CREATED: 24/06/2018
#
##############################

class multi_functions
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$server_info = $ts->serverInfo()['data'];
		$count = 0;
		foreach ($clients as $client)
		{
			if($client['client_platform']!='ServerQuery' && !$sbot::in_group($cfg['functions']['online']['ignored_groups'],$client['client_servergroups']))
				$count++;
		}

		foreach($cfg['functions'] as $name => $more)
		{
			if($more['enabled'])
			{
				if($name=='online')
					$change = $count;
				else if($name=='packets')
					$change = floor($server_info['virtualserver_total_packetloss_total']).'%';
				else if($name=='ping')
					$change = floor($server_info['virtualserver_total_ping']).'ms';
				else if($name=='visits')
					$change = $server_info['virtualserver_client_connections'];
				else if($name=='channels')
					$change = $server_info['virtualserver_channelsonline'];
				else if($name=='clock')
					$change = date($more['format']);
				else if($name=='date')
					$change = date($more['format']);
				else if($name=='uptime')
					$change = $sbot::convert_time($server_info['virtualserver_uptime'],true,true);
				else
					$change = '????';

				$ts->channelEdit($more['channel_id'],['channel_name'=>str_replace('[CHANGE]',$change,$more['channel_name'])]);
			}
		}
		unset($server_info,$count,$name,$more,$change,$client);
	}
}

?>