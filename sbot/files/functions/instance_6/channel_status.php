<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: channel_status
#	DATE CREATED: 10/09/2018
#
##############################

class channel_status
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		if(empty($args[1]))
		{
			$ts->sendMessage(1,$invoker['clid'],"[color=red]Podaj jakiś argument![/color] [i]Przykład: [b]!channel_status <add/del/list>");
			return;
		}
		else if((isset($args[1]) && $args[1]=='del') && empty($args[2]))
		{
			 $ts->sendMessage(1,$invoker['clid'],"[color=red]Podaj jakiś argument![/color] [i]Przykład: [b]!channel_status del <database id>");
			 return;
		}
		else if((isset($args[1]) && $args[1]=='add') && (empty($args[2]) || empty($args[3]) || empty($args[4]) || empty($args[5])))
		{
			 $ts->sendMessage(1,$invoker['clid'],"[color=red]Podaj jakiś argument![/color] [i]Przykład: [b]!channel_status add <database id> <channel id> <group id> <description enabled (true/false)> <facebook - nie wymagane> <email - nie wymagane> <gadugadu - nie wymagane> <telegram - nie wymagane>");
			 return;
		}

		switch($args[1])
		{
			case 'add':
				if($db->query("SELECT * FROM `client_channel_status` WHERE `client_database_id`='".$args[2]."'")->fetch(PDO::FETCH_ASSOC))
				{
					$ts->sendMessage(1,$invoker['clid'],'Taka osoba jest już w bazie danych!');
					return;
				}
				$db->prepare("INSERT INTO `client_channel_status` (`client_database_id`,`channel_id`,`sgid`,`description_enabled`,`format`,`fb`,`email`,`telegram`,`gg`) VALUES (:dbid,:cid,:sgid,:dscenabled,:format,:fb,:email,:telegram,:gg)")->execute([
					'dbid' => $args[2],
					'cid' => $args[3],
					'sgid' => $args[4],
					'dscenabled' => (strtolower($args[5])=='true' ? 1 : (strtolower($args[5])=='false' ? 0 : null)),
					'format' => '• [[GROUP]] [NICK] - [STATUS]',
					'fb' => (empty($args[6]) ? '' : $args[6]),
					'email' => (empty($args[7]) ? '' : $args[7]),
					'telegram' => (empty($args[8]) ? '' : $args[8]),
					'gg' => (empty($args[9]) ? '' : $args[9]),
				]);
				
				$ts->sendMessage(1,$invoker['clid'],"Użytkownik został poprawnie dodany do bazy danych. Wkrótce jego kanał zostanie zaktualizowany.");
				break;
			case 'del':
				if(!$db->query("SELECT * FROM `client_channel_status` WHERE `client_database_id`='".$args[2]."'")->fetch(PDO::FETCH_ASSOC))
				{
					$ts->sendMessage(1,$invoker['clid'],'Takiej osoby nie ma w bazie danych!');
					return;
				}
				$db->query("DELETE FROM `client_channel_status` WHERE `client_database_id`='".$args[2]."'");
				
				$ts->sendMessage(1,$invoker['clid'],"Użytkownik został poprawnie usunięty z bazy danych.");
				break;
			case 'list':
				foreach($db->query("SELECT * FROM `client_channel_status`")->fetchAll(PDO::FETCH_ASSOC) as $row)
				{
					$ts->sendMessage(1,$invoker['clid'],"Kanał - Id: ".$row['channel_id']." Dbid: ".$row['client_database_id']." Grupa:".$row['sgid']);
				}
				break;
		}

		
	}

}



?>