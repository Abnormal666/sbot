<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: groups_remove
#	DATE CREATED: 03/08/2018
#
##############################

class groups_remove
{
	function __construct($ts,$cfg,$sbot,$lang,$client,$db)
	{
		foreach($cfg['channels'] as $cid => $more)
		{
			$sbot::check_ids($ts,$cid,'channel','groups_remove');
			if($client['cid']!=$cid)
				continue;
			foreach($more as $sgid)
			{
				$sbot::check_ids($ts,$sgid,'group','groups_remove');
				if(in_array($sgid, explode(',', $client['client_servergroups'])))
				{
					$ts->serverGroupDeleteClient($sgid,$client['client_database_id']);
				}
			}
			$ts->clientPoke($client['clid'],'[b][color=green]Pomyślnie odebrano Ci wszystkie grupy!');
			$ts->clientKick($client['clid'],'channel');
			unset($more,$cid,$sgid);
		}
	}
	
}



?>