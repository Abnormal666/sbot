<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: servergroups_security
#	DATE CREATED: 28/06/2018
#
##############################

class servergroups_security
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		/*if(in_array(2,$cfg['security_groups']))
		{
			die(PREFIX_LOGS.color_red.$lang['servergroups_security']['asq_error'].END.END);
		}*/

		$check = $db->query("SELECT * FROM `groups_security`");
		if($check)
		{
			foreach($check->fetchAll(PDO::FETCH_ASSOC) as $row)
			{
				if(!in_array($row['cldbid'],array_keys($cfg['clients'])))
				{
					$cfg['clients'][$row['cldbid']] = [$row['group']];
				}
			}
		}
		else
			unset($check);

		foreach($clients as $client)
		{
			if(!isset($cfg['clients'][$client['client_database_id']]))
			{
				foreach($cfg['security_groups'] as $sgid)
				{
					if(in_array($sgid,explode(',',$client['client_servergroups'])))
					{
						echo $client['client_nickname'].END;
						$ts->serverGroupDeleteClient($sgid,$client['client_database_id']);
						$ts->clientPoke($client['clid'],$lang['servergroups_security']['poke_message']);
						if($cfg['type_kick']=='kick')
							$ts->clientKick($client['clid'],'server',$lang['servergroups_security']['kick_message']);
						else if($cfg['type_kick']=='kick')
							$ts->banClient($client['clid'],$cfg['ban_time'],$lang['servergroups_security']['kick_message']);
						else
							$ts->clientKick($client['clid'],'server',$lang['servergroups_security']['kick_message']);
					}
				}
				
			}
			else
			{
				foreach($cfg['security_groups'] as $sgid)
				{
					if(!in_array($sgid, $cfg['clients'][$client['client_database_id']]) && in_array($sgid, explode(',',$client['client_servergroups'])))
					{
						$ts->serverGroupDeleteClient($sgid,$client['client_database_id']);
						$ts->clientPoke($client['clid'],$lang['servergroups_security']['poke_message']);
						if($cfg['type_kick']=='kick')
							$ts->clientKick($client['clid'],'server',$lang['servergroups_security']['kick_message']);
						else if($cfg['type_kick']=='kick')
							$ts->banClient($client['clid'],$cfg['ban_time'],$lang['servergroups_security']['kick_message']);
						else
							$ts->clientKick($client['clid'],'server',$lang['servergroups_security']['kick_message']);
					}
				}
			}
		}
/*
		foreach($clients as $client)
		{
			if(!isset($cfg['clients'][$client['client_database_id']]) || empty($cfg['clients'][$client['client_database_id']]))
			{
				foreach($cfg['security_groups'] as $sgid)
				{
					$sbot::check_ids($ts,$sgid,'group','servergroups_security');
					if(in_array($sgid,explode(',',$client['client_servergroups'])))
					{
						$ts->serverGroupDeleteClient($sgid,$client['client_database_id']);
						$ts->clientPoke($client['clid'],$lang['servergroups_security']['poke_message']);
						switch ($cfg['type_kick'])
						{
							case 'kick':
								$ts->clientKick($client['clid'],'server',$lang['servergroups_security']['kick_message']);
								break;
							case 'ban':
								$ts->banClient($client['clid'],$cfg['ban_time'],$lang['servergroups_security']['kick_message']);
								break;
							default:
								$ts->clientKick($client['clid'],'server',$lang['servergroups_security']['kick_message']);
								break;
						}
					}
				}
			}
			else if(isset($cfg['clients'][$client['client_database_id']]) && !empty($cfg['clients'][$client['client_database_id']]))
			{
				foreach(explode(',',$client['client_servergroups']) as $sgid)
				{
					foreach($cfg['security_groups'] as $group)
					{
						$sbot::check_ids($ts,$group,'group','servergroups_security');
						if($sbot::in_group())
						{
							if(!in_array($sgid,$cfg['clients'][$client['client_database_id']]))
							{
								$ts->serverGroupDeleteClient($sgid,$client['client_database_id']);
								$ts->clientPoke($client['clid'],$lang['servergroups_security']['poke_message']);
								switch ($cfg['type_kick'])
								{
									case 'kick':
										$ts->clientKick($client['clid'],'server',$lang['servergroups_security']['kick_message']);
										break;
									case 'ban':
										$ts->banClient($client['clid'],$cfg['ban_time'],$lang['servergroups_security']['kick_message']);
										break;
									default:
										$ts->clientKick($client['clid'],'server',$lang['servergroups_security']['kick_message']);
										break;
								}
							}
						}
					}
				}
			}
			else
				continue;
		}*/
		unset($client,$sgid,$group);
		
	}

}

?>