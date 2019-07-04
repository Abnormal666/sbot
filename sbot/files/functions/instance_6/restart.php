<?php

##############################
#
#	AUTHOR: `Demon.
#	COMMAND NAME: restart
#	DATE CREATED: 30/10/2018
#
##############################

class restart
{
	function __construct($ts,$cfg,$sbot,$lang,$invoker,$args,$db)
	{
		if($args[1]=='all')
		{
			if(shell_exec('if screen -list | grep -q "sbot_daemon" ; then echo "1"; else echo "0"; fi')!=1)
			{
				$ts->sendMessage(1,$invoker['clid'],"[color=red]Nie jest włączony SBOT DAEMON, wiec restart nie zadziała![/color]");
				return;
			}
			else
			{
				shell_exec('./exec.sh stop');
				$ts->sendMessage('[b][color=green]Instancje zostały pomyślnie zresetowane!');
			}
		}
		elseif(is_numeric($args[1]))
		{
			shell_exec('./exec.sh it '.$args[1]);
			shell_exec('./exec.sh it '.$args[1]);
		}
	}

}



?>