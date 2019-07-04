<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: pokeall
#	DATE CREATED: 15/07/2018
#
##############################

class pokeall
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		if(empty($args[1]))
		{
			$ts->sendMessage(1,$invoker['clid'],"[color=red]Podaj jakiś argument![/color] [i]Przykład: [b]!pokeall Testowa wiadomość");
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

		foreach($ts->clientList()['data'] as $client)
		{
			$ts->clientPoke($client['clid'],$msg);
			$count++;
		}
		
		$ts->sendMessage(1,$invoker['clid'],"Wiadomość została pomyślnie wysłana do: [b][color=green]$count użytkowników[/color][/b]");
	}

}



?>