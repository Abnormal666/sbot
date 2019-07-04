<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: top
#	DATE CREATED: 23/09/2018
#
##############################

class top
{

	function __construct($ts,$cfg,$db,$lang,$sbot)
	{
		global $profiles;
		$cfg = $cfg['top'];
		$desc = '[center][size=20][b]'.$cfg['top_desc'].'[/b][/size][/center]\n[size=10]';
		$number = 1;
		$data = $db->query("SELECT * FROM `clients` ORDER BY `points` DESC LIMIT 50");

		while($row = $data->fetch(PDO::FETCH_ASSOC))
		{
			if($cfg['limit']>=$number && !empty($row['client_servergroups']) && !$sbot::in_group($cfg['ignored_groups'],$row['client_servergroups']) && $row['points']>0)
			{
				$desc .= '\n• '.$number++.'. [img]https://i.imgur.com/Mwm3Rfn.png[/img] [url=client://0/'.$row['client_unique_identifier'].'][b]'.$row['client_nickname'].'[/url]'.($profiles['enabled']==true ? ' - [url='.$profiles['url'].$row['client_database_id'].']Profil[/url]' : '').' - posiada [b][color=green]'.$row['points'].'[/color][/b] punktów';
			}
		}
		
		$desc .= '[/size]'.$lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc]);
		unset($desc,$number,$data,$row);
	}

}

?>