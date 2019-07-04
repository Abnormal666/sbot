<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: achievements
#	DATE CREATED: 11/07/2018
#
##############################

class achievements
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['first_group'],'group','achievements');
		$sbot::check_ids($ts,$cfg['end_group'],'group','achievements');
		$sbot::check_ids($ts,$cfg['connections_group'],'group','achievements');
		$sbot::check_ids($ts,$cfg['time_spent_group'],'group','achievements');
		$sbot::check_ids($ts,$cfg['level_group'],'group','achievements');
		foreach ($clients as $client)
		{
			if($sbot::in_group($cfg['needed_groups'],$client['client_servergroups']) && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
			{
				if(!$sbot::in_group([$cfg['first_group']],$client['client_servergroups']))
					$ts->serverGroupAddClient($cfg['first_group'],$client['client_database_id']);

				if(!$sbot::in_group([$cfg['end_group']],$client['client_servergroups']))
					$ts->serverGroupAddClient($cfg['end_group'],$client['client_database_id']);
				
				if($cfg['connections_enabled']==true && !$sbot::in_group([$cfg['connections_group']],$client['client_servergroups']))
					$ts->serverGroupAddClient($cfg['connections_group'],$client['client_database_id']);

				if($cfg['time_spent_enabled']==true && !$sbot::in_group([$cfg['time_spent_group']],$client['client_servergroups']))
					$ts->serverGroupAddClient($cfg['time_spent_group'],$client['client_database_id']);

				if($cfg['add_first_level_group']==true && !$sbot::in_group([$cfg['level_group']],$client['client_servergroups']))
					$ts->serverGroupAddClient($cfg['level_group'],$client['client_database_id']);

				$client_info = $db->query("SELECT * FROM `clients` WHERE `client_database_id`='".$client['client_database_id']."'")->fetch(PDO::FETCH_ASSOC);
				if(!empty($client_info))
				{
					if($cfg['connections_enabled']==true)
					{
						$connections = -1;
						foreach($cfg['connections'] as $index => $more)
						{
							$sbot::check_ids($ts,$more['group_id'],'group','achievements');
							if($client_info['connections']>=$more['connections'])
							{
								$connections = $index;
							}
						}
						if(isset($cfg['connections'][$connections]))
						{
							if(!$sbot::in_group([$cfg['connections'][$connections]['group_id']],$client['client_servergroups']))
							{
								if($connections-1 != -1 && $connections != -1)
									$ts->serverGroupDeleteClient($cfg['connections'][$connections-1]['group_id'],$client['client_database_id']);
								$ts->serverGroupAddClient($cfg['connections'][$connections]['group_id'],$client['client_database_id']);
								$ts->sendMessage(1,$client['clid'],str_replace(['[CONNECTIONS]','[NEXT]'], [$cfg['connections'][$connections]['connections'],($cfg['connections'][$connections+1]['connections'] ?: 0)], $lang['achievements']['message_get']['connections']));
							}
							foreach($cfg['connections'] as $index => $more)
							{
								if($sbot::in_group([$more['group_id']],$client['client_servergroups']))
								{
									if($index!=$connections)
									{
										$ts->serverGroupDeleteClient($more['group_id'],$client['client_database_id']);
									}
								}
							}
						}
					}

					if($cfg['time_spent_enabled']==true)
					{
						$time_spent = -1;
						foreach($cfg['time_spent'] as $index => $more)
						{
							$sbot::check_ids($ts,$more['group_id'],'group','achievements');
							if(($client_info['time_spent']/1000/60)>=$more['time_spent'])
							{
								$time_spent = $index;
							}
						}

						if(isset($cfg['time_spent'][$time_spent]))
						{
							if(!$sbot::in_group([$cfg['time_spent'][$time_spent]['group_id']],$client['client_servergroups']))
							{
								if($time_spent-1 != -1 && $time_spent!= -1)
									$ts->serverGroupDeleteClient($cfg['time_spent'][$time_spent-1]['group_id'],$client['client_database_id']);
								$ts->serverGroupAddClient($cfg['time_spent'][$time_spent]['group_id'],$client['client_database_id']);
								$ts->sendMessage(1,$client['clid'],str_replace(['[TIME_SPENT]','[NEXT]'], [$cfg['time_spent'][$time_spent]['time_spent'],($cfg['time_spent'][$time_spent+1]['time_spent'] ?: 0)], $lang['achievements']['message_get']['time_spent']));
							}
							foreach($cfg['time_spent'] as $index => $more)
							{
								if($sbot::in_group([$more['group_id']],$client['client_servergroups']))
								{
									if($index!=$time_spent)
									{
										$ts->serverGroupDeleteClient($more['group_id'],$client['client_database_id']);
									}
								}
							}
						}
					}
				}
			}
		}
		unset($client_info,$time_spent,$index,$connections,$client);
	}
	
}



?>