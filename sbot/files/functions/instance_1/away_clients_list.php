<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: away_clients_list
#	DATE CREATED: 28/06/2018
#
##############################

class away_clients_list
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','away_clients_list');
		$aways = [];
		foreach($clients as $client)
		{
			if($client['client_platform']!='ServerQuery' && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
			{
				$client_info = $ts->getElement('data',$ts->clientInfo($client['clid']));
				if(($client_info['client_idle_time'] >= ($cfg['afk_time']*1000*60)) || ($client_info['client_output_muted']==1) || ($client_info['client_away']==1))
				{
					$aways[] = $client;
				}
			}
		}

		#$desc = '[center][size=20][b]Lista użytkowników away[/b][/size][/center]\n[size=11]';
		$desc = $descriptions['away_clients_list']['header'];
		if(!empty($aways))
		{
			foreach($aways as $client)
			{
				$desc .= str_replace('[CLIENT_URL]', '[url=client://0/'.$client['client_unique_identifier'].'][b]'.$client['client_nickname'].'[/url]', $descriptions['away_clients_list']['client_row']);
			}
		}
		else
		{
			$desc .= $descriptions['away_clients_list']['empty_list'];
		}

		$desc .= '[/size]'.$lang['system']['footer'];

		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc,'channel_name'=>str_replace('[COUNT]', count($aways), $cfg['channel_name'])]);
	}
}

?>