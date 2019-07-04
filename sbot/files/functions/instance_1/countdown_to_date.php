<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: countdown_to_date
#	DATE CREATED: 24/06/2018
#
##############################

class countdown_to_date
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','countdown_to_date');
			$date = explode(' ',$more['date']);
			$days = explode('/',$date[0]);
			$hours = explode(':',$date[1]);
			if($more['type']=='down')
				$counter = mktime($hours[0], $hours[1],0,$days[1],$days[0], $days[2])-time();
			else if($more['type']=='from')
				$counter = time()-mktime($hours[0], $hours[1],0,$days[1],$days[0], $days[2]);
			
			$ts->channelEdit($cid,['channel_name'=>str_replace('[COUNTER]', ($counter<=0 ? 'Odliczno' : $sbot::convert_time($counter,true,true)), $more['channel_name']), 'channel_topic' => $more['date']]);
		}
	}
	
}



?>