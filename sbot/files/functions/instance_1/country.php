<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: country
#	DATE CREATED: 24/06/2018
#
##############################

class country
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','country');
		$users = [];
		$count = 0;
		foreach($clients as $client)
		{
			if($client['client_country']!='PL' && isset($client['client_country']) && $client['client_platform']!='ServerQuery' && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
			{
				$count++;
				$users[] = $client;
			}
		}
		#$desc = '[center][size=20][b]Lista osób spoza Polski[/b][/size][/center]\n[size=11]';
		$desc = $descriptions['country']['header'];
		if($count>0)
		{
			foreach($users as $user)
			{
				$desc .= str_replace(['[CLIENT_URL]', '[COUNTRY]'], ['[url=client://'.$user['clid'].'/'.$user['client_unique_identifier'].']'.$user['client_nickname'].'[/url]', self::get_country(strtolower($user['client_country']))], $descriptions['country']['client_row']);
			}
		}
		else
			$desc .= $descriptions['country']['empty_list'];
		
		$desc .= '[/size]'.$lang['system']['footer'];
		$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc,'channel_name'=>str_replace('[COUNT]',$count,$cfg['channel_name'])]);
	}
	
	private function get_country($tag)
	{
		$countries = array
		(
			'ae' => 'Zjednoczone Emiraty Arabskie',
			'af' => 'Afganistan',
			'al' => 'Albania',
			'ar' => 'Argentyna',
			'at' => 'Austria',
			'au' => 'Australia',
			'ba' => 'Bośnia i Hercegowina',
			'bb' => 'Barbados',
			'bd' => 'Bangladesz',
			'be' => 'Belgia',
			'bg' => 'Bułgaria',
			'bo' => 'Boliwia',
			'br' => 'Brazylia',
			'by' => 'Białoruś',
			'ca' => 'Kanada',
			'ch' => 'Szwajcaria',
			'cn' => 'Chiny',
			'co' => 'Kolumbia',
			'cy' => 'Cypr',
			'cz' => 'Czechy',
			'de' => 'Niemcy',
			'dk' => 'Dania',
			'dz' => 'Algieria',
			'ec' => 'Ekwador',
			'ee' => 'Estonia',
			'eg' => 'Egipt',
			'es' => 'Hiszpania',
			'fi' => 'Finlandia',
			'fr' => 'Francja',
			'gb' => 'Wielka Brytania',
			'gr' => 'Grecja',
			'hr' => 'Chorwacja',
			'hu' => 'Węgry',
			'id' => 'Indonezja',
			'ie' => 'Irlandia',
			'il' => 'Izrael',
			'in' => 'Indie',
			'iq' => 'Irak',
			'ir' => 'Iran',
			'it' => 'Włochy',
			'jp' => 'Japonia',
			'kn' => 'Saint Kitts i Nevis',
			'kp' => 'Korea Północna',
			'lr' => 'Liberia',
			'lt' => 'Litwa',
			'lv' => 'Łotwa',
			'mc' => 'Monako',
			'md' => 'Mołdawia',
			'mx' => 'Meksyk',
			'nl' => 'Holandia',
			'no' => 'Norwegia',
			'nz' => 'Nowa Zelandia',
			'ph' => 'Filipiny',
			'pk' => 'Pakistan',
			'pl' => 'Polska',
			'pt' => 'Portugalia',
			'py' => 'Paragwaj',
			'ro' => 'Rumunia',
			'ru' => 'Rosja',
			'sa' => 'Arabia Saudyjska',
			'se' => 'Szwecja',
			'si' => 'Słowenia',
			'sk' => 'Słowacja',
			'tn' => 'Tunezja',
			'ua' => 'Ukraina',
			'us' => 'Stany Zjednoczone',
			'vn' => 'Wietnam',
		);
		if(!isset($countries[$tag]))
			return '???';
		else
			return $countries[$tag];
	}
}


?>