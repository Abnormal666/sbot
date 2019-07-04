<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: partners
#	DATE CREATED: 24/06/2018
#
##############################

class partners
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','partners');
			$i = rand(0,count($more)-1);
			$ts->channelEdit($cid,['channel_name' => $more[$i]['channel_name'], 'channel_description' => $more[$i]['channel_description']]);
		}
	}
	
}



?>