<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: admins_tops
#	DATE CREATED: 11/07/2018
#
##############################

class admins_tops
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['time_spent']['channel_id'],'channel','admins_tops');
		$sbot::check_ids($ts,$cfg['servergroups']['channel_id'],'channel','admins_tops');
		$sbot::check_ids($ts,$cfg['help_center']['channel_id'],'channel','admins_tops');
		
		$data = $db->query("SELECT * FROM `admins`")->fetchAll(PDO::FETCH_ASSOC);
		if($cfg['time_spent']['enabled'])
		{
			$desc = $descriptions['admins_tops']['time_spent']['header'];
			foreach($data as $row)
			{
				$desc .= str_replace(['[GROUP_NAME]', '[CLIENT_URL]', '[TIME_SPENT_DAY]', '[TIME_SPENT_WEEK]', '[TIME_SPENT_MONTH]', '[TIME_SPENT_ALL]'], [$row['group_name'], '[url=client://0/'.$row['client_unique_identifier'].'][b]'.$row['client_nickname'].'[/url]', $sbot::convert_time($row['time_spent_day']/1000), $sbot::convert_time($row['time_spent_week']/1000), $sbot::convert_time($row['time_spent_month']/1000), $sbot::convert_time($row['time_spent']/1000)], $descriptions['admins_tops']['time_spent']['client_row']);
			
			}
			
			$desc .= '[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cfg['time_spent']['channel_id'],['channel_description'=>$desc]);
		}
		unset($desc);

		if($cfg['servergroups']['enabled'])
		{
			$desc = $descriptions['admins_tops']['servergroups']['header'];
			foreach($data as $row)
			{
				$desc .= str_replace(['[GROUP_NAME]', '[CLIENT_URL]', '[REG_DAY]', '[REG_WEEK]', '[REG_MONTH]', '[REG_ALL]'], [$row['group_name'], '[url=client://0/'.$row['client_unique_identifier'].'][b]'.$row['client_nickname'].'[/url]', $row['groups_day_register'], $row['groups_week_register'], $row['groups_month_register'], $row['groups_total_register']], $descriptions['admins_tops']['servergroups']['reg_groups']);
				$desc .= str_replace(['[GROUPS_DAY]', '[GROUPS_WEEK]', '[GROUPS_MONTH]', '[GROUPS_ALL]'], [$row['groups_day_other'], $row['groups_week_other'], $row['groups_month_other'], $row['groups_total_other']], $descriptions['admins_tops']['servergroups']['other_groups']);
			
			}
			
			$desc .= '[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cfg['servergroups']['channel_id'],['channel_description'=>$desc]);
		}
		unset($desc);

		if($cfg['help_center']['enabled'])
		{
			$desc = $descriptions['admins_tops']['help_center']['header'];
			foreach($data as $row)
			{
				$desc .= str_replace(['[GROUP_NAME]', '[CLIENT_URL]', '[HELP_DAY]', '[HELP_WEEK]', '[HELP_MONTH]', '[HELP_TOTAL]', '[HELP_TIME_DAY]', '[HELP_TIME_WEEK]', '[HELP_TIME_MONTH]', '[HELP_TIME_TOTAL]'], [$row['group_name'], '[url=client://0/'.$row['client_unique_identifier'].'][b]'.$row['client_nickname'].'[/url]',
					$row['help_day'],$row['help_week'],$row['help_month'],$row['help_total'],($row['day_help_time']>1000 ? $sbot::convert_time($row['day_help_time']/1000) : '0 czasu'),($row['week_help_time']>1000 ? $sbot::convert_time($row['week_help_time']/1000) : '0 czasu'),($row['month_help_time']>1000 ? $sbot::convert_time($row['month_help_time']/1000) : '0 czasu'),($row['total_help_time']>1000 ? $sbot::convert_time($row['total_help_time']/1000) : '0 czasu') ], $descriptions['admins_tops']['help_center']['client_row']);
			}
			
			$desc .= '[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cfg['help_center']['channel_id'],['channel_description'=>$desc]);
		}
		unset($desc);
	}
	
}


?>