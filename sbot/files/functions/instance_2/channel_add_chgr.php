<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: channel_add_chgr
#	DATE CREATED: 24/06/2018
#
##############################

class channel_add_chgr
{
	function __construct($ts,$cfg,$sbot,$lang,$client,$db)
	{
		$more = $cfg['channels'][$client['cid']];
		if($ts->channelGroupClientList($more['add_on_cid'],$client['client_database_id'],$more['group_id'])['success']==1 && $more['remove'])
		{ 
			$ts->setClientChannelGroup($cfg['guest_channel_group_id'],$more['add_on_cid'],$client['client_database_id']);
			$ts->clientKick($client['clid'],'channel');
			$ts->clientPoke($client['clid'],$lang['channel_add_group']['group_removed']);
			return;
		}
		
		if($ts->channelGroupClientList($more['add_on_cid'],$client['client_database_id'],$more['group_id'])['success']!=1)
		{
			$ts->setClientChannelGroup($more['group_id'],$more['add_on_cid'],$client['client_database_id']);
			$ts->clientPoke($client['clid'],$lang['channel_add_group']['group_added']);
			if($more['move'])
				$ts->clientMove($client['clid'],$more['move_id']);
			else
				$ts->clientKick($client['clid'],'channel');
			return;
		}
	}
}




?>