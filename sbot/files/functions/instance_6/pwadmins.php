<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: pwadmins
#	DATE CREATED: 15/07/2018
#
##############################

class pwadmins
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		if(empty($args[1]))
		{
			$ts->sendMessage(1,$invoker['clid'],"[color=red]Podaj jakiś argument![/color] [i]Przykład: [b]!pwadmins Testowa wiadomość");
			return;
		}

		$msg = '';
		$count = 0;
		foreach($args as $arg)
		{
			if(strpos($args[0], $arg)===FALSE)
			{
				$msg.=$arg.' ';
			}
		}

		foreach($ts->clientList('-groups')['data'] as $client)
		{
			if($sbot::in_group($cfg['admin_groups'],explode(',',$client['client_servergroups'])))
			{
				$ts->sendMessage(1,$client['clid'],$msg);
				$count++;
			}
		}
		
		$ts->sendMessage(1,$invoker['clid'],"Wiadomość została pomyślnie wysłana do: [b][color=green]$count adminów[/color][/b]");
	}

}



?>