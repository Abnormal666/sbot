<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: register_reminder
#	DATE CREATED: 26/10/2018
#
##############################

class register_reminder
{
	private static $users=[];
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($clients as $client)
		{
			if($sbot::in_group($cfg['needed_groups'],$client['client_servergroups']) && !$sbot::in_group($cfg['ignored_group'],$client['client_servergroups']) && (!isset(self::$users[$client['client_database_id']]) || (floor(time()-self::$users[$client['client_database_id']])>=$cfg['time_to_info']*60)))
			{
				switch ($cfg['type'])
				{
					case 'poke':
						$ts->clientPoke($client['clid'],str_replace('[NICK]', $client['client_nickname'], $lang['register_reminder']['message']));
						break;
					case 'msg':
						$ts->sendMessage(1,$client['clid'],str_replace('[NICK]', $client['client_nickname'], $lang['register_reminder']['message']));
						break;
					default:
						$ts->clientPoke($client['clid'],str_replace('[NICK]', $client['client_nickname'], $lang['register_reminder']['message']));
						break;
				}
				self::$users[$client['client_database_id']]=time();
			}
			else if($sbot::in_group($cfg['ignored_group'],$client['client_servergroups']))
			{
				if(array_key_exists($client['client_database_id'],self::$users) && isset(self::$users[$client['client_database_id']]))
				{
					unset(self::$users[$client['client_database_id']]);
				}
			}
		}

		if(date('H:i')=='00:00')
		{
			self::$users=[];
			return;
		}
	}
	
}



?>