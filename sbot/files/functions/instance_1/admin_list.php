<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: admin_list
#	DATE CREATED: 23/06/2018
#
##############################

class admin_list
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		global $profiles;
		#$desc = '[center][size=20][b]Lista Administracji[/b][/size][/center]\n';
		foreach($cfg['channels'] as $channel_id => $more)
		{
			$sbot::check_ids($ts,$channel_id,'channel','admin_list');
			$desc = $more['top_desc'];
			foreach($more['admin_groups'] as $sgid)
			{
				$sbot::check_ids($ts,$sgid,'group','admin_list');
				$online_admins = [];
				$offline_admins = [];
				$alls = 0;
				foreach($ts->getElement('data',$ts->serverGroupClientList($sgid, true)) as $admin)
				{
					if(isset($admin['cldbid']))
					{
						$alls++;
						$status = false;
						foreach($clients as $client)
						{
							if(!$sbot::in_group($more['ignored_groups'],$client['client_servergroups']) && $client['client_database_id']==$admin['cldbid'])
							{
								$status = true;
								$status_name = '????';
								$status_icon = '';
								if($client['client_output_muted']==1)
								{
									$status_name = $descriptions['admin_list']['status_name']['away'];
									$status_icon = $descriptions['admin_list']['status_icon']['away'];
								}
								else
								{
									$status_name = $descriptions['admin_list']['status_name']['online'];
									$status_icon = $descriptions['admin_list']['status_icon']['online'];
								}
								
								$channel = $ts->getElement('data',$ts->channelInfo($client['cid']));
								$online_admins[] = [
									'nickname' => $client['client_nickname'],
									'uid' => $client['client_unique_identifier'],
									'clid' => $client['clid'],
									'cldbid' => $client['client_database_id'],
									'cid' => $client['cid'],
									'cname' => $channel['channel_name'],
									'status' => $status_name,
									'status_icon' => $status_icon,
									'status_for' => $sbot::convert_time(time()-$client['client_lastconnected']),
								];
							}
						}
						if($status==false)
						{
							$client = $ts->getElement('data',$ts->clientDbInfo($admin['cldbid']));
							$offline_admins[] = [
								'nickname' => $client['client_nickname'],
								'cldbid' => $admin['cldbid'],
								'status' => $descriptions['admin_list']['status_name']['offline'],
								'status_icon' => $descriptions['admin_list']['status_icon']['offline'],
								'status_for' => $sbot::convert_time(time()-$client['client_lastconnected']),
							];
						}
						unset($status,$status_name,$status_icon);
					}
				}
				
				$group_info = self::group_info($sgid);
				$desc .= str_replace('[GROUP_NAME]', $group_info['name'], $descriptions['admin_list']['group_head']);
				$result = count($online_admins)+count($offline_admins);
				$desc .= str_replace('[COUNT]', $result, $descriptions['admin_list']['all_count_in_group']);
				$desc .= str_replace('[COUNT]', count($online_admins), $descriptions['admin_list']['online_count_in_group']);
				
				if(!empty($online_admins) || !empty($offline_admins))
				{
					foreach($online_admins as $admin)
					{
						
						$desc .= str_replace(['[CLIENT_URL]','[CLIENT_UID]','[CLIENT_CLID]','[CLIENT_NICK]','[PROFILE]','[STATUS_ICON]', '[STATUS_NAME]', '[STATUS_FOR]','[CID]', '[CHANNEL_NAME]'], ['[url=client://'.$admin['clid'].'/'.$admin['uid'].']'.$admin['nickname'].'[/url]',$admin['uid'],$admin['clid'],$admin['nickname'],($profiles['enabled']==true ? ' - [url='.$profiles['url'].$admin['cldbid'].']Profil[/url]' : ''), $admin['status_icon'], $admin['status'], $admin['status_for'],$admin['cid'],$admin['cname']], $descriptions['admin_list']['online_client']);
						
					}
					foreach($offline_admins as $admin)
					{
						$desc .= str_replace(['[CLIENT_NICK]', '[PROFILE]', '[STATUS_ICON]', '[STATUS_NAME]', '[STATUS_FOR]'], [$admin['nickname'], ($profiles['enabled']==true ? ' - [url='.$profiles['url'].$admin['cldbid'].']Profil[/url]' : ''), $admin['status_icon'], $admin['status'], $admin['status_for']], $descriptions['admin_list']['offline_client']);
					}
				}
				else
				{
					$desc .= $descriptions['admin_list']['empty_group'];
				}
				
				$desc .= '[/size]\n[hr]\n';
			}
			$desc .= str_replace('[hr]','',$lang['system']['footer']);
			$ts->channelEdit($channel_id,['channel_description'=>$desc]);
			unset($online_admins,$offline_admins,$desc,$group_info,$alls,$admin,$sgid,$channel_id,$more,$result);
		}

	}
	
	private function group_info($sgid)
	{
		global $ts;
		foreach($ts->getElement('data',$ts->serverGroupList()) as $group)
		{
			if($group['sgid']==$sgid)
			{
				return $group;
			}
		}
	}
}




?>