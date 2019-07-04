<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: client_permissions_security
#	DATE CREATED: 29/06/2018
#
##############################

class client_permissions_security
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($clients as $client)
		{
			if(!$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
			{
				$client_perms = $ts->getElement('data', $ts->clientPermList($client['client_database_id'],true));
				if(isset($client_perms[0]['permsid']))
				{
					$perms = [];
					$perms_msg = '';
					foreach($client_perms as $perm)
					{
						if((empty($cfg['clients'][$client['client_database_id']]) ||
								!in_array($perm['permsid'], $cfg['clients'][$client['client_database_id']])) &&
							!in_array($perm['permsid'], $cfg['ignored_permissions']))
						{
							$perms[] = $perm['permsid'];
							$perms_msg .= $perm['permsid'].' ';
						}
					}

					if(!empty($perms))
					{
						$ts->sendMessage(1,$client['clid'],str_replace('[PERMISSIONS_NAME]',$perms_msg,$lang['client_permissions_security']['message']));
						$ts->clientDelPerm($client['client_database_id'], $perms);
						$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] został wyrzucony za posiadanie niedozwolonych uprawnień!');
						switch ($cfg['type_kick'])
						{
							case 'kick':
								$ts->clientKick($client['clid'],'server',$lang['client_permissions_security']['kick_message']);
								break;
							case 'ban':
								$ts->banClient($client['clid'],$cfg['ban_time'],$lang['client_permissions_security']['kick_message']);
								break;
							default:
								$ts->clientKick($client['clid'],'server',$lang['client_permissions_security']['kick_message']);
								break;
						}
					}
				}
				else
				{
					unset($client_perms);
					continue;
				}
			}

		}
	}
	
}



?>