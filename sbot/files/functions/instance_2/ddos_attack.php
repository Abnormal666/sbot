<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: ddos_attack
#	DATE CREATED: 11/07/2018
#
##############################

class ddos_attack
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$packets = floor($ts->serverInfo()['data']['virtualserver_total_packetloss_total']);
		if($cfg['min_packets']<=$packets)
		{
			if($cfg['type_information']=='server')
			{
				$ts->sendMessage(3,null,str_replace('[PACKETSLOST]', $packets, $lang['ddos_attack']['message']));
			}
			else if($cfg['type_information']=='admins')
			{
				foreach($clients as $client)
				{
					if($sbot::in_group($cfg['admin_groups'],$client['client_servergroups']))
						$ts->sendMessage(1,$client['clid'],str_replace('[PACKETSLOST]', $packets, $lang['ddos_attack']['message']));
				}
			}
		}
	}
	
}



?>