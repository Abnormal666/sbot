<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: server_hostname
#	DATE CREATED: 23/06/2018
#
##############################

class server_hostname
{
	
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$server_info = $ts->getElement('data',$ts->serverInfo());
		$count = 0;
		foreach ($clients as $client)
		{
			if($client['client_platform']!='ServerQuery' && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
				$count++;
		}
		$percent = floor(($count/$server_info['virtualserver_maxclients'])*100)."%";
		$ts->serverEdit(['virtualserver_name'=>str_replace(['[ONLINE]','[MAX]','[%]'],[$count,$server_info['virtualserver_maxclients'],$percent],$cfg['name'])]);
		unset($percent);
		
	}
	
}


?>