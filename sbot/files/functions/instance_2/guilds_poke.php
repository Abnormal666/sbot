<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: guilds_poke
#	DATE CREATED: 03/08/2018
#
##############################

class guilds_poke
{
	function __construct($ts,$cfg,$sbot,$lang,$invokder,$db)
	{
		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','guilds_poke');
			$sbot::check_ids($ts,$more['group_id'],'group','guilds_poke');
			if($invokder['cid']!=$cid)
				continue;
			foreach($ts->clientList('-groups')['data'] as $client)
			{
				if(in_array($more['group_id'], explode(',', $client['client_servergroups'])))
				{
					$to_poke = $ts->channelGroupClientList(null,$client['client_database_id'])['data'];
					foreach($to_poke as $user)
					{
						foreach($more['ch_groups'] as $chsgid)
						{
							if($user['cgid']==$chsgid)
							{
								$ts->clientPoke($client['clid'],'Ktoś czeka na rekrutacji');
							}
						}
					}
				}
			}
		}
	}
	
}


?>