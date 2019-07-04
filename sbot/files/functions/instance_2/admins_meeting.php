<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: admins_meeting
#	DATE CREATED: 23/08/2018
#
##############################

class admins_meeting
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','admins_meeting');
		$channel = $ts->channelInfo($cfg['channel_id'])['data'];
		if($channel['channel_topic']=='none' || !isset($channel['channel_topic']) || empty($channel['channel_topic']))
			return;
		$admins = [];
		$time = strtotime($channel['channel_topic']);
		if($cfg['send_info_1h'])
		{
			$ddd = explode(' ', $channel['channel_topic']);
			$eee = explode(':', $ddd[1]);
			if($eee[0]!=file_get_contents('files/cache/admins_meeting') && $eee[0]==date('G',strtotime('+1 hour')))
			{
				foreach ($clients as $client)
				{
					if($sbot::in_group($cfg['admin_groups'],$client['client_servergroups']))
					{
						$ts->clientPoke($client['clid'],'Za 1h zacznie się zebranie!');
					}
				}
				file_put_contents('files/cache/admins_meeting', $eee[0]);
			}
		}
		if($time==time())
		{
			foreach($clients as $client)
			{
				if($sbot::in_group($cfg['admin_groups'],$client['client_servergroups']))
				{
					$ts->clientMove($client['clid'],$cfg['channel_id']);
					$ts->clientPoke($client['clid'],'Witamy na zebraniu!');
					$admins[$client['client_database_id']] = [$client['client_nickname'],$client['clid'],$client['client_unique_identifier']];
				}
			}
			if($cfg['make_desc'])
			{
				$desc = '[center][size=20][b]Zebranie[/b][/size][/center][size=10]\n';
				foreach($cfg['admin_groups'] as $sgid)
				{
					$sbot::check_ids($ts,$sgid,'group','admins_meeting');
					foreach($ts->getElement('data',$ts->serverGroupClientList($sgid, true)) as $admin)
					{
						if(isset($admin['cldbid']))
						{
							if(in_array($admin['cldbid'], array_keys($admins)))
							{
								$desc .= ' • ( '.self::grname($sgid).' ) [url=client://'.$admins[$admin['cldbid']][1].'/'.$admins[$admin['cldbid']][2].']'.$admins[$admin['cldbid']][0].'[/url] - [color=green]Obecny[/color]\n';
							}
							else
							{
								$adm = $ts->getElement('data',$ts->clientDbInfo($admin['cldbid']));
								$desc .= ' • ( '.self::grname($sgid).' ) '.$adm['client_nickname'].' - [color=red]Nieobecny[/color]\n';
							}
						}
					}
				}
				$desc .= '[/size]'.$lang['system']['footer'];
				$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc]);
			}

			file_put_contents('files/cache/admins_meeting', '');
		}
	}

	private function grname($sgid)
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