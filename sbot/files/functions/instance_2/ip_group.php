<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: ip_group
#	DATE CREATED: 23/08/2018
#
##############################

class ip_group
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		global $diff;
		if(!empty($diff))
		{
			foreach($diff as $clid)
			{
				$client = $ts->clientInfo($clid)['data'];
				foreach($cfg['ips'] as $ip => $group)
				{
					$sbot::check_ids($ts,$group,'group','ip_group');
					if($client['connection_client_ip']==$ip)
					{
						$ts->serverGroupAddClient($group,$ts->clientGetDbIdFromUid($client['client_unique_identifier'])['data']['cldbid']);
					}
				}
			}
		}
	}
}

?>