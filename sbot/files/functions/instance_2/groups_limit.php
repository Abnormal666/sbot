<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: groups_limit
#	DATE CREATED: 29/06/2018
#
##############################

class groups_limit
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		foreach($clients as $client)
		{
			if(!$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
			{
				foreach($cfg['groups'] as $index => $more)
				{
					$count=0;
					foreach($more['groups_id'] as $sgid)
					{
						$sbot::check_ids($ts,$sgid,'group','groups_limit');
						if(in_array($sgid, explode(',', $client['client_servergroups'])))
						{
							$count++;
						}
					}
					if($count>$more['groups_limit'])
					{
						$count2 = $count;
						foreach($more['groups_id'] as $group)
						{
							$sbot::check_ids($ts,$group,'group','groups_limit');
							if(in_array($group, explode(',', $client['client_servergroups'])) && !($count2<=$more['groups_limit']))
							{
								$ts->serverGroupDeleteClient($group,$client['client_database_id']);
								$count2--;
							}
						}
						unset($count2);
					}
					unset($count);
				}
			}
		}
		unset($client,$sgid);
		
	}
	
}



?>