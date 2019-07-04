<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: poke_admins
#	DATE CREATED: 23/06/2018
#
##############################

class poke_admins
{
	private static $waiting;
	
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($clients as $client)
		{
			foreach($cfg['channels'] as $cid => $more)
			{
				$sbot::check_ids($ts,$cid,'channel','poke_admins');
				if(!$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']) && $client['cid']==$cid)
				{
					$admins = [];
					foreach($more['groups'] as $sgid)
					{
						$sbot::check_ids($ts,$sgid,'group','poke_admins');
						foreach($ts->clientList('-groups -uid -info -voice')['data'] as $user)
						{
							if(!$sbot::in_group($cfg['admin_ignored_groups'],$user['client_servergroups']) && in_array($sgid,explode(',',$user['client_servergroups'])))
							{
								if($user['cid']==$cid)
								{
									$ts->sendMessage(1,$client['clid'], $lang['poke_admins']['admin_in_channel']);
									break;
								}
								$admins[] = $user;
							}
						}
					}
					
					if((isset(self::$waiting[$client['client_database_id']]) && time()-self::$waiting[$client['client_database_id']]>=240) || !isset(self::$waiting[$client['client_database_id']]))
					{
						self::$waiting[$client['client_database_id']] = time();
						foreach($lang['poke_admins']['user_msg'] as $msgg)
						{
							if(strpos($msgg, '[LIST]')!==FALSE)
							{
								foreach($admins as $admin)
								{
									$ts->sendMessage(1,$client['clid'],"» [color=orange][b]{$admin['client_nickname']}");
								}
							}
							else
							{
								$ts->sendMessage(1,$client['clid'],str_replace(['[ID]','[UID]','[NICK]'], [$client['clid'],$client['client_unique_identifier'],$client['client_nickname']],$msgg));
							}
						}
					}

					foreach($admins as $admin)
					{
						if($more['move_to']==true && in_array($admin['cid'],$more['support_channels']) && self::count_of_channels($admin['cid'],$clients)<=1 && !(self::count_of_channels($admin['cid'],$clients)>=2) )
						{
							$ts->clientMove($client['clid'],$admin['cid']);
							unset($admins,$poke,$admin,$chid,$channel,$cid,$sgid);
							break(2);
						}
						if(!in_array($admin['cid'],$more['support_channels']))
						{
							foreach($lang['poke_admins']['poke_msg'] as $poke)
							{
								$ts->clientPoke($admin['clid'],str_replace(['[ID]','[UID]','[NICK]'], [$client['clid'],$client['client_unique_identifier'],$client['client_nickname']],$poke));
							}
						}
					}
				}
			}
		}
		unset($admins,$poke,$admin,$chid,$channel,$cid,$sgid);
	}

	private function channel_info($cid,$ts)
	{
		foreach($ts->channelList()['data'] as $channel)
		{
			if($channel['cid']==$cid)
			{
				return $channel;
			}
		}
		return null;
	}

	private function count_of_channels($cid,$clients)
	{
		$count = 0;
		foreach($clients as $client)
		{
			if($client['client_platform']!='ServerQuery')
			{
				if($client['cid']==$cid)
				{
					$count++;
				}
			}
		}
		return $count;
	}
	
}


?>