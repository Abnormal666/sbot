<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: query_channel_list
#	DATE CREATED: 29/06/2018
#
##############################

class query_channel_list
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','query_channel_list');
		#$desc = '[center][size=20][b]Lista klientów query[/b][/size][/center][size=10]';
		$desc = $descriptions['query_channel_list']['header'];
		$count = 0;
		foreach($clients as $client)
		{
			if($client['client_platform']=='ServerQuery')
			{
				$channel = $ts->getElement('data',$ts->channelInfo($client['cid']));
				$desc .= str_replace(['[CLIENT_URL]', '[CHANNEL_ID]', '[CHANNEL_NAME]'], ['[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url]', $client['cid'], $channel['channel_name']], $descriptions['query_channel_list']['client_row']);
				$count++;
			}
		}

		if($count<=0)
			$desc .= $descriptions['query_channel_list']['empty_list'];

		$desc .= '[/size]'.$lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc,'channel_name'=>str_replace('[COUNT]', $count, $cfg['channel_name'])]);
	}
	
}



?>