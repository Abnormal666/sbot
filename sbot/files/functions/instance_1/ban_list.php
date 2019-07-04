<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: ban_list
#	DATE CREATED: 24/06/2018
#
##############################

class ban_list
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','ban_list');
		$ban_list = $ts->banList();
		#$desc = '[center][size=20][b]Lista banów[/b][/size][/center]\n[size=10]';
		$desc = $descriptions['ban_list']['header'];
		if($ban_list['success']!=1)
		{
			$desc .= $descriptions['ban_list']['empty_list'];
		}
		else
		{
			$i = 1;
			foreach(array_reverse($ban_list['data']) as $ban)
			{
				if($i<=$cfg['max_view'] && empty($ban['ip']))
				{
					if($ban['duration']==0)
						$duration = str_replace('[TIME]',$sbot::convert_time($ban['duration']),$descriptions['ban_list']['durations']['perm']);
					else
						$duration = $descriptions['ban_list']['durations']['time'];
					$desc .= str_replace(['[BAN_ID]', '[BANNED_NAME]', '[BANNED_UID]', '[BANNED_REASON]', '[DURATION]', '[BAN_CREATED]', '[BAN_OWNER]'], [$i++, $ban['lastnickname'], $ban['uid'], $ban['reason'], $duration, date('d/m/Y G:i',$ban['created']), $ban['invokername']], $descriptions['ban_list']['row']);
				}
			}
		}
		$desc .= '[/size]'.$lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc]);
		
	}
}

?>