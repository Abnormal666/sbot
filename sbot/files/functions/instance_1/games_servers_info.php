<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: games_servers_info
#	DATE CREATED: 25/12/2018
#
# 	[PL] Funckja używa klasy dostępnej na github: // [EN] Function used class available on github:
#		https://github.com/Austinb/GameQ/
#
##############################

	require 'files/libs/GameQ/Autoloader.php';
class games_servers_info
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','games_servers_info');
			$GameQ = new \GameQ\GameQ();
			$GameQ->addServer([
			    'type' => $more['server_type'],
			    'host' => $more['server_host'],
			]);
			$results = $GameQ->process()[$more['server_host']];
			if(isset($results['num_players']))
				$online = $results['num_players'];
			else if(isset($results['numplayers']))
				$online = $results['numplayers'];
			else if(isset($results['sinumplayers']))
				$online = $results['sinumplayers'];
			else if(isset($results['clients']))
				$online = $results['clients'];
			if(isset($results['max_players']))
				$slots = $results['max_players'];
			else if(isset($results['maxplayers']))
				$slots = $results['maxplayers'];
			else if(isset($results['simaxplayers']))
				$slots = $results['simaxplayers'];
			else if(isset($results['maxclients']))
				$slots = $results['maxclients'];
			else if(isset($results['svmaxclients']))
				$slots = $results['svmaxclients'];


			if($results['gq_online'])
			{
				$desc = '[center][size=20][b]Serwer '.$more['server_name'].'[/b][/size][/center][size=11]\n[list]';
				$desc .= '[*][img]https://i.imgur.com/4zJumKC.png[/img] Osób online: [b]'.$online.'/'.$slots.'[/b]';
				$desc .= '[*][img]https://i.imgur.com/NSEcwRs.png[/img] Motd: [b]'.$results['hostname'].'[/b]';
				if(strtolower($more['server_type'])!='minecraft')
				{
					$desc .= '[*][img]https://i.imgur.com/KubYUXU.png[/img] Mapa: [b]'.$results['map'].'[/b]';
				}
				$desc .= '[*][img]https://i.imgur.com/6qJJGgl.png[/img] Wersja: [b]'.$results['version'].'[/b]';
				$desc .= '[*]Połącz się: [url='.$results['gq_joinlink'].']Kliknij tutaj[/url]';
				$desc .= '[/list][/size]'.$lang['system']['footer'];
				$ts->channelEdit($cid,['channel_name'=>str_replace(['[ONLINE]','[SLOTS]'], [$online,$slots], $more['channel_name'])]);
			}
			else
			{
				$desc = '[center][size=20][b]Serwer '.$more['server_name'].'[/b][/size][/center][size=11]\n[img]https://i.imgur.com/na3yGsj.png[/img] Serwer jest aktualnie wyłączony i nie możemy pobrać danych z tego serwera.';
				$desc .= '[/size]\n'.$lang['system']['footer'];
				$ts->channelEdit($cid,['channel_name'=> ''.$more['server_name'].' Offline']);
			}
			$ts->channelEdit($cid,['channel_description'=>$desc]);
			unset($desc,$online,$slots,$results,$cid,$more,$GameQ);
		}
	}
	
}



?>