<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: create_vip_channel
#	DATE CREATED: 29/06/2018
#
##############################

class create_vip_channel
{
	function __construct($ts,$cfg,$sbot,$lang,$client,$db)
	{
		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','create_vip_channel');
			if($client['cid']!=$cid)
				continue;
			$user_ch = $db->query("SELECT `home_channel` FROM `vip_channels` WHERE `owner_dbid`='".$client['client_database_id']."'")->fetch(PDO::FETCH_ASSOC);
			print_r($user_ch);
			if(isset($user_ch['home_channel']) || !empty($user_ch))
			{
				$ts->clientPoke($client['clid'],"Posidasz już kanał!");
				$ts->clientMove($client['clid'],$user_ch['home_channel']);
				unset($user_ch);
				continue;
			}
			unset($user_ch);

			$info = [];
			$check = $db->query("SELECT * FROM `vip_channels` WHERE `zone_name`='".$more['zone_name']."'");
			if($check->rowCount()<=0)
			{
				$info['number'] = 1;
				$info['separator'] = $more['first_channel'];
			}
			else
			{
				$rows = array_reverse($check->fetchAll(PDO::FETCH_ASSOC));
				foreach($rows as $row)
				{
					$info['number'] = $row['number']+1;
					$info['separator'] = $row['separator_id'];
					break;
				}
			}

			$in_start_points1 = $ts->serverInfo()['data']['virtualserver_antiflood_points_needed_command_block'];
			$in_start_points2 = $ts->serverInfo()['data']['virtualserver_antiflood_points_needed_ip_block'];
			$ts->serverEdit(['virtualserver_antiflood_points_needed_command_block'=>'99999','virtualserver_antiflood_points_needed_ip_block'=>'99999']);
			$info['tag'] = $more['zone_name'].$info['number'];
			$client_info = $ts->getElement('data',$ts->clientInfo($client['clid']));
			if(isset($client_info['client_description']) && !empty($client_info['client_description']))
			{
				$info['tag'] = $client_info['client_description'];
			}
			unset($client_info);
			$info['group_id'] = $ts->getElement('data',$ts->serverGroupCopy($more['group_id'],0,$info['tag']));
			$ts->serverGroupAddClient($info['group_id']['sgid'],$client['client_database_id']);

			$main = self::create_channel($lang['create_vip_channel']['main_channel_name'],$info['separator'],$info['number'],$info['tag'],true);
			$ts->setClientChannelGroup($more['owner_channel_id'], $main, $client['client_database_id']);
			$sep = self::create_channel($lang['create_vip_channel']['separator_name'],$main,$info['number'],$info['tag'],true);
			$group = self::create_channel($lang['create_vip_channel']['group_channel_name'],$main,$info['number'],$info['tag']);
			$home = self::create_channel($lang['create_vip_channel']['home_channel_name'],$main,$info['number'],$info['tag']);
			$rekru = self::create_channel($lang['create_vip_channel']['rekru_channel_name'],$main,$info['number'],$info['tag']);
			if($more['online_from_group'])
				$grouponline = self::create_channel($lang['create_vip_channel']['group_subchannel_name'][0],$group,$info['number'],$info['tag']);
			if($more['channel_add_group'])
				$groupadd = self::create_channel($lang['create_vip_channel']['group_subchannel_name'][1],$group,$info['number'],$info['tag']);
			if($more['teleport'])
				$teleport = self::create_channel($lang['create_vip_channel']['group_subchannel_name'][2],$group,$info['number'],$info['tag']);
			self::create_subchannel($lang['create_vip_channel']['subchannel_name'],$home,$more['home_subchannel_count'],$info['tag']);
			self::create_subchannel($lang['create_vip_channel']['subchannel_name'],$rekru,$more['rekru_subchannel_count'],$info['tag'],true);

			$db->prepare("INSERT INTO `vip_channels` (number,zone_name,main_channel,separator_id,group_add_id,group_online_id,group_id,home_channel,owner_dbid) VALUES (:num,:name,:main,:sep,:group_add,:group_online,:group_id,:home,:owner_dbid)")->execute([
				'num' => $info['number'],
				'name' => $more['zone_name'],
				'main' => $main,
				'sep' => $sep,
				'group_add' => $groupadd,
				'group_online' => $grouponline,
				'group_id' => $info['group_id']['sgid'],
				'home' => $home,
				'owner_dbid' => $client['client_database_id'],
			]);
			if($more['teleport'])
				$db->prepare("INSERT INTO `teleport` (`channel_id`,`group_name`) VALUES (:chid,:grname)")->execute([
					'chid' => $teleport,
					'grname' => $info['tag'],
				]);

			$ts->clientMove($client['clid'],$home);
			$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] otrzymał kanał [b]'.$more['zone_name'].'[/b] o numerze: [b]'.$info['number'].'[/b]');
			sleep(1);
			$ts->serverEdit(['virtualserver_antiflood_points_needed_command_block'=>$in_start_points1,'virtualserver_antiflood_points_needed_ip_block'=>$in_start_points2]);
			unset($main,$sep,$group,$home,$rekru,$info,$in_start_points1,$in_start_points2,$teleport);
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
		}
		return;
	}
	
}



?>