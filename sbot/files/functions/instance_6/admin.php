<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: admin
#	DATE CREATED: 21/09/2018
#
##############################

class admin
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		if(empty($args[1]))
		{
			$ts->sendMessage(1,$invoker['clid'],"[color=red]Podaj jakiś argument![/color] [i]Przykład: [b]!admin {CLIENT_DATABASE_ID}");
			return;
		}
		$admin = $db->query("SELECT * FROM `admins` WHERE `client_database_id`='".$args[1]."'");
		if($admin->rowCount()<=0 || !is_numeric($args[1]))
		{
			$ts->sendMessage(1,$invoker['clid'],"[color=red]Nie znaleziono takiej osoby w bazie danch![/color]");
			unset($admin);
			return;
		}
		$admin = $admin->fetch(PDO::FETCH_ASSOC);
		$ts->sendMessage(1,$invoker['clid'],'• Nick użytkownika: [color=orange][b]'.$admin['client_nickname']);
		$ts->sendMessage(1,$invoker['clid'],'» DBID: [color=#0055ff][b]'.$admin['client_database_id']);
		$ts->sendMessage(1,$invoker['clid'],'» UID: [color=orange][b]'.$admin['client_unique_identifier']);
		$ts->sendMessage(1,$invoker['clid'],'» Grupa: [color=orange][b]'.$admin['group_name']);
		$ts->sendMessage(1,$invoker['clid'],'» Spędzony czas ogółem: [color=#0055ff][b]'.$sbot::convert_time($admin['time_spent']/1000));
		$ts->sendMessage(1,$invoker['clid'],'» Spędzony czas dziś: [color=#0055ff][b]'.$sbot::convert_time($admin['time_spent_day']/1000));
		$ts->sendMessage(1,$invoker['clid'],'» Spędzony czas w tym tygodniu: [color=#0055ff][b]'.$sbot::convert_time($admin['time_spent_week']/1000));
		$ts->sendMessage(1,$invoker['clid'],'» Spędzony czas w tym miesiacu: [color=#0055ff][b]'.$sbot::convert_time($admin['time_spent_month']/1000));
		$ts->sendMessage(1,$invoker['clid'],'» Nadanych rejestracji ogółem: [color=#0055ff][b]'.$admin['groups_total_register']);
		$ts->sendMessage(1,$invoker['clid'],'» Nadanych rejestracji dziś: [color=#0055ff][b]'.$admin['groups_day_register']);
		$ts->sendMessage(1,$invoker['clid'],'» Nadanych rejestracji w tym tygodniu: [color=#0055ff][b]'.$admin['groups_week_register']);
		$ts->sendMessage(1,$invoker['clid'],'» Nadanych rejestracji w tym miesiacu: [color=#0055ff][b]'.$admin['groups_month_register']);
		$ts->sendMessage(1,$invoker['clid'],'» Nadanych grup łącznie: [color=#0055ff][b]'.$admin['groups_total_other']);
		$ts->sendMessage(1,$invoker['clid'],'» Nadanych grup dziś: [color=#0055ff][b]'.$admin['groups_day_other']);
		$ts->sendMessage(1,$invoker['clid'],'» Nadanych grup w tym tygodniu: [color=#0055ff][b]'.$admin['groups_week_other']);
		$ts->sendMessage(1,$invoker['clid'],'» Nadanych grup w tym miesiacu: [color=#0055ff][b]'.$admin['groups_month_other']);
		$ts->sendMessage(1,$invoker['clid'],'» Udzielonej pomocy łącznie: [color=#0055ff][b]'.$admin['help_total']);
		$ts->sendMessage(1,$invoker['clid'],'» Udzielonej pomocy dziś: [color=#0055ff][b]'.$admin['help_day']);
		$ts->sendMessage(1,$invoker['clid'],'» Udzielonej pomocy w tym tygodniu: [color=#0055ff][b]'.$admin['help_week']);
		$ts->sendMessage(1,$invoker['clid'],'» Udzielonej pomocy w tym miesiacu: [color=#0055ff][b]'.$admin['help_month']);
		unset($admin);
	}

}



?>