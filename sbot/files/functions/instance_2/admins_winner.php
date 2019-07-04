<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: admins_winner
#	DATE CREATED: 11/07/2018
#
##############################

class admins_winner
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['today_group'],'group','admins_winner');
		$sbot::check_ids($ts,$cfg['week_group'],'group','admins_winner');
		$sbot::check_ids($ts,$cfg['month_group'],'group','admins_winner');

		$today = $db->query('SELECT * FROM `admins` ORDER BY `time_spent_day` DESC, `help_day` DESC LIMIT 1;')->fetch();
		$week = $db->query('SELECT * FROM `admins` ORDER BY `time_spent_week` DESC, `help_week` DESC LIMIT 1;')->fetch();
		$month = $db->query('SELECT * FROM `admins` ORDER BY `time_spent_month` DESC, `help_month` DESC LIMIT 1;')->fetch();
		if(!empty($today) && $cfg['today_enabled'])
		{
			foreach($ts->serverGroupClientList($cfg['today_group'])['data'] as $client)
			{
				if(isset($client['cldbid']))
				{
					if($client['cldbid']!=$today['client_database_id'])
					{
						$ts->serverGroupDeleteClient($cfg['today_group'], $client['cldbid']);
					}
				}
					else
					{
						$ts->serverGroupAddClient($cfg['today_group'], $today['client_database_id']);
					}
			}
		}
		if(!empty($week) && $cfg['week_enabled'])
		{
			foreach($ts->serverGroupClientList($cfg['week_group'])['data'] as $client)
			{
				if(isset($client['cldbid']))
				{
					if($client['cldbid']!=$week['client_database_id'])
						$ts->serverGroupDeleteClient($cfg['week_group'], $client['cldbid']);
				}
				else
					$ts->serverGroupAddClient($cfg['week_group'], $week['client_database_id']);
			}
		}
		if(!empty($month) && $cfg['month_enabled'])
		{
			foreach($ts->serverGroupClientList($cfg['month_group'])['data'] as $client)
			{
				if(isset($client['cldbid']))
				{
					if($client['cldbid']!=$month['client_database_id'])
						$ts->serverGroupDeleteClient($cfg['month_group'], $client['cldbid']);
				}
				else
					$ts->serverGroupAddClient($cfg['month_group'], $month['client_database_id']);
			}
		}
		unset($month,$week,$today);
	}
	
}


?>