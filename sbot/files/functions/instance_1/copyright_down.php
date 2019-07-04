<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: copyright_down
#	DATE CREATED: 02/11/2018
#
##############################

class copyright_down
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','copyright_down');
		$arrch = $ts->channelList()['data'];
		$arrch = array_reverse($arrch);
		if(isset($arrch[0]['cid']))
		{
			if($arrch[0]['cid']!=$cfg['channel_id'])
			{
				$ts->channelEdit($cfg['channel_id'],['CHANNEL_ORDER' => $arrch[0]['cid']]);
			}
		}
	}
	
}



?>