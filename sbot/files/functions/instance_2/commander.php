<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: commander
#	DATE CREATED: 06/10/2018
#
##############################

class commander
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($clients as $client)
		{
			if(!$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']) && $sbot::in_group($cfg['admin_groups'],$client['client_servergroups']) && $client['client_is_channel_commander']==0)
			{
				$ts->clientPoke($client['clid'],$lang['commander']['off_channel_commander']);
			}
		}
	}
	
}



?>