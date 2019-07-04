<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: auto_register
#	DATE CREATED: 23/06/2018
#
##############################

class auto_register
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($clients as $client)
		{
			if($client['client_type']!=1)
			{
				if(floor((time()-$client['client_lastconnected'])/60)>=$cfg['time_spent'] && !in_array($cfg['register_group'],explode(',',$client['client_servergroups'])) && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
				{
					$ts->serverGroupAddClient($cfg['register_group'],$client['client_database_id']);
					$ts->clientPoke($client['clid'],$lang['auto_register']['message']);
					$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] został zarejestrowany!');
				}
			}
		}
	}
}


?>