<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: save_to_event
#	DATE CREATED: 29/06/2018
#
##############################

class save_to_event
{
	function __construct($ts,$cfg,$sbot,$lang,$client,$db,$descriptions)
	{
		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','save_to_event');
			$sbot::check_ids($ts,$more['channel_id_list'],'channel','save_to_event');
			if($client['cid']!=$cid)
				continue;

			$channel = $ts->channelInfo($more['channel_id_list'])['data'];
			if(empty($channel['channel_description']))
			{
				$ts->channelEdit($more['channel_id_list'],['channel_description'=>'[center][size=20]'.$more['top_desc'].'[/size][/center][size=10]\n\n \n\n[/size]'.$lang['system']['footer']]);
			}
			unset($channel);
			$channel = $ts->channelInfo($more['channel_id_list'])['data'];
			if(strpos($channel['channel_description'], $client['client_nickname'])===FALSE)
			{
				$desc = explode('\n\n',$channel['channel_description']);
				$edit = $desc[0].'\n\n'.$desc[1].str_replace(['[CLIENT_URL]', '[SAVE_DATE]'], ['[url=client://'.$client['clid'].'/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url]', date('d/m/Y G:i')], $descriptions['save_to_event']['client_row']).$desc[2];
				$ts->clientPoke($client['clid'],$lang['save_to_event']['saved']);
				$ts->clientKick($client['clid'],'channel');
				$ts->channelEdit($more['channel_id_list'],['channel_description'=>$edit]);
				$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] został zapisany do eventu.');
			}
			else
			{
				$ts->clientPoke($client['clid'],$lang['save_to_event']['is_saved']);
				$ts->clientKick($client['clid'],'channel');
			}
		}
	}
	
}



?>