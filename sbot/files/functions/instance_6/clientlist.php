<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: clientlist
#	DATE CREATED: 15/07/2018
#
##############################

class clientlist
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		$count = 0;
		foreach($ts->clientList('-uid')['data'] as $client)
		{
			$ts->sendMessage(1,$invoker['clid'],'• Nick: [color=green][b]'.$client['client_nickname'].'[/color]  |  » ID: [color=#0055ff][b]'.$client['clid'].'[/color]  |  » UID: [color=orange][b]'.$client['client_unique_identifier'].'[/color]  |  » DBID: [color=green][b]'.$client['client_database_id'].'[/color]  |  » Na kanale: [color=orange][b]'.$ts->channelInfo($client['cid'])['data']['channel_name'].'[/color]  |  » Id kanału: [color=#0055ff][b]'.$client['cid'].'[/color]  |  » URL: [url=client://'.$client['clid'].'/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url]');
			$count++;
		}
		$ts->sendMessage(1,$invoker['clid'],"Łączna ilość użytkowników online: [b][color=green]$count");
	}

}



?>