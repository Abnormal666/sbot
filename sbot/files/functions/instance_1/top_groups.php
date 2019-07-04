<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: top_groups
#	DATE CREATED: 30/10/2018
#
##############################

class top_groups
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','top_groups');
		$groups = [];
		foreach($ts->serverGroupList(1)['data'] as $group)
		{
			$countg = 0;
			if(!in_array($group['sgid'], $cfg['ignored_groups']))
			{
				foreach($ts->serverGroupClientList($group['sgid'])['data'] as $rer)
				{
					$countg++;
				}
				if($countg>=$cfg['min_count'])
					$groups[$group['sgid'].'.'.$group['name']] = $countg;
			}
		}
		arsort($groups);
		$desc = $cfg['top_desc'];
		$number = 1;

		foreach($groups as $info => $count)
		{
			if($cfg['limit']>=$number)
			{
				list($sgid,$name) = explode('.', $info);
				$desc .= str_replace(['[NUM]','[GROUP_NAME]', '[GROUP_ID]', '[COUNT]'], [$number++, $name, $sgid, $count], $descriptions['top_groups']);
				
			}
		}
		
		$desc .= '[/size]'.$lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc]);
		unset($groups,$desc,$number,$info,$count,$sgid,$name);
	}
	
}


?>