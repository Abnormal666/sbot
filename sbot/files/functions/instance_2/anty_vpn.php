<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: anty_vpn
#	DATE CREATED: 18/07/2018
#
##############################

class anty_vpn
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		global $diff;
		if(!empty($diff))
		{
			foreach($diff as $clid)
			{
				$client = $ts->clientInfo($clid)['data'];
				if(!$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
				{
					$vpn_detect = json_decode(file_get_contents("https://vpn.wabolserver.com/vpn.php?ip=".$client['connection_client_ip']),1);
					if($vpn_detect['vpn']=='true')
					{
						$ts->clientPoke($clid,$lang['anty_vpn']['has_vpn']);
						$ts->clientKick($clid,'server','AntyVPN');
						$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] został wyrzucony za VPN.');
					}
				}
			}
		}
	}
	
}



?>