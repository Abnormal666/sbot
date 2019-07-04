<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: description_checker
#	DATE CREATED: 23/09/2018
#
##############################

class description_checker
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','description_checker');
		$channels = [];
		$desc = '';
		foreach($ts->channelList()['data'] as $channel)
		{
			if($channel['cid']!=$cfg['channel_id'] && !in_array($channel['cid'], $cfg['ignored_channels']))
			{
				$channels[] = $channel['cid'];
			}
		}
	
		foreach($channels as $cid)
		{
			$channel = $ts->channelInfo($cid)['data'];
			$desc = $channel['channel_description'];
			$links = [];
			# Źródło: https://css-tricks.com/snippets/php/find-urls-in-text-make-links/
			preg_match_all("/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/", strtolower($desc), $links);
			$links = $links[0];
			foreach($links as $link)
			{
				$found = true;
				foreach($cfg['allowed_links'] as $allowed_link)
				{
					if(strpos(strtolower($link), strtolower($allowed_link))!==FALSE)
					{
						$found = false;
						break;
					}
				}
				if($found==true)
				{
					$desc = str_replace($link, 'ZAKAZANY LINK ~ SBOT SECURITY', strtolower($desc));	
					$db->query("INSERT INTO `description_checker_logs` (`content`,`date`) VALUES ('Wykryto zakazany link na kanale: [url=channelid://".$cid."]".$channel['channel_name']." (Id kanału: ".$cid.")[/url] - [color=green][b]".$link."[/b][/color].','".time()."')");
					$ts->channelEdit($cid, array('channel_description' => $desc));
				}
			}
		}
		
		$logs = '[center][size=20][b]Usunięte linki[/b][/size][/center][size=10]\n';
		foreach(array_reverse($db->query("SELECT * FROM `description_checker_logs`")->fetchAll(PDO::FETCH_ASSOC)) as $row)
		{
			$logs .= '• [b]'.date('d/m/Y G:i',$row['date']).'[/b] | '.$row['content'].'\n';
		}
		$logs .= $lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'], ['channel_description' => $logs]);
	}
	
}



?>