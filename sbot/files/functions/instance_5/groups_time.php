<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: groups_time
#	DATE CREATED: 23/09/2018
#
##############################

class groups_time
{

	function __construct($ts,$cfg,$db,$lang,$sbot)
	{
		foreach($db->query("SELECT * FROM `pointsbot_groups`")->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			if(!empty($row['time_remove']))
			{
				if($row['time_remove']<=time())
				{
					$ts->serverGroupDeleteClient($row['sgid'],$row['cldbid']);
					$db->query("DELETE FROM `pointsbot_groups` WHERE `cldbid`='".$row['cldbid']."'");
				}
			}
		}

		foreach($db->query("SELECT `points_time`,`client_database_id`,`boost_lv` FROM `clients`")->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			if($row['points_time']>60)
			{
				if(floor((($row['points_time']/1000) - (floor(($row['points_time']/1000) / 86400) * 86400)) / 3600)>=1)
				{
					$row['boost_lv'] = ($row['boost_lv']==0 ? 1 : $row['boost_lv']);
					$db->query("UPDATE `clients` SET `points`=`points`+'". (5+$cfg['boosts'][$row['boost_lv']][0]) ."',`points_time`=0 WHERE `client_database_id`='".$row['client_database_id']."'");
				}
			}
		}
	}

}

?>