<?php

/**
 *
 *	@name  SBOT v6.0 PREMIUM
 *	@author  `DEMON.
 *	@file  config.php
 *	@copyright  Copyright (c) 2018-2019, Julian '`Demon.'
 *	
**/

$config = [];


/**
 *	(PL) Inne ustawienia
 *  (EN) Other settings
**/
$config['settings']['other'] = [

	# Link do profili (jest w funkcjach: admin_list, admins_online, online_from_groups)
	# Zaproponował: Arek
	'profiles' => [
		'enabled' => false, # Włacz - True | Wyłącz - False
		'url' => 'http://link.pl/?profile&dbid=', # Link do profili
	],
	

	# Logi bota
	'logs' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'delete_time' => '3', # Liczba w dniach | Po jakim czasie logi mają się usuwać, włącznie z plikami błędów
	],

	# Czy blacklista ma być włączona na serwerze? Włacz - True | Wyłącz - False
	'blacklist' => true,

	# Nazwa pliku języka (ściezka: files/languages/nazwa.php). Podawaj nazwy bez .php i z małych liter najlepiej!
	# Domyślnie pl
	'language' => 'pl', 

];


/**
 *	(PL) Ustawienia pierwszej instancji
 *  (EN) Settings first instance
**/
$config['settings']['1'] = [

		# Nazwa bota
		'bot_name' => 'SBOT » Aktualizator',


		# Instance enabled
		'instance_enabled' => true,
		

		# Domyślny kanał
		'default_channel' => 2,
		

		# Baza danych
		# Włacz - True | Wyłącz - False
		'database_enabled' => true,
		

		# Nazwa systemu
		# Dla bezpieczeństwa nie zmieniać,bo moze wybuchnąć
		'system_type' => '@functions',
		

		# Nazwa folderu
		# Domyślnie: instance_1
		'folder_name' => 'instance_1',
		

		# Czas odświerzania instnacji
		# Domyślnie: 1.5
		'interval' => 1.5,

];


/**
 *	(PL) Funkcje instancji
 *  (EN) Instance settings
**/
$config['functions']['1'] = [

	# •» ADD_DESCRIPTION - Funkcja służaca do uzupełnienia opisy gdy ten jest pusty
	'add_description' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'description'=>'\n\n[hr][center][img]https://i.imgur.com/kRigSTl.png?1[/img]\n',
		'replace' => [
			'enabled' => false, # Włacz - True | Wyłącz - False
			'from' => 'https://i.imgur.com/kRigSTl.png',
			'on' => 'https://i.imgur.com/kRigSTl.png?1',
		],
		'interval' => ['days' => 0,'hours' => 1,'minutes' => 0,'seconds' => 10],
	],


	# •» ADMIN_LIST - Funkcja wpisująca w opis kanał listę wszystkich administratorów z podanych grup
	'admin_list' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channels' => [
			# Id kanału => ['admin_groups' => [Grupy administracji], 'ignored_groups' => [Ignorowane grupy np. Urlop/Admin zajęty], 'top_desc'=>'Górna nazwa opisu'],
			5 => ['admin_groups' => [10,11,67,365],'ignored_groups' => [38], 'top_desc'=>'[center][img]https://i.imgur.com/Go0mB4I.png[/img][/center]\n'],
			1294 => ['admin_groups' => [373,375],'ignored_groups' => [0], 'top_desc'=>'[center][img]https://i.imgur.com/Go0mB4I.png[/img][/center]\n'],
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 2, 'seconds' => 10],
	],


	# •» ADMINS_ONLINE - Funkcja wpisująca w nazwę kanału ilość dostąpnych administratorów,a w jego opis listę dostępnych adminów
	'admins_online' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 22, # Id kanału
		'channel_name' => '[cspacer]• Dostępnych adminów: [COUNT]', # Nazwa kanału
		'admin_groups' => [10,11,67,365], # Grupy administracji
		'ignored_groups' => [38], # Ignorowane grupy, np. Urlop/Admin zajęty
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10],
	],


	# •» HELP_CHANNELS - Funkcja służaca do otwierania/zamykania centrum pomocy gdy jest to potrzebne
	'help_channels' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channels' => [
		#
		#	id_kanału => [
		#		'channel_name_open' => 'Nazwa kanału gdy ma być otwarte',
		#		'channel_name_close' => 'Nazwa kanału gdy ma być zamknięte',
		#		'type'=>'time', # Typ jaki ma być, dostępne: time - otiwera/zamyka cp o ustalonej godzinie | admins - otwiera gdy jest administracja i
		#						  zamyka gdy jej nie ma
		#		'time_open' => '14:00', # potrzebne do typu: time, ustala się godzinę otwarcia
		#		'time_close' => '21:00', # potrzebne do typu: time, ustala się godzinę zamknięcia
		#		'admin_groups' => [10,11,67,365], # potrzebne do typu: admins, wpisuje się wszystkie grupy administracyjne
		#	],
		#
			1539 => [
				'channel_name_open' => '• Support dla Standard',
				'channel_name_close' => '• Support dla Standard ( OFF )',
				'type'=>'time',
				'time_open' => '14:00',
				'time_close' => '17:00',
			],
			25 => [
				'channel_name_open' => '• Support dla Premium',
				'channel_name_close' => '• Support dla Premium ( Brak supportów )',
				'type'=>'admins',
				'admin_groups' => [10,365,11,67],
			],
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 15],
	],


	# •» ADMINS_TOPS - Funkcja służąca do zapisywania statystyk administracji na kanałach
	'admins_tops' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		# Spedzony czas przez administrację
		'time_spent' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'channel_id' => 232, # Id kanału do edycji
		],
		# Ilość nadanych grup przez administrację
		'servergroups' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'channel_id' => 233, # Id kanału do edycji
		],
		# Ilość udzielonej pomocy przez administrację
		'help_center' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'channel_id' => 234, # Id kanału do edycji
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 4, 'seconds' => 10],
	],


	# •» AWAY_CLIENTS_LIST - Funkcja służaca do wpisywania w opis kanału listy użytkowników away, a w nazwę ich ilość
	'away_clients_list' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'afk_time' => 30, # Czas away,w minutach
		'channel_id' => 79, # Id kanału
		'channel_name' => '• Ilość osób away: [COUNT]', # Nazwa kanału
		'ignored_groups' => [37,68,9],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10],
	],

	
	# •» BAN_LIST - Funkcja wpisująca w opis wszystkie bany z serwera
	'ban_list' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 56, # Id kanału
		'max_view' => 15, # Ilość wyświetlanych banów
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 2, 'seconds' => 10],
	],

	
	# •» SERVER_HOSTNAME - Funkcja wpisująca w nazwę serwera ilość osób online
	'server_hostname' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'name' => 'SBot.pl :: Użytkowników online: [ONLINE]/[MAX] ok. [%]', 
		'ignored_groups' => [37,68], # Ignorowane grupy, które nie będzie wliczać w online
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 15],
	],
	

	# •» SERVER_HOSTMESSAGE - Funkcja wpisująca w hosta wiadomość
	'server_hostmessage' => [
		#
		#	ZMIENNE:
		#
		#	[ONLINE] - Pokazuje ilość użytkowników online
		#	[MAX] - Pokazuje ilość slotów
		#	[UPTIME] - Pokazuje aktualny uptime serwera
		#	[RECORD] - Pokazuje rekord online
		#
		'enabled' => false, # Włacz - True | Wyłącz - False
		'message' => 'Witamy na [b]SBOT.pl[/b]\nAktualnie jest: [b][ONLINE]/[MAX][/b]\nUptime: [b][UPTIME][/b]\nRekord: [b][RECORD]',
		'ignored_groups' => [37,68], # Ignorowane grupy, które nie będzie wliczać w online
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 15],
	],
	

	# •» CLIENT_CHANNEL_STATUS - Funkcja wpisująca w nazwę kanału status administratora
	'client_channel_status' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'groups' => [10,11,67,365], # Grupy administracji
		'ignored_groups' => [38], # Grupy, w których wpisuje `Urlop`
		'channels' => [
	# DdbId klienta | Id kanału | Format nazwy kanału
			6 => [ # Początek użytkownika (od tą możesz kopiować)
				'channel_id' => 8, # Id kanału do edycji
				'format' => '• [NICK] - [STATUS]', # Nazwa kanału | Dostępne: [GROUP] [NICK] [STATUS]
				# Opis kanału
				'description' => [
					'enabled' => true, # Włacz - True | Wyłącz - False
					'fb' => 'sbotteamspeak', # Id z facebook (puste = nie wpisuje)
					'email' => 'diegopolska333@gmail.com', # Email (puste = nie wpisuje)
					'gadugadu' => '60535067', # Numer gg (puste = nie wpisuje)
					'telegram' => 'demonek', # Nazwa na telegram (puste = nie wpisuje)
				],
			], # Koniec jednego użytkownika
		],
		# Nazwy statusów
		'status_name' => [
			'online' => 'Dostępny', # Status: Dostępny
			'offline' => 'Niedostępny', # Status: Niedostępny
			'away' => 'Away', # Status: Away
			'ignored' => 'Urlop', # Status: Urlop // Gdy admin posiada grupę z `ignored_groups`
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 25],
	],


	# •» CLIENTS_TOPS - Funkcja służaca do wpisywania rankingów w opisy kanałów
	'clients_tops' => [
		'enabled' => true, # Włacz - True | Wyłącz - False

		# TOP: Spędzonego czasu
		'time_spent' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'limit' => 15, # Limit wyświetlanych topek
			'top_desc' => '[center][size=20][b][img]https://i.imgur.com/Xyn1c8Z.png[/img][/b][/size][/center]\n[size=10]', # Górny napis w opisie
			'channel_id' => 73, # Id kanału do edycji
			'ignored_groups' => [385,276,373,256], # Ignorowane grupy, które nie będą wyświetlane w topkach
		],

		# TOP: Ilość połączeń z serwerem
		'connections' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'limit' => 15, # Limit wyświetlanych topek
			'top_desc' => '[center][size=20][b][img]https://i.imgur.com/ZqYU3ek.png[/img][/b][/size][/center]\n[size=10]', # Górny napis w opisie
			'channel_id' => 74, # Id kanału do edycji
			'ignored_groups' => [385,276,373,256], # Ignorowane grupy, które nie będą wyświetlane w topkach
		],

		# TOP: Najdłuższe połączenia
		'connection_time' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'limit' => 15, # Limit wyświetlanych topek
			'top_desc' => '[center][size=20][b][img]https://i.imgur.com/kw3T3OZ.png[/img][/b][/size][/center]\n[size=10]', # Górny napis w opisie
			'channel_id' => 75, # Id kanału do edycji
			'ignored_groups' => [37,68,9], # Ignorowane grupy, które nie będą wyświetlane w topkach
		],

		# TOP: Spędzonego czasu away
		'idle_time' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'limit' => 15, # Limit wyświetlanych topek
			'top_desc' => '[center][size=20][b][img]https://i.imgur.com/jbFyMjK.png[/img][/b][/size][/center]\n[size=10]', # Górny napis w opisie
			'channel_id' => 76, # Id kanału do edycji
			'ignored_groups' => [37,68,9], # Ignorowane grupy, które nie będą wyświetlane w topkach
		],

		# TOP: Poziomów
		'level' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'limit' => 15, # Limit wyświetlanych topek
			'top_desc' => '[center][size=20][b][img]https://i.imgur.com/85dmTqB.png[/img][/b][/size][/center]\n[size=10]', # Górny napis w opisie
			'channel_id' => 219, # Id kanału do edycji
			'ignored_groups' => [37,68,9], # Ignorowane grupy, które nie będą wyświetlane w topkach
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 4, 'seconds' => 10],
	],


	# •» COPYRIGHT_DOWN - Funkcja służaca do przenoszenia kanału z copyrightem na sam doł serwera TS3
	'copyright_down' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 1374, # Id kanału, który ma przenosić
		'interval' => ['days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 35],
	],


	# •» COUNT_OF_DATABASE_CLIENTS - Funkcja służąca do wpisywania w nazwę kanału ilości klientów w bazie danych
	'count_of_database_clients' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 228, # Id kanału do edycji
		'channel_name' => '• Użytkowników w bazie danych: [COUNT]', # Nazwa kanału
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 5, 'seconds' => 10],
	],


	# •» COUNTDOWN_TO_DATE - Funkcja służaca do odliczania z danej daty i zapisywania w nazwie kanału
	# TIP: Format daty to: dd/mm/YYYY GG:ii
	'countdown_to_date' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channels' => [
			93 => [ // Boże narodzenie
				'date' => '24/12/2018 13:30', # Format
				'type' => 'down', # from - od | down - do
				'channel_name' => '» [COUNTER]',# Nazwa kanału | [COUNTER] - Odliczanie
			],
			1767 => [ // Sylwester
				'date' => '01/01/2019 00:01', # Format
				'type' => 'down', # from - od | down - do
				'channel_name' => '» [COUNTER]',# Nazwa kanału | [COUNTER] - Odliczanie
			],
			207 => [ // Powstanie sbota
				'date' => '24/06/2018 14:00',
				'type' => 'from', # from - od | down - do
				'channel_name' => '» [COUNTER]',
			],
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 20],
	],
	

	# •» COUNTRY - Funkcja wpisująca w opis kanału listę osób spoza Polski
	'country' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 62, # Id kanału
		'channel_name' => '• Osoby spoza Polski: [COUNT]', # Nazwa kanału
		'ignored_groups' => [37,68], # Ignorowane grupy
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 20],
	],


	# •» DESCRIPTION_CHECKER - Funkcja służaca do usunięcia niedozwolonych linków z opisu kanału
	'description_checker' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 355, # Id kanału gdzie będzie wpisywać wszystkie usuniete linki
		'allowed_links' => ['sbot','teamspeak','imgur','facebook','fb','zippyshare','youtube','twitter','telegram','instagram','tsforum','hastebin','pastebin','gyazo','mediafire','paypal','paysafecard','mega','openweathermap','s-forum','ts-stars','ggpht','youtube'], # Dozwolone adresy
		'ignored_channels' => [235], # Id kanałów ignorowanych.
		'interval' => ['days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10],
	],


	# •» ADD_DESCRIPTION - Funkcja służaca do uzupełnienia opisy gdy ten jest pusty
	'add_description' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'description'=>'\n\n[hr][center][img]https://i.imgur.com/kRigSTl.png?1[/img]\n',
		'replace' => [
			'enabled' => false, # Włacz - True | Wyłącz - False
			'from' => 'https://i.imgur.com/kRigSTl.png',
			'on' => 'https://i.imgur.com/kRigSTl.png?1',
		],
		'interval' => ['days' => 0,'hours' => 1,'minutes' => 0,'seconds' => 10],
	],


	# •» QUERY_CHANNEL_LIST - Funkcja służaca do wpisywania w opis kanału użytkowników query
	'query_channel_list' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 96, # Id kanału 
		'channel_name' => '• Klientów query: [COUNT]', # Nazwa kanału
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 10],
	],

	# •» FB_POSTS - Funkcja służaca do wpisywania w nazwę kanału ilości lajków z fanpage, a w opisie wypisywanie postów.
	# TIP: Musi być api z fb (poradnik w pliku: INSTRUCTION.txt)
	'fb_posts' => [
		'enabled' => false, # Włacz - True | Wyłącz - False
		'page_id' => 'sbotteamspeak', # Id strony
		'post_view' => 5, # Ilość wyświetlanych postów
		'channel_id' => 209, # Id kanału 
		'channel_name' => '• Posty z FanPage (Polubień: [COUNT])', # Nazwa kanału
		'api_key' => 'EAAeJw73ppiUBAHnxxLwh2tot3hl8EL6t4Nx2ZCalvKuEnn6JOtAkheQcqZBkWVdmTS9dHRHiks8FLDwNiFhlahZA9RdX551CTR0URDZBAfWI4ZAM2z14RZCpAMYENip1FsZBpxXxXzcBCikZA0MaKmmuzogOiU7m8sCXi1xa8skZAROp58SZAc2vT4', # Api
		'interval' => ['days' => 0, 'hours' => 1, 'minutes' => 1, 'seconds' => 1],
	],

	# •» YOUTUBE_IN_CHANNEL - Funkcja służaca do wpisywania w nazwy kanału statystyki, a w opis informacje z danego kanału na youtube
	# Zaproponował: textr1
	'youtube_in_channel' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'api_key' => 'AIzaSyCOXygGkGvU8Oivx7rvb9dZRCg03atjCvU', # Api youtube
		'channels' => [
			0 => [
				# Id youtubera można pozyskać z tej strony: https://commentpicker.com/youtube-channel-id.php podając url kanału.
				'user_id' => 'UCwBtP6NDQtsP5YBa4vuZqHA',
				# Id kanału, na którym będa wyświetlane główne informacje z kanału
				'channel_id_main' => 212,
				# Ilość subskrybcji
				'channel_id_subs' => 212,
				'channel_name_subs' => '• Friz ( Subskrybcji: [COUNT] )',
				# Ilość wyświetlenia
				'channel_id_views' => 213,
				'channel_name_views' => '» Ilość wyświetleń: [COUNT]',
				# Ilość kanałów
				'channel_id_videos' => 214,
				'channel_name_videos' => '» Ilość wyświetleń: [COUNT]',
			],
		],
		'interval' => ['days' => 0, 'hours' => 1, 'minutes' => 1, 'seconds' => 1],
	],



	# •» DJ_IN_CHANNEL - Funkcja służaca do wpisywania w nazwę kanału aktualnej osoby z talkpowerem
	'dj_in_channel' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 38, # Id kanału gdzie będzie dj
		'channel_id_name' => 215, # Id kanału gdzie wpisuje nazwę
		'channel_name' => '• Aktualnie gra: [NAME]',
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 15],
	],


	# •» GAMES_SERVERS_INFO - Funkcja służaca do pobierania danych z serwera gier i wpsiywania w kanał
	'games_servers_info' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		/**
			# [PL] Funckja używa klasy dostępnej na github: // [EN] Function used class available on github:
				https://github.com/Austinb/GameQ/

			# [PL] Id kanału, gdzie będą wpisywane opis i nazwa // [EN] Channel id for write description and name
			1772 => [ 
				'server_type' => 'minecraft', # [PL] Nazwa gry serwera (Poniżej jest lista) // [EN] Server game name (Below is the list)
				'server_host' => '37.187.143.232:25565', # [PL] IP serwera:Port serwera // [EN] Server address:Server port
				'server_name' => 'MineFox.pl', # [PL] Nazwa serwera // [EN] Own server name
				'channel_name' => '» MineFox.pl | Online: [ONLINE]/[SLOTS] ', # [PL] Nazwa kanału // [EN] Channel name
			],

			[PL] Dostępne zmienne w `channel_name` // [EN] Available vars in `channel_name`:
				[ONLINE] - Users online
				[SLOTS] - Server slots
			
			[PL] Często używane typy: // [EN] Often used server type:
				`minecraft` - Minecraft server
				`mta` - Multi Theft Auto
				`csgo` - Counter-Strike: Global Offensive
				`cs16` - Counter-Strike 1.6

			[PL] Cała lista z typami: // [EN] List of all types
				https://github.com/Austinb/GameQ/tree/v3/src/GameQ/Protocols

		**/
		'channels' => [
			1772 => [
				'server_type' => 'minecraft',
				'server_host' => '37.187.143.232:25565',
				'server_name' => 'MineFox.pl',
				'channel_name' => '» MineFox.pl | Online: [ONLINE]/[SLOTS] ',
			],
			1773 => [
				'server_type' => 'csgo',
				'server_host' => '193.33.176.95:27015',
				'server_name' => 'uwujka.pl',
				'channel_name' => '» uwujka.pl | Arena | Online: [ONLINE]/[SLOTS] ',
			],
		],
		'interval' => ['days' => 0,'hours' => 0,'minutes' => 4,'seconds' => 30],
	],


	# •» LAST_ACTIONS - Funkcja odpowiadająca za wypisywanie w nazwę kanału ostatnich akcji z bota
	'last_actions' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'show_limit' => 15, # Ilość akcji w opisie
		'channel_id'=>237, # Id kanału do edycji
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10],
	],


	# •» LAST_ACTIONS - Funkcja odpowiadająca za wypisywanie w nazwę kanału ostatnich akcji z bota
	'channels_logs' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'show_limit' => 15, # Ilość akcji w opisie
		'channel_id'=> 1248, # Id kanału do edycji
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10],
	],


	# •» TOP_GROUPS - Funkcja odpowiadająca za wypisywanie w opis kanału X grup z największą ilością osób w niej
	'top_groups' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'ignored_groups'=> [9,10,11,13,15,14], # Id kanału do edycji
		'min_count' => 5, # Minimalna liczba osób w grupie aby pokazywało w topce
		'limit' => 15, # Limit do topki
		'top_desc' => '[center][size=20][b]TOP 15 Wybieranych grup[/b][/size][/center]\n[size=10]', # Górna część opisu
		'channel_id' => 1372, # Id kanału do edycji
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10],
	],
	

	# •» MULTI_FUNCTIONS - Funkcja wpisująca w nazwy kanałów różne informacje
	'multi_functions' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'functions' => [
			'online' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'channel_id' => 49, # Id kanału
				'ignored_groups' => [37,68],
				'channel_name' => '• Użytkowników online: [CHANGE]', # Nazwa kanał
			],
			'packets' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'channel_id' => 50, # Id kanału
				'channel_name' => '• Średni packet losst: [CHANGE]', # Nazwa kanału
			],
			'ping' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'channel_id' => 51, # Id kanału
				'channel_name' => '• Ping serwera: [CHANGE]', # Nazwa kanału
			],
			'visits' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'channel_id' => 52, # Id kanału
				'channel_name' => '• Odwiedzono nas: [CHANGE]', # Nazwa kanału
			],
			'channels' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'channel_id' => 53, # Id kanału
				'channel_name' => '• Wszystkich kanałów: [CHANGE]', # Nazwa kanału
			],
			'clock' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'channel_id' => 175, # Id kanału
				'channel_name' => '• Aktualna godzina: [CHANGE]', # Nazwa kanału
				'format' => 'G:i', # Format kanału
			],
			'date' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'channel_id' => 176, # Id kanału
				'channel_name' => '• Aktualna data: [CHANGE]', # Nazwa kanału
				'format' => 'd/m/Y', # Format kanału
			],
			'uptime' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'channel_id' => 177, # Id kanału
				'channel_name' => '• UPTIME: [CHANGE]', # Nazwa kanału
			],
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10],
	],
	

	# •» RECORD_ONLINE - Funkcja odpowiadająca za spisywanie największej ilości osób na serwerze,a następnie wpisywania to na kanał
	'record_online' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 46, # Id kanału
		'channel_name' => '• Rekord online: [RECORD]', # Nazwa kanału
		'ignored_groups' => [], # Ignorowane grupy
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 10],
	],


	# •» NEW_CLIENTS_TODAY - Funkcja odpowiadająca za sczytywanie nowych użytkowników do bazy dancyh, a następnie wypisywanie ich do opisu kanału
	'new_clients_today' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 221, # Id kanału, na którym będzie wypisywana nazwa i opis
		'channel_name' => '• Nowych klientów dziś: [COUNT]', # Nazwa kanału
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 5],
	],

	
	# •» ONLINE_FROM_GROUP - Funkcja wpisująca w nazwę kanału ilość osób z grupy, a w opis ich listę
	'online_from_group' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channels' => [
		#	Id kanału |		Id grupy | Format nazwy kanału | Jak ma pokazywać stauts,
			/*
				`status_for` dostępne:
					- `time` - pokazuje czas np. 13 godziny 2 minuty
					- `date` - pokazuje date np. 17.02.2019 14:20
			*/
			65 => ['group_id' => 16, 'format' => '• Online z [GROUP_NAME]: [ONLINE]/[MAX]', 'status_for' => 'time'],
			66 => ['group_id' => 17, 'format' => '• Online z [GROUP_NAME]: [ONLINE]/[MAX]', 'status_for' => 'time'],
			1960 => ['group_id' => 399, 'format' => '• Online z [GROUP_NAME]: [ONLINE]/[MAX]', 'status_for' => 'date'],
			1961 => ['group_id' => 400, 'format' => '• Online z [GROUP_NAME]: [ONLINE]/[MAX]', 'status_for' => 'time'],
			1962 => ['group_id' => 401, 'format' => '• Online z [GROUP_NAME]: [ONLINE]/[MAX]', 'status_for' => 'date'],
			1963 => ['group_id' => 402, 'format' => '• Online z [GROUP_NAME]: [ONLINE]/[MAX]', 'status_for' => 'time'],
		],
		'db_formats' => [
			'vip_channels' => '• Online z [GROUP_NAME]: [ONLINE]/[MAX]',
			'elite_channels' => '[cspacer]Online z [GROUP_NAME]: [ONLINE]/[MAX]',
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10],
	],
	

	# •» PARTNERS - Funkcja wpisująca w nazwę i w opis partnerów co x sekund
	'partners' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		#
		#	PRZYKŁAD:
		#
		#	ID_KANAŁU => [ 
		#		0 => [
		#			'channel_name' => '• xSpeaker.pl | Najlepszy serwer TS3!',
		#			'channel_description' => 'Polecamy tego tsa...',
		#		],
		#		1 => [
		#			'channel_name' => '• SBot.pl | Usługi programistyczne',
		#			'channel_description' => 'Twórcy tego bota...',
		#		],
		#	],
		#
		'channels' => [
			59 => [
				0 => [
					'channel_name' => '• SBot.pl | Aplikacja pod serwery TS3',
					'channel_description' => '[center][size=20][b]Aplikacja SBOT[/b][/size][/center][size=10]\nJest to darmowa aplikacja automatyzująca serwery TeamSpeak3. Ma ona za zadanie ułatwiać pracę administratorom i umilać spędzony czas użytkonikom.\nBot wyróżnia się wydajnością oraz szybkością jak na taką liczbę funkcji. W bocie funkcje są podzielone na eventy te które mają sobię wykonywać co określony czas i pluginy czyli, te które mają się wykonać wtedy gdy muszą.\n[/size]\n[hr][right][img]https://i.imgur.com/NmtH4WW.png[/img]',
				],
				1 => [
					'channel_name' => '• Opnia Naszego bota!',
					'channel_description' => '[center][size=20][b]Opinia SBOT[/b][/size]\n[size=12]Jeżeli chcesz wystawić opinię naszego bota zapraszamy na fora[/size][/center][size=10]\n• [url=https://www.s-forum.pl/forum/99-opinie/]Przjedź do tematu na S-Forum.pl[/url][/size]\n[hr][right][img]https://i.imgur.com/NmtH4WW.png[/img]',
				],
			],
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10],
	],


	# •» WEATHER_IN_CHANNEL - Funkcja służaca do wpisywania w opis kanału pogody z danego miasta
	'weather_in_channel' => [
		'enabled' => false, # Włacz - True | Wyłącz - False
		'api_key' => '8e0ff1e21fd0e7eac017a1eeb087baf4', # Api z http://openweathermap.org
		'channels' => [
			'Warszawa' => [
				'channel_id' => 82, # Id kanału do edycji
				'channel_name' => '• Pogoda - [CITY_NAME]', # Nazwa kanału
				'country_tag' => 'PL', # Tag kraju skąd jest misto
			],
			'Kraków' => [
				'channel_id' => 83,
				'channel_name' => '• Pogoda - [CITY_NAME]',
				'country_tag' => 'PL',
			],
			'Częstochowa' => [
				'channel_id' => 84,
				'channel_name' => '• Pogoda - [CITY_NAME]',
				'country_tag' => 'PL',
			],
		],
		'interval' => ['days' => 0, 'hours' => 1, 'minutes' => 0, 'seconds' => 10],
	],




];

/**
 *	(PL) Ustawienia drugiej instancji
 *  (EN) Settings second instance
**/
$config['settings']['2'] = [

		# Nazwa bota
		'bot_name' => 'SBOT » Administrator',


		# Instance enabled
		'instance_enabled' => true,
		

		# Domyślny kanał
		'default_channel' => 2,
		

		# Baza danych
		# Włacz - True | Wyłącz - False
		'database_enabled' => true,
		

		# Nazwa systemu
		# Dla bezpieczeństwa nie zmieniać,bo moze wybuchnąć
		'system_type' => '@functions',
		

		# Nazwa folderu
		# Domyślnie: instance_2
		'folder_name' => 'instance_2',
		

		# Czas odświerzania instnacji
		# Domyślnie: 1.5
		'interval' => 1.5,

];


/**
 *	(PL) Funkcje instancji
 *  (EN) Instance settings
**/
$config['functions']['2'] = [


	# •» GET_CLIENTS - Funkcja służaca do sczytywania statystyk użytkowników
	# WYMAGANE do topek,poziomów,osiągnięć, no praktycznie do wszystkiego wiec nie wyłączaj tego lepiej :>
	'get_clients' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 20],
	],


	# •» CLEINT_LEVELS - Funkcja odpowiadająca za nadanie użytkownikowi poziomu za jego spędzony na serwerze czas
	# WAŻNE INFO: Czas na następną grupę resetuje się wraz z uzyskaniem nowej grupy.
	'client_levels' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		#
		#	PRZYDATNE:	
		#	1 godzina: 60
		#	2 godziny: 2*60
		#	1 dzień: 24*60
		#	2 dni: 2*24*60
		#
		'levels' => [
		# Level | Czas w minutach | Id grupy
			1 => ['time' => 1, 'group_id' => 56],
			2 => ['time' => 5, 'group_id' => 57],
			3 => ['time' => 60, 'group_id' => 58],
			4 => ['time' => 4, 'group_id' => 59],
			5 => ['time' => 8*60, 'group_id' => 60],
			6 => ['time' => 24*60, 'group_id' => 62],
			7 => ['time' => 5*60, 'group_id' => 63],
			8 => ['time' => 2*24*60, 'group_id' => 64],
			9 => ['time' => 3*60, 'group_id' => 65],
			10 => ['time' => 24*60, 'group_id' => 66],
		],
		'ignored_groups' => [37,9,68], # Grupy ignorowane
		'needed_groups' => [13], # Potrzebna jedna grupa z całej listy aby otrzymać poziom
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 4, 'seconds' => 10],
	],


	# •» ACHIEVEMENTS - Funkcja odpowiadająca za nadanie danej grupy za ilość połączeń i spędzony czas
	# Zaproponował: Polarnyy
	'achievements' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'connections_enabled' => true, # Czy osiągnięcia połączeń mają być łączone
		'time_spent_enabled' => true, # Czy osiągnięcia spędzonego czasu mają być łączone
		'add_first_level_group' => true, # Czy ma nadawać grupę np. '* Poziomy'
		'first_group' => 70, # Id grupy z nazwą np. '__-= Osiągnięcia =-__'
		'end_group' => 71, # Id grupy z nazwą np. '__-= Osiągnięcia Koniec =-__'
		'connections_group' => 74, # Id grupy z nazwą np. '* Połączenia' | Tylko gdy - connections_enabled jest na true
		'time_spent_group' => 75, # Id grupy z nazwą np. '* Spędzony czas' | Tylko gdy - time_spent_enabled jest na true
		'level_group' => 72, # Id grupy z nazwą np. '* Poziomy' | Tylko gdy są włączone poziomy i add_first_level_group jest na true
		'connections' => [
			# Index | Ilość połączeń | Id grupy
			0 => ['connections' => 1, 'group_id' => 76],
			1 => ['connections' => 10, 'group_id' => 77],
			2 => ['connections' => 100, 'group_id' => 78],
			3 => ['connections' => 200, 'group_id' => 79],
			4 => ['connections' => 250, 'group_id' => 80],
			5 => ['connections' => 500, 'group_id' => 81],
		],
		# Grupy ze spędzonym czasem
		'time_spent' => [
			# Index | Spędzony czas, w minutach | Id grupy
			0 => ['time_spent' => 1, 'group_id' => 82],
			1 => ['time_spent' => 1*60, 'group_id' => 83],
			2 => ['time_spent' => 5*60, 'group_id' => 84],
			3 => ['time_spent' => 10*60, 'group_id' => 85],
			4 => ['time_spent' => 24*60, 'group_id' => 86],
			5 => ['time_spent' => 10*24*60, 'group_id' => 87],
			6 => ['time_spent' => 20*24*60, 'group_id' => 88],
			7 => ['time_spent' => 50*24*60, 'group_id' => 89],
		],
		'needed_groups' => [13], # Wymagana jedna grupa z listy aby otrzymać osiągnięcia
		'ignored_groups' => [37,68,9], # Ignorowane grupy
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 15],
	],


	# •» RANDOM_GROUP - Funkcja służąca do losowania grupy 
	'random_group' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'for_time' => 1, # Czas nadania grupy | W dniach
		'needed_groups' => [13], # Potrzebane grupy do losowania
		'ignored_groups' => [37,10,11,68,9], # Ignorowane grupy w losowaniu
		'group_award_id' => 90, # Id grupy tzw. nagroda
		'channel_id' => 231, # Id kanału z wypisanymi zwycięzcami 
		'view_in_desc' => 30, # Ilość zwycięzców pokazanych w opisie
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 5, 'seconds' => 10],
	],


	# •» GET_STATISTICS_OF_ADMINS - Funkcja służąca do sczytywania statystyk administracji
	'get_admins' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'admin_groups' => [10,11,67,365],# Grupy administracji
		'register_groups' => [274,275], # Grupy rejestracji
		'support_channels' => [26,27,28],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 10],
	],


	# •» ADMINS_STATISTICS_SAVE_IN_CHANNEL - Funkcja służąca do zapisywania statystyk administracji na kanałach
	'admins_winner' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'today_enabled' => true, # Czy ma być nadawana grup "admin dnia"
		'today_group' => 189, # Id grupy np. 'admin dnia'
		'week_enabled' => true, # Czy ma być nadawana grup "admin tygodnia"
		'week_group' => 190, # Id grupy np. 'admin tygodnia'
		'month_enabled' => true, # Czy ma być nadawana grup "admin miesiąca"
		'month_group' => 191, # Id grupy np. 'admin miesiąca'
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 4, 'seconds' => 10],
	],

	# •» WELCOME_MESSAGE - Funkcja służaca do wysłania użytkownikowi wiadomości powitalnej
	'welcome_message' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'ignored_groups' => [], # Ignorowane grupy do online
		#
		#	DOSTĘPNE ZMIENNE DO UŻYCIA
		#	[NICKNAME] - Pokazuje nazwę użytkownika
		#	[UID] - Pokazuje unikalne id użytkownika
		#	[DBID] - Pokazuje id z bazy danych TSa
		#	[IP] - Pokazuje ip użytkownika
		#	[PLATFORM] - Pokazuje pltformę użytkownika
		#	[VERSION] - Pokazuje wersję użytkownika
		#	[COUNTY] - Pokazuje kraj użytkownika
		#	[LASTCONNECTED] - Pokazuje kiedy ostatni raz użytkownik połączył się z serwerem
		#	[CREATED] - Pokazuje kiedy użytkownik wszedł poraz pierwszy na serwer
		#	[TOTAL_CONNECTIONS] - Pokazuje ilość połączeń użytkownika
		#	[TIME_SPENT] - Pokazuje spędzony czas użytkownika
		#	[TIME_IDLE] - Pokazuje spędzony czas away użytkownika
		#	[TIME_CONNECTED] - Pokazuje najdłuższe połączenie użytkownika
		#	[LEVEL] - Pokazuje poziom użytkownika
		#	[RECORD] - Pokazuje rekord serwera
		#	[RECORD_DATE] - Pokazuje datę ustanowienia rekordu
		#	[ONLINE] - Pokazuje ilość użytkowników online
		#	[%] - Pokazuje procent ilości użytkowników online
		#	[SLOTS] - Pokazuje ilość slotów serwera
		#	[SERVER_NAME] - Pokazuje nazwę serwera
		#	[SERVER_UID] - Pokazuje unikalny identyfikator serwera
		#	[SERVER_PLATFORM] - Pokazuje pltformę serwera
		#	[SERVER_VERSION] - Pokazuje wersję serwera
		#
		#	Wiadomość zmienia się w pliku z językiem (ścieżka: files/language.php)
		#
		'messages' => [
			' ',
			'Witamy [color=orange][b][NICKNAME][/b][/color] na serwerze [color=orange][b]SBOT.pl[/b][/color]!',
			' ',
			'● Statystyki Serwera:',
			'Serwer działa bez przerwy już: [color=orange][b][SERVER_UPTIME][/b][/color],',
			'Wersja naszego serwera: [color=orange][b][SERVER_VERSION][/b][/color],',
			'Platforma serwera: [color=orange][b][SERVER_PLATFORM][/b][/color],',
			'Unikalny identyfikator serwera: [color=orange][b][SERVER_UID][/b][/color],',
			'Aktualnie na serwrze jest [color=green][b][ONLINE][/b][/color]/[color=red][b][SLOTS][/b][/color], czyli ok. [color=orange][b][%][/b][/color]',
			'Rekord naszego serwera to: [color=orange][b][RECORD][/b][/color] ustanowiony dnia [color=orange][b][RECORD_DATE][/b][/color]',
			' ',
			'● Statystyki o Tobie:',
			'Twój nick: [color=orange][b][NICKNAME][/b][/color],',
			'Twój unikalny identyfikator: [color=orange][b][UID][/b][/color],',
			'Twoje id w bazie danych: [color=orange][b][DBID][/b][/color],',
			'Twoje IP: [color=orange][b][IP][/b][/color],',
			'Twoja platforma: [color=orange][b][PLATFORM][/b][/color],',
			'Twoja wersja klienta: [color=orange][b][VERSION][/b][/color],',
			'Twoj kraj: [color=orange][b][COUNTY][/b][/color],',
			'Ostatni raz połączyłeś się: [color=orange][b][LASTCONNECTED][/b][/color],',
			'Dołączyłeś dnia: [color=orange][b][CREATED][/b][/color],',
			'Połączyłeś się z nami już: [color=orange][b][TOTAL_CONNECTIONS][/b][/color],',
			'Spędziłeś u nas już: [color=orange][b][TIME_SPENT][/b][/color],',
			'Łączny czas away: [color=orange][b][TIME_IDLE][/b][/color],',
			'Twoje najdłuższe połączonie wynosi: [color=orange][b][TIME_CONNECTED][/b][/color],',
			'Twój aktualny poziom: [color=orange][b][LEVEL][/b][/color],',
			' ',
			'[color=orange][b]Pozdrawiamy, ekipa serwera oraz Życzymy miłych i udanych rozmów![/b][/color]',
			' ',
		],
	],


	# •» AWAY_MOVE - Funkcja służaca do przenoszenia użytkowników będących away na odpowiedni kanał
	'away_move' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 39, # Id kanału
		'move_when_time' => true, # Czy ma przenieść gdy ktoś jest X czasu away
		'afk_time' => 25, # Czas afk w minutach
		'ignored_groups' => [10,11,37,68,67,34,35,365], # Ignorowane grupy
	],


	# •» AWAY_GROUP - Funkcja służaca do nadawania grupy użytkownikom będących away
	'away_group' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'group_id' => 39, # Id grupy 
		'add_when_time' => true, # Czy ma nadać grupę jak ktoś będzie X czasu away
		'afk_time' => 25, # Czas afk w minutach
		'ignored_groups' => [10,11,37,9,37,68,365], # Ignorowane grupy
	],
	

	# •» BANNER - Funkcja służąca do generowania banneru interaktywnego
	'banner' => [
		'enabled' => false, # Włacz - True | Wyłącz - False
		'background_name' => 'bg.png', # Nazwa obrazu (ściażka do pliku: files/cache/);
		'src_generated' => '/var/www/banner.png',
		#
		#	PRZYKŁAD:
		#
		#	'online' => [
		#		'color' => ['255','255','255'], # Kolor w rgb
		#		'coordies' => [760,51], # oś X, oś Y
		#		'size' => 50, # Wielkość
		#		'font' => 'font.ttf', # Nazwa pliku z czcionką (czcionki znajdują się w folderze: files/cache/fonts/)
		#	],
		#
		'elements' => [
		
			# Ilość użytkowników online
			'online' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'color' => ['255','255','255'],
				'coordies' => [760,51],
				'size' => 50,
				'font' => 'font.ttf',
				'ignored_groups' => [], # Ignorowane grupy
			],
			
			# Ilość administratorów online
			'admins' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'color' => ['0','0','0'],
				'coordies' => [796,149],
				'size' => 30,
				'font' => 'font.ttf',
				'admin_groups' => [9,10], # Id grup administracji
			],
			
			# Data/Godzina
			'date' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'color' => ['255','255','255'],
				'coordies' => [60,57],
				'size' => 50,
				'font' => 'font.ttf',
				'format' => 'G:i', # Format
			],
			
			# Rekord online
			'record' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'color' => ['0','0','0'],
				'coordies' => [796,108],
				'size' => 30,
				'font' => 'font.ttf',
			],
			
			# Ilość odwiedzin serwera
			'visits' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'color' => ['255','255','255'],
				'coordies' => [796,108],
				'size' => 30,
				'font' => 'font.ttf',
			],
			
			# Ilość lajków z fanpage
			# TIP: Musi być api (może być takie jak z fb_post)
			'fb_likes' => [
				'enabled' => true, # Włacz - True | Wyłącz - False
				'color' => ['255','255','255'],
				'coordies' => [796,108],
				'size' => 30,
				'font' => 'font.ttf',
				'page_id' => 'sbotteamspeak', # Id strony
				'api_key' => 'EAAeJw73ppiUBAKplZARXZCZC6y2NKPyyrwFcDXeCNlA3ZBFUHXYzosb0dvA6TIIyHQPRVgzjRbeCrQZBHz3LYT1Erlt8MZBr3AwMZA2XjIgyrHBYgOWpYtepW59YiHEHmYndewzWObSawe8QnoRk2uSCGNZCZBdpXUtFaFrG6tqlsSonZApp30i7EI', # Api
			],
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 10],
	],


	# •» PLATFORMS - Funkcja wykrywa platformę klienta oraz nadaje mu odpowiednią grupę
	'platforms' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'os' => [
			# Nazwa platformy | Włącz/Wyłącz | Id grupy
			'windows' => ['enabled' => true, 'group_id' => 18],
			'linux' => ['enabled' => true, 'group_id' => 19],
			'android' => ['enabled' => true, 'group_id' => 20],
			'ios' => ['enabled' => true, 'group_id' => 69],
		],
		'ignored_groups' => [37,68,9], # Ignorowane grupy
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 15],
	],


	# •» ADVERTISEMENT - Funkcja służaca do pisania co x czasu na głównym czasie wiadomości
	'advertisement' => [
		'enabled' => false, # Włacz - True | Wyłącz - False
		'messages' => [
			# Index => 'Wiadomość', # \n - nowa linia
			0 => 'Witamy na testowym serwerze aplikacji [b]SBot[/b] | Autor: [b]`Demon.[/b] | Aktualna wersja Standard: [b]4.4[/b] | Aktualna wersja Premium: [b]5.0[/b]',
			1 => '[b]SBOT Standard jest za [u][color=green]DARMO[/color][u]!',
			2 => 'Zapraszamy do wystawienia opini na s-forum: [url=https://www.s-forum.pl/topic/105-opinia-aplikacje-sbot/]PRZEJDŹ[/url]',
			3 => 'Zapraszamy na nowe forum o ogólnej tematyce! [url=https://www.s-forum.pl/]PRZEJDŹ[/url]',
		],
		'interval' => ['days' => 0, 'hours' => 1, 'minutes' => 1, 'seconds' => 20],
	],


	# •» SAVE_TO_EVENT - Funkcja służaca do zapisywania użytkowników, którzy wejdą na odpowiedni kanał na event
	# Zaproponował: Arek
	'save_to_event' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => [87,88,1565], # Id kanałów, po których użytkownik zostanie zapisany do listy
		#
		#	PRZYKŁAD:
		#
		#	id_kanału => [
		#		'channel_id_list' => id_kanału_z_listą,
		#		'top_desc' => 'Górna nazwa opisu',
		#	],
		#
		'channels' => [
			87 => [
				'channel_id_list' => 87,
				'top_desc' => 'Zapisy na EVENT #1',
			],
			88 => [
				'channel_id_list' => 89,
				'top_desc' => 'Zapisy na EVENT #2',
			],
		],
	],


	# •» GROUPS_REMOVE - Funkcja służaca do usunięcia użytkownikowi wszystkich ustalonych grup po wejściu na odpowiedni kanał
	'groups_remove' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => [218,217], # Id kanałów, po których użytkownikowi zostaną zabrane grupy
		'channels' => [
			# Id_kanału => [id_grupy1,id_grupy2],
			218 => [16,17],
			217 => [48,41,42,43,44,45,46,47,49],
		],
	],

	# •» BOT_CHECKER - Funkcja służaca do sprawdzania czy bot muzyczny (TS3AudioBot) gra coś, jeżeli nie włącza ustaloną piosenkę
	# Pomysłodawca: .Szopeł
	'bots_checker' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'bots' => [
			# dbid => 'co ma grac'
			4502 => '!play http://s2.radioparty.pl:8005/',
		],
		'interval' => ['days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 20],
	],

	# •» REGISTER_REMINDER - Funkcja służaca do informowania użytkownika o rejestracji
	'register_reminder' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'needed_groups' => [9], # Potrzebne grupy do informowania
		'ignored_group' => [14,15,13], # Grupy rejestracyjne (Grupy ignorowane)
		'time_to_info' => 30, # Czas co jaki ma informować | Wartość w minutach
		'type' => 'poke', # Typ informacji | Dostępne: `poke` / `msg`
		'interval' => ['days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 10],
	],

	# •» DDOS_ATTACK - Funkcja służaca do informowania gdy packetlosst serwera zwiększy się do danej liczby
	# Zaproponował: textr1
	'ddos_attack' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'type_information' => 'admins', # Dostępne: server - wysyła wiadomość na czacie globalnym | admins - wysyła wiadomość do niżej ustalonych grup
		'admin_groups' => [10,11,67,365], # Potrzebne gdy w 'type_information' jest ustawione 'admins'
		'min_packets' => 10, # Minimalna ilość pakietów do wysłania informacji
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 5],
	],


	# •» CLIENT_INFO - Funkcja służaca do wyświetlenia informacji o kliencie gdy ten wejdzie na odpowiedni kanał
	'client_info' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => 178, # Id kanału, którego po wejściu na niego otrzymamy zaczepke
		'type_information' => 'poke', # Dostępne: poke | msg
		# Pogoda użytkownika z jego IP
		'weather' => [
			'enabled' => false, # Włacz - True | Wyłącz - False
			'ip_api' => 'f1a4fa95d2ed5b730849876ed41efbb6fe790738f639676d718962c7fda0f24a', # Api IP (pobiera najbliższą miejscowość) http://ipinfodb.com
			'weather_api' => '8e0ff1e21fd0e7eac017a1eeb087baf4', # Api pogody (to samo api co z funkcją 'weather_in_channel')
		],
		#
		#	[NICKNAME] - Pokazuje nick użytkownika
		#	[UID] - Pokazuje unikalny identyfikator użytkownika
		#	[DBID] - Pokazuje database id użytkownika
		#	[IP] - Pokazuje ip użytwkowniak
		#	[VERSION] - Pokazuje wersję użytkownika
		#	[PLATFORM] - Pokazuje platformę użytkownika
		#	[CREATED] - Pokazuje kiedy użytkownik pierwszy raz połączył się z serwerem
		#	[CONNECTIONS] - Pokazuje ilość połączeń
		#	[TIME_SPENT] - Pokazuje spędzony czas użytkownika
		#	[IDLE_TIME] - Pokazuje spędzony czas idle użytkownika
		#	[CONNECTION_TIME] - Pokazuje najdłuższe połączenie użytkownika
		#	[WEATHER_CITY] - Pokazuje nazwę miasta skad pobiera pogodę
		#	[WEATHER_STATUS] - Pokazuje stan pogody użytkownika
		#	[WEATHER_TEMP] - Pokazuje ilość stopni użytkownika pogody
		#
		'messages' => [
			'Witaj [color=orange][b][NICKNAME]',
			'Twoje DBID: [color=orange][b][DBID]',
			'Twoje UID: [color=orange][b][UID]',
			'Twoja wersja TSa: [color=orange][b][VERSION]',
			'Twoja platforma: [color=orange][b][PLATFORM]',
			'Twoje IP: [color=orange][b][IP]',
			'Pierwszy raz połączyłeś sie: [color=orange][b][CREATED]',
			'Połączyłeś się z nami: [color=orange][b][CONNECTIONS] razy',
			'Spędziłeś: [color=orange][b][TIME_SPENT]',
			'Byłeś away przez: [color=orange][b][IDLE_TIME]',
			'Twoje najdłuższe połączenie: [color=orange][b][CONNECTION_TIME]',
			'Pogoda z: [color=#0055ff][b][WEATHER_CITY]',
			'Stan pogody: [color=#0055ff][b][WEATHER_STATUS]',
			'Ilość stopni: [color=#0055ff][b][WEATHER_TEMP]',
		],
	],


	# •» GUILDS_POKE - Funkcja służaca do zeczepiania osób typu lider w kanałach gildyjnych
	'guilds_poke' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => [1341], # Id kanałów, po które jak osoba na nie wejdzie gidlia otrzyma poke
		'channels' => [
		# Id kanału od poke | Id grupy gildii | Id grup kanałowych do poke
			1341 => ['group_id'=>220,'ch_groups'=>[12,14,15]],
		],
	],

	# •» ADMINS_MEETING - Funkcja służaca do automatycznego przeniesienia administracji i ustawienia opisu, oraz 1 godzinę przed zebraniem informuje wszystkich o zbiórce
	# Pro tip: Datę zebrania ustawia się w temacie kanału ( format: dd.mm.YY GG:ii ), natomiast gdy nie ma zebrania najlepiej wpisać 'none'
	'admins_meeting' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'channel_id' => 179, # Id kanału zebrania
		'send_info_1h' => true, # Czy 1 godzinę przez zebraniem ma wysyłać informację
		'admin_groups' => [10,11,67,365], # Grupy administracji
		'make_desc' => true, # Czy ma automatycznie uzupełnić opis, Wpisuje kto jest, a kogo nie ma.
	],
	

	# •» AUTO_REGISTER - Funkcja odpowiadająca za automatyczne nadanie grupy użytkownikowi gdy ten spędzi na serwerze odpowiedni czas
	'auto_register' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'register_group' => 13, # Id grupy rejestacji
		'time_spent' => 2, # W minutach
		'ignored_groups' => [37,68], # Ignorowane grupy
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 15],
	],
	

	# •» CHANNEL_REGISTER - Funkcja odpowiadająca za rejestrację użytkownika gdy ten wejdzie na kanał
	'channel_register' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => [31,32], # Kanał, na który ma wejść osoba, aby się zarejestrowała
		'groups' => [14,15], # Grupy rejestracji
		'channels' => [
		#	Id kanału |		Id grupy | Po jakim czacie ma nadawać
			31 => ['group_id' => 14, 'time_spent' => 5],
			32 => ['group_id' => 15, 'time_spent' => 5],
		],
	],


	# •» GROUPS_LIMIT - Funkcja służaca do dopilnowania aby każdy użytkownik na serwerze nie posiadał wiecej grup niż jest limit
	'groups_limit' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'ignored_groups' => [], # Ignorowane grupy
		'groups' => [
			0 => [ # Index
				'groups_id' => [26,27,28,29,30,31,32,36], # Id grup do sprawdzania
				'groups_limit' => 1, # Limit grup
			],
			1 => [
				'groups_id' => [48,41,42,43,44,45,46,47,49],
				'groups_limit' => 3,
			],
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 10],
	],
	

	# •» POKE_ADMINS - Funkcja służąca do zaczepiania dostępnych administratorów gdy ktoś wejdzie na kanał pomocy
	'poke_admins' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'ignored_groups' => [37], # Ignorowane grupy, które nie będą wliczane do zaczepki.
		'admin_ignored_groups' => [38], # Ignorowane grupy, które admin będzie posiadał to nie bedzie go zaczepiać.
		'channels' => [
		#
		#	id_kanału => ['groups' => [Grupy,Ktore,Ma,Zaczepiac], 'move_to' => true, 'support_channels' => [id kanałów od pomocy] ],
		#
			25 => ['groups' => [10,365,11,67], 'move_to' => true, 'support_channels' => [26,27,28,1345] ],
			1400 => ['groups' => [10], 'move_to' => true, 'support_channels' => [26,27,28,1345] ],
			1539 => ['groups' => [10,365,11,67], 'move_to' => true, 'support_channels' => [26,27,28,1345] ],
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 3],
	],
	

	# •» CHANNEL_ADD_GROUP - Funkcja odpowiadająca za nadanie lub zdjęcie grupy serwerowej gdy użytkownik wejdzie na kanał
	'channel_add_group' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => [69,70],
		'channels' => [
		#	Id kanału |	Id grupy | Czy ma usuwać po ponowym wejściu na kanał | Czy ma przenosić po nadaniu | Id kanały gdzie ma przenieść
			69 => ['group_id' => 16, 'remove' => true, 'move' => false, 'move_id' => 559],
			70 => ['group_id' => 17, 'remove' => true, 'move' => false, 'move_id' => 559],
		],
	],


	# •» CHANNEL_ADD_CHGR - Funkcja odpowiadająca za nadanie lub zdjęcie grupy kanałowej gdy użytkownik wejdzie na kanał
	'channel_add_chgr' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => [1923],
		'guest_channel_group_id' => 10, # Id grupy `gość kanału`
		'channels' => [
		#	Id kanału |	Id kanału gdzie ma nadać | Id grupy kanałowej | Czy ma usuwać po ponowym wejściu na kanał | Czy ma przenosić po nadaniu | Id kanały gdzie ma przenieść
			1923 => ['add_on_cid' => 1922, 'group_id' => 12, 'remove' => true, 'move' => true, 'move_id' => 1922],
		],
	],

	# •» BAD_NICKNAMES - Funkcja służaca do sprawdzania czy użytkownik nie posiada w nazwie niedozwolonego nicku
	# Brzydkie słowa sa od teraz w pliku z językiem
	'bad_nicknames' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'ignored_groups' => [10,11,67,37,68,365], # Ignorowane grupy
		'check_description' => true, # Czy ma sprawdzać opis użytkownika
		'anty_agodzilla' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'ban_time' => 0, # Czas na jaki ma banowac
			'reason' => 'SBOT Anty AGodZilla.', # Powód bana
		],
	],


	# •» ANTY_RECORD - Funkcja służaca do sprawdzania czy użytkownicy nie nagrywają na kanałach
	'anty_record' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'ignored_groups' => [10,11,67,37,68,365], # Ignorowane grupy
	],


	# •» SERVERGROUPS_SECURITY - Funkcja służaca do chronienia grup
	'servergroups_security' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'security_groups' => [10], # Wszystkie id grup chronionych
		'type_kick' => 'kick', # Typ wyrzucenia z serwera, dostępne: `kick` - wyrzuca z serwera, `ban` - banuje
		'ban_time' => 0, # Czas bana, gdy `type_kick` jest na `ban`.
		'clients' => [
			# client database id => [id grup]
			6 => [10],
		],
	],


	# •» CLIENT_PERMISSIONS_SECURITY - Funkcja służaca do wykrywania i usuwania permisji użytkownikom
	'client_permissions_security' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'ignored_groups' => [0], # Ignorowane grupy
		'ignored_permissions' => [], # Ignorowane permisje dla każdego
		'type_kick' => 'kick', # Typ wyrzucenia z serwera, dostępne: `kick` - wyrzuca z serwera, `ban` - banuje
		'ban_time' => 0, # Czas bana, gdy `type_kick` jest na `ban`.
		'clients' => [
			# client database id => [permisje],
			0 => [''],
		],
	],


	# •» IP_GROUP - Funkcja służaca do nadania danej grupy osobie, która ma takie samo ip jak w konfiguracji
	'ip_group' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'ips' => [
			'51.38.137.107' => '37',
		],
	],


	# •» ANTY_VPN - Funkcja służaca do wykrywania i wyrzucania użytkowników posiadających VPN
	'anty_vpn' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'ignored_groups' => [10,11,67,37,68,365], # Ignorowane grupy
	],


	# •» COMMANDER - Funkcja służaca do zaczepiania użytkowników z grupami aby włączyli channel commandera gdy nie mają włączonego
	'commander' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'admin_groups' => [10,11,67,365], # Grupy administracji
		'ignored_groups' => [38], # Ignorowane grupy
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 30],
	],

];


/**
 *	(PL) Ustawienia trzeciej instancji
 *  (EN) Settings third instance
**/
$config['settings']['3'] = [

		# Nazwa bota
		'bot_name' => 'SBOT » Strażnik kanałów',


		# Instance enabled
		'instance_enabled' => true,
		

		# Domyślny kanał
		'default_channel' => 2,
		

		# Baza danych
		# Włacz - True | Wyłącz - False
		'database_enabled' => true,
		

		# Nazwa systemu
		# Dla bezpieczeństwa nie zmieniać,bo moze wybuchnąć
		'system_type' => '@functions',
		

		# Nazwa folderu
		# Domyślnie: instance_1
		'folder_name' => 'instance_3',
		

		# Czas odświerzania instnacji
		# Domyślnie: 1.5
		'interval' => 1.5,

];


/**
 *	(PL) Funkcje instancji
 *  (EN) Instance settings
**/
$config['functions']['3'] = [
	


	# •» CHANNELS_CHECKER - Funkcja służaca do monitorowania kanałów prywatnych.
	# TIP: Brzydkie słowa sa od teraz w pliku z językiem
	# TIP: Ta funkcja automatycznie tworzy kanały prywatne!
	'channels_checker' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'private_zone' => 98, # Id kanału ze strefa
		'channels_count' => 5, # Ilość wolnych kanałów
		'delete_badword' => true, # Czy ma sprawdzać nazwy kanałów/podkanałów względem brzydkich słów
		'check_numbering' => true, # Czy ma sprawdzić poprawną kolejność numerowania kanałów
		# Sprawdzanie daty i usuwanie kanałów ze starą datą
		'date_checker'=> [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'warning' => '**ZMIEŃ DATE**', # Wygląd ostrzeżenia o zmianie daty
			'refresh' => true, # Czy ma odświeżać automatycznie datę gdy użytkownik będzie na głównym kanale
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 20],
	],


	# •» GET_PRIVATE_CHANNEL - Funkcja służaca do nadania peirwszego wolnego kanału prywatnego
	'get_private_channel' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => 33, # Id kanału, którego po wejściu na niego otrzymamy kanał prywatny
		'owner_channel_group' => 9, # Id grupy kanałowej typu Właściciel kanału
		'private_zone' => 98, # Id kanału ze strefą
		'sub_channels_count' => 3, # ilośc podkanałów
		'channel_password' => 'haslo12345', # Hasło jakie ma być ustawione po otrzymaniu kanału
		'needed_groups' => [13], # Wymagane grupy aby otrzymać kanał
	],


	# •» PUBLIC_CHANNELS_SORT - Funkcja służaca do monitorowania kanałów publicznych
	'public_channels_sort' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'clients_count' => true, # Czy ma pokazywać ile jest osób na kanale.
		#
		#	PRZYKŁAD:
		#
		#	0 => [ # Index
		#		'channel_name' => '» Kanał publiczny #[NUM] (bez limitu)', # Nazwa kanału
		#		'min_channels' => 1, # Minimalna ilość kanałów
		#		'clients_limit' => 0, # Limit klientów na kanale | 0 oznacza nielimitowane
		#		'zone_id' => 182, # Id kanału od strefy
		#	],
		#
		#
		'channels' => [
			0 => [ # Index
				'channel_name' => '» Kanał publiczny #[NUM] ([COUNT]/∞)', # Nazwa kanału
				'min_channels' => 1, # Minimalna ilość kanałów
				'clients_limit' => 0, # Limit klientów na kanale | 0 oznacza nielimitowane
				'zone_id' => 182, # Id kanału od strefy
			],
			1 => [
				'channel_name' => '» Kanał publiczny #[NUM] ([COUNT]/2)',
				'min_channels' => 1,
				'clients_limit' => 2,
				'zone_id' => 183,
			],
			2 => [
				'channel_name' => '» Kanał publiczny #[NUM] ([COUNT]/3)',
				'min_channels' => 1,
				'clients_limit' => 3,
				'zone_id' => 184,
			],
			3 => [
				'channel_name' => '» Kanał publiczny #[NUM] ([COUNT]/4)',
				'min_channels' => 1,
				'clients_limit' => 4,
				'zone_id' => 185,
			],
			4 => [
				'channel_name' => '» Kanał publiczny #[NUM] ([COUNT]/5)',
				'min_channels' => 1,
				'clients_limit' => 5,
				'zone_id' => 186,
			],
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 10],
	],


	# •» PRIVATE_CHANNELS_INFO - Funkcja służaca do wypisywania w nazwe kanału statystyk z kanałów prywatnych
	'private_channels_info' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'private_zone' => 98, # kanał w którym znajduje się strefa prywatna
		# W nazwie kanału wpisuje ilość wolnych kanałów prywatnych
		'empty' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'channel_id' => 192, # Id kanału
			'channel_name' => '• Wolnych kanałów prywatnych: [COUNT]', # Nazwa kanału
		],
		# W nazwie kanału wpisuje ilość zajętych kanałów prywatnych
		'locked' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'channel_id' => 193, # Id kanału
			'channel_name' => '• Zajętych kanałów prywatnych: [COUNT]', # Nazwa kanału
		],
		# W nazwie kanału wpisuje ilość wszystkich kanałów prywatnych
		'all' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'channel_id' => 194, # Id kanału
			'channel_name' => '• Wszystkich kanały prywatnych: [COUNT]', # Nazwa kanału
		],
		# W opis kanału wpisuje kanały wolne i do usunięcia
		'delete_info' => [
			'enabled' => true, # Włacz - True | Wyłącz - False
			'channel_id' => 33, # Id kanału
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 1, 'seconds' => 30],
	],

	# •» CREATE_VIP_CHANNEL - Funkcja służąca do stworzenia kanału vip gdy użytkownik wejdzie na odpowiedni kanał
	# Nazwy kanałów/podkanałów można edytować w pliku z językiem (ścieżka: files/language.php)
	'create_vip_channel' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => [1458], # Id kanałów, po których otrzymamy kanał
		'channels' => [
			1458 => [ # Id kanału
				'zone_name' => 'VIP', # Nazwa strefy
				'get_tag_from_desc' => true, # Czy ma brać nazwę gildii z opisu klienta
				'online_from_group' => true, # Czy ma być online z grupy
				'channel_add_group' => true, # Czy ma być nadawanie grupu
				'teleport' => true, # Czy ma być teleport
				'first_channel' => 142, # Pierwszy kanał gdy nie ma żadnych kanałów
				'group_id' => 51, # Id grupy szablonu (do kopiowania grupy)
				'owner_channel_id' => 14, # Id grupy kanałowej kanałowej
				'home_subchannel_count' => 8, # Ilość podkanałów do głównego
				'rekru_subchannel_count' => 1, # Ilość podkanałów do kanału rekrutacji
			],
		],
	],


	# •» CREATE_ELITE_CHANNEL - Funkcja służąca do stworzenia kanału elite gdy użytkownik wejdzie na odpowiedni kanał
	'create_elite_channel' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'is_client_on_channel' => [1441], # Id kanałów, po których otrzymamy kanał
		'channels' => [
		# Nazwa strefy
			'PREMIUM' => [
				'channel_id' => 1441, # Id kanału, którego po wejściu otrzyma się kanał
				'first_channel' => 1450, # Pierwszy kanał
				'group_id' => 51, # id grupy tzw. szablon
				'owner_channel_id' => 14, # Id grupy kanałowej właściciela
				'create_big_number' => true, # Czy mają być numerki na 4 kanały
				'get_tag_from_desc' => true, # Czy z opisu użytkownika ma brać tag
				'main_channel_name' => '[cspacer]● [TAG] #[NUM] ●', # Nazwa pierwszego kanału, dostępne: [TAG],[NUM]
				/**
					`channel_name` - Nazwa kanału, dostępne:
						- [TAG] - Wstawia TAG gildii,
						- [NUM] - Wstawia numerek gildii,
					`type` - typ kanału, dostepne:
						- `teleporter` - tworzy kanał do teleportera, automatycznie podpina
						- `online_from_group` - Tworzy kanał do statusu online z grupy, automatycznie podpina
						- `add_group` - Tworzy kanał do nadaj/zabierz grupę, automaytcznie podpina
						- `liders` - Tworzy kanały liderów (z podkanałem)
						- `channel` - Tworzy zwykły kanał,
					`subchannels_count` - Ilość podkanałów, używa się gdy `type` jest na `liders`
					`subchannels_close_count` - Ilość zamkniętych podkanałów, używa się gdy `type` jest na `channel`
					`subchannels_open_count` - Ilość otwartych podkanałów, używa się gdy `type` jest na `channel`
					`main` - Ustawia się 'Kanał główny', możesz użyć RAZ!

					!! WYGLĄD AKTUALNEGO STYLU !!
					- https://gyazo.com/291ca3b9f4df52f3f1ef943d259cc7d4
				**/
				'channels' => [
					0 => [
						'channel_name' => '[cspacer]Przystanek [TAG]',
						'type' => 'teleporter',
					],
					1 => [
						'channel_name' => '[cspacer]Online z [TAG]',
						'type' => 'online_from_group',
					],
					2 => [
						'channel_name' => '[cspacer]Nadaj/Zabierz [TAG]',
						'type' => 'add_group',
					],
					3 => [
						'channel_name' => '[cspacer[TAG][NUM]]• Liderówka •',
						'subchannel_name' => '• Liderówka #[NUM]',
						'affair_channel_name' => '» Sprawa',
						'type' => 'liders',
						'subchannels_count' => 3,
					],
					4 => [
						'channel_name' => '[cspacer[TAG][NUM]]• Kanał Główny •',
						'type' => 'channel',
						'main' => true,
						'subchannels_close_count' => 11,
					],
					5 => [
						'channel_name' => '[cspacer[TAG][NUM]]• Rekrutacja •',
						'type' => 'channel',
						'subchannels_close_count' => 2,
						'subchannels_open_count' => 1,
					],
				],
			],
		],
	],


	# •» ELITE_VIP_CHANNELS_SORT - Funkcja służąca do sortowania kanałów elite/vip
	'elite_vip_channels_sort' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'zones' => [
		# Nazwa strefy => Typ `elite` (create_elite_channel) / `vip` (create_vip_channel)
			'PREMIUM' => 'elite',
			'VIP' => 'vip',
		],
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 10],
	],

];


/**
 *	(PL) Ustawienia czwartej instancji
 *  (EN) Settings fourth instance
**/
$config['settings']['4'] = [

		# Nazwa bota
		'bot_name' => 'SBOT » Wesoły Autobus',


		# Instance enabled
		'instance_enabled' => true,
		

		# Domyślny kanał
		'default_channel' => 2,
		

		# Baza danych
		# Włacz - True | Wyłącz - False
		'database_enabled' => true,
		

		# Nazwa systemu
		# Dla bezpieczeństwa nie zmieniać,bo moze wybuchnąć
		'system_type' => '@teleport',
		

		# Nazwa folderu
		# Ta instancja nie potrzebuje folderu
		'folder_name' => '',
		

		# Czas odświerzania instnacji
		# Domyślnie: 0
		'interval' => 0,

];


/**
 *	(PL) Opcje instancji
 *  (EN) Instance options
**/
$config['options']['4'] = [

	# Wiadomość przy wejściu
	'welcome_message' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		# Wiadomości
		'messages' => [
			'[b][color=green]Witaj [NICKNAME][/b], ja jestem [b]Wesołym Autobusem[/b] ( ͡° ͜ʖ ͡°)',
			'Zawiozę Cię praktycznie do każdej gildii na serwerze,',
			'Wystarczy, że powiesz mi gdzie chcesz jechać. [i](Uzycie: !jedz TAG)[/i]',
			' ',
			'[b]● Lista przystanków ●[/b]',
		],
	],

	# Spis gildii
	'guilds_list' => [
	# Nazwa gildii => Id kanału tzw. Przystanka
	],

	# Wygląd komend
	'commands' => [
		'!jedz', # Komenda od teleportowania do gildii
		'!rozklad', # Komenda od listy gildii
	],

];


/**
 *	(PL) Ustawienia piątej instancji
 *  (EN) Settings fifth instance
**/
$config['settings']['5'] = [

		# Nazwa bota
		'bot_name' => 'SBOT » PointsBot',


		# Instance enabled
		'instance_enabled' => true,
		

		# Domyślny kanał
		'default_channel' => 2,
		

		# Baza danych
		# Włacz - True | Wyłącz - False
		'database_enabled' => true,
		

		# Nazwa systemu
		# Dla bezpieczeństwa nie zmieniać,bo moze wybuchnąć
		'system_type' => '@pointsbot',
		

		# Nazwa folderu
		# Domyślnie: instance_5
		'folder_name' => 'instance_5',
		

		# Czas odświerzania instnacji
		# Domyślnie: 0.5
		'interval' => 0.5,

];


/**
 *	(PL) Opcje instancji
 *  (EN) Instance options
**/
$config['options']['5'] = [

	# Wiadomość powitalna
	'welcome' => [
		'enabled' => true, # Czy ma być włączone
		# Dostępne: [NICKNAME] - NIck użytkownikowka, [POINTS] - Punkty użytkownika
		'messages' => [
			'Siema, jestem Marek.',
			'Aktualnie masz [b][POINTS][/b] presiżowych punktów.',
			'Aby sprawdzić presiżową pomoc wpisz: [b]!pomoc[/b]',
			'Aby sprawdzić prestożowe punkty wpisz: [b]!punkty[/b]',
		],
	],

	'boosts' => [
		# Level id => Od ile ma dodać wiecej punktów co 1h
		'1' => ['5','500'],
		'2' => ['30','1000'],
		'3' => ['50','1700'],
		'4' => ['70','2300'],
		'5' => ['100','4000'],
	],

	# Ustawienia sklepu
	'shop' => [
		# id => ['nazwa', ilość_dni, cena, id_grupy],
		# 1 => ['VIP', 30, 100, 361],
		1 => ['VIP', 30, 100, 361],
		2 => ['SPONSOR', 7, 150, 362],
		3 => ['ANTYPOKE', 1, 20, 363],
	],

	# TOP 15: Punktów
	'top' => [
		'enabled' => true, # Włacz - True | Wyłącz - False
		'limit' => 15, # Limit wyświetlanych topek
		'top_desc' => '[img]https://i.imgur.com/r3Iisd2.png[/img]', # Górny napis w opisie
		'channel_id' => 1173, # Id kanału do edycji
		'ignored_groups' => [385,276,373,256], # Ignorowane grupy, które nie będą wyświetlane w topkach
		'interval' => ['days' => 0, 'hours' => 0, 'minutes' => 4, 'seconds' => 10],
	],

];


/**
 *	(PL) Ustawienia szóstej instancji
 *  (EN) Settings sixth instance
**/
$config['settings']['6'] = [

		# Nazwa bota
		'bot_name' => 'SBOT » Komander',


		# Instance enabled
		'instance_enabled' => true,
		

		# Domyślny kanał
		'default_channel' => 2,
		

		# Baza danych
		# Włacz - True | Wyłącz - False
		'database_enabled' => true,
		

		# Nazwa systemu
		# Dla bezpieczeństwa nie zmieniać,bo moze wybuchnąć
		'system_type' => '@commands',
		

		# Nazwa folderu
		# Domyślnie: instance_6
		'folder_name' => 'instance_6',
		

		# Czas odświerzania instnacji
		# Domyślnie: 0.5
		'interval' => 0.5,

];


/**
 *	(PL) Komendy instancji
 *  (EN) Instance commands
**/
$config['commands']['6'] = [


	# •» PWALL - Po wywołaniu komendy, bot wysyła wiadomość do wszystkich użytkowników na serwerze
	# Użycie: !pwall Wiadomość testowa
	'pwall' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» PWGROUP - Po wywołaniu komendy, bot wysyła wiadomość do wszystkich użytkowników na serwerze z podanej grupy
	# Użycie: !pwgroup {id_grupy} Wiadomość testowa
	'pwgroup' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» PWADMINS - Po wywołaniu komendy, bot wysyła wiadomość do wszystkich adminów na serwerze
	# Użycie: !pwadmins Wiadomość testowa
	'pwadmins' => [
		'enabled' => true,
		'admin_groups' => [10,11,67,365],
		'needed_groups' => [10,2],
	],


	# •» POKEALL - Po wywołaniu komendy, bot zaczepia wszystkich użytkowników na serwerze
	# Użycie: !pokeall Wiadomość testowa
	'pokeall' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» POKEGROUP - Po wywołaniu komendy, bot zaczepia wszystkich użytkowników na serwerze z podanej grupy
	# Użycie: !pokegroup {id_grupy} Wiadomość testowa
	'pokegroup' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» POKEADMINS - Po wywołaniu komendy, bot zaczepia wszystkich adminów na serwerze
	# Użycie: !pokeadmins Wiadomość testowa
	'pokeadmins' => [
		'enabled' => true,
		'admin_groups' => [10,11,67,365],
		'needed_groups' => [10,2],
	],


	# •» MEETING - Po wywołaniu komendy, bot przenosi wszystkich adminów na kanał zebrania
	# Użycie: !meeting
	'meeting' => [
		'enabled' => true,
		'admin_groups' => [10,11,67,365],
		'channel_id' => 179,
		'needed_groups' => [10,2],
	],


	# •» CLIENTLIST - Po wywołaniu komendy, bot wypisuje wszystkich użytkowników z serwera
	# Użycie: !clientlist
	'clientlist' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» CHANNELLIST - Po wywołaniu komendy, bot wypisuje wszystkie kanały z serwera
	# Użycie: !channellist
	'channellist' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» RESTART - Po wywołaniu komendy, bot restartuje wszystkie instancje
	# Użycie: !restart
	'restart' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» CLIENT - Po wywołaniu komendy, bot wypisuje informacje z podanego użytkownika
	# Użycie: !client {client_database_id}
	'client' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» CHANNEL_STATUS - Po wywołaniu komendy, bot dodaje do bazy dancyh użytkownika.
	# Użycie: !channel_status
	'channel_status' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» GROUPS_SECURITY - Po wywołaniu komendy, bot dodaje do bazy dancyh użytkownika.
	# Użycie: !groups_security
	'groups_security' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],


	# •» ADMIN - Po wywołaniu komendy, bot wypisuje satystyki danego administratora.
	# Użycie: !admin <cldbid>
	'admin' => [
		'enabled' => true,
		'needed_groups' => [10,2],
	],

];

/**
 *
 *	End of configuration file.
 *
**/

?>