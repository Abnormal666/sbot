<?php

/**
 *
 *	@name  SBOT v6.0 PREMIUM
 *	@author  `DEMON.
 *	@file  pl.php
 *	@copyright  Copyright (c) 2018-2019, Julian '`Demon.'
 *	
**/
 
 
	$lang['system']['footer'] = '[hr][right][img]https://i.imgur.com/kRigSTl.png?1[/img]';
	$lang['system']['instance_disabled'] = 'Ta instancja jest aktualnie wyłączona.';
	$lang['system']['instance_success'] = 'Instancja została poprawnie włączona.';
	$lang['system']['bad_instance'] = 'Wybrana instancja jest błęda!';
	$lang['system']['database_connection'] = 'Wystąpił błąd podczas Łącznia z bazą danych!\nJeżeli w szczegółach błędu będzie `Unknown database sbote` wpisz: php core.php -t';
	$lang['system']['database_success'] = 'Baza danych została poprawie wczytana.';
	$lang['system']['database_off'] = 'Baza danych w tej instancji jest wyłączona.';
	$lang['system']['teamspeak_login'] = 'Wystąpił błąd podczas logowania do konta query.';
	$lang['system']['teamspeak_select_server'] = 'Wystąpił błąd podczas wybierania serwera.';
	$lang['system']['teamspeak_change_nick'] = 'Wystąpił błąd podczas zmiany nazwy.';
	$lang['system']['teamspeak_change_channel'] = 'Wystąpił błąd podczas zmiany kanału.';
	$lang['system']['teamspeak_host'] = 'Wystąpił błąd podczas logowania do hosta.';
	$lang['system']['not_functions_load'] = 'Brak funkcji do załadowania, zatrzymuję bota...';
	$lang['system']['not_packet'] = 'Zabrakło pakietu: ';
	$lang['system']['all_packets'] = 'Wymagane pakiety PHP zostały poprawnie wczytane.';
	$lang['system']['old_php'] = 'Masz starą wersje php. Wpisz: `php core.php --update` aby pobrać aktualizację.';
	$lang['system']['newest_php'] = 'Twoja wersja PHP jest poprawna.';
	$lang['system']['commands']['not_group'] = '[b]( [color=green]Komendy[/color] )[/b] Niestety nie posiadasz grupy aby użyć tej komendy!';
	$lang['system']['version'][0] = 'Twoja wersja bota jest najnowsza!';

	$lang['auto_register']['message'] = 'Witaj, spędziłeś/aś na naszym serwerze wystarczają ilość czasu dzięki czemu zostałeś/aś zarejestrowany/a!';
	
	$lang['channel_register']['has_group'] = 'Jesteś już zarejestrowany!';
	$lang['channel_register']['group_added'] = 'Grupa została pomyślnie nadana!';
	$lang['channel_register']['not_time'] = 'Jesteś za krótko na serwerze!';
	
	$lang['channel_add_group']['group_added'] = 'Pomyślnie nadano grupę!';
	$lang['channel_add_group']['group_removed'] = 'Pomyślnie zdjęto grupę!';
	
	$lang['create_private_channel']['has_channel'] = 'Posiadasz już kanał prywatny, więc zostałeś na niego przeniesiony.';
	$lang['create_private_channel']['get_message'] = 'Witaj, właśnie otrzymałeś swój kanał prywatny! Aby przeszkodzić trollom zabezpieczyliśmy twój kanał hasłem: [b]haslo12345[/b]';

	$lang['tops_save_in_channel']['time_spent'] = ' spędził na serwerze ';
	$lang['tops_save_in_channel']['connections'] = ' połączył się ';
	$lang['tops_save_in_channel']['connection_time'] = ' najdłużej przesiedział ';
	$lang['tops_save_in_channel']['idle_time'] = ' był afk przez ';
	$lang['tops_save_in_channel']['level'] = ' posiada ';

	$lang['bad_nicknames']['nickname']['poke_message'] = '[color=green]Nasz system wykrył, że posiadasz niedozwolone słowo w swoim nicku! ( [b][WORD][/b] )';
	$lang['bad_nicknames']['nickname']['kick_message'] = 'Niedozwolone słowo w nazwie - [WORD]';
	$lang['bad_nicknames']['description']['poke_message'] = '[color=green]Nasz system wykrył, że posiadasz niedozwolone słowo w swoim opisie! ( [b][WORD][/b] )';
	$lang['bad_nicknames']['description']['kick_message'] = 'Niedozwolone słowo w opisie - [WORD]';

	$lang['poke_admins']['admin_in_channel'] = '[b][color=green]Admin znajduje się już na kanale!';
	$lang['poke_admins']['poke_msg'][0] = '[url=client://[ID]/[UID]][NICK][/url]';
	$lang['poke_admins']['poke_msg'][1] = 'Oczekuje na Centrum Pomocy!';
	$lang['poke_admins']['user_msg'][0] = ' ';
	$lang['poke_admins']['user_msg'][1] = '[color=green][b]Witaj [NICK],[/b] na kanale pomocy. Administracja została powiadomiona o Twoim pobycie na kanale.';
	$lang['poke_admins']['user_msg'][2] = '[b]● Dostępni administratorzy ●';
	$lang['poke_admins']['user_msg'][3] = '[LIST]';
	$lang['poke_admins']['user_msg'][4] = ' ';

	$lang['anty_record']['poke_message'] = '[color=green]Nagrywanie jest zabronione!';

	$lang['client_permissions_security']['message'] = '[color=green]Nasz system wykrył, że posiadasz nielegelnie permisje na klienta, które zostaną Ci teraz zabrane! ( Permisje: [b][PERMISSIONS_NAME][/b])';
	$lang['client_permissions_security']['kick_message'] = 'Posiadałeś nielegalnie permisje!';

	$lang['servergroups_security']['asq_error'] = 'Nie możesz wpisać grupy Admin Server Query do chronionych grup!';
	$lang['servergroups_security']['poke_message'] = 'Posiadałeś zabezpieczoną grupę.';
	$lang['servergroups_security']['kick_message'] = 'Posiadałeś zabezpieczoną grupę.';

	$lang['away_move']['move_message'] = 'Jako iż jesteś afk zostałeś przeniesiony na odpowiedni do tego kanał.';
	$lang['away_move']['back_message'] = 'Jako iż już jesteś dostępny zostałeś przeniesiony na swój poprzedni kanał!';

	$lang['save_to_event']['is_saved'] = 'Jesteś już zapisany!';
	$lang['save_to_event']['saved'] = 'Zostałeś pomyślnie zapisany na event!';

	$lang['create_vip_channel']['main_channel_name'] = '[cspacer]● #[NUM] Kanał VIP: [TAG]';
	$lang['create_vip_channel']['group_channel_name'] = '• Grupa';
	$lang['create_vip_channel']['home_channel_name'] = '• Kanał Główny';
	$lang['create_vip_channel']['rekru_channel_name'] = '• Rekrutacja';
	$lang['create_vip_channel']['subchannel_name'] = '» Podkanał #[NUM]';
	$lang['create_vip_channel']['group_subchannel_name'][0] = '» Online z grupy:';
	$lang['create_vip_channel']['group_subchannel_name'][1] = '» Nadaj/Zdejmij grupę [TAG]';
	$lang['create_vip_channel']['group_subchannel_name'][2] = '» Przystanek [TAG]';
	$lang['create_vip_channel']['separator_name'] = '[*spacer[NUM][TAG]]...';

	$lang['create_elite_channel']['subchannel_name'] = '» Podkanał #[NUM]';
	$lang['create_elite_channel']['subchannel_name_open'] = '» Podkanał #[NUM] (OPEN)';
	$lang['create_elite_channel']['separator_name'] = '[*spacer[NUM][TAG]]...';
	$lang['create_elite_channel']['get_channel'] = '[color=green]Pomyślnie otrzymałeś swój kanał [b][ZONE_NAME][/b] o numerze [b][NUM]';
	
	$lang['client_levels']['message'] = '[b]( [color=green]POZIOMY[/color] )[/b] Właśnie awansowałeś z [b][OLD_LEVEL][/b] na [b][NEW_LEVEL][/b] poziom! Do następnego poziomu brakuje Ci: [b][TIME_NEXT][/b] minut.';

	$lang['achievements']['message_get']['connections'] = '[b]( [color=green]Osiągnięcia[/color] )[/b] Właśnie otrzymałeś grupę za [b][CONNECTIONS][/b] wejść! Do następnej grupy brakuje Ci [b][NEXT][/b] połączeń.';
	$lang['achievements']['message_get']['time_spent'] = '[b]( [color=green]Osiągnięcia[/color] )[/b] Właśnie otrzymałeś grupę za [b][TIME_SPENT][/b] godzin spędzonego czasu! Do następnej grupy brakuje Ci [b][NEXT][/b] godzin spędzonego czasu.';

	$lang['ddos_attack']['message'] = '[b][color=red]DDOS ATTACK[/color][/b] :|: Nasz system wykrył duży wzrost packetlosstu [i]([PACKETSLOST]%)[/i].';

	$lang['random_group']['message_get'] = '[b]( [color=green]Losowanie[/color] )[/b] Gratulacje zostałeś wylosowany z użytkowników i wygrałeś grupę na okres [b]1 dnia[/b].';

	$lang['anty_vpn']['has_vpn'] = 'Nasz system wykrył, ze posiadasz VPN! Zostajesz zatem wyrzucony z serwera.';

	
	$lang['get_private_channel']['message'] = '[color=green][b]Pomyślnie otrzymałeś swój kanał prywatny o numerze: [u]#[NUM][/u], hasło to: [u]haslo12345';
	$lang['get_private_channel']['has_channel'] = '[b][color=green]Posiadasz już kanał prywatny!';
	$lang['get_private_channel']['not_has_group'] = '[color=green][b]Nie posiadasz wymaganych grup, aby uzyskać kanał!';

	$lang['teleport']['user_moved'] = '[color=green][b]Zostałeś pomyślnie przeniesiony do gildii: [u][NAME]';
	$lang['teleport']['bad_command'] = '[color=red][b]Niestety, ale taka komenda nie istnieje![/color] [b]Dostępne: !jedz / !rozklad';
	$lang['teleport']['not_guild'] = '[color=red][b]Niestety, ale taka gildia nie istnieje![/color] [b]Sprawdź listę gildii: !rozklad';

	$lang['pointsbot']['bad_command'] = '[color=red][b]Niestety, ale taka komenda nie istnieje![/color] [b]Dostępne: !punkty / !pomoc';
	$lang['pointsbot']['not_id'] = '[color=red][b]Niestety, ale ta komenda nie będzie działać bez id produktu![/color]';
	$lang['pointsbot']['donete_id'] = '[color=red][b]Musisz podać kwotę i do kogo chcesz przesłać punkty![/color]';
	$lang['pointsbot']['not_product'] = '[color=red][b]Niestety, ale produkt o takim id nie istnieje![/color]';
	$lang['pointsbot']['one_buy'] = '[color=red][b]Już raz zakupiłeś tę usługę![/color]';
	$lang['pointsbot']['poor'] = '[color=red][b]Jesteś za biedny na to![/color]';
	$lang['pointsbot']['purchased'] = '[b][color=green]Pomyślnie zakupiono produkt! [/color] - [ITEM]';
	$lang['pointsbot']['client_offline'] = '[b][color=red]Taj osoby nie ma na serwerze![/color]';
	$lang['pointsbot']['not_points'] = '[b][color=red]Podana kwota jest za duża, nie posiadasz tyle punktów![/color]';
	$lang['pointsbot']['success_donate'] = '[b][color=green]Pomyślnie podarowano [POINTS] prestiżowych punktów innej osobie![/color]';
	$lang['pointsbot']['get_points'] = '[b][color=green]Otrzymałeś [POINTS] prestiżowych punktów od [NICK]![/color]';
	$lang['pointsbot']['help_msg'] = [
		' ',
		'• Za spędzony czas otrzymujesz presiżowe punkty! [i](1h = 5 pkt)[/i]',
		'• Dostepne komendy:',
		'× [b]!pomocy[/b] [i]- Tu jesteś. ',
		'× [b]!punkty[/b] [i]- Pokazuje aktualny stan punktów. ',
		'× [b]!sklep[/b] [i]- Przenosi do sklepu. ',
		'× [b]!donate[/b] [i]- Przesyłasz innej osobie punkty. ',
		' ',
	];

	$lang['commander']['off_channel_commander'] = 'Prosimy włączyć [b][color=orange]channel commandera[/b]!';

	$lang['register_reminder']['message'] = '[b]Witaj [NICK],[/b] Wykryliśmy, że nie jesteś zalogowany, wiec prosimy się zarejestrować!';

	$lang['clear_group']['success_message'] = '[color=green][b]Pomyślnie wyczyszczono osoby z grupy!';
	$lang['clear_group']['error_message'] = '[color=red][b]Nie posiadasz odpowiedniej grupy aby to zrobić!';

	$lang['guilds_meeting']['success_message'] = '[color=green][b]Pomyślnie przeniesiono wszystkich dostępnych!';
	$lang['guilds_meeting']['error_message'] = '[color=red][b]W tej chwili nie ma zebrania, więc nie możesz tu siedzieć.';

	# Podesłał DEVELPL.
	$lang['bad_words'] = ['chuj','chuja', 'chujek', 'chuju', 'chujem', 'chujnia', 'chujowy', 'chujowa', 'chujowe', 'cipa', 'cipę', 'cipe', 'cipą', 'cipie', 'dojebać','dojebac', 'dojebie', 'dojebał', 'dojebal', 'dojebała', 'dojebala', 'dojebałem', 'dojebalem', 'dojebałam', 'dojebalam', 'dojebię', 'dojebie', 'dopieprzać', 'dopieprzac', 'dopierdalać', 'dopierdalac', 'dopierdala', 'dopierdalał', 'dopierdalal', 'dopierdalała', 'dopierdalala', 'dopierdoli', 'dopierdolił', 'dopierdolil', 'dopierdolę', 'dopierdole', 'dopierdoli', 'dopierdalający', 'dopierdalajacy', 'dopierdolić', 'dopierdolic', 'dupa', 'dupie', 'dupą', 'dupcia', 'dupeczka', 'dupy', 'dupe', 'huj', 'hujek', 'hujnia', 'huja', 'huje', 'hujem', 'huju', 'jebać', 'jebac', 'jebał', 'jebal', 'jebie', 'jebią', 'jebia', 'jebak', 'jebaka', 'jebal', 'jebał', 'jebany', 'jebane', 'jebanka', 'jebanko', 'jebankiem', 'jebanymi', 'jebana', 'jebanym', 'jebanej', 'jebaną', 'jebana', 'jebani', 'jebanych', 'jebanymi', 'jebcie', 'jebiący', 'jebiacy', 'jebiąca', 'jebiaca', 'jebiącego', 'jebiacego', 'jebiącej', 'jebiacej', 'jebia', 'jebią', 'jebie', 'jebię', 'jebliwy', 'jebnąć', 'jebnac', 'jebnąc', 'jebnać', 'jebnął', 'jebnal', 'jebną', 'jebna', 'jebnęła', 'jebnela', 'jebnie', 'jebnij', 'jebut', 'koorwa', 'kórwa', 'kurestwo', 'kurew', 'kurewski', 'kurewska', 'kurewskiej', 'kurewską', 'kurewska', 'kurewsko', 'kurewstwo', 'kurwa', 'kurwaa', 'kurwami', 'kurwą', 'kurwe', 'kurwę', 'kurwie', 'kurwiska', 'kurwo', 'kurwy', 'kurwach', 'kurwami', 'kurewski', 'kurwiarz', 'kurwiący', 'kurwica', 'kurwić', 'kurwic', 'kurwidołek', 'kurwik', 'kurwiki', 'kurwiszcze', 'kurwiszon', 'kurwiszona', 'kurwiszonem', 'kurwiszony', 'kutas', 'kutasa', 'kutasie', 'kutasem', 'kutasy', 'kutasów', 'kutasow', 'kutasach', 'kutasami', 'matkojebca', 'matkojebcy', 'matkojebcą', 'matkojebca', 'matkojebcami', 'matkojebcach', 'nabarłożyć', 'najebać', 'najebac', 'najebał', 'najebal', 'najebała', 'najebala', 'najebane', 'najebany', 'najebaną', 'najebana', 'najebie', 'najebią', 'najebia', 'naopierdalać', 'naopierdalac', 'naopierdalał', 'naopierdalal', 'naopierdalała', 'naopierdalala', 'naopierdalała', 'napierdalać', 'napierdalac', 'napierdalający', 'napierdalajacy', 'napierdolić', 'napierdolic', 'nawpierdalać', 'nawpierdalac', 'nawpierdalał', 'nawpierdalal', 'nawpierdalała', 'nawpierdalala', 'obsrywać', 'obsrywac', 'obsrywający', 'obsrywajacy', 'odpieprzać', 'odpieprzac', 'odpieprzy', 'odpieprzył', 'odpieprzyl', 'odpieprzyła', 'odpieprzyla', 'odpierdalać', 'odpierdalac', 'odpierdol', 'odpierdolił', 'odpierdolil', 'odpierdoliła', 'odpierdolila', 'odpierdoli', 'odpierdalający', 'odpierdalajacy', 'odpierdalająca', 'odpierdalajaca', 'odpierdolić', 'odpierdolic', 'odpierdoli', 'odpierdolił', 'opieprzający', 'opierdalać', 'opierdalac', 'opierdala', 'opierdalający', 'opierdalajacy', 'opierdol', 'opierdolić', 'opierdolic', 'opierdoli', 'opierdolą', 'opierdola', 'piczka', 'pieprznięty', 'pieprzniety', 'pieprzony', 'pierdel', 'pierdlu', 'pierdolą', 'pierdola', 'pierdolący', 'pierdolacy', 'pierdoląca', 'pierdolaca', 'pierdol', 'pierdole', 'pierdolenie', 'pierdoleniem', 'pierdoleniu', 'pierdolę', 'pierdolec', 'pierdola', 'pierdolą', 'pierdolić', 'pierdolicie', 'pierdolic', 'pierdolił', 'pierdolil', 'pierdoliła', 'pierdolila', 'pierdoli', 'pierdolnięty', 'pierdolniety', 'pierdolisz', 'pierdolnąć', 'pierdolnac', 'pierdolnął', 'pierdolnal', 'pierdolnęła', 'pierdolnela', 'pierdolnie', 'pierdolnięty', 'pierdolnij', 'pierdolnik', 'pierdolona', 'pierdolone', 'pierdolony', 'pierdołki', 'pierdzący', 'pierdzieć', 'pierdziec', 'pizda', 'pizdą', 'pizde', 'pizdę', 'piździe', 'pizdzie', 'pizdnąć', 'pizdnac', 'pizdu', 'podpierdalać', 'podpierdalac', 'podpierdala', 'podpierdalający', 'podpierdalajacy', 'podpierdolić', 'podpierdolic', 'podpierdoli', 'pojeb', 'pojeba', 'pojebami', 'pojebani', 'pojebanego', 'pojebanemu', 'pojebani', 'pojebany', 'pojebanych', 'pojebanym', 'pojebanymi', 'pojebem', 'pojebać', 'pojebac', 'pojebalo', 'popierdala', 'popierdalac', 'popierdalać', 'popierdolić', 'popierdolic', 'popierdoli', 'popierdolonego', 'popierdolonemu', 'popierdolonym', 'popierdolone', 'popierdoleni', 'popierdolony', 'porozpierdalać', 'porozpierdala', 'porozpierdalac', 'poruchac', 'poruchać', 'przejebać', 'przejebane', 'przejebac', 'przyjebali', 'przepierdalać', 'przepierdalac', 'przepierdala', 'przepierdalający', 'przepierdalajacy', 'przepierdalająca', 'przepierdalajaca', 'przepierdolić', 'przepierdolic', 'przyjebać', 'przyjebac', 'przyjebie', 'przyjebała', 'przyjebala', 'przyjebał', 'przyjebal', 'przypieprzać', 'przypieprzac', 'przypieprzający', 'przypieprzajacy', 'przypieprzająca', 'przypieprzajaca', 'przypierdalać', 'przypierdalac', 'przypierdala', 'przypierdoli', 'przypierdalający', 'przypierdalajacy', 'przypierdolić', 'przypierdolic', 'qrwa', 'rozjebać', 'rozjebac', 'rozjebie', 'rozjebała', 'rozjebią', 'rozpierdalać', 'rozpierdalac', 'rozpierdala', 'rozpierdolić', 'rozpierdolic', 'rozpierdole', 'rozpierdoli', 'rozpierducha', 'skurwić', 'skurwiel', 'skurwiela', 'skurwielem', 'skurwielu', 'skurwysyn', 'skurwysynów', 'skurwysynow', 'skurwysyna', 'skurwysynem', 'skurwysynu', 'skurwysyny', 'skurwysyński', 'skurwysynski', 'skurwysyństwo', 'skurwysynstwo', 'spieprzać', 'spieprzac', 'spieprza', 'spieprzaj', 'spieprzajcie', 'spieprzają', 'spieprzaja', 'spieprzający', 'spieprzajacy', 'spieprzająca', 'spieprzajaca', 'spierdalać', 'spierdalac', 'spierdala', 'spierdalał', 'spierdalała', 'spierdalal', 'spierdalalcie', 'spierdalala', 'spierdalający', 'spierdalajacy', 'spierdolić', 'spierdolic', 'spierdoli', 'spierdoliła', 'spierdoliło', 'spierdolą', 'spierdola', 'srać', 'srac', 'srający', 'srajacy', 'srając', 'srajac', 'sraj', 'sukinsyn', 'sukinsyny', 'sukinsynom', 'sukinsynowi', 'sukinsynów', 'sukinsynow', 'śmierdziel', 'udupić', 'ujebać', 'ujebac', 'ujebał', 'ujebal', 'ujebana', 'ujebany', 'ujebie', 'ujebała', 'ujebala', 'upierdalać', 'upierdalac', 'upierdala', 'upierdoli', 'upierdolić', 'upierdolic', 'upierdoli', 'upierdolą', 'upierdola', 'upierdoleni', 'wjebać', 'wjebac', 'wjebie', 'wjebią', 'wjebia', 'wjebiemy', 'wjebiecie', 'wkurwiać', 'wkurwiac', 'wkurwi', 'wkurwia', 'wkurwiał', 'wkurwial', 'wkurwiający', 'wkurwiajacy', 'wkurwiająca', 'wkurwiajaca', 'wkurwić', 'wkurwic', 'wkurwi', 'wkurwiacie', 'wkurwiają', 'wkurwiali', 'wkurwią', 'wkurwia', 'wkurwimy', 'wkurwicie', 'wkurwiacie', 'wkurwić', 'wkurwic', 'wkurwia', 'wpierdalać', 'wpierdalac', 'wpierdalający', 'wpierdalajacy', 'wpierdol', 'wpierdolić', 'wpierdolic', 'wpizdu', 'wyjebać', 'wyjebac', 'wyjebali', 'wyjebał', 'wyjebac', 'wyjebała', 'wyjebały', 'wyjebie', 'wyjebią', 'wyjebia', 'wyjebiesz', 'wyjebie', 'wyjebiecie', 'wyjebiemy', 'wypieprzać', 'wypieprzac', 'wypieprza', 'wypieprzał', 'wypieprzal', 'wypieprzała', 'wypieprzala', 'wypieprzy', 'wypieprzyła', 'wypieprzyla', 'wypieprzył', 'wypieprzyl', 'wypierdal', 'wypierdalać', 'wypierdalac', 'wypierdala', 'wypierdalaj', 'wypierdalał', 'wypierdalal', 'wypierdalała', 'wypierdalala', 'wypierdalać', 'wypierdolić', 'wypierdolic', 'wypierdoli', 'wypierdolimy', 'wypierdolicie', 'wypierdolą', 'wypierdola', 'wypierdolili', 'wypierdolił', 'wypierdolil', 'wypierdoliła', 'wypierdolila', 'zajebać', 'zajebac', 'zajebie', 'zajebią', 'zajebia', 'zajebiał', 'zajebial', 'zajebała', 'zajebiala', 'zajebali', 'zajebana', 'zajebani', 'zajebane', 'zajebany', 'zajebanych', 'zajebanym', 'zajebanymi', 'zajebiste', 'zajebisty', 'zajebistych', 'zajebista', 'zajebistym', 'zajebistymi', 'zajebiście', 'zajebiscie', 'zapieprzyć', 'zapieprzyc', 'zapieprzy', 'zapieprzył', 'zapieprzyl', 'zapieprzyła', 'zapieprzyla', 'zapieprzą', 'zapieprza', 'zapieprzy', 'zapieprzymy', 'zapieprzycie', 'zapieprzysz', 'zapierdala', 'zapierdalać', 'zapierdalac', 'zapierdalaja', 'zapierdalał', 'zapierdalaj', 'zapierdalajcie', 'zapierdalała', 'zapierdalala', 'zapierdalali', 'zapierdalający', 'zapierdalajacy', 'zapierdolić', 'zapierdolic', 'zapierdoli', 'zapierdolił', 'zapierdolil', 'zapierdoliła', 'zapierdolila', 'zapierdolą', 'zapierdola', 'zapierniczać', 'zapierniczający', 'zasrać', 'zasranym', 'zasrywać', 'zasrywający', 'zesrywać', 'zesrywający', 'zjebać', 'zjebac', 'zjebał', 'zjebal', 'zjebała', 'zjebala', 'zjebana', 'zjebią', 'zjebali', 'zjeby','teamspeakuser','ceo','właściciel','wlasciciel','admin','razor','razormeister','d0m1n0','dshimen','werton','hunterpl','pawelmf','卐'];
?>