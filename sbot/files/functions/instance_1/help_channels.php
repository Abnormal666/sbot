<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: help_channels
#	DATE CREATED: 11/07/2018
#
##############################

class help_channels
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','help_channels');
			$channel = $ts->channelInfo($cid)['data'];
			if($more['type']=='time')
			{
				if($channel['channel_name']!=$more['channel_name_open'] && (time()>=strtotime($more['time_open']) && time()<strtotime($more['time_close'])))
				{
					$ts->channelEdit($cid,[
						'channel_name' => $more['channel_name_open'],
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_flag_maxclients_unlimited' => 1,
						'channel_maxfamilyclients' => '0',
					]);
				}
				else if($channel['channel_name']!=$more['channel_name_close'] && !(time()>=strtotime($more['time_open']) && time()<strtotime($more['time_close'])))
				{
					$ts->channelEdit($cid,[
						'channel_name' => $more['channel_name_close'],
						'channel_flag_maxfamilyclients_unlimited' => 0,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_maxfamilyclients' => '0',
						'channel_flag_maxclients_unlimited' => 0,
					]);
				}
			}
			else if($more['type']=='admins')
			{
				$admins = 0;
				foreach($clients as $client)
				{
					if($sbot::in_group($more['admin_groups'],$client['client_servergroups']))
						$admins++;
				}
				if($channel['channel_name']!=$more['channel_name_open'] && $admins>0 && $admins!=0)
				{
					$ts->channelEdit($cid,[
						'channel_name' => $more['channel_name_open'],
						'channel_flag_maxfamilyclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_flag_maxclients_unlimited' => 1,
						'channel_maxfamilyclients' => '0',
					]);
				}
				else if($channel['channel_name']!=$more['channel_name_close'] && $admins==0)
				{
					$ts->channelEdit($cid,[
						'channel_name' => $more['channel_name_close'],
						'channel_flag_maxfamilyclients_unlimited' => 0,
						'channel_flag_maxfamilyclients_inherited' => 0,
						'channel_maxfamilyclients' => '0',
						'channel_flag_maxclients_unlimited' => 0,
					]);
				}
			}
			unset($channel);
		}
	}
	
}



?>