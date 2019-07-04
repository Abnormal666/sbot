<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: count_of_database_clients
#	DATE CREATED: 11/07/2018
#
##############################

class count_of_database_clients
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','count_of_database_clients');
		$ts->channelEdit($cfg['channel_id'],['channel_name'=>str_replace('[COUNT]', count($db->query("SELECT `id` FROM `clients`")->fetchAll(PDO::FETCH_ASSOC)), $cfg['channel_name'])]);
	}
	
}



?>