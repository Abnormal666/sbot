<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: public_channels_sort
#	DATE CREATED: 21/07/2018
#
##############################

class public_channels_sort
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($cfg['channels'] as $index => $more)
		{
			$sbot::check_ids($ts,$more['zone_id'],'channel','public_channels_sort');
			$all = 0;
			$free = [];
			$free['count']=0;
			foreach ($ts->channelList()['data'] as $channel)
			{
				if($channel['pid']==$more['zone_id'])
				{
					$all++;
					if($channel['total_clients']==0)
					{
						$free['cids'][] = $channel['cid'];
						$free['count']++;
					}
				}
			}
			unset($channel);
			if($free['count']>$more['min_channels'])
			{
				foreach(array_reverse($free['cids']) as $cid)
				{
					if($free['count']!=$more['min_channels'])
					{
						$ts->channelDelete($cid,1);
						$free['count']--;
						sleep(1);
					}
				}
				unset($cid);
			}
			elseif($free['count']<$more['min_channels'])
			{
				for($i=$free['count']; $i<$more['min_channels']; $i++)
				{
					if($more['clients_limit']==0)
					{
						$ts->channelCreate([
							'channel_name' => str_replace(['[NUM]','[COUNT]'], [++$all,0], $more['channel_name']),
							'cpid' => $more['zone_id'],
							'channel_flag_permanent' => 1,
							'channel_flag_maxclients_unlimited' => 1,
							'channel_flag_maxfamilyclients_unlimited' => 1,
						]);
					}
					else
					{
						$ts->channelCreate([
							'channel_name' => str_replace(['[NUM]','[COUNT]'], [++$all,0], $more['channel_name']),
							'cpid' => $more['zone_id'],
							'channel_maxclients' => $more['clients_limit'],
							'channel_flag_permanent' => 1,
							'channel_flag_maxclients_unlimited' => 0,
							'channel_flag_maxfamilyclients_unlimited' => 1,
						]);
					}
					sleep(1);
				}
				unset($i);
			}
		}
		unset($all,$free,$more,$index);
		if($cfg['clients_count'])
		{
			foreach($cfg['channels'] as $index => $more)
			{
				$i = 1;
				foreach($ts->channelList()['data'] as $channel)
				{
					if($channel['pid']==$more['zone_id'])
					{
						$ts->channelEdit($channel['cid'],['channel_name'=>str_replace(['[NUM]','[COUNT]'], [$i++,count($ts->channelClientList($channel['cid'])['data'])], $more['channel_name'])]);
					}
				}
			}
			unset($index,$more,$i,$channel);
		}

	}

	
}



?>