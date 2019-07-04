<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: create_elite_channel
#	DATE CREATED: 29/06/2018
#
##############################

class create_elite_channel
{
	function __construct($ts,$cfg,$sbot,$lang,$client,$db)
	{
		
		foreach($cfg['channels'] as $zone_name => $more)
		{
			$sbot::check_ids($ts,$more['channel_id'],'channel','create_elite_channel');
			if($client['cid']!=$more['channel_id'])
				continue;

			$user_ch = $db->query("SELECT `home_channel` FROM `elite_channels` WHERE `owner_dbid`='".$client['client_database_id']."'")->fetch(PDO::FETCH_ASSOC);
			if(isset($user_ch['home_channel']) || !empty($user_ch))
			{
				$ts->clientPoke($client['clid'],"Posidasz już kanał!");
				$ts->clientMove($client['clid'],$user_ch['home_channel']);
				unset($user_ch);
				continue;
			}
			unset($user_ch);

			$info = [];
			$other_channels = [];
			$big_numbers = [];
			$check = $db->query("SELECT * FROM `elite_channels` WHERE `zone_name`='".$zone_name."'");
			if($check->rowCount()<=0)
			{
				$info['number'] = 1;
				$info['separator'] = $more['first_channel'];
			}
			else
			{
				$row = array_reverse($check->fetchAll(PDO::FETCH_ASSOC));
				
				$info['number'] = $row[0]['number']+1;
				$info['separator'] = $row[0]['separator_id'];
			}
			$in_start_points1 = $ts->serverInfo()['data']['virtualserver_antiflood_points_needed_command_block'];
			$in_start_points2 = $ts->serverInfo()['data']['virtualserver_antiflood_points_needed_ip_block'];
			$ts->serverEdit(['virtualserver_antiflood_points_needed_command_block'=>'99999','virtualserver_antiflood_points_needed_ip_block'=>'99999']);
			sleep(1);

			$info['tag'] = $zone_name.$info['number'];
			$client_info = $ts->getElement('data',$ts->clientInfo($client['clid']));
			if(isset($client_info['client_description']) && !empty($client_info['client_description']))
			{
				$info['tag'] = $client_info['client_description'];
			}
			unset($client_info);
			$info['group_id'] = $ts->getElement('data',$ts->serverGroupCopy($more['group_id'],0,$info['tag']));
			$ts->serverGroupAddClient($info['group_id']['sgid'],$client['client_database_id']);

			$main = self::create_channel($more['main_channel_name'],$info['separator'],$info['number'],$info['tag'],true);
			$ts->setClientChannelGroup($more['owner_channel_id'], $main, $client['client_database_id']);
			$index = 0;
			$groupadd = 0;
			$grouponline = 0;
			usleep(500000);
			foreach(array_reverse($more['channels']) as $x => $channel)
			{
				if(isset($channel['main']) && $channel['main']==true)
				{
					$home = self::create_channel($channel['channel_name'],$main,$info['number'],$info['tag'],true);
					if(isset($channel['subchannels_close_count']))
					{
						self::create_subchannel($lang['create_elite_channel']['subchannel_name'],$home,$channel['subchannels_close_count'],$info['tag']);
					}
					if(isset($channel['subchannels_open_count']))
					{
						self::create_subchannel($lang['create_elite_channel']['subchannel_name_open'],$home,$channel['subchannels_open_count'],$info['tag'],true);
					}
					$ts->setClientChannelGroup($more['owner_channel_id'], $home, $client['client_database_id']);
					usleep(500000);
				}
				else
				{
					if($channel['type']=='online_from_group')
					{
						$grouponline = self::create_channel($channel['channel_name'],$main,$info['number'],$info['tag'],true);
					}
					else if($channel['type']=='teleporter')
					{
						$teleport = self::create_channel($channel['channel_name'],$main,$info['number'],$info['tag'],true);
						$ts->setClientChannelGroup($more['owner_channel_id'], $teleport, $client['client_database_id']);
					}
					else if($channel['type']=='add_group')
					{
						$groupadd = self::create_channel($channel['channel_name'],$main,$info['number'],$info['tag'],true);
						$ts->setClientChannelGroup($more['owner_channel_id'], $groupadd, $client['client_database_id']);
					}
					else if($channel['type']=='liders')
					{
						$ch = self::create_channel($channel['channel_name'],$main,$info['number'],$info['tag'],true);
						$ts->setClientChannelGroup($more['owner_channel_id'], $ch, $client['client_database_id']);
						if(isset($channel['subchannels_count']))
						{
							self::create_liderchannel($channel['subchannel_name'],$channel['affair_channel_name'],$ch,$channel['subchannels_count'],$info['tag']);
						}
					}
					else if($channel['type']=='channel')
					{
						$ch = self::create_channel($channel['channel_name'],$main,$info['number'],$info['tag'],true);
						$ts->setClientChannelGroup($more['owner_channel_id'], $ch, $client['client_database_id']);
						if(isset($channel['subchannels_close_count']))
						{
							self::create_subchannel($lang['create_elite_channel']['subchannel_name'],$ch,$channel['subchannels_close_count'],$info['tag']);
						}
						if(isset($channel['subchannels_open_count']))
						{
							self::create_subchannel($lang['create_elite_channel']['subchannel_name_open'],$ch,$channel['subchannels_open_count'],$info['tag'],true);
						}
					}
					if(isset($ch))
					{
						$other_channels[$index] = $ch;
						$index++;
						unset($ch);
					}
				}
				usleep(500000);
			}

			$sep = self::create_channel($lang['create_elite_channel']['separator_name'],($other_channels[0] ?: $home),$info['number'],$info['tag'],true);
			if($more['create_big_number'])
			{
				$sep1 = self::create_channel('[cspacer[NUM]11]'.self::get_num(1,$info['number']),$info['separator'],$info['number'],$info['tag'],true);
				$big_numbers[] = $sep1;
				usleep(500000);
				$sep2 = self::create_channel('[cspacer[NUM]21]'.self::get_num(2,$info['number']),$sep1,$info['number'],$info['tag'],true);
				$big_numbers[] = $sep2;
				usleep(500000);
				$sep3 = self::create_channel('[cspacer[NUM]31]'.self::get_num(3,$info['number']),$sep2,$info['number'],$info['tag'],true);
				$big_numbers[] = $sep3;
				usleep(500000);
				$sep4 = self::create_channel('[cspacer[NUM]41]'.self::get_num(4,$info['number']),$sep3,$info['number'],$info['tag'],true);
				$big_numbers[] = $sep4;
				usleep(500000);
				$sep5 = self::create_channel('[cspacer[NUM]51]',$sep4,$info['number'],$info['tag'],true);
				$big_numbers[] = $sep5;
				usleep(500000);
			}
			$db->prepare("INSERT INTO `elite_channels` (number,zone_name,main_channel,home_channel,separator_id,group_add_id,group_online_id,group_id,other_channels,big_numbers,owner_dbid) VALUES (:num,:name,:main,:home,:sep,:group_add,:group_online,:group_id,:other,:numbers,:owner_dbid)")->execute([
				'num' => $info['number'],
				'name' => $zone_name,
				'main' => $main,
				'home' => $home,
				'sep' => $sep,
				'group_add' => $groupadd,
				'group_online' => $grouponline,
				'group_id' => $info['group_id']['sgid'],
				'other' => json_encode($other_channels),
				'numbers' => json_encode($big_numbers),
				'owner_dbid' => $client['client_database_id'],
			]);
			if(isset($teleport))
			{
				$db->prepare("INSERT INTO `teleport` (`channel_id`,`group_name`,`group_id`) VALUES (:chid,:grname,:grid)")->execute([
					'chid' => $teleport,
					'grname' => $info['tag'],
					'grid' => $info['group_id']['sgid'],
				]);
			}

			$ts->clientMove($client['clid'],$home);
			$ts->clientPoke($client['clid'],str_replace(['[ZONE_NAME]','[NUM]'], [$zone_name,$info['number']], $lang['create_elite_channel']['get_channel']));
			$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] otrzymał kanał [b]'.$zone_name.'[/b] o numerze: [b]'.$info['number'].'[/b]');

			usleep(1000000);
			$ts->serverEdit(['virtualserver_antiflood_points_needed_command_block'=>$in_start_points1,'virtualserver_antiflood_points_needed_ip_block'=>$in_start_points2]);
			unset($main,$sep,$groupadd,$grouponline,$home,$other_channels,$info,$big_numbers,$in_start_points1,$in_start_points2);
		
		}
		
	}

	private function create_channel($name,$cpid,$i,$tag,$order=false)
	{
		global $ts;

		if(!$order)
		{
			$ch = $ts->channelCreate([
				'channel_name' => str_replace(['[TAG]','[NUM]'], [$tag,$i], $name),
				'cpid' => $cpid,
				'channel_flag_permanent' => 1,
				'channel_maxclients' => 0,
				'channel_flag_maxclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_unlimited' => 1,
				'channel_flag_maxfamilyclients_inherited' => 0,
			]);
		}
		else
		{
			$ch = $ts->channelCreate([
				'channel_name' => str_replace(['[TAG]','[NUM]'], [$tag,$i], $name),
				'channel_order' => $cpid,
				'channel_flag_permanent' => 1,
				'channel_maxclients' => 0,
				'channel_flag_maxclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_unlimited' => 1,
				'channel_flag_maxfamilyclients_inherited' => 0,
			]);
		}
		return $ch['data']['cid'];
	}

	private function create_subchannel($name,$cpid,$count,$tag=null,$open=false)
	{
		global $ts;
		for($i=1;$i<=$count;$i++)
		{
			if(!$open)
			{
				$ts->channelCreate([
					'channel_name' => str_replace(['[TAG]','[NUM]'], [$tag,$i], $name),
					'cpid' => $cpid,
					'channel_flag_permanent' => 1,
					'channel_maxclients' => 0,
					'channel_flag_maxclients_unlimited' => 0,
					'channel_flag_maxfamilyclients_unlimited' => 1,
					'channel_flag_maxfamilyclients_inherited' => 0,
				]);
			}
			else
			{
				$ts->channelCreate([
					'channel_name' => str_replace(['[TAG]','[NUM]'], [$tag,$i], $name),
					'cpid' => $cpid,
					'channel_flag_permanent' => 1,
					'channel_flag_maxclients_unlimited' => 1,
					'channel_flag_maxfamilyclients_unlimited' => 1,
					'channel_flag_maxfamilyclients_inherited' => 0,
				]);
			}
			usleep(500000);
		}
		return;
	}

	private function create_liderchannel($name,$subname,$cpid,$count,$tag=null)
	{
		global $ts;
		for($i=1;$i<=$count;$i++)
		{
			$tmpch = $ts->channelCreate([
				'channel_name' => str_replace(['[TAG]','[NUM]'], [$tag,$i], $name),
				'cpid' => $cpid,
				'channel_flag_permanent' => 1,
				'channel_maxclients' => 0,
				'channel_flag_maxclients_unlimited' => 0,
				'channel_flag_maxfamilyclients_unlimited' => 1,
				'channel_flag_maxfamilyclients_inherited' => 0,
			]);
			usleep(500000);
			$ts->channelCreate([
				'channel_name' => str_replace('[TAG]', $tag, $subname),
				'cpid' => $tmpch['data']['cid'],
				'channel_flag_permanent' => 1,
				'channel_flag_maxclients_unlimited' => 1,
				'channel_flag_maxfamilyclients_unlimited' => 1,
				'channel_flag_maxfamilyclients_inherited' => 0,
			]);
			usleep(500000);
		}
		return;
	}
	
	private static function get_num($id,$number)
	{
		$spacer = [
			1 => [
				1 => '▄▀▀▀▄──▄█',
				2 => '▄▀▀▀▄─▄▀▀▀▄',
				3 => '▄▀▀▀▄─▄▀▀▀▄',
				4 => '▄▀▀▀▄────▄█─',
				5 => '▄▀▀▀▄─█▀▀▀▀',
				6 => '▄▀▀▀▄─▄▀▀▀▄',
				7 => '▄▀▀▀▄─▀▀▀▀█',
				8 => '▄▀▀▀▄─▄▀▀▀▄',
				9 => '▄▀▀▀▄─▄▀▀▀▄',
				10 => '──▄█──▄▀▀▀▄',
				11 => '──▄█───▄█',
				12 => '──▄█──▄▀▀▀▄',
				13 => '──▄█──▄▀▀▀▄',
				14 => '──▄█─────▄█─',
				15 => '──▄█──█▀▀▀▀',
				16 => '──▄█──▄▀▀▀▄',
				17 => '──▄█─▀▀▀▀█',
				18 => '──▄█──▄▀▀▀▄',
				19 => '──▄█──▄▀▀▀▄',
				20 => '▄▀▀▀▄─▄▀▀▀▄',
			],
			2 => [
				1 => '█───█─▀─█',
				2 => '█───█────▄▀',
				3 => '█───█───▄▄▀',
				4 => '█───█──▄▀─█─',
				5 => '█───█─█▄▄▄─',
				6 => '█───█─█▄▄▄─',
				7 => '█───█────█─',
				8 => '█───█─▀▄▄▄▀',
				9 => '█───█─▀▄▄▄▀',
				10 => '─▀─█──█───█',
				11 => '─▀─█──▀─█',
				12 => '─▀─█─────▄▀',
				13 => '─▀─█────▄▄▀',
				14 => '─▀─█───▄▀─█─',
				15 => '─▀─█──█▄▄▄─',
				16 => '─▀─█──█▄▄▄─',
				17 => '─▀─█────█─',
				18 => '─▀─█──▀▄▄▄▀',
				19 => '─▀─█──▀▄▄▄▀',
				20 => '───▄▀─█───█',
			],
			3 => [
				1 => '█───█───█',
				2 => '█───█──▄▀──',
				3 => '█───█─────█',
				4 => '█───█─█▄▄▄█▄',
				5 => '█───█─────█',
				6 => '█───█─█───█',
				7 => '█───█───█──',
				8 => '█───█─█───█',
				9 => '█───█─────█',
				10 => '───█──█───█',
				11 => '───█────█',
				12 => '───█───▄▀──',
				13 => '───█──────█',
				14 => '───█──█▄▄▄█▄',
				15 => '───█──────█',
				16 => '───█──█───█',
				17 => '───█───█──',
				18 => '───█──█───█',
				19 => '───█──────█',
				20 => '─▄▀───█───█',
			],
			4 => [
				1 => '▀▄▄▄▀───█',
				2 => '▀▄▄▄▀─█▄▄▄▄',
				3 => '▀▄▄▄▀─▀▄▄▄▀',
				4 => '▀▄▄▄▀─────█─',
				5 => '▀▄▄▄▀─▀▄▄▄▀',
				6 => '▀▄▄▄▀─▀▄▄▄▀',
				7 => '▀▄▄▄▀──█───',
				8 => '▀▄▄▄▀─▀▄▄▄▀',
				9 => '▀▄▄▄▀──▄▄▄▀',
				10 => '───█──▀▄▄▄▀',
				11 => '───█────█',
				12 => '───█──█▄▄▄▄',
				13 => '───█──▀▄▄▄▀',
				14 => '───█──────█─',
				15 => '───█──▀▄▄▄▀',
				16 => '───█──▀▄▄▄▀',
				17 => '───█──█───',
				18 => '───█──▀▄▄▄▀',
				19 => '───█───▄▄▄▀',
				20 => '─█▄▄▄▄▀▄▄▄▀',
			],
		];
		return $spacer[$id][$number];
	}
	
}



?>