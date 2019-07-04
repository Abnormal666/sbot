<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: client
#	DATE CREATED: 15/07/2018
#
##############################

class client
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		if(empty($args[1]))
		{
			$ts->sendMessage(1,$invoker['clid'],"[color=red]Podaj jakiś argument![/color] [i]Przykład: [b]!client {DATABASE_ID}");
			return;
		}
		$user = $db->query("SELECT * FROM `clients` WHERE `client_database_id`='".$args[1]."'");
		if($user->rowCount()<=0 || !is_numeric($args[1]))
		{
			$ts->sendMessage(1,$invoker['clid'],"[color=red]Taki użytkownik nie istnieje![/color]");
			return;
		}
		$client = $user->fetch(PDO::FETCH_ASSOC);
		$ts->sendMessage(1,$invoker['clid'],'• Nick użytkownika: [color=orange][b]'.$client['client_nickname']);
		$ts->sendMessage(1,$invoker['clid'],'» DBID: [color=#0055ff][b]'.$client['client_database_id']);
		$ts->sendMessage(1,$invoker['clid'],'» UID: [color=orange][b]'.$client['client_unique_identifier']);
		$ts->sendMessage(1,$invoker['clid'],'» Spędzony czas: [color=#0055ff][b]'.$sbot::convert_time($client['time_spent']/1000));
		$ts->sendMessage(1,$invoker['clid'],'» Spędzony czas away: [color=orange][b]'.$sbot::convert_time($client['idle_time']/1000));
		$ts->sendMessage(1,$invoker['clid'],'» Najdłuższe połączenie: [color=#0055ff][b]'.$sbot::convert_time($client['connection_time']/1000));
		$ts->sendMessage(1,$invoker['clid'],'» Ilość połączeń: [color=orange][b]'.$client['connections']);
	}

}



?>