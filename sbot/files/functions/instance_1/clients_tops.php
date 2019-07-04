<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: clients_tops
#	DATE CREATED: 23/08/2018
#
##############################

class clients_tops
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		global $profiles;
		$sbot::check_ids($ts,$cfg['idle_time']['channel_id'],'channel','clients_tops');
		$sbot::check_ids($ts,$cfg['time_spent']['channel_id'],'channel','clients_tops');
		$sbot::check_ids($ts,$cfg['connections']['channel_id'],'channel','clients_tops');
		$sbot::check_ids($ts,$cfg['connection_time']['channel_id'],'channel','clients_tops');
		$sbot::check_ids($ts,$cfg['level']['channel_id'],'channel','clients_tops');
		
		if($cfg['idle_time']['enabled'])
		{
			$desc = $cfg['idle_time']['top_desc'];
			$number = 1;
			$data = $db->query("SELECT * FROM `clients` ORDER BY `idle_time` DESC LIMIT 50");

			while($row = $data->fetch(PDO::FETCH_ASSOC))
			{
				if($cfg['idle_time']['limit']>=$number && !empty($row['client_servergroups']) && !$sbot::in_group($cfg['idle_time']['ignored_groups'],$row['client_servergroups']) && $row['idle_time']>1000)
				{
					$desc .= str_replace(['[NUM]', '[CLIENT_URL]', '[PROFILE]', '[TIME]'], [$number++, '[url=client://0/'.$row['client_unique_identifier'].'][b]'.$row['client_nickname'].'[/url]', ($profiles['enabled']==true ? ' - [url='.$profiles['url'].$row['client_database_id'].']Profil[/url]' : ''), $sbot::convert_time($row['idle_time']/1000)], $descriptions['clients_tops']['idle_time']);
				}
			}
			
			$desc .= '[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cfg['idle_time']['channel_id'],['channel_description'=>$desc]);
			unset($desc,$number,$data,$row);
		}

		if($cfg['time_spent']['enabled'])
		{
			$desc = $cfg['time_spent']['top_desc'];
			$number = 1;
			$data = $db->query("SELECT * FROM `clients` ORDER BY `time_spent` DESC LIMIT 50");

			while($row = $data->fetch(PDO::FETCH_ASSOC))
			{
				if($cfg['time_spent']['limit']>=$number && !empty($row['client_servergroups']) && !$sbot::in_group($cfg['time_spent']['ignored_groups'],$row['client_servergroups']) && $row['time_spent']>=1000)
				{
					$proc = $row['time_spent']-$row['idle_time'];
					$proc = floor($proc/$row['time_spent']*100);

					$desc .= str_replace(['[NUM]', '[CLIENT_URL]', '[PROFILE]', '[TIME]', '[PROC]'], [$number++, '[url=client://0/'.$row['client_unique_identifier'].'][b]'.$row['client_nickname'].'[/url]', ($profiles['enabled']==true ? ' - [url='.$profiles['url'].$row['client_database_id'].']Profil[/url]' : ''), $sbot::convert_time($row['time_spent']/1000), $proc], $descriptions['clients_tops']['time_spent']);
				}
			}
			
			$desc .= '[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cfg['time_spent']['channel_id'],['channel_description'=>$desc]);
			unset($desc,$number,$data,$row);
		}

		if($cfg['connection_time']['enabled'])
		{
			$desc = $cfg['connection_time']['top_desc'];
			$number = 1;
			$data = $db->query("SELECT * FROM `clients` ORDER BY `connection_time` DESC LIMIT 50");

			while($row = $data->fetch(PDO::FETCH_ASSOC))
			{
				if($cfg['connection_time']['limit']>=$number && !empty($row['client_servergroups']) && !$sbot::in_group($cfg['connection_time']['ignored_groups'],$row['client_servergroups']) && $row['connection_time']>1000)
				{
					$desc .= str_replace(['[NUM]', '[CLIENT_URL]', '[PROFILE]', '[TIME]'], [$number++, '[url=client://0/'.$row['client_unique_identifier'].'][b]'.$row['client_nickname'].'[/url]', ($profiles['enabled']==true ? ' - [url='.$profiles['url'].$row['client_database_id'].']Profil[/url]' : ''), $sbot::convert_time($row['connection_time']/1000)], $descriptions['clients_tops']['connection_time']);
				}
			}
			
			$desc .= '[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cfg['connection_time']['channel_id'],['channel_description'=>$desc]);
			unset($desc,$number,$data,$row);
		}

		if($cfg['connections']['enabled'])
		{
			$desc = $cfg['connections']['top_desc'];
			$number = 1;
			$data = $db->query("SELECT * FROM `clients` ORDER BY `connections` DESC LIMIT 50");

			while($row = $data->fetch(PDO::FETCH_ASSOC))
			{
				if($cfg['connections']['limit']>=$number && !empty($row['client_servergroups']) && !$sbot::in_group($cfg['connections']['ignored_groups'],$row['client_servergroups']) && $row['connections']>0)
				{
					$desc .= str_replace(['[NUM]', '[CLIENT_URL]', '[PROFILE]', '[CONNECTIONS]'], [$number++, '[url=client://0/'.$row['client_unique_identifier'].'][b]'.$row['client_nickname'].'[/url]', ($profiles['enabled']==true ? ' - [url='.$profiles['url'].$row['client_database_id'].']Profil[/url]' : ''), $row['connections']], $descriptions['clients_tops']['connections']);
				}
			}
			
			$desc .= '[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cfg['connections']['channel_id'],['channel_description'=>$desc]);
			unset($desc,$number,$data,$row);
		}

		if($cfg['level']['enabled'])
		{
			$desc = $cfg['level']['top_desc'];
			$number = 1;
			$data = $db->query("SELECT * FROM `clients` ORDER BY `level` DESC LIMIT 50");

			while($row = $data->fetch(PDO::FETCH_ASSOC))
			{
				if($cfg['level']['limit']>=$number && !empty($row['client_servergroups']) && !$sbot::in_group($cfg['level']['ignored_groups'],$row['client_servergroups']) && $row['level']>0)
				{
					$desc .= str_replace(['[NUM]', '[CLIENT_URL]', '[PROFILE]', '[LEVEL]'], [$number++, '[url=client://0/'.$row['client_unique_identifier'].'][b]'.$row['client_nickname'].'[/url]', ($profiles['enabled']==true ? ' - [url='.$profiles['url'].$row['client_database_id'].']Profil[/url]' : ''), $row['level']], $descriptions['clients_tops']['level']);
				}
			}
			
			$desc .= '[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cfg['level']['channel_id'],['channel_description'=>$desc]);
			unset($desc,$number,$data,$row);
		}
	}
	
}


?>