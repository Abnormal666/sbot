<?Php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: platforms
#	DATE CREATED: 24/06/2018
#
##############################

class platforms
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$tmp_clients = [];
		$tmp_i = [];
		foreach($clients as $client)
		{
			if($client['client_platform']!="ServerQuery")
			{
				$tmp_i[$client['client_database_id']]=0;
				if(!array_key_exists($client['client_database_id'], $tmp_clients))
				{
					$tmp_clients[$client['client_database_id']] = $client['clid'];
				}
				else
				{
					$tmp_e = $tmp_clients[$client['client_database_id']];
					unset($tmp_clients[$client['client_database_id']]);
					$tmp_clients[$client['client_database_id']][$tmp_i[$client['client_database_id']]++] = $tmp_e;
					unset($tmp_e);
					$tmp_clients[$client['client_database_id']][$tmp_i[$client['client_database_id']]++] = $client['clid'];
				}
			}
			
		}
		unset($tmp_i);
		foreach($cfg['os'] as $name => $more)
		{
			$sbot::check_ids($ts,$more['group_id'],'group','platforms');
			$check[] = $more['group_id'];
			foreach($tmp_clients as $tmp_client)
			{
				if(is_array($tmp_client))
				{
					$tmp_client = $tmp_client[0];
				}
				$client = $ts->clientInfo($tmp_client)['data'];
				if($more['enabled'] && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
				{	
					if(strtolower($client['client_platform'])==$name)
					{
						if(!in_array($more['group_id'],explode(',',$client['client_servergroups'])))
						{
							$ts->serverGroupAddClient($more['group_id'],$client['client_database_id']);
						}
					}
					else
					{	
						if(in_array($more['group_id'],explode(',',$client['client_servergroups'])))
						{
							$ts->serverGroupDeleteClient($more['group_id'],$client['client_database_id']);
						}
					}
				}
			}
		}
	}
}
?>