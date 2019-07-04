<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: youtube_in_channel
#	DATE CREATED: 10/07/2018
#
##############################

class youtube_in_channel
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		foreach($cfg['channels'] as $index => $more)
		{
			$sbot::check_ids($ts,$more['channel_id_main'],'channel','youtube_in_channel');
			$sbot::check_ids($ts,$more['channel_id_subs'],'channel','youtube_in_channel');
			$sbot::check_ids($ts,$more['channel_id_videos'],'channel','youtube_in_channel');
			$sbot::check_ids($ts,$more['channel_id_views'],'channel','youtube_in_channel');
			
			$contents = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id='.$more['user_id'].'&key='.$cfg['api_key']),true);
			$data = $contents['items'][0]['snippet'];
			$statistics = $contents['items'][0]['statistics'];
			$desc = str_replace(['[YT_NAME]','[YT_AVATAR]'], [$data['title'],$data['thumbnails']['default']['url']], $descriptions['youtube_in_channel']['header']);
			$desc .= str_replace(['[SUB_COUNT]', '[VIDEO_COUNT]', '[VIEW_COUNT]', '[USER_ID]', '[USER_DESCRIPTION]'], [self::short($statistics['subscriberCount']), $statistics['videoCount'], self::short($statistics['viewCount']), $more['user_id'], $data['description']], $descriptions['youtube_in_channel']['row']);

			$desc .= $lang['system']['footer'];

			$ts->channelEdit($more['channel_id_main'],['channel_description'=>$desc]);
			$ts->channelEdit($more['channel_id_subs'],['channel_name'=>str_replace('[COUNT]', self::short($statistics['subscriberCount']), $more['channel_name_subs'])]);
			$ts->channelEdit($more['channel_id_videos'],['channel_name'=>str_replace('[COUNT]', $statistics['videoCount'], $more['channel_name_videos'])]);
			$ts->channelEdit($more['channel_id_views'],['channel_name'=>str_replace('[COUNT]', self::short($statistics['viewCount']), $more['channel_name_views'])]);
		}
	}

	private function short($count)
	{
		if($count>=1000000)
		{
			return round($count/1000000,1).' mln.';
		}
		else if($count>=1000)
		{
			return round($count/1000,1).' tys.';
		}
		else
			return $count;
	}
	
}



?>