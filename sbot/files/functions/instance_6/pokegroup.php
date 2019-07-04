<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: pokegroup
#	DATE CREATED: 15/07/2018
#
##############################

class pokegroup
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		if(empty($args[1]) || empty($args[2]))
		{
			$ts->sendMessage(1,$invoker['clid'],"[color=red]Podaj jakiś argument![/color] [i]Przykład: [b]!pokegroup {ID_GROUPY} Testowa wiadomość");
			return;
		}

		$msg = '';
		$count = 0;
		foreach($args as $arg)
		{
			if(strpos($args[0], $arg)===FALSE && strpos($args[1], $arg)===FALSE)
			{
				$msg.=$arg.' ';
			}
		}

		foreach($ts->clientList('-groups')['data'] as $client)
		{
			if(in_array($args[1],explode(',',$client['client_servergroups'])))
			{
				$ts->clientPoke($client['clid'],$msg);
				$count++;
			}
		}
		
		$ts->sendMessage(1,$invoker['clid'],"Wiadomość została pomyślnie wysłana do: [b][color=green]$count użytkowników[/color][/b]");
	}

}



?>