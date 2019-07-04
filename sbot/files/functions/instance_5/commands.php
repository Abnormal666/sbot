<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: commands
#	DATE CREATED: 23/09/2018
#
##############################

class commands
{

	function __construct($ts,$cfg,$db,$args,$data,$lang)
	{
		if(!in_array($args[0], ['!punkty','!pomoc','!sklep','!donate','!kup','!boosts']))
		{
			$ts->sendMessage(1,$data['invokerid'],$lang['pointsbot']['bad_command']);
		}
		else
		{
			$usr = $ts->clientInfo($data['invokerid'])['data'];
			$dbid = $usr['client_database_id'];
			$nickname = $usr['client_nickname'];
			$points = $db->query("SELECT `points` FROM `clients` WHERE `client_database_id`='".$dbid."'")->fetch(PDO::FETCH_ASSOC)['points'];
			if($args[0]=='!punkty')
			{
				$ts->sendMessage(1,$data['invokerid'],' ');
				$ts->sendMessage(1,$data['invokerid'],'• Twoja ilość punktów to: [b]'.$points.'[/b]');
				$ts->sendMessage(1,$data['invokerid'],' ');
				return;
			}
			else if($args[0]=='!pomoc')
			{
				foreach($lang['pointsbot']['help_msg'] as $msg)
					$ts->sendMessage(1,$data['invokerid'],$msg);
				return;
			}
			else if($args[0]=='!sklep')
			{
				$ts->sendMessage(1,$data['invokerid'],' ');
				$ts->sendMessage(1,$data['invokerid'],'• [b]Presiżowy sklep[/b], prestiżowe punkty możesz wymienić na:');
				foreach($cfg['shop'] as $idx => $item)
				{
					$ts->sendMessage(1,$data['invokerid'],'× Grupę [b]'.$item[0].'[/b] na okres [b]'.$item[1].' dni[/b], cena [b]'.$item[2].'[/b] - [b]#'.$idx);
				}
				unset($idx,$item);
				$ts->sendMessage(1,$data['invokerid'],' ');
				$ts->sendMessage(1,$data['invokerid'],'• Aby wymienić punkty wpisz: [b]!kup <id>[/b] - [i]Przykład: !kup 2');
				$ts->sendMessage(1,$data['invokerid'],' ');
				return;
			}
			else if($args[0]=='!kup')
			{
				if(!isset($args[1]))
				{
					$ts->sendMessage(1,$data['invokerid'],$lang['pointsbot']['not_id']);
					return;
				}
				else
				{
					if(in_array($args[1], array_keys($cfg['shop'])))
					{
						foreach($cfg['shop'] as $idx => $item)
						{
							if($args[1]==$idx)
							{
								if($points<$item[2])
								{
									$ts->sendMessage(1,$data['invokerid'],$lang['pointsbot']['poor']);
									return;
								}
								else
								{
									$check = $db->query("SELECT `product_id` FROM `pointsbot_groups` WHERE `cldbid`='".$dbid."'")->fetchAll(PDO::FETCH_ASSOC);
									foreach($check as $sdhr)
									{
										if($sdhr['product_id']==$idx)
										{
											$ts->sendMessage(1,$data['invokerid'],$lang['pointsbot']['one_buy']);
											return;
										}
									}
									
									$db->query("UPDATE `clients` SET `points`='".($points-$item[2])."' WHERE `client_database_id`='".$dbid."'");
									$db->prepare("INSERT INTO `pointsbot_groups` (`cldbid`,`sgid`,`product_id`,`time_remove`) VALUES (:dbid,:sgid,:id,:time)")->execute([
										'dbid' => $dbid,
										'sgid' => $item[3],
										'id' => $idx,
										'time' => strtotime('+'.$item[1].' '.($item[1]==1 ? 'day' : 'days').''),
									]);
									$ts->serverGroupAddClient($item[3],$dbid);
									$ts->sendMessage(1,$data['invokerid'],str_replace('[ITEM]',$item[0],$lang['pointsbot']['purchased']));
									return;
									
								}
								return;
							}
						}
						unset($idx,$item,$check);
					}
					else
					{
						$ts->sendMessage(1,$data['invokerid'],$lang['pointsbot']['not_product']);
						return;
					}
				}
			}
			else if($args[0]=='!donate')
			{
				# !donate cldbid kwota
				if(!isset($args[1]) && !isset($args[2]))
				{
					$ts->sendMessage(1,$data['invokerid'],$lang['pointsbot']['donate_id']);
					return;
				}
				else
				{
					$found = false;
					foreach($ts->clientList()['data'] as $client)
					{
						if($client['client_database_id']==$args[1])
						{
							$found = true;
							break;
						}
					}
					if($found==false)
					{
						$ts->sendMessage(1,$data['invokerid'],$lang['pointsbot']['client_offline']);
						return;
					}
					else
					{
						if($args[2]>$points)
						{
							$ts->sendMessage(1,$data['invokerid'],$lang['pointsbot']['not_points']);
							return;
						}
						else
						{
							$db->query("UPDATE `clients` SET `points`='".($points-$args[2])."' WHERE `client_database_id`='".$dbid."'");
							$db->query("UPDATE `clients` SET `points`=points+".$args[2]." WHERE `client_database_id`='".$args[1]."'");
							$ts->sendMessage(1,$data['invokerid'],str_replace('[POINTS]',$args[2],$lang['pointsbot']['success_donate']));
							$ts->sendMessage(1,$client['clid'],str_replace('[POINTS]',$args[2],str_replace(['[POINTS]','[NICK]'], [$args[2],$nickname], $lang['pointsbot']['get_points'])));
							unset($client);
							return;
						}
					}
				}
			}
			else if($args[0]=='!boosts')
			{
				# !donate cldbid kwota
				if(!isset($args[1]))
				{
					$ts->sendMessage(1,$data['invokerid'],'Brak argumentów (Dostępne: list,kup)');
					return;
				}
				else if($args[1]=='list')
				{
					$ts->sendMessage(1,$data['invokerid'],' ');
					$ts->sendMessage(1,$data['invokerid'],'[b]Dostępne poziomy boost\'a do kupienia:[/b]');
					foreach($cfg['boosts'] as $index => $value)
					{
						$row = $db->query("SELECT * FROM `clients` WHERE `client_database_id`='".$dbid."'")->fetch(PDO::FETCH_ASSOC);
						if($index==$row['boost_lv'])
						{
							$ts->sendMessage(1,$data['invokerid'],'• #'.$index.'. Boost - [b][color=green]'.$value[0].'[/color][/b] [i](Cena: [b]'.$value[1].'[/b])');
						}
						else if($index>$row['boost_lv'])
						{
							$ts->sendMessage(1,$data['invokerid'],'• #'.$index.'. Boost - [b][color=orange]'.$value[0].'[/color][/b] [i](Cena: [b]'.$value[1].'[/b])');
						}
						else
						{
							$ts->sendMessage(1,$data['invokerid'],'• #'.$index.'. Boost - [b][color=red]'.$value[0].'[/color][/b] [i](Cena: [b]'.$value[1].'[/b])');
						}
					}
					$ts->sendMessage(1,$data['invokerid'],'[i]Aby zakupić boosta wpisz: !boosts kup <id>');
					$ts->sendMessage(1,$data['invokerid'],' ');
				}
				else if($args[1]=='kup')
				{
					if(array_key_exists($args[2], $cfg['boosts']))
					{
						$row = $db->query("SELECT * FROM `clients` WHERE `client_database_id`='".$dbid."'")->fetch(PDO::FETCH_ASSOC);
						if($row['points']>=$cfg['boosts'][$args[2]][1])
						{
							if($args[2]<=$row['boost_lv'])
							{
								$ts->sendMessage(1,$data['invokerid'],'[color=red][b]Nie możesz kupić niższego boost\'a!');
							}
							else
							{
								$db->query("UPDATE `clients` SET `boost_lv`='".$args[2]."',`points`='".($row['points']-$cfg['boosts'][$args[2]][1])."' WHERE `client_database_id`='".$dbid."'");
								$ts->sendMessage(1,$data['invokerid'],'[color=green][b]Pomyślnie zakupiono boost\'a!');
							}
						}
						else
						{
							$ts->sendMessage(1,$data['invokerid'],'[color=red][b]Nie masz wystarczającej ilości gotówki!');
						}
					}
				}

			}
			unset($points);
		}
	}

}

?>