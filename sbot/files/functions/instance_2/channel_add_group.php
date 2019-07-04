<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: channel_add_group
#	DATE CREATED: 24/06/2018
#
##############################

class channel_add_group
{
	function __construct($ts,$cfg,$sbot,$lang,$client,$db)
	{
		$more = $cfg['channels'][$client['cid']];
		$sbot::check_ids($ts,$more['group_id'],'group','channel_add_group');
		if(in_array($more['group_id'],explode(',',$client['client_servergroups'])) && $more['remove'])
		{
			$ts->serverGroupDeleteClient($more['group_id'],$client['client_database_id']);
			$ts->clientKick($client['clid'],'channel');
			$ts->clientPoke($client['clid'],$lang['channel_add_group']['group_removed']);
		}
		
		if(!in_array($more['group_id'],explode(',',$client['client_servergroups'])))
		{
			$ts->serverGroupAddClient($more['group_id'],$client['client_database_id']);
			$ts->clientPoke($client['clid'],$lang['channel_add_group']['group_added']);
			if($more['move'])
				$ts->clientMove($client['clid'],$more['move_id']);
			else
				$ts->clientKick($client['clid'],'channel');
		}
	}
}




?>