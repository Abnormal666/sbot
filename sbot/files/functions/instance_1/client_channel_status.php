<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: client_channel_status
#	DATE CREATED: 23/06/2018
#
##############################

class client_channel_status
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$check  =$db->query("SELECT * FROM `client_channel_status`");
		if($check)
		{
			foreach($check->fetchAll(PDO::FETCH_ASSOC) as $row)
			{
				if(!in_array($row['client_database_id'],array_keys($cfg['channels'])))
				{
					$cfg['channels'][$row['client_database_id']] = ['channel_id' => $row['channel_id'],'format' => $row['format'],'description' => ['enabled' => $row['description_enabled'],'fb' => $row['fb'],'email' => $row['email'],'gadugadu' => $row['gg'],'telegram' => $row['telegram']]];
				}
			}
		}
		else
			unset($check);
		
		$users = [];

		foreach($cfg['channels'] as $dbid => $more)
		{
			$sbot::check_ids($ts,$more['channel_id'],'channel','client_channel_status');
			$status= false;
			$group_info = self::get_group($cfg['groups'],$dbid);
			foreach($clients as $client)
			{
				if($dbid==$client['client_database_id'])
				{
					$status_name = '???';
					
					if($sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
					{
						$status_name = $cfg['status_name']['ignored'];
						$status_name_desc = '[color=purple][b]'.$cfg['status_name']['ignored'].'[/b][/color]';
					}
					else if($client['client_output_muted']==1)
					{
						$status_name = $cfg['status_name']['away'];
						$status_name_desc = '[color=orange][b]'.$cfg['status_name']['away'].'[/b][/color]';
					}
					else
					{
						$status_name = $cfg['status_name']['online'];
						$status_name_desc = '[color=green][b]'.$cfg['status_name']['online'].'[/b][/color]';
					}
					if($more['description']['enabled'])
					{
						$desc = str_replace(['[CLIENT_NICK]', '[CLIENT_GROUP]', '[STATUS_NAME]', '[CID]', '[CHANNEL_NAME]'], [$client['client_nickname'],$group_info,$status_name_desc,$client['cid'],$ts->channelInfo($client['cid'])['data']['channel_name']], $descriptions['client_channel_status']['online_client']);
						$desc .= ($more['description']['fb']!='' ? '• Facebook: [url=https://facebook.com/'.$more['description']['fb'].'][b]Przejdź[/url]\n' : null);
						$desc .= ($more['description']['email']!='' ? '• Email: [b]'.$more['description']['email'].'[/b]\n' : null);
						$desc .= ($more['description']['gadugadu']!='' ? '• Gadu-Gadu: [b]'.$more['description']['gadugadu'].'[/b]\n' : null);
						$desc .= ($more['description']['telegram']!='' ? '• Telegram: [b]@'.$more['description']['telegram'].'[/b]\n' : null);
						$desc .= '[/size]'.$lang['system']['footer'];
					}
					$users[] = [
						'nickname' => $client['client_nickname'],
						'group_name' => $group_info,
						'status' => $status_name,
						'cid' => $more['channel_id'],
						'format' => $more['format'],
						'desc' => ($more['description']['enabled']==true ? $desc : ''),
					];
					$status = true;
					unset($status_name_desc);
				}
			}
			if(!$status)
			{
				$client = $ts->getElement('data',$ts->clientDbInfo($dbid));
				if($more['description']['enabled'])
				{
					$desc = str_replace(['[CLIENT_NICK]', '[CLIENT_GROUP]', '[STATUS_NAME]'], [$client['client_nickname'], $group_info, $cfg['status_name']['offline']], $descriptions['client_channel_status']['offline_client']);
					$desc .= ($more['description']['fb']!='' ? '• Facebook: [url=https://facebook.com/'.$more['description']['fb'].']Przejdź[/url]\n' : null);
					$desc .= ($more['description']['email']!='' ? '• Email: '.$more['description']['email'].'\n' : null);
					$desc .= ($more['description']['gadugadu']!='' ? '• Gadu-Gadu: '.$more['description']['gadugadu'].'\n' : null);
					$desc .= ($more['description']['telegram']!='' ? '• Telegram: @'.$more['description']['telegram'].'\n' : null);
					$desc .= '[/size]'.$lang['system']['footer'];
				}
				$users[] = [
					'nickname' => $client['client_nickname'],
					'group_name' => $group_info,
					'status' => $cfg['status_name']['offline'],
					'cid' => $more['channel_id'],
					'format' => $more['format'],
					'desc' => ($more['description']['enabled']==true ? $desc : ''),
				];
			}
			unset($status,$status_name,$group_info);
		}

		foreach($users as $user)
		{
			$check = $ts->channelEdit($user['cid'],['channel_name' => str_replace([ '[GROUP]','[NICK]','[STATUS]' ],[ $user['group_name'],$user['nickname'],$user['status'] ],$user['format']),'channel_description'=>$user['desc']]);
		}
		unset($users);

	}
	
	private function get_group($groups,$cldbid)
	{
		global $ts;
		foreach($ts->getElement('data',$ts->serverGroupsByClientID($cldbid)) as $group)
		{
			foreach($groups as $sgid)
			{
				if($sgid==$group['sgid'])
				{
					return $group['name'];
				}
			}
		}
	}
	
}


?>