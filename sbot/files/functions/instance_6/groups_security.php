<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: groups_security
#	DATE CREATED: 14/09/2018
#
##############################

class groups_security
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		if(empty($args[1]) || empty($args[2]))
		{
			$ts->sendMessage(1,$invoker['clid'],"[color=red]Podaj jakiś argument![/color] [i]Przykład: [b]!groups_security <add/del> <database id> [group id]");
			return;
		}
		if($args[1]=='add')
		{
			if($db->query("SELECT * FROM `groups_security` WHERE `cldbid`='".$args[2]."'")->fetch(PDO::FETCH_ASSOC))
			{
				$ts->sendMessage(1,$invoker['clid'],'Taka osoba jest już w bazie danych!');
				return;
			}
			$db->prepare("INSERT INTO `groups_security` (`cldbid`,`group`) VALUES (:dbid,:sgid)")->execute([
				'dbid' => $args[2],
				'sgid' => $args[3],
			]);
			
			$ts->sendMessage(1,$invoker['clid'],"Użytkownik został poprawnie dodany do bazy danych.");
			$ts->serverGroupAddClient($args[3],$args[2]);
		}
		else if($args[1]=='del')
		{
			if(!$db->query("SELECT * FROM `groups_security` WHERE `cldbid`='".$args[2]."'")->fetch(PDO::FETCH_ASSOC))
			{
				$ts->sendMessage(1,$invoker['clid'],'Takiej osoby nie ma w bazie danych!');
				return;
			}
			$ts->serverGroupDeleteClient($args[3],$args[2]);
			$db->query("DELETE FROM `groups_security` WHERE `cldbid`='".$args[2]."'");
			
			$ts->sendMessage(1,$invoker['clid'],"Użytkownik został poprawnie usunięty do bazy danych.");
		}
	}

}



?>