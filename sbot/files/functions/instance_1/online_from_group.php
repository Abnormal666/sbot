<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: online_from_group
#	DATE CREATED: 24/06/2018
#
##############################

class online_from_group
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		global $profiles;

		foreach(['vip_channels','elite_channels'] as $chname)
		{
			$check = $db->query("SELECT `group_id`,`group_online_id` FROM `$chname`");
			if($check)
			{
				foreach($check->fetchAll(PDO::FETCH_ASSOC) as $row)
				{
					if(!in_array($row['group_online_id'],$cfg['channels']))
					{
						$cfg['channels'][$row['group_online_id']] = ['group_id' => $row['group_id'], 'format' => $cfg['db_formats'][$chname], 'status_for'=>'time'];
					}
				}
			}
			else
				unset($check);
		}
		$check = $db->query("SELECT * FROM `groups_online`");
		if($check)
		{
			foreach($check->fetchAll(PDO::FETCH_ASSOC) as $row)
			{
				if(!in_array($row['cid'],$cfg['channels']))
				{
					$cfg['channels'][$row['cid']] = ['group_id' => $row['sgid'], 'format' => $row['name_type'], 'status_for'=>'time'];
				}
			}
		}
		else
			unset($check);

		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','online_from_group');
			$sbot::check_ids($ts,$more['group_id'],'group','online_from_group');
			$guild = [];
			$online = 0;
			$max = 0;
			foreach($ts->getElement('data',$ts->serverGroupClientList($more['group_id'],true)) as $user)
			{
				if(isset($user['cldbid']))
				{
					$max++;
					$status = false;
					foreach($clients as $client)
					{
						if($client['client_database_id']==$user['cldbid'])
						{
							$status_name = '????';
							$status_icon = '';
							
							if($client['client_output_muted']==1 && $client['client_input_muted']==1)
							{
								$status_name = $descriptions['online_from_group']['status_name']['away'];
								$status_icon = $descriptions['online_from_group']['status_icon']['away'];
							}
							else
							{
								$status_name = $descriptions['online_from_group']['status_name']['online'];
								$status_icon = $descriptions['online_from_group']['status_icon']['online'];
							}
							$status_for = 0;
							switch ($more['status_for'])
							{
								case 'time':
									$status_for = $sbot::convert_time(time()-$client['client_lastconnected']);
									break;
								case 'date':
									$status_for = date('d.m.Y G:i',$client['client_lastconnected']);
									break;
								default:
									$status_for = $sbot::convert_time(time()-$client['client_lastconnected']);
									break;
							}
							$guild[] = [
								'nickname' => $client['client_nickname'],
								'uid' => $client['client_unique_identifier'],
								'clid' => $client['clid'],
								'time' => $status_for,
								'cldbid' => $client['client_database_id'],
								'status' => $status_name,
								'status_icon' => $status_icon,
							];
							$status= true;
							$online++;
							unset($status_name,$status_icon,$status_for);
						}
					}
					if(!$status)
					{
						$client = $ts->getElement('data',$ts->clientDbInfo($user['cldbid']));
						$status_for = 0;
						switch ($more['status_for'])
						{
							case 'time':
								$status_for = $sbot::convert_time(time()-$client['client_lastconnected']);
								break;
							case 'date':
								$status_for = date('d.m.Y G:i',$client['client_lastconnected']);
								break;
							default:
								$status_for = $sbot::convert_time(time()-$client['client_lastconnected']);
								break;
						}
						$guild[] = [
							'nickname' => $client['client_nickname'],
							'time' => $status_for,
							'cldbid' => $user['cldbid'],
							'status' => $descriptions['online_from_group']['status_name']['offline'],
							'status_icon' => $descriptions['online_from_group']['status_icon']['offline'],
						];
						unset($status_for);
					}
				}
			}
			
			$desc = $descriptions['online_from_group']['header'];
			if(!empty($guild))
			{
				foreach($guild as $client)
				{
					if($client['status']!='[color=red]Niedostępny[/color]')
						$desc .= str_replace([ '[STATUS_ICON]', '[STATUS_NAME]', '[STATUS_FOR]', '[CLIENT_URL]', '[PROFILE]'], [$client['status_icon'], $client['status'], $client['time'],' [url=client://'.$client['clid'].'/'.$client['uid'].']'.$client['nickname'].'[/url]', ($profiles['enabled']==true ? ' - [url='.$profiles['url'].$client['cldbid'].']Profil[/url]' : ''), ], $descriptions['online_from_group']['online_client']);
					else
						$desc .= str_replace([ '[STATUS_ICON]', '[STATUS_NAME]', '[STATUS_FOR]', '[CLIENT_NICK]', '[PROFILE]'], [$client['status_icon'], $client['status'], $client['time'],$client['nickname'], ($profiles['enabled']==true ? ' - [url='.$profiles['url'].$client['cldbid'].']Profil[/url]' : ''), ], $descriptions['online_from_group']['offline_client']);
				}
			}
			else
				$desc .= $descriptions['online_from_group']['empty_group'];
			
			$desc .= '[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cid,['channel_name'=>str_replace(['[GROUP_NAME]','[ONLINE]','[MAX]'],[self::group_info($more['group_id']),$online,$max],$more['format'])]);
			$ts->channelEdit($cid,['channel_description'=>$desc]);
		}
	}
	
	private function group_info($sgid)
	{
		global $ts;
		foreach($ts->getElement('data',$ts->serverGroupList()) as $group)
		{
			if($group['sgid']==$sgid)
			{
				return $group['name'];
			}
		}
	}
}

?>