<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: away_group
#	DATE CREATED: 29/06/2018
#
##############################

class away_group
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['group_id'],'group','away_group');
		foreach($clients as $client)
		{
			if($client['client_platform']!='ServerQuery' && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
			{
				$client_info = $ts->getElement('data',$ts->clientInfo($client['clid']));
				if(($cfg['add_when_time'] && ($client_info['client_idle_time'] >= ($cfg['afk_time']*1000*60))) || ($client_info['client_away']==1) || ($client_info['client_output_muted']==1))
				{
					if(!in_array($cfg['group_id'], explode(',',$client['client_servergroups'])))
					{
						$ts->serverGroupAddClient($cfg['group_id'],$client['client_database_id']);
					}
				}
				else
				{
					if(in_array($cfg['group_id'], explode(',',$client['client_servergroups'])))
					{
						$ts->serverGroupDeleteClient($cfg['group_id'],$client['client_database_id']);
					}
				}
				unset($client_info);
			}
			else if(!$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
			{
				if(in_array($cfg['group_id'], explode(',',$client['client_servergroups'])))
				{
					$ts->serverGroupDeleteClient($cfg['group_id'],$client['client_database_id']);
				}
			}
		}
	}
	
}



?>