<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: dj_in_channel
#	DATE CREATED: 11/07/2018
#
##############################

class dj_in_channel
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['channel_id_name'],'channel','dj_in_channel');
		$talking = false;
		foreach($ts->channelClientList($cfg['channel_id'],'-voice')['data'] as $client)
		{
			if($client['client_is_talker']==1)
			{
				$talking = true;
				break;
			}
			else
			{
				$talking = false;
			}
		}
		if($talking==true)
			$ts->channelEdit($cfg['channel_id_name'],['channel_name'=>str_replace('[NAME]', $client['client_nickname'], $cfg['channel_name'])]);
		else
			$ts->channelEdit($cfg['channel_id_name'],['channel_name'=>str_replace('[NAME]', 'Brak', $cfg['channel_name'])]);
		unset($client,$talking);
	}
	
}



?>