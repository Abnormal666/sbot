<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: private_channels_info
#	DATE CREATED: 28/07/2018
#
##############################

class private_channels_info
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$empty =0;
		$all = 0;
		$locked =0;
		$empty_list = '';
		$delete_today = '';
		$delete_tomorrow = '';
		foreach($ts->channelList('-topic -info')['data'] as $channel)
		{
			if($channel['pid']==$cfg['private_zone'])
			{
				$all++;
				if($channel['channel_topic']=='#empty')
				{
					$empty++;
					$empty_list .= explode('.', $channel['channel_name'])[0].', ';
				}
				else
				{
					$locked++;
					$channel_date = strtotime(str_replace('/','.',$channel['channel_topic']));
					if($channel_date<=strtotime('-9 days'))
					{
						$delete_today .= explode('.', $channel['channel_name'])[0].', ';
					}
					else if($channel_date<=strtotime('-8 days'))
					{
						$delete_tomorrow .= explode('.', $channel['channel_name'])[0].', ';
					}
				}
			}
		}
		if(strlen($empty_list)<=0) $empty_list = 'Brak';
		if(strlen($delete_today)<=0) $delete_today = 'Brak';
		if(strlen($delete_tomorrow)<=0) $delete_tomorrow = 'Brak';

		if($cfg['empty']['enabled'])
		{
			$ts->channelEdit($cfg['empty']['channel_id'],['channel_name'=>str_replace('[COUNT]', $empty, $cfg['empty']['channel_name'])]);
		}
		if($cfg['locked']['enabled'])
		{
			$ts->channelEdit($cfg['locked']['channel_id'],['channel_name'=>str_replace('[COUNT]', $locked, $cfg['locked']['channel_name'])]);
		}
		if($cfg['all']['enabled'])
		{
			$ts->channelEdit($cfg['all']['channel_id'],['channel_name'=>str_replace('[COUNT]', $all, $cfg['all']['channel_name'])]);
		}
		if($cfg['delete_info']['enabled'])
		{
			$desc = str_replace(['[EMPTY_LIST]', '[DELETE_TODAY]', '[DELETE_TOMORROW]'], [$empty_list, $delete_today, $delete_tomorrow], $descriptions['private_channels_info']['delete_info']).$lang['system']['footer'];
			$ts->channelEdit($cfg['delete_info']['channel_id'],['channel_description'=>$desc]);
		}
	}
}



?>