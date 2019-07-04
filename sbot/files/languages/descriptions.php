<?php

/**
 *
 *	@name  SBOT v6.0 PREMIUM
 *	@author  `DEMON.
 *	@file  descriptions.php
 *	@copyright  Copyright (c) 2018-2019, Julian '`Demon.'
 *	
**/
	

/**
 *	Funkcja: admin_list
**/

	$descriptions['admin_list']['status_name'] = [
		'away' => '[color=yellow]Away[/color]',
		'online' => '[color=green]Dostępny[/color]',
		'offline' => '[color=red]Niedostępny[/color]',
	];
	$descriptions['admin_list']['status_icon'] = [
		'away' => '[img]https://i.imgur.com/NB65Fbq.png[/img]',
		'online' => '[img]https://i.imgur.com/BNkLtpE.png[/img]',
		'offline' => '[img]https://i.imgur.com/na3yGsj.png[/img]',
	];
	$descriptions['admin_list']['group_head'] = '[size=13][b][GROUP_NAME][/b][/size]\n';
	$descriptions['admin_list']['all_count_in_group'] = '[size=10][u]Ilość adminów w grupie: [COUNT][/u]\n';
	$descriptions['admin_list']['online_count_in_group'] = '[u]Online adminów z grupy: [COUNT][/u][/size][size=12]\n';
	;
	# Dostępne: [CLIENT_URL], [CLIENT_UID], [CLIENT_CLID], [CLIENT_UID], [CLIENT_NICK], [PROFILE], [STATUS_ICON], [STATUS_NAME], [STATUS_FOR], [CID], [CHANNEL_NAME]
	$descriptions['admin_list']['online_client'] = '\n• [img]https://i.imgur.com/xUbl9xn.png[/img] [CLIENT_URL] [PROFILE]\n    » [STATUS_ICON] Status: [STATUS_NAME] od: [STATUS_FOR]\n    » [img]https://i.imgur.com/5g89OVp.png[/img] Na kanale: [url=channelid://[CID]][CHANNEL_NAME][/url]\n';
	# Dostepne: [CLIENT_NICK], [PROFILE], [STATUS_ICON], [STATUS_NAME], [STATUS_FOR]
	$descriptions['admin_list']['offline_client'] = '\n• [img]https://i.imgur.com/xUbl9xn.png[/img] [CLIENT_NICK] [PROFILE]\n    » [STATUS_ICON] Status: [STATUS_NAME] od: [STATUS_FOR]\n';
	$descriptions['admin_list']['empty_group'] = '\n• [img]https://i.imgur.com/XJth52t.png[/img] Brak osób w grupie.\n';


/**
 *	Funkcja: admins_online
**/

	$descriptions['admins_online']['header'] = '[center][img]https://i.imgur.com/wlOVpmn.png[/img][/center]\n[size=11]';
	$descriptions['admins_online']['no_admins'] = '\n• [img]https://i.imgur.com/XJth52t.png[/img] Aktualnie nie ma żadnego dostępnego administratora.\n';
	# Dostepne: [CLIENT_URL], [CLIENT_GROUP], [PROFILE], [STATUS_FOR], [CID], [CHANNEL_NAME]
	$descriptions['admins_online']['client_row'] = '\n• [img]https://i.imgur.com/xUbl9xn.png[/img] ( [b][CLIENT_GROUP][/b] ) [CLIENT_URL] [PROFILE]\n    » [img]https://i.imgur.com/BNkLtpE.png[/img] Dostepny od: [b][color=green][STATUS_FOR][/color][/b]\n    » [img]https://i.imgur.com/5g89OVp.png[/img] Na kanale: [url=channelid://[CID]][CHANNEL_NAME][/url]\n';


/**
 *	Funkcja: client_channel_status
**/

	# Dostepne: [CLIENT_NICK], [CLIENT_GROUP], [STATUS_NAME], [CID], [CHANNEL_NAME]
	$descriptions['client_channel_status']['online_client'] = '[center][size=20][b]Kanał [CLIENT_NICK][/b][/size][/center][size=10]\n\n[size=15][b]● Informacje:[/size]\n• Grupa: [b][CLIENT_GROUP][/b]\n• Status: [STATUS_NAME]\n• Kanał: [url=channelid://[CID]][b][CHANNEL_NAME][/b][/url]\n\n[size=15][b]● Kontakt:[/size]\n';
	# Dostepne: [CLIENT_NICK], [CLIENT_GROUP], [STATUS_NAME]
	$descriptions['client_channel_status']['offline_client'] = '[center][size=20][b]Kanał [CLIENT_NICK][/b][/size][/center][size=10]\n\n[size=15][b]● Informacje:[/size]\n• Grupa: [b][CLIENT_GROUP][/b]\n• Status: [color=red][b][STATUS_NAME][/b][/color]\n[size=15][b]● Kontakt:[/size]\n';


/**
 *	Funkcja: online_from_group
**/

	$descriptions['online_from_group']['status_name'] = [
		'away' => '[color=yellow]Away[/color]',
		'online' => '[color=green]Dostępny[/color]',
		'offline' => '[color=red]Niedostępny[/color]',
	];
	$descriptions['online_from_group']['status_icon'] = [
		'away' => '[img]https://i.imgur.com/NB65Fbq.png[/img]',
		'online' => '[img]https://i.imgur.com/BNkLtpE.png[/img]',
		'offline' => '[img]https://i.imgur.com/na3yGsj.png[/img]',
	];
	$descriptions['online_from_group']['header'] = '[center][size=20][b]Lista Użytkowników z gildii[/b][/size][/center]\n[size=11]';
	# Dostepne: [STATUS_ICON], [STATUS_NAME], [STATUS_FOR], [CLIENT_URL], [PROFILE]
	$descriptions['online_from_group']['online_client'] = '\n• [STATUS_ICON] [CLIENT_URL] [PROFILE] - [STATUS_NAME] od: [STATUS_FOR]\n';
	# Dostepne: [STATUS_ICON], [STATUS_NAME], [STATUS_FOR], [CLIENT_NICK], [PROFILE]
	$descriptions['online_from_group']['offline_client'] = '\n• [STATUS_ICON] [CLIENT_NICK] [PROFILE] - [STATUS_NAME] od: [STATUS_FOR]\n';
	$descriptions['online_from_group']['empty_group'] = '\n• [img]https://i.imgur.com/XJth52t.png[/img] Brak osób w grupie';


/**
 *	Funkcja: record_online
**/

	$descriptions['record_online']['header'] = '[center][img]https://i.imgur.com/YtuGiCV.png[/img][/center]\n\n[size=11]';
	# Dostępne: [RECORD_COUNT], [RECORD_DATE]
	$descriptions['record_online']['desc'] = '» [img]https://i.imgur.com/4zJumKC.png[/img] Aktualny rekord online: [b][RECORD_COUNT][/b]\n» [img]https://i.imgur.com/CjYvK6d.png[/img] Rekord został ustanowiony w dniu: [b][RECORD_DATE][/b]\n[/size][hr]\n[center][size=17][b]Ostatnie 5 rekordów[/b][/size][/center]\n\n[size=11]';
	$descriptions['record_online']['top_row'] = '» Rekord [b][RECORD_COUNT][/b] został ustanowiony w dniu: [b][RECORD_DATE][/b]\n';


/**
 *	Funkcja: get_private_channel
**/

	# Dostępne: [NUM], [NICKNAME], [CREATED]
	$descriptions['get_private_channel']['channel_description'] = '[center][img]https://i.imgur.com/BPrriPk.png[/img][size=14]\nNumer Kanału [b][NUM][/b][/center][size=11]\n \n• [img]https://i.imgur.com/xUbl9xn.png[/img] Właściciel: [b][color=orange][NICKNAME][/b]\n• [img]https://i.imgur.com/CjYvK6d.png[/img] Nadano: [b][color=orange][CREATED][/b]\n[/size]';
	# Dostępne: [NUM], [NICKNAME], [CREATED]
	$descriptions['get_private_channel']['subchannel_description'] = '[center][img]https://i.imgur.com/7mLr0e8.png[/img][size=14]\nNumer [b][NUM][/b][/center][size=11]\n \n• [img]https://i.imgur.com/xUbl9xn.png[/img] Właściciel: [b][color=orange][NICKNAME][/b]\n• [img]https://i.imgur.com/CjYvK6d.png[/img] Nadano: [b][color=orange][CREATED][/b]\n[/size]';


/**
 *	Funkcja: channels_checker
**/
	# Dostępne: [NUM]
	$descriptions['channels_checker']['channel_description'] ='[center][img]https://i.imgur.com/kNXXkEE.png[/img][size=14]\nNumer kanału [b][NUM][/b][/center][size=11]\n \n• Jeżeli chcesz go otrzymać zgłoś się do adminsitracji.\n[/size]';


/**
 *	Funkcja: private_channels_info
**/
	# Dostępne: [EMPTY_LIST], [DELETE_TODAY], [DELETE_TOMORROW]
	$descriptions['private_channels_info']['delete_info'] = '[center][size=20][b]Kanały prywatne[/b][/size][/center][size=10]\n[size=11]● Wolne kanały prywatne:[/size] \n• [b][color=green][EMPTY_LIST][/b]\n\n[size=11]● Kanały do usunięcia dziś [size=9][i](O godzinie 00:00)[/i][/size]:[/size] \n• [color=green][b][DELETE_TODAY][/color]\n\n[size=11]● Kanały do usunięcia jutro:[/size] \n• [color=green][b][DELETE_TOMORROW][/color]\n[/size]';


/**
 *	Funkcja: away_clients_list
**/
	$descriptions['away_clients_list']['header'] = '[center][img]https://i.imgur.com/UiPWfle.png[/img][/center]\n[size=11]';
	# Dostępne: [CLIENT_URL]
	$descriptions['away_clients_list']['client_row'] = '\n• [img]https://i.imgur.com/d93qFkT.png[/img] [CLIENT_URL]';
	$descriptions['away_clients_list']['empty_list'] = '\n• [img]https://i.imgur.com/XJth52t.png[/img] Brak osób away';


/**
 *	Funkcja: ban_list
**/
	$descriptions['ban_list']['header'] = '[center][img]https://i.imgur.com/IC5b6l6.png[/img][/center][size=10]';
	$descriptions['ban_list']['empty_list'] = '\n• [img]https://i.imgur.com/XJth52t.png[/img] Brak osób zbanowanych\n';
	$descriptions['ban_list']['durations'] = [
		'perm' => '[color=red]PERMANENTNIE[/color]',
		'time' => '[color=#ffba00][TIME][/color]',
	];
	# Dostępne: [BAN_ID], [BANNED_NAME], [BANNED_UID], [BANNED_REASON], [DURATION], [BAN_CREATED], [BAN_OWNER]
	$descriptions['ban_list']['row'] = '\n[size=13]• Ban #[BAN_ID][/size][list] [*] [img]https://i.imgur.com/xUbl9xn.png[/img] [b]Nick:[/b] [color=#ffba00][b][BANNED_NAME][/b][/color] [*] [img]https://i.imgur.com/6qJJGgl.png[/img] [b]Unikalne id:[/b] [BANNED_UID] [*] [img]https://i.imgur.com/NSEcwRs.png[/img] [b]Powód:[/b] [color=green][BANNED_REASON][/color] [*] [img]https://i.imgur.com/a2O70sE.png[/img] [b]Czas trwania:[/b] [DURATION] [*] [img]https://i.imgur.com/CjYvK6d.png[/img] [b]Zbanowano:[/b] [BAN_CREATED] [*] [img]https://i.imgur.com/aSAqP65.png[/img] [b]Zbanował:[/b] [color=#ffba00][b][BAN_OWNER][/b][/color][/list]';


/**
 *	Funkcja: country
**/
	$descriptions['country']['header'] = '[center][img]https://i.imgur.com/hdxqd9G.png[/img][/center][size=11]';
	# Dostępne: [CLIENT_URL], [COUNTRY]
	$descriptions['country']['client_row'] = '\n• [img]https://i.imgur.com/xUbl9xn.png[/img] [CLIENT_URL] - [COUNTRY]\n';
	$descriptions['country']['empty_list'] = '\n• [img]https://i.imgur.com/XJth52t.png[/img] Niestety nikt z osób po za Polski nas nie lubi :c';


/**
 *	Funkcja: fb_posts
**/
	# Dostępne: [FP_ID]
	$descriptions['fb_posts']['header'] = '[center][img]https://i.imgur.com/EMFYuGJ.png[/img][size=10]\n[url=https://facebook.com/[FP_ID]]Kliknij tutaj aby przejść na naszego fanpage[/url][/size][/center]\n';
	# Dostepne: [POST_NUM], [POST_CREATED], [FP_ID], [POST_ID], [POST_MSG]
	$descriptions['fb_posts']['post_row'] = '\n[size=12][b]POST #[POST_NUM][/b][/size]\n[right][size=9][i]Stworzono: [POST_CREATED][/i]\n[url=https://www.facebook.com/[FP_ID]/posts/[POST_ID]]Przejdź do postu[/url][/right][size=10]\n[POST_MSG]\n[/size][hr]';
	$descriptions['fb_posts']['empty'] = '\n[size=10]Brak postów na podanym fanpage[/size]';


/**
 *	Funkcja: query_channel_list
**/
	$descriptions['query_channel_list']['header'] = '[center][img]https://i.imgur.com/RQl86NL.png[/img][/center][size=10]';
	# Dostępne: [CLIENT_URL], [CHANNEL_ID], [CHANNEL_NAME]
	$descriptions['query_channel_list']['client_row'] = '\n• [img]https://i.imgur.com/ZLrgj0r.png[/img] [CLIENT_URL] Na kanale [url=channelid://[CHANNEL_ID]][b][CHANNEL_NAME][/url]';
	$descriptions['query_channel_list']['empty_list'] = '\n• Brak klientów query.';


/**
 *	Funkcja: save_to_event
**/
	# DOstępne: [CLIENT_URL], [SAVE_DATE]
	$descriptions['save_to_event']['client_row'] = '\n• [img]https://i.imgur.com/EhZ2cLu.png[/img] [CLIENT_URL] zapisał sie: [b][color=green][SAVE_DATE][/color][/b]\n\n';


/**
 *	Funkcja: weather_in_channel
**/
	# DOstępne: [CITY_NAME]
	$descriptions['weather_in_channel']['header'] = '[center][size=20][b]Pogoda - [CITY_NAME][/b][/size][/center]\n';
	# Dostepne: [WEATHER_ICON], [TEMP], [STATE], [WIND_SPEED], [VISIBILITY], [HUMIDITY], [PRESSURE]
	$descriptions['weather_in_channel']['desc'] = '[center][WEATHER_ICON][/center][size=11]\n» Temperatura: [b][TEMP]°C[/b]\n» Stan: [b][STATE][/b]\n» Szybkość wiatru: [b][WIND_SPEED]m/s[/b]\n» Widoczność: [b][VISIBILITY]m[/b]\n» Wilgotność: [b][HUMIDITY]%[/b]\n» Ciśnienie: [b][PRESSURE]HPa[/b]\n';


/**
 *	Funkcja: youtube_in_channel
**/
	# Dostępne: [YT_NAME], [YT_AVATAR]
	$descriptions['youtube_in_channel']['header'] = '[center][size=20][b]Informacje z kanału [YT_NAME][/b][/size]\n[img][YT_AVATAR][/img][/center]\n[size=10]';
	# Dostępne: [SUB_COUNT], [VIDEO_COUNT], [VIEW_COUNT], [USER_ID], [USER_DESCRIPTION]
	$descriptions['youtube_in_channel']['row'] = '• Liczba subskrybcji: [b][SUB_COUNT][/b]\n• Liczba filmów: [b][VIDEO_COUNT][/b]\n• Liczba wyświetleń: [b][VIEW_COUNT][/b]\n• Link do kanału: [url=https://www.youtube.com/channel/[USER_ID]]Przejdź[/url]\n[/size][hr][size=15][b]Opis kanału:[/b][/size][size=11]\n[USER_DESCRIPTION][/size]\n';


/**
 *	Funkcja: admins_tops
**/
	$descriptions['admins_tops']['time_spent']['header'] = '[center][img]https://i.imgur.com/8JEqMRo.png[/img][/center]\n[size=11]';
	# Dostępne: [GROUP_NAME], [CLIENT_URL], [TIME_SPENT_DAY], [TIME_SPENT_WEEK], [TIME_SPENT_MONTH], [TIME_SPENT_ALL]
	$descriptions['admins_tops']['time_spent']['client_row'] = '\n• ( [b][GROUP_NAME][/b] ) [CLIENT_URL]\n    » Spędzony czas w tym dniu: [b][color=orange][TIME_SPENT_DAY][/color][/b]\n    » Spędzony czas w tym tygodniu: [b][color=orange][TIME_SPENT_WEEK][/color][/b]\n    » Spędzony czas w tym miesiącu: [b][color=orange][TIME_SPENT_MONTH][/color][/b]\n    » [u]Spędzony czas łącznie: [b][color=orange][TIME_SPENT_ALL][/color][/b][/u]\n';

	$descriptions['admins_tops']['servergroups']['header'] = '[center][img]https://i.imgur.com/VyPdfsB.png[/img][/center]\n[size=11]';
	# Dostepne: [GROUP_NAME], [CLIENT_URL], [REG_DAY], [REG_WEEK], [REG_MONTH], [REG_ALL]
	$descriptions['admins_tops']['servergroups']['reg_groups'] = '\n• ( [b][GROUP_NAME][/b] ) [CLIENT_URL]\n[b]● Grupy rejestracji[/b]\n    » Ilość nadanych rejestracji w tym dniu: [b][color=orange][REG_DAY][/color][/b]\n    » Ilość nadanych rejestracji w tym tygodniu: [b][color=orange][REG_WEEK][/color][/b]\n    » Ilość nadanych rejestracji w tym miesiącu: [b][color=orange][REG_MONTH][/color][/b]\n    » [u]Łączna ilośc nadanych rejestracji: [b][color=orange][REG_ALL][/color][/b][/u]\n';
	# Dostepne: [GROUPS_DAY], [GROUPS_WEEK], [GROUPS_MONTH], [GROUP_ALL]
	$descriptions['admins_tops']['servergroups']['other_groups'] = '[b]● Grupy ogólne[/b]\n    » Ilość nadanych group w tym dniu: [b][color=orange][GROUPS_DAY][/color][/b]\n    » Ilość nadanych group w tym tygodniu: [b][color=orange][GROUPS_WEEK][/color][/b]\n    » Ilość nadanych group w tym miesiącu: [b][color=orange][GROUPS_MONTH][/color][/b]\n    » [u]Łączna ilość nadanych grup: [b][color=orange][GROUP_ALL][/color][/b][/u]\n';

	$descriptions['admins_tops']['help_center']['header'] = '[center][img]https://i.imgur.com/vOseTWd.png[/img][/center]\n[size=11]';
	# Dostepne: [GROUP_NAME], [CLIENT_URL], [HELP_DAY], [HELP_WEEK], [HELP_MONTH], [HELP_TOTAL], [HELP_TIME_DAY], [HELP_TIME_WEEK], [HELP_TIME_MONTH], [HELP_TIME_TOTAL]
	$descriptions['admins_tops']['help_center']['client_row'] = '\n• ( [b][GROUP_NAME][/b] ) [CLIENT_URL]\n    » Udzielona pomoc w tym dniu: [b][color=orange][HELP_DAY][/color][/b] przy czym spędził [b][color=orange][HELP_TIME_DAY][/color][/b]\n    » Udzielona pomoc w tym tygodniu: [b][color=orange][HELP_WEEK][/color][/b] przy czym spędził [b][color=orange][HELP_TIME_WEEK][/color][/b]\n    » Udzielona pomoc w tym miesiącu: [b][color=orange][HELP_MONTH][/color][/b] przy czym spędził [b][color=orange][HELP_TIME_MONTH][/color][/b]\n    » [u]Łączna ilość udzielonej pomocy: [b][color=orange][HELP_TOTAL][/color][/b] przy czym spędził [b][color=orange][HELP_TIME_TOTAL][/color][/b][/u]\n';


/**
 *	Funkcja: clients_tops
**/
	# Dostępne: [NUM], [CLIENT_URL], [PROFILE], [TIME]
	$descriptions['clients_tops']['idle_time'] = '\n• [NUM]. [img]https://i.imgur.com/d93qFkT.png[/img] [CLIENT_URL] [PROFILE] - spędził będąc afk [b][color=green][TIME][/color][/b]';
	# Dostępne: [NUM], [CLIENT_URL], [PROFILE], [TIME], [PROC]
	$descriptions['clients_tops']['time_spent'] = '\n• [NUM]. [img]https://i.imgur.com/g0rJ2ue.png[/img] [CLIENT_URL] [PROFILE] - spędził [b][color=green][TIME][/color][/b] w tym [b][color=green][PROC]%[/color][/b] jako dostępny';
	# Dostępne: [NUM], [CLIENT_URL], [PROFILE], [TIME]
	$descriptions['clients_tops']['connection_time'] = '\n• [NUM]. [img]https://i.imgur.com/LkqzG25.png[/img] [CLIENT_URL] [PROFILE] - najdłużej przesiedział [b][color=green][TIME][/color][/b]';
	# Dostępne: [NUM], [CLIENT_URL], [PROFILE], [CONNECTIONS]
	$descriptions['clients_tops']['connections'] = '\n• [NUM]. [img]https://i.imgur.com/KubYUXU.png[/img] [CLIENT_URL] [PROFILE] - połączył się z nami [b][color=green][CONNECTIONS][/color][/b]';
	# Dostępne: [NUM], [CLIENT_URL], [PROFILE], [LEVEL]
	$descriptions['clients_tops']['level'] = '\n• [NUM]. [img]https://i.imgur.com/z43AeGb.png[/img] [CLIENT_URL] [PROFILE] - posiada [b][color=green][LEVEL][/color][/b] poziom';


/**
 *	Funkcja: last_actions
**/
	$descriptions['last_actions']['header'] = '[center][img]https://i.imgur.com/fCcJOkU.png[/img][/center]\n[size=10]';
	# DOstępne: [DATE], [ACTION]
	$descriptions['last_actions']['action_row'] = '\n• [b][DATE][/b] :: [ACTION]';


/**
 *	Funkcja: new_clients_today
**/
	$descriptions['new_clients_today']['header'] = '[center][img]https://i.imgur.com/Zk6IC4z.png[/img][/center][size=11]\n';
	# Dostępne: [CLIENT_URL]
	$descriptions['new_clients_today']['client_row'] = '• [img]https://i.imgur.com/KSlapl4.png[/img] [CLIENT_URL]\n';
	$descriptions['new_clients_today']['empty_list'] = '• [img]https://i.imgur.com/XJth52t.png[/img] Brak nowych użytkowników.\n';


/**
 *	Funkcja: random_group
**/
	$descriptions['random_group']['header'] = '[center][img]https://i.imgur.com/XdQLd2q.png[/img][/center][size=10]\n';
	# Dostępne: [CLIENT_URL], [WIN_DATE]
	$descriptions['random_group']['client_row'] = '• [img]https://i.imgur.com/jpbcGOz.png[/img] [CLIENT_URL] wygrał w dniu: [b][color=green][WIN_DATE][/color][/b]\n';


/**
 *	Funkcja: top_groups
**/
	# Dostępne: [NUM], [GROUP_NAME], [GROUP_ID], [COUNT]
	$descriptions['top_groups'] = '\n• [NUM]. [img]https://i.imgur.com/d93qFkT.png[/img] [b][GROUP_NAME][/b] [i](Id: [GROUP_ID])[/i] posiada [b][color=green][COUNT][/color][/b] osób';


?>