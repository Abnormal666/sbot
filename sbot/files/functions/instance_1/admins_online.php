<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: admins_online
#	DATE CREATED: 23/06/2018
#
##############################

class admins_online
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		global $profiles;

		$sbot::check_ids($ts,$cfg['channel_id'],'channel','admins_online');
		$count= 0;
		#$desc = '[center][size=20][b]Lista Dostępnej Administracji[/b][/size][/center]\n[size=11]';
		$desc = $descriptions['admins_online']['header'];
		foreach($cfg['admin_groups'] as $sgid)
		{
			$sbot::check_ids($ts,$sgid,'group','admins_online');
			foreach($clients as $client)
			{
				if(!$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']) && in_array($sgid,explode(',',$client['client_servergroups'])) && $client['client_output_muted']!=1)
				{
					$gr = self::group_info($sgid,$ts);
					$channel = $ts->getElement('data',$ts->channelInfo($client['cid']));
					$desc .= str_replace(['[CLIENT_URL]', '[CLIENT_GROUP]', '[PROFILE]', '[STATUS_FOR]', '[CID]', '[CHANNEL_NAME]'], ['[url=client://'.$client['clid'].'/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url]', $gr['name'],($profiles['enabled']==true ? ' - [url='.$profiles['url'].$client['client_database_id'].']Profil[/url]' : ''),$sbot::convert_time(time()-$client['client_lastconnected']),$client['cid'],$channel['channel_name']], $descriptions['admins_online']['client_row']);
					$count++;
				}
			}
		}
		
		if($count==0)
			$desc .= $descriptions['admins_online']['no_admins'];
		
		$desc .= '[/size]'.$lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc]);
		$ts->channelEdit($cfg['channel_id'],['channel_name'=>str_replace('[COUNT]',$count,$cfg['channel_name'])]);
		unset($gr,$desc,$count);
	}

	private function group_info($sgid,$ts)
	{
		foreach($ts->getElement('data',$ts->serverGroupList()) as $group)
			if($group['sgid']==$sgid)
				return $group;
	}
}

?>