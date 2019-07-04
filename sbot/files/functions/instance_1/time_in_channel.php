<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: time_in_channel
#	DATE CREATED: 11/07/2018
#
##############################

class time_in_channel
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['clock']['channel_id'],'channel','time_in_channel_clock');
		$sbot::check_ids($ts,$cfg['date']['channel_id'],'channel','time_in_channel_date');
		if($cfg['clock']['enabled'])
		{
			$ts->channelEdit($cfg['clock']['channel_id'],['channel_name'=>str_replace('[TIME]', date($cfg['clock']['format']), $cfg['clock']['channel_name'])]);
		}
		if($cfg['date']['enabled'])
		{
			$ts->channelEdit($cfg['date']['channel_id'],['channel_name'=>str_replace('[TIME]', date($cfg['date']['format']), $cfg['date']['channel_name'])]);
		}
	}
	
}



?>