<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: add_description
#	DATE CREATED: 23/09/2018
#
##############################

class add_description
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($ts->channelList()['data'] as $ch)
		{
			$channel = $ts->channelInfo($ch['cid'])['data'];
			if(!isset($channel['channel_description']) || empty($channel['channel_description']))
			{
				$ts->channelEdit($ch['cid'],['channel_description'=>$cfg['description']]);
			}
			else
			{
				if($cfg['replace']['enabled'])
				{
					$ts->channelEdit($ch['cid'],['channel_description'=>str_replace($cfg['replace']['from'], $cfg['replace']['on'], $channel['channel_description'])]);
				}
			}
			unset($channel);
		}
	}
	
}



?>