<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: away_move
#	DATE CREATED: 29/06/2018
#
##############################

class away_move
{
	private static $away_clients = [];
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','away_move');
		foreach($clients as $client)
		{
			if($client['client_platform']!='ServerQuery' && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
			{
				$client_info = $ts->getElement('data',$ts->clientInfo($client['clid']));
				if(self::check_status($client,$cfg) && $client['cid']!=$cfg['channel_id'])
				{
					if($client['cid']!=$cfg['channel_id'])
					{
						self::$away_clients[] = ['clid'=>$client['clid'],'cid'=>$client['cid']];
						$ts->clientPoke($client['clid'],$lang['away_move']['move_message']);
						$ts->clientMove($client['clid'],$cfg['channel_id']);
					}
				}
				elseif($client['cid']==$cfg['channel_id'] && !self::check_status($client,$cfg))
				{
					foreach(self::$away_clients as $x => $more)
					{
						if($client['clid']==$more['clid'])
						{
							$ts->clientPoke($more['clid'],$lang['away_move']['back_message']);
							$ts->clientMove($more['clid'],$more['cid']);
							unset(self::$away_clients[$x]);
						}
					}
				}
			}
			unset($client_info,$client);
		}
	}

	private function check_status($client,$cfg)
	{
		if($client['client_away']==1 || (($client['client_idle_time']>=($cfg['afk_time'])*60000) && $cfg['move_when_time'])  || $client['client_output_muted']==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}



?>