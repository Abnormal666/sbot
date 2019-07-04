<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: channellist
#	DATE CREATED: 15/07/2018
#
##############################

class channellist
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		$count = 0;
		foreach($ts->channelList()['data'] as $channel)
		{
			$ts->sendMessage(1,$invoker['clid'],'• Nazwa kanału: [color=green][b]'.$channel['channel_name'].'[/color]  |  » ID: [color=#0055ff][b]'.$channel['cid'].'[/color]  |  » URL: [url=channelid://'.$channel['cid'].']'.$channel['channel_name'].'[/url]');
			$count++;
		}

		$ts->sendMessage(1,$invoker['clid'],"Łączna ilość kanałów: [b][color=green]$count");
	}

}



?>