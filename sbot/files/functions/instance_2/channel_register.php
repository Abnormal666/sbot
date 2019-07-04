<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: channel_register
#	DATE CREATED: 23/06/2018
#
##############################

class channel_register
{
	function __construct($ts,$cfg,$sbot,$lang,$client,$db)
	{
		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','channel_register');
			if($client['cid']!=$cid)
				continue;
			$has = false;
			foreach($cfg['groups'] as $sgid)
			{
				$sbot::check_ids($ts,$sgid,'group','channel_register');
				if(in_array($sgid,explode(',',$client['client_servergroups'])))
				{
					$ts->clientKick($client['clid'],'channel');
					$ts->clientPoke($client['clid'],$lang['channel_register']['has_group']);
					$has = true;
					return;
				}
			}
			
			if(!$has)
			{
				if(floor((time()-$client['client_created'])/60)>=$more['time_spent'])
				{
					$ts->clientKick($client['clid'],'channel');
					$ts->clientPoke($client['clid'],$lang['channel_register']['group_added']);
					$ts->serverGroupAddClient($more['group_id'],$client['client_database_id']);
					$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] został zarejestrowany po przez kanał.');
					return;
				}
				else
				{
					$ts->clientKick($client['clid'],'channel');
					$ts->clientPoke($client['clid'],$lang['channel_register']['not_time']);
					return;
				}
			}
		}
	}
}

?>