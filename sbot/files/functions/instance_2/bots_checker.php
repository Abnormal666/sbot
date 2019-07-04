<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: bots_checker
#	DATE CREATED: 16/10/2018
#
##############################

class bots_checker
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		global $socket;
		foreach($cfg['bots'] as $dbid => $play)
		{
			foreach($clients as $client)
			{
				if($client['client_database_id']==$dbid && floor($client['client_idle_time']/1000/60)>=1)
				{
					$ts->sendMessage(1,$client['clid'],$play);
				}
			}
		}
	}
	
}



?>