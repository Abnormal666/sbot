<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: anty_record
#	DATE CREATED: 28/06/2018
#
##############################

class anty_record
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($clients as $client)
		{
			if($client['client_platform']!='ServerQuery' && $client['client_is_recording']==1 && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
			{
				$ts->clientPoke($client['clid'],$lang['anty_record']['poke_message']);
				$ts->clientKick($client['clid'],'server');
				$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] został wyrzucony za nagrywanie.');
			}
		}
	}
}

?>