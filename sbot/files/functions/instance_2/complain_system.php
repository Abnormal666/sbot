<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: complain_system
#	DATE CREATED: 30/10/2018
#
##############################

class complain_system
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$users = [];
		$results =$ts->complainList();
		if($results['success']==1)
		{
			foreach($ts->complainList()['data'] as $complain)
			{
				$users[$complain['tcldbid'].'.'.$complain['fcldbid']]=$complain;
			}
		}
		print_r($users);
	}
	
}



?>