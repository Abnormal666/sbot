<?php

/**
 *
 *	@name  SBOT v6.0 PREMIUM
 *	@author  `DEMON.
 *	@file  connection_config.php
 *	@copyright  Copyright (c) 2018-2019, Julian '`Demon.'
 *	
**/


/**
 *	(PL) Ustawienia połączenia z serwerem
 *  (EN) Settings to server connection
**/
$config['connection_ts3'] = [


		# (PL) Adres IP serwera TeamSpeak
		# (EN) Server IP address
		# Format: 0.0.0.0
		'ip' => '127.0.0.1',
		

		# (PL) Port query
		# (EN) Server query port
		# Default: 10011
		'port_query' => 10011,
		

		# (PL) Port voice serwera
		# (EN) Server voice port
		# Default: 9987
		'server_port' => 9987,
		

		# (PL) Login do konta query
		# (EN) Login to query account
		# Default: serveradmin
		'login' => 'serveradmin',
		

		# (PL) Hasło do konta query
		# (EN) Password to query account
		'pass' => 'Your_password_here',
		
		
];


/**
 *	(PL) Ustawienia połączenia z bazą danych
 *  (EN) Settings to database connection
**/
$config['connection_db'] = [

		# (PL) Adres IP bazy danych
		# (EN) Database IP address
		# Format: 0.0.0.0
		'database_host' => '127.0.0.1',
		

		# (PL) Login do bazy danych
		# (EN) Login to database account
		# Default: root
		'database_login' => 'root',
		

		# (PL) Hasło do bazy danych
		# (EN) Password to database account
		'database_pass' => 'Your_password_here',
		

		# (PL) Nazwa bazy danych
		# (EN) Database name
		# Default: sbot_free
		'database_name' => 'sbot',

];


/**
 *	(PL) Indywidualne logowanie
 *  (EN) Individual login
**/
$config['individual_login'] = [

	/*  Remove this line for enabled
	# Id instancji bota
	5 => [

		# Login do konta Query
		'login' => 'Your_login_here',

		# Hasło do konta Query
		'pass' => 'Your_password_here',

	],
	And remove this line for enabled */

];


?>