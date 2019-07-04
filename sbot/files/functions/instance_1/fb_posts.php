<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: fb_posts
#	DATE CREATED: 10/07/2018
#
##############################

class fb_posts
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','fb_posts');
		$desc = str_replace('[FP_ID]', $cfg['page_id'], $descriptions['fb_posts']['header']);
		$posts = json_decode(file_get_contents('https://graph.facebook.com/'.$cfg['page_id'].'/posts?access_token='.$cfg['api_key'].''),true)['data'];
		sleep(2);
		$likes = json_decode(file_get_contents('https://graph.facebook.com/'.$cfg['page_id'].'?access_token='.$cfg['api_key'].'&fields=name,fan_count'),true);
		$i=1;
		if(!empty($posts))
		{
			foreach($posts as $post)
			{
				if($i<=$cfg['post_view'] && !empty($post['message']))
					$desc .= str_replace(['[POST_NUM]', '[POST_CREATED]', '[FP_ID]', '[POST_ID]', '[POST_MSG]'], [$i++, date('d/m/Y G:i:s',strtotime($post['created_time'])), $cfg['page_id'], $post['id'], $post['message']], $descriptions['fb_posts']['post_row']);
			}
		}
		else
		{
			$desc .= $descriptions['fb_posts']['empty'];
		}
		$desc .= str_replace('[hr]', '', $lang['system']['footer']);
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc]);
		$ts->channelEdit($cfg['channel_id'],['channel_name'=>str_replace('[COUNT]', $likes['fan_count'], $cfg['channel_name'])]);
	}
	
}



?>