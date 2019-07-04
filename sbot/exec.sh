#!/bin/bash

##
 #
 #	@name  SBOT v6.0 PREMIUM
 #	@author  `DEMON.
 #	@file  exec.sh
 #	@copyright  Copyright (c) 2018-2019, Julian '`Demon.'
 #	
 ##

instances=6;
version="6.0";
daemon_start_instances=(1 2 3 4 5 6);
welcome()
{
	clear;
	echo -e " "
	echo -e "  \e[93m|> Witamy!"
	echo -e "     Autor: \`Demon. "
	echo -e "     Posiadasz wersję: $version PREMIUM\e[0m"
	echo -e " "
	
}

start_instances()
{
	if [[ "$1" == "daemon" ]]; then
		for id in ${daemon_start_instances[@]}; do
			if ! screen -list | grep -q "sbot_$id" ; then 
				sudo screen -dmS sbot_$id php core.php -i $id
				echo -e "     \e[32m[DAEMON] Instancja $id została poprawnie włączona! \e[0m"
				#sleep 1
			fi
		done
	else
		for (( id=1; $id <= $instances; id++ )) ; do
			if ! screen -list | grep -q "sbot_$id" ; then 
				sudo screen -dmS sbot_$id php core.php -i $id
				echo -e "     \e[32mInstancja $id została poprawnie włączona! \e[0m"
				#sleep 1
			else
				echo -e "     \e[91mInstancja $id jest już włączona! \e[0m"
			fi
		done
	fi
}

stop_inctances()
{
	for (( id=1; $id <= $instances; id++ )) ; do
		if screen -list | grep -q "sbot_$id" ; then 
			screen -S sbot_$id -X quit
			echo -e "     \e[32mInstancja $id została poprawnie wyłączona! \e[0m"
			#sleep 1
		else
			echo -e "     \e[91mInstancja $id nie jest włączona! \e[0m"
		fi
	done
}

restart_instances()
{
	for (( id=1; $id <= $instances; id++ )) ; do
		if screen -list | grep -q "sbot_$id" ; then 
			screen -S sbot_$id -X quit
		fi
			sleep 1;
		if ! screen -list | grep -q "sbot_$id" ; then 
			screen -dmS sbot_$id php core.php -i $id
			#sleep 1
		fi
			echo -e "     \e[32mInstancja $id została poprawnie zrestartowana! \e[0m"
	done
}

daemon_start()
{
	if ! screen -list | grep -q "sbot_daemon" ; then
		screen -dmS sbot_daemon ./exec.sh daemon lepiejnieruszajjakniepotrafiszxd
		echo -e "     \e[32mSBOT daemon został porawnie włączony!\e[0m"
	fi
}

daemon_stop()
{
	if screen -list | grep -q "sbot_daemon" ; then
		screen -S sbot_daemon -X quit
		echo -e "     \e[32mSBOT daemon został porawnie wyłączony!\e[0m"
	fi
	echo -e " "
	stop_inctances
}

daemon_start_proces()
{
	echo -e " "
	while [ 1 ];do
		start_instances "daemon"
		sleep 3;
	done
}


install_packets()
{
	welcome
	
	apt-get update && apt-get upgrade -y
	apt-get install screen wget -y
	apt-get install software-properties-common
	add-apt-repository ppa:ondrej/php
	apt-get update
	apt-get install php7.2 php-pear php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml libapache2-mod-php -y
	service apache2 restart
}

show_help()
{
	welcome
	if [[ "$1" == "help" ]]; then
		echo -e "     \e[36m POMOC :: \e[91mLista dostępnych argumentów:\e[0m"
	elif [[ "$1" == "notexixtsparams" ]]; then
		echo -e "     \e[36m BŁĄD :: \e[91mBrakuje argumentów! Dostępne:\e[0m"
	fi
	echo -e "     • \e[93mstart\e[0m - Włącza wszystkie instancje"
	echo -e "     • \e[93mstop\e[0m - Wyłącza wszystkie instancje"
	echo -e "     • \e[93mrestart\e[0m - Restartuje wszystkie instance"
	echo -e "     • \e[93mit\e[0m - Włącza podaną instancę"
	echo -e "     • \e[93mdaemon\e[0m - Tryb samoczynnego włączania instancji"
	echo -e "       » \e[36mstart\e[0m - Włącza tryb"
	echo -e "       » \e[36mstop\e[0m - Wyłącza tryb"
	echo -e "       » \e[36mrestart\e[0m - Resetuje tryb"
	echo -e "     • \e[93minstall\e[0m - Opcje instalacji"
	echo -e "       » \e[36mpackets\e[0m - Instalacja pakietów (php,curl,wget,screen,etc)"
	echo -e "       » \e[36mioncube\e[0m - Instalacja Ioncube do php"
	echo -e "       » \e[36mdatabase\e[0m - Instalacja oraz sprawdzanie bazy danych"
	echo -e "     • \e[93mversion\e[0m - Pokazuje aktualną wersję"
	echo -e "     • \e[93mupdate\e[0m - Sprawdza dostępność aktualizacji"
	echo -e "     • \e[93mhelp\e[0m - Wyświetla listę z parametrami do startera"
	echo -e "     • \e[93mfaq\e[0m - Wyświetla link do strony z FAQ do sbota"
	echo -e "     • \e[93mstatus\e[0m - Wyświetla status instancji"
}



if [ "$1" == "start" ]; then
	welcome
	start_instances
elif [ "$1" == "stop" ]; then
	welcome
	stop_inctances
elif [ "$1" == "restart" ]; then
	welcome
	restart_instances
elif [ "$1" == "daemon" ]; then
	welcome
	if [ "$2" == "start" ]; then
		daemon_start
	elif [ "$2" == "stop" ]; then
		daemon_stop
	elif [ "$2" == "restart" ]; then
		daemon_stop
		echo -e " "
		daemon_start
	elif [ "$2" == "lepiejnieruszajjakniepotrafiszxd" ]; then
		daemon_start_proces
	else
		echo -e "     \e[36m BŁĄD :: \e[91mWybierz parametr! Dostępne:\e[0m"
		echo -e "     • \e[93mstart\e[0m - Włącza tryb"
		echo -e "     • \e[93mstop\e[0m - Wyłącza tryb"
		echo -e "     • \e[93mrestart\e[0m - Resetuje tryb"
	fi
elif [ "$1" == "install" ]; then
	if [ "$2" == "packets" ]; then
		install_packets
		welcome
		echo -e "     \e[32mPoprawnie zainstalowano php7.2 i wymagane pakiety!\e[0m"
	else
		welcome
		echo -e "     \e[36m BŁĄD :: \e[91mWybierz parametr! Dostępne:\e[0m"
		echo -e "     • \e[93mpackets\e[0m - Instalacja pakietów (php,curl,wget,screen,etc)"
	fi
elif [ "$1" == "it" ]; then
	welcome
	if [ ! -z "$2" ]; then
		if screen -list | grep -q "sbot_$2" ; then 
			screen -S sbot_$2 -X quit
			echo -e "     \e[32mInstancja $2 została poprawnie wyłączona! \e[0m"
		elif ! screen -list | grep -q "sbot_$2" ; then 
			screen -dmS sbot_$2 php core.php -i $2
			echo -e "     \e[32mInstancja $2 została poprawnie włączona! \e[0m"
		fi
	else
		echo -e "     \e[36m BŁĄD :: \e[91mWybierz instancję!\e[0m"
	fi

elif [ "$1" == "version" ]; then
	welcome
	echo -e "     \e[32mPosiadasz wersję: $version \e[0m"
	echo -e "     \e[32mAby sprawdzić dostępność aktualizacji wpisz: ./exec.sh update \e[0m"
	echo -e ""
elif [ "$1" == "update" ]; then
	php core.php --update
elif [ "$1" == "faq" ]; then
	welcome
	echo -e "     \e[36mFAQ dostępne jest na: \e[93mhttps://sbot.pl/?faq \e[0m"
elif [ "$1" == "help" ]; then
	show_help "help"
elif [ "$1" == "status" ]; then
	welcome
	echo -e "     \e[36mStatus instancji: \e[0m"
	for (( id=1; $id <= $instances; id++ )) ; do
		if screen -list | grep -q "sbot_$id" ; then 
			echo -e "     Instancja $id jest \e[32mwłączona\e[0m! \e[0m"
		elif ! screen -list | grep -q "sbot_$id" ; then 
			echo -e "     Instancja $id jest \e[91mwyłączona\e[0m! \e[0m"
		fi
	done
else
	show_help "notexixtsparams"
fi

echo -e ""
