<?php

/**
 *
 *	@name  SBOT v6.0 PREMIUM
 *	@author  `DEMON.
 *	@file  sbot.class.php
 *	@copyright  Copyright (c) 2018-2019, Julian '`Demon.'
 *	
**/
 

	class sbot
	{
		
		public static function get_success($from)
		{
			global $ts;
			return $from['success'];
		}
		
		
		public static function interval($interval)
		{
			$interval['hours'] = $interval['hours'] + $interval['days'] * 24;
			$interval['minutes'] = $interval['minutes'] + $interval['hours'] * 60;
			$interval['seconds'] = $interval['seconds'] + $interval['minutes'] * 60;
			return $interval['seconds'];
		}
		
		
		public static function zegar($time,$interval)
		{
			if( ( strtotime($time) + $interval ) < time() )
			{
				return true;
			}
			
			return false;
		}


		public static function send_socket_command($command,$socket)
		{
			$splittedCommand = str_split($command, 1024);
			$splittedCommand[(count($splittedCommand) - 1)] .= "\n";
			
			foreach($splittedCommand as $commandPart) {
				fputs($socket, $commandPart);
			}
			
			return self::get_socket_data($socket);
		}
	

		public static function get_socket_data($socket)
		{
			global $ts;
			$data = fgets($socket, 4096);
			if(!empty($data))
			{
			 	$datasets = explode(' ', $data);
			  	$output = array();
			  	foreach($datasets as $dataset)
			  	{
					$dataset = explode('=', $dataset);
					if(count($dataset) > 2)
					{
					  	for($i = 2; $i < count($dataset); $i++)
					  	{
							$dataset[1] .= '='.$dataset[$i];
					  	}
					 	$output[self::unEscapeText($dataset[0])] = self::unEscapeText($dataset[1]);
					}
					else
					{
						
						if(count($dataset) == 1)
						{
							$output[self::unEscapeText($dataset[0])] = '';
						}
						else
						{
							$output[self::unEscapeText($dataset[0])] = self::unEscapeText($dataset[1]);
						}
					}
				}
				return $output;
			}
		}


		public static function unEscapeText($text)
		{
			$escapedChars = array("\t", "\v", "\r", "\n", "\f", "\s", "\p", "\/");
			$unEscapedChars = array('', '', '', '', '', ' ', '|', '/');
			$text = str_replace($escapedChars, $unEscapedChars, $text);
			return $text;
		}
		

		public static function convert_time($seconds,$month=true,$short=false)
		{
			$convert = [];
			$time = '';
			$convert['year']=floor($seconds / 31536000);
			$convert['month']=floor(($seconds - ($convert['year'] * 31536000)) / 2628000);
			$convert['days']=floor(($seconds - (($convert['year'] * 31536000)+($convert['month'] * 2628000))) / 86400);
			$convert['hours']=floor(($seconds - (($convert['year'] * 31536000)+($convert['month'] * 2628000)+($convert['days']*86400)) ) / 3600);
			$convert['minutes']=floor(($seconds - (($convert['year'] * 31536000)+($convert['month'] * 2628000)+($convert['days'] * 86400)+($convert['hours']*3600))) / 60);
			
			$time = '';
			if($seconds<60)
			{
				$time.=' mniej niż minuta ';
			}
			else
			{
				if($convert['year']>0 && $convert['year']>4)
					$time .= ''.$convert['year'].($short==true ? 'l ' : ' lata ');
				else if($convert['year']==1 && $convert['year']>0)
					$time .= ''.$convert['year'].($short==true ? 'r ' : ' rok ');
				else if($convert['year']>0 && $convert['year']>1 && $convert['year']<=4)
					$time .= ''.$convert['year'].($short==true ? 'l ' : ' lat ');

				if($convert['month']>0 && $convert['month']>4)
					$time .= ''.$convert['month'].($short==true ? 'msc ' : ' miesiące ');
				else if($convert['month']==1 && $convert['month']>0)
					$time .= ''.$convert['month'].($short==true ? 'msc ' : ' miesiąc ');
				else if($convert['month']>0 && $convert['month']>1 && $convert['month']<=4)
					$time .= ''.$convert['month'].($short==true ? 'msc ' : ' miesięcy ');

				if($convert['days']>0 && $convert['days']>1)
					$time .= ''.$convert['days'].($short==true ? 'd ' : ' dni ');
				else if($convert['days']>0 && $convert['days']==1)
					$time .= ''.$convert['days'].($short==true ? 'd ' : ' dzień ');

				if($convert['hours']>0 && $convert['hours']>4)
					$time .= ''.$convert['hours'].($short==true ? 'g ' : ' godzin ');
				else if($convert['hours']==1 && $convert['hours']>0)
					$time .= ''.$convert['hours'].($short==true ? 'g ' : ' godzina ');
				else if($convert['hours']>0 && $convert['hours']>1 && $convert['hours']<=4)
					$time .= ''.$convert['hours'].($short==true ? 'g ' : ' godziny ');

				if($convert['minutes']>0 && $convert['minutes']>4)
					$time .= ''.$convert['minutes'].($short==true ? 'm ' : ' minut ');
				else if($convert['minutes']==1 && $convert['minutes']>0)
					$time .= ''.$convert['minutes'].($short==true ? 'm ' : ' minuta ');
				else if($convert['minutes']>0 && $convert['minutes']>1 && $convert['minutes']<=4)
					$time .= ''.$convert['minutes'].($short==true ? 'm ' : ' minuty ');

			}
			return $time;
		}


		public static function put_log($log,$id)
		{
			file_put_contents('files/logs/instance_'.$id.'/'.date('d.m.Y').'.txt', $log."\n",FILE_APPEND);
			return;
		}


		public static function check_logs($id,$cfg)
		{
			if(!is_dir('files/logs/instance_'.$id.''))
			{
				self::check_folders($id);
			}
			else
			{
				foreach(array_diff(scandir('files/logs/instance_'.$id.'/'),['.','..']) as $file)
				{
					if(filesize('files/logs/instance_'.$id.'/'.$file)>=5*1048576)
					{
						unlink('files/logs/instance_'.$id.'/'.$file);
						continue;
					}
					if(strpos($file, 'errors_') && $file!='errors_check_ids.txt')
					{
						if(strtotime(str_replace('.txt', '', $file)) <= strtotime('- '.$cfg['delete_time'].' days'))
						{
							unlink('files/logs/instance_'.$id.'/'.$file);
						}
					}
					elseif( $file!='errors_check_ids.txt')
					{
						if(filemtime('files/logs/instance_'.$id.'/'.$file) <= strtotime('- '.$cfg['delete_time'].' days'))
						{
							unlink('files/logs/instance_'.$id.'/'.$file);
						}
					}
				}
			}
			return;
		}


		public static function put_error($log,$tag)
		{
			global $id;
			file_put_contents('files/logs/instance_'.$id.'/errors_'.$tag.'.txt', $log."\n",FILE_APPEND);
			return;
		}


		public static function check_folders($id)
		{
			if(!is_dir('files/logs/instance_'.$id.''))
			{
				if(mkdir('files/logs/instance_'.$id.'/'))
					return true;
			}
			else
				return true;

			return false;
		}


		public static function check_packets($lang)
		{
			if(!extension_loaded('gd')) die('    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red.'[CRITICAL ERROR] '.$lang['system']['not_packet'].'PHP-GD'.END.END);
			if(!extension_loaded('pdo')) die('    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red.'[CRITICAL ERROR] '.$lang['system']['not_packet'].'PHP-PDO'.END.END);

			echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_green.$lang['system']['all_packets'].END;
		}


		public static function check_php($lang)
		{
			if(version_compare(phpversion(), '7.0', '<')) 
			{
			    echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red.$lang['system']['old_php'].END;
			}
			else
			{
			    echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_green.$lang['system']['newest_php'].END;
			} 
		}


		public static function in_group($groups,$cl)
		{
			foreach($groups as $group)
			{
				if(in_array($group, explode(',',$cl)))
					return true;
			}
		}




		public static function show_errors($errors)
		{
			foreach($errors as $error)
			{
				echo color_red.$error.END;
			}
		}


		public static function add_action($db,$action)
		{
			global $settings;
			if($settings['database_enabled'])
			{
				$db->query("INSERT INTO `last_actions` (`action`,`time`) VALUES ('$action','".time()."')");
			}
			unset($action);
			return;

		}


		public static function checkstring($haystack, $needles=array(), $offset=0)
		{
	        $chr = array();
	        foreach($needles as $needle)
	        {
	            $res = strpos($haystack, $needle, $offset);
	           	if ($res !== false)
	           		$chr[$needle] = $res;
	        }

	        if(empty($chr)) return false;
	       		return min($chr);
		}


		// $sbot::check_ids($ts,$cfg['channel_id'],'channel','admins_meeting');
		static public function check_ids($ts,$number=0,$type='',$function='')
		{
			if(!isset($function) || $function=='')
			{
				echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red."Error :: Prosimy podać nazwę funckji".END.END;
				self::put_error(date('d/m/Y G:i:s').' - Error :: Prosimy podać nazwę funckji.','check_ids');
				exit;
			}
			if(!in_array($type, ['channel','group']))
			{
				echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red."Error :: Niewłaściwy typ sprawdzania błędu.".END.END;
				self::put_error(date('d/m/Y G:i:s').' - Error :: Niewłaściwy typ sprawdzania błędu.','check_ids');
				exit;
			}
			if(!is_numeric($number) && $number!=0)
			{
				echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red."Error :: Id ".($type=='channel' ? 'kanału' : ($type=='group' ? 'grupy' : 'błąd')).' w funkcji: '.$function.' jest nie poprawne!'.END.END;
				self::put_error(date('d/m/Y G:i:s')." - Error :: Id ".($type=='channel' ? 'kanału' : ($type=='group' ? 'grupy' : 'błąd')).' w funkcji: '.$function.' jest nie poprawne!','check_ids');
				exit;
			}
			if($number==0)
				return;
			switch ($type)
			{
				case 'group':
					$found = false;
					$groups = [];
					foreach($ts->serverGroupList(0)['data'] as $group)
					{
						$groups[] = $group['sgid'];
					}
					foreach($ts->serverGroupList(1)['data'] as $group)
					{
						$groups[] = $group['sgid'];
					}
					foreach($ts->serverGroupList(2)['data'] as $group)
					{
						$groups[] = $group['sgid'];
					}
					foreach($groups as $group)
					{
						if($group==$number)
						{
							$found=true;
							break;
						}
					}
					unset($groups,$group);
					if($found==false)
					{
						echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red."Error :: Nieznaleziono id grupy (Funckja: $function, Id: $number)".END.END;
						self::put_error(date('d/m/Y G:i:s')." - Error :: Nieznaleziono id grupy (Funckja: $function, Id: $number)",'check_ids');
						exit;
					}
					break;
				case 'channel':
					$found = false;
					foreach($ts->channelList()['data'] as $channel)
					{
						if($channel['cid']==$number)
						{
							$found=true;
							break;
						}
					}
					if($found==false)
					{
						echo '    ( '.date('d/m/Y G:i:s',time()).' ) '.color_red."Error :: Nieznaleziono id kanału (Funckja: $function, Id: $number)".END.END;
						self::put_error(date('d/m/Y G:i:s')." - Error :: Nieznaleziono id kanału (Funckja: $function, Id: $number)",'check_ids');
						exit;
					}
					break;
			}
			return true;
		}

	}




?>