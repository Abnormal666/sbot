<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: bad_nicknames
#	DATE CREATED: 28/06/2018
#
##############################

class bad_nicknames
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($clients as $cl)
		{
			$cl = $cl['clid'];
			$client = $ts->clientInfo($cl)['data'];
			foreach($lang['bad_words'] as $word)
			{
				if(strpos($client['client_nickname'],$word)!==FALSE && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
				{
					$ts->clientPoke($cl, str_replace('[WORD]', $word, $lang['bad_nicknames']['nickname']['poke_message']));
					$ts->clientKick($cl,'server',str_replace('[WORD]', $word, $lang['bad_nicknames']['nickname']['kick_message']));
					$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']***[/url] został wyrzucony za niepoprawną nazwę.');
					break;
				}
				else if(strpos($client['client_description'], $word)!==FALSE && $cfg['check_description'])
				{
					$ts->clientEdit($cl,['client_description'=>str_replace($word, 'Niedozwolone słowo!', $client['client_description'])]);
					$ts->clientPoke($cl, str_replace('[WORD]', $word, $lang['bad_nicknames']['description']['poke_message']));
					$ts->clientKick($cl,'server',str_replace('[WORD]', $word, $lang['bad_nicknames']['description']['kick_message']));
					$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']***[/url] został wyrzucony za niepoprawny opis.');
					break;
				}
			}
			if($cfg['anty_agodzilla']['enabled']==true)
			{
				if(strpos(strtolower($client['client_description']), 'agodzilla')!==FALSE || strpos(strtolower($client['client_description']), 'dolo')!==FALSE || strpos(strtolower($client['client_myteamspeak_id']), 'agodzilla')!==FALSE || strpos(strtolower($client['client_myteamspeak_id']), 'dolo')!==FALSE || strpos(strtolower($client['client_meta_data']), 'agodzilla')!==FALSE || strpos(strtolower($client['client_meta_data']), 'dolo')!==FALSE || strpos(strtolower($client['client_talk_request_msg']), 'agodzilla')!==FALSE || strpos(strtolower($client['client_talk_request_msg']), 'dolo')!==FALSE || $client['client_talk_request_msg']==99999999)
				{
					$ts->banAddByIp($client['connection_client_ip'],$cfg['anty_agodzilla']['ban_time'],$cfg['anty_agodzilla']['reason']);
				}
			}
		}
		unset($word,$client,$cl);
	}
}

?>