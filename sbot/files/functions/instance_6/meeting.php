<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: meeting
#	DATE CREATED: 15/07/2018
#
##############################

class meeting
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		$count = 0;
		foreach($ts->clientList('-groups')['data'] as $client)
		{
			if($sbot::in_group($cfg['admin_groups'],$client['client_servergroups']))
			{
				$ts->clientPoke($client['clid'],"[color=green][b]Zostałeś przeniesiony na zebranie administracji!");
				$ts->clientMove($client['clid'],$cfg['channel_id']);
				$count++;
			}
		}
		
		$ts->sendMessage(1,$invoker['clid'],"Pomyślnie przeniesiono: [b][color=green]$count adminów![/color][/b]");
	}

}



?>