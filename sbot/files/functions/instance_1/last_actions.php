<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: last_actions
#	DATE CREATED: 29/07/2018
#
##############################

class last_actions
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','last_actions');
		#$desc = '[center][size=20][b]Ostatnie Akcje[/b][/size][/center]\n[size=10]';
		$desc = $descriptions['last_actions']['header'];
		$number = 1;
		$data = $db->query("SELECT * FROM `last_actions` ORDER BY `id` DESC LIMIT ".$cfg['show_limit']);

		while($row = $data->fetch(PDO::FETCH_ASSOC))
		{
			if(!empty($row['action']))
			{
				$desc .= str_replace(['[DATE]','[ACTION]'], [date('d/m/Y G:i',$row['time']), $row['action']], $descriptions['last_actions']['action_row']);
			}
		}
		
		$desc .= '[/size]'.$lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc]);
	}
	
}


?>