<?php

/**
 *
 *	@name  SBOT v6.0 PREMIUM
 *	@author  `DEMON.
 *	@file  core.php
 *	@copyright  Copyright (c) 2018-2019, Julian '`Demon.'
 *	
**/
 
	// Prefixy/kolorki
	define('END',"\e[0m\n");
	define('color_red', "\e[91m");
	define('MAIN','  |> ');
	define('PREFIX','     '); 
	define('color_green', "\e[92m"); 
	define('color_blue', "\e[94m");

	date_default_timezone_set('Europe/Warsaw');	
	ini_set('memory_limit', -1);
	ini_set('default_charset', 'UTF-8');
	setlocale(LC_ALL, 'UTF-8');

	// Błędy
	error_reporting(E_ALL); 
	ini_set('display_errors', TRUE);
	ini_set('log_errors', TRUE);
	if(isset(getopt('i:')['i']))
		ini_set('error_log', 'files/logs/instance_'.getopt('i:')['i'].'/errors_'.date('d-m-Y',time()).'.log');
	ini_set('log_errors_max_len', 5024);

	require_once 'files/config.php';
	require_once 'files/connection_config.php';
	require_once 'files/libs/ts3admin.class.php';
	// Kernel and SBOT CLASS setup
	require_once 'files/libs/sbot.class.php';
	$sbot = new sbot();
	// END :: Kernel and SBOT CLASS setup

	// Język
	require_once 'files/languages/'.$config['settings']['other']['language'].'.php';
	require_once 'files/languages/descriptions.php';


	$getopt = getopt('i:');
	if(!array_key_exists('i',$getopt) || empty($getopt['i']) || !isset($getopt['i']) || !is_numeric($getopt['i']) || $getopt['i']<0 || !array_key_exists($getopt['i'], $config['settings']))
		die(END.PREFIX.color_red.$lang['system']['bad_instance'].END);
	
	$id = $getopt['i'];


	
	// Powitanie
	system('clear'); system('clear');
	echo END.MAIN.'Witamy!'.END;
	echo PREFIX.color_blue.'Twórca aplikacji: `Demon.'.END;
	echo PREFIX.color_blue.'Wersja aplikacji: '.VERSION.END;

	if($config['settings'][$id]['instance_enabled']!=true)
	{
		die(END.'    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red.$lang['system']['instance_disabled'].END.END);
	}


	echo END.MAIN.'Logi'.END;
	if($config['settings']['other']['logs']['enabled']==false)
	{
		echo PREFIX.color_blue.'Logi instancji są wyłączone.';
	}
	else
	{
		if($config['settings']['other']['logs']['delete_time']!=0 && (file_exists('files/logs/instance_'.$id.'/errors_'.date('d-m-Y',time()).'.log') && time()-filemtime('files/logs/instance_'.$id.'/errors_'.date('d-m-Y',time()).'.log')>86400*$config['settings']['other']['logs']['delete_time']))
		{
			unlink('files/logs/instance_'.$id.'/errors_'.date('d-m-Y',time()).'.log');
		}
		if(!$sbot::check_folders($id))
		{
			die(PREFIX.color_red.'[CRITICAL ERROR] Nie udało się stworzyć folderu z logami!'.END.END);
		}
		else
		{
			$sbot::check_logs($id,$config['settings']['other']['logs']);
			echo PREFIX.color_green.'Poprawnie załadowano system logów.'.END;
			$sbot::put_log('    ( '.date('d/m/Y G:i:s',time()).' ) '.'Pomyślnie załadowano system logów.',$id);
		}
	}

	$intervals = []; 
	$events = [];
	$plugins = [];
	$commands = [];
	$errors = [];
	$settings = $config['settings'][$id];
	if($settings['system_type']=='@functions')
	{
		$profiles = $config['settings']['other']['profiles'];
		foreach($config['functions'][$id] as $fnc_name => $more)
		{
			if($more['enabled'])
			{
				if(!file_exists('files/functions/'.$settings['folder_name'].'/'.$fnc_name.'.php')) die(PREFIX.color_red.'[CRITICAL ERROR] Plik funkcji \''.$fnc_name.'\' nie istnieje!'.END.END);
				include_once 'files/functions/'.$settings['folder_name'].'/'.$fnc_name.'.php';
				if(isset($more['interval']))
				{
					$intervals[$fnc_name]['data'] = '1970-01-01 00:00:00';
					$intervals[$fnc_name]['convert'] = $sbot::interval($more['interval']);
					$events[] = $fnc_name;
				}
				else
				{
					$plugins[] = $fnc_name;
				}
			}
		}
		
	}
	else if($settings['system_type']=='@commands')
	{
		foreach($config['commands'][$id] as $command => $more)
		{
			if($more['enabled'])
			{
				if(!file_exists('files/functions/'.$settings['folder_name'].'/'.$command.'.php')) die(PREFIX.color_red.'[CRITICAL ERROR] Plik komendy \''.$command.'\' nie istnieje!'.END.END);
				include_once 'files/functions/'.$settings['folder_name'].'/'.$command.'.php';
				$commands[] = $command;
			}
		}
	}
	else if($settings['system_type']=='@pointsbot')
	{
		$intervals['groups_time']['data'] = '1970-01-01 00:00:00';
		$intervals['groups_time']['convert'] = $sbot::interval(['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10]);
		$intervals['top']['data'] = '1970-01-01 00:00:00';
		$intervals['top']['convert'] = $sbot::interval($config['options'][$id]['top']['interval']);
		include 'files/functions/'.$settings['folder_name'].'/groups_time.php';
		include 'files/functions/'.$settings['folder_name'].'/commands.php';
		include 'files/functions/'.$settings['folder_name'].'/top.php';
	}

	if(isset($config['individual_login'][$id]))
	{
		$config['connection_ts3']['login'] = $config['individual_login'][$id]['login'];
		$config['connection_ts3']['pass'] = $config['individual_login'][$id]['pass'];
	}
	$ts = new ts3admin($config['connection_ts3']['ip'],$config['connection_ts3']['port_query'],$sbot);

	if($ts->connect()['success'])
	{
		if($ts->login($config['connection_ts3']['login'],$config['connection_ts3']['pass'])['success'])
		{
			if($ts->selectServer($config['connection_ts3']['server_port'],'port',false,$settings['bot_name'])['success'])
			{
				if(!$ts->clientMove($ts->whoAmI()['data']['client_id'],$settings['default_channel'])['success'])
				{
					if($config['settings']['other']['logs']['enabled']==true)
					{
						$sbot::put_log('    ( '.date('d/m/Y G:i:s',time()).' ) '.'[ERROR] '.$lang['system']['teamspeak_change_channel'],$id);
					}
					echo(PREFIX.color_red.'[ERROR] '.$lang['system']['teamspeak_change_channel'].END);
				}
				echo END.MAIN.'Baza danych'.END;
				if($settings['database_enabled'])
				{
					try
					{
					    $db = new PDO('mysql:host='.$config['connection_db']['database_host'].';dbname='.$config['connection_db']['database_name'], $config['connection_db']['database_login'], $config['connection_db']['database_pass']);
					    $db->exec("set names utf8");
					}
					catch (PDOException $e)
					{
					    echo PREFIX.color_red.'[CRITICAL ERROR]'.$lang['system']['database_connection'].END.END.PREFIX.color_red.'[ERROR DETAILS] '.$e->getMessage().END.END;
					    die();
					}
					echo PREFIX.color_green.$lang['system']['database_success'].END;
				}
				else
				{
					echo PREFIX.color_blue.$lang['system']['database_off'].END;
					$db = null;
				}
				$socket = $ts->runtime['socket'];
				
				/*if(!$ts->setName()['success'])
				{
					if($config['settings']['other']['logs']['enabled']==true)
					{
						$sbot::put_log('    ( '.date('d/m/Y G:i:s',time()).' ) '.'[ERROR] '.$lang['system']['teamspeak_change_nick'],$id);
					}
					echo(PREFIX.color_red.'[ERROR] '.$lang['system']['teamspeak_change_nick'].END);
				}*/


				echo END.MAIN.'System:'.END;
				echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_blue.'Nazwa bota: '.$settings['bot_name'].END;

				 echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_green.$lang['system']['version'][0].END;
				
				$sbot::check_packets($lang);
				$sbot::check_php($lang);

				if($config['settings']['other']['logs']['enabled']==true)
				{
					$sbot::put_log('    ( '.date('d/m/Y G:i:s',time()).' ) '.$lang['system']['instance_success'],$id);
				}
				echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_green.$lang['system']['instance_success'].END;
				
				if($settings['system_type']=='@functions')
				{
					if(in_array('ip_group', $plugins) || in_array('welcome_message', $plugins) || in_array('anty_vpn', $plugins))
					{
						$now_clients = [];
						foreach($ts->clientList('-info')['data'] as $client)
						{
							if($client['client_database_id']!=1 && $client['client_platform']!='ServerQuery')
								$now_clients[] = $client['clid'];
						}
					}
				}
				while(1)
				{
					if($settings['system_type']=='@functions')
					{
						if(empty($events) && empty($plugins)) die( '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red.$lang['system']['not_functions_load'].END.END);

						if(!empty($events))
						{
							foreach($events as $event)
							{ 
								if($sbot::zegar($intervals[$event]['data'],$intervals[$event]['convert']))
								{
									new $event($ts,$config['functions'][$id][$event],$sbot,$lang,$ts->clientList('-uid -away -voice -times -groups -info -country -ip')['data'],$db,$descriptions);
									
									$intervals[$event]['data'] = date('Y-m-d G:i:s', time());
								}
							}
							unset($event);
						}

						if(!empty($plugins))
						{
							if(in_array('channel_add_group', $plugins))
							{
								foreach(['vip_channels','elite_channels'] as $chname)
								{
									$check = $db->query("SELECT `group_id`,`group_add_id`,`home_channel` FROM `$chname`")->fetchAll(PDO::FETCH_ASSOC);
									if($check)
									{
										foreach($check as $row)
										{
											if(!in_array($row['group_add_id'],$config['functions'][$id]['channel_add_group']['is_client_on_channel']))
											{
												$config['functions'][$id]['channel_add_group']['is_client_on_channel'][] = $row['group_add_id'];
												$config['functions'][$id]['channel_add_group']['channels'][$row['group_add_id']] = ['group_id' => $row['group_id'], 'remove' => true, 'move' => true, 'move_id' => $row['home_channel']];
											}
										}
									}
									else
										unset($check);
								}
								unset($check);
								$check = $db->query("SELECT * FROM `groups_add`")->fetchAll(PDO::FETCH_ASSOC);
								if($check)
								{
									foreach($check as $row)
									{
										if(!in_array($row['cid'],$config['functions'][$id]['channel_add_group']['is_client_on_channel']))
										{
											$config['functions'][$id]['channel_add_group']['is_client_on_channel'][] = $row['cid'];
											$config['functions'][$id]['channel_add_group']['channels'][$row['cid']] = ['group_id' => $row['sgid'], 'remove' => $row['remove'], 'move' => true, 'move_id' => $row['main']];
										}
									}
								}
								else
									unset($check);
								unset($check);
							}
							if(in_array('ip_group', $plugins) || in_array('welcome_message', $plugins) || in_array('anty_vpn', $plugins))
							{
								$new_clients = [];
								foreach($ts->clientList('-info')['data'] as $client)
								{
									if($client['client_database_id']!=1 && $client['client_version']!='ServerQuery' && isset($client['clid']))
									{
										$new_clients[] = $client['clid'];
									}
								}
								
								$diff = array_diff($new_clients,$now_clients);
					        }

							foreach($plugins as $plugin)
							{

								if(array_key_exists('is_client_on_channel', $config['functions'][$id][$plugin]) && is_array($config['functions'][$id][$plugin]['is_client_on_channel']))
								{
									foreach($ts->clientList('-uid -away -voice -times -groups -info -country -ip')['data'] as $client)
									{
										if($client['client_database_id']!=1 && $client['client_platform']!='ServerQuery')
										{
											if(in_array($client['cid'], $config['functions'][$id][$plugin]['is_client_on_channel']))
											{

												new $plugin($ts,$config['functions'][$id][$plugin],$sbot,$lang,$client,$db,$descriptions);
											}
										}
									}
									unset($client);
								}
								else if(array_key_exists('is_client_on_channel', $config['functions'][$id][$plugin]) && !is_array($config['functions'][$id][$plugin]['is_client_on_channel']))
								{
									foreach($ts->clientList('-uid -away -voice -times -groups -info -country -ip')['data'] as $client)
									{
										if($client['client_database_id']!=1 && $client['client_platform']!='ServerQuery')
										{
											if($client['cid']==$config['functions'][$id][$plugin]['is_client_on_channel'])
											{
												new $plugin($ts,$config['functions'][$id][$plugin],$sbot,$lang,$client,$db,$descriptions);
											}
										}
									}
									unset($client);
								}
								else
								{
									new $plugin($ts,$config['functions'][$id][$plugin],$sbot,$lang,$ts->clientList('-uid -away -voice -times -groups -info -country -ip')['data'],$db,$descriptions);
								}
							}
							unset($plugin);
							
							if(in_array('ip_group', $plugins) || in_array('welcome_message', $plugins) || in_array('anty_vpn', $plugins))
							{
						        $now_clients = $new_clients;
						    }
							unset($new_clients);
						}
					}
					else if($settings['system_type']=='@commands')
					{
						$sbot::send_socket_command('servernotifyregister event=textprivate',$socket);
						$data = $sbot::get_socket_data($socket);
						if(isset($data['msg']) && !empty($data['msg']))
						{
							$args = explode(' ',$data['msg']);
							foreach($commands as $command)
							{
								if($args[0]=='!help')
								{
									$ts->sendMessage(1,$data['invokerid'],"Dostępne komendy:");
									foreach($commands as $cmd)
									{
										$ts->sendMessage(1,$data['invokerid'],"!$cmd");
									}
									break;
								}
								else if('!'.$command==$args[0])
								{
									$invoker = $ts->clientInfo($data['invokerid'])['data'];
									if($sbot::in_group($config['commands'][$id][$command]['needed_groups'],$invoker['client_servergroups']))
									{
										$invoker['clid'] = $data['invokerid'];
										new $command($ts,$config['commands'][$id][$command],$sbot,$lang,$invoker,$args,$db);
									}
									else
									{
										$ts->sendMessage(1,$data['invokerid'],$lang['system']['commands']['not_group']);
									}
								}
							}
						}
						unset($data,$args,$command,$invoker);
					}
					else if($settings['system_type']=='@teleport')
					{
						$sbot::send_socket_command('servernotifyregister event=textprivate',$socket);
						$sbot::send_socket_command('servernotifyregister event=server',$socket);
						$data = $sbot::get_socket_data($socket);
						$guilds = [];
						$guilds = $db->query("SELECT * FROM `teleport`")->fetchAll(PDO::FETCH_ASSOC);
						if($config['options'][$id]['welcome_message']['enabled']==true && isset($data['notifycliententerview']))
						{
							foreach($config['options'][$id]['welcome_message']['messages'] as $msg)
								$ts->sendMessage(1,$data['clid'],str_replace('[NICKNAME]', $data['client_nickname'], $msg));
							foreach($config['options'][$id]['guilds_list'] as $name => $cid)
								$ts->sendMessage(1,$data['clid'],'• [b]'.$name);
							foreach($guilds as $guild)
								$ts->sendMessage(1,$data['clid'],'• [b]'.$guild['group_name']);
						}

						if(isset($data['notifytextmessage']) && isset($data['msg']) && !empty($data['msg']))
						{
							$args = explode(' ', $data['msg']);
							
							if(!in_array($args[0], $config['options'][$id]['commands']))
							{
								$ts->sendMessage(1,$data['invokerid'],$lang['teleport']['bad_command']);
							}
							else
							{
								if($config['options'][$id]['commands'][0]==$args[0])
								{
									$found = false;
									foreach($config['options'][$id]['guilds_list'] as $name => $cid)
									{
										if(strtolower($name)==strtolower($args[1]))
										{
											$ts->clientMove($data['invokerid'],$cid);
											$ts->clientPoke($data['invokerid'],str_replace('[NAME]', $name, $lang['teleport']['user_moved']));
											$found = true;
											break;
										}
									}
									foreach ($guilds as $guild)
									{
										if(strtolower($guild['group_name'])==strtolower($args[1]))
										{
											$ts->clientMove($data['invokerid'],$guild['channel_id']);
											$ts->clientPoke($data['invokerid'],str_replace('[NAME]', $guild['group_name'], $lang['teleport']['user_moved']));
											$found = true;
											break;
										}
									}
									if($found==false)
									{
										$ts->sendMessage(1,$data['invokerid'],$lang['teleport']['not_guild']);
									}
									unset($found);
								}
								else if($config['options'][$id]['commands'][1]==$args[0])
								{
									$ts->sendMessage(1,$data['invokerid'],'[b]● Lista przystanków ●[/b]');
									foreach($config['options'][$id]['guilds_list'] as $name => $cid)
										$ts->sendMessage(1,$data['invokerid'],'• [b]'.$name);
								}
							}
						}
					}
					else if($settings['system_type']=='@pointsbot')
					{
						$cfg = $config['options'][$id];
						foreach(['groups_time','top'] as $dtref)
						{
							if($sbot::zegar($intervals[$dtref]['data'],$intervals[$dtref]['convert']))
							{
								new $dtref($ts,$cfg,$db,$lang,$sbot);
								$intervals[$dtref]['data'] = date('Y-m-d G:i:s', time());
							}
						}
						$sbot::send_socket_command('servernotifyregister event=textprivate',$socket);
						$sbot::send_socket_command('servernotifyregister event=server',$socket);
						$data = $sbot::get_socket_data($socket);
						if($cfg['welcome']['enabled']==true && isset($data['notifycliententerview']))
						{
							$points = $db->query("SELECT `points` FROM `clients` WHERE `client_database_id`='".$data['client_database_id']."'")->fetch(PDO::FETCH_ASSOC);
							foreach($cfg['welcome']['messages'] as $msg)
							{
								$ts->sendMessage(1,$data['clid'],str_replace(['[NICKNAME]','[POINTS]'], [$data['client_nickname'],$points['points']], $msg));
							}
							unset($points,$msg);
						}
						if(isset($data['notifytextmessage']) && isset($data['msg']) && !empty($data['msg']) && isset($data['invokerid']))
						{
							$args = explode(' ', $data['msg']);
							new commands($ts,$cfg,$db,$args,$data,$lang);
							
						}
						unset($cfg,$args);

					}

					usleep($settings['interval'] * 1000000);
				}
			}
			else
			{
				if($config['settings']['other']['logs']['enabled']==true)
				{
					$sbot::put_log('    ( '.date('d/m/Y G:i:s',time()).' ) '.'[CRITICAL ERROR] '.$lang['system']['teamspeak_select_server'],$id);
				}
				die(PREFIX.color_red.'[CRITICAL ERROR] '.$lang['system']['teamspeak_select_server'].END.END.PREFIX.color_red.'[ERROR DETAILS] '.$sbot::show_errors($ts->selectServer($config['connection_ts3']['server_port'])['errors']).END.END);
			}
		}
		else
		{
			if($config['settings']['other']['logs']['enabled']==true)
			{
				$sbot::put_log('    ( '.date('d/m/Y G:i:s',time()).' ) '.'[CRITICAL ERROR] '.$lang['system']['teamspeak_login'],$id);
			}
			die(PREFIX.color_red.'[CRITICAL ERROR] '.$lang['system']['teamspeak_login'].END.END.PREFIX.color_red.'[ERROR DETAILS] '.$sbot::show_errors($ts->login($config['connection_ts3']['login'],$config['connection_ts3']['pass'])['errors']).END.END);
		}
	}
	else
	{
		if($config['settings']['other']['logs']['enabled']==true)
		{
			$sbot::put_log('    ( '.date('d/m/Y G:i:s',time()).' ) '.'[CRITICAL ERROR] '.$lang['system']['teamspeak_host'],$id);
		}
		echo PREFIX.color_red.'[CRITICAL ERROR] '.$lang['system']['teamspeak_host'].END.PREFIX.color_red.'[ERROR DETAILS] ';
		$sbot::show_errors($ts->connect()['errors']);
		echo END.END;
		exit;
	}

	
?>