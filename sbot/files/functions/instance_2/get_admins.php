<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: get_admins
#	DATE CREATED: 11/07/2018
#
##############################

class get_admins
{
	private static $cache_groups = [];
	private static $cache_helps = [];
	private static $time_help = [];
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$logtemplate_helps = [];
		$logtemplate_groups = [];
		$admins = [];
		$users=[];
		$actual_channels=[];
		foreach($clients as $client)
		{
			if($client['client_platform']!='ServerQuery')
			{
				if($sbot::in_group($cfg['admin_groups'],$client['client_servergroups']))
				{

					$check = $db->query("SELECT * FROM `admins` WHERE `client_database_id`='".$client['client_database_id']."'");
					if($check->rowCount()<=0)
					{
						$grname=self::get_group($cfg['admin_groups'],$client['client_servergroups'],$ts);
						$db->prepare("INSERT INTO `admins` (client_database_id,client_unique_identifier,client_nickname,group_name,time_spent,time_spent_day,time_spent_week,time_spent_month,number_day,number_week,number_month,groups_total_register,groups_total_other,groups_day_other,groups_week_other,groups_month_other,groups_day_register,groups_week_register,groups_month_register,day_help_time,week_help_time,month_help_time,total_help_time) VALUES (:cldbid,:cluid,:clnick,:grname,:timespent,:tsd,:tsw,:tsm,:td,:tw,:tm,:groups_total_register,:groups_total_other,:groups_day_other,:groups_week_other,:groups_month_other,:groups_day_register,:groups_week_register,:groups_month_register,:day_help_time,:week_help_time,:month_help_time,:total_help_time)")->execute([
							'cldbid' => $client['client_database_id'],
							'cluid' => $client['client_unique_identifier'],
							'clnick' => $client['client_nickname'],
							'grname' => $grname,
							'timespent' => 0,
							'tsd' => 0,
							'tsw' => 0,
							'tsm' => 0,
							'td' => 0,
							'tw' => 0,
							'tm' => 0,
							'groups_total_register' => 0,
							'groups_total_other' => 0,
							'groups_day_other' => 0,
							'groups_week_other' => 0,
							'groups_month_other' => 0,
							'groups_day_register' => 0,
							'groups_week_register' => 0,
							'groups_month_register' => 0,
							'day_help_time' => 0,
							'week_help_time' => 0,
							'month_help_time' => 0,
							'total_help_time' => 0,
						]);
						$admins[] = $client;
						$actual_channels[] = $client['cid'];
					}
					else
					{
						$admins[] = $client;
						$actual_channels[] = $client['cid'];
					}
				}
			}
		}

		foreach($admins as $client)
		{
			$check = $db->query("SELECT * FROM `admins` WHERE `client_database_id`='".$client['client_database_id']."'");
			$grname=self::get_group($cfg['admin_groups'],$client['client_servergroups'],$ts);
			$row = $check->fetch(PDO::FETCH_ASSOC);
			if(!isset($row['client_database_id']) || !is_numeric($row['client_database_id']))
				continue;
			$cldbid = $row['client_database_id'];
			
			$time_spent = ($sbot::interval($cfg['interval'])*1000);
			if($row['number_day']!=date('d'))
			{
				$db->query("UPDATE `admins` SET `time_spent_day`='0', `number_day`='".date('d')."', `groups_day_other`='0', `groups_day_register`='0',`help_day`='0',`day_help_time`='0' WHERE `client_database_id`='$cldbid'");
			}
			else
			{
				$db->query("UPDATE `admins` SET `time_spent_day`=`time_spent_day`+'$time_spent' WHERE `client_database_id`='$cldbid'");
			}
			if($row['number_month']!=date('m'))
			{
				$db->query("UPDATE `admins` SET `time_spent_month`='0', `number_month`='".date('m')."', `groups_month_other`='0', `groups_month_register`='0',`help_month`='0',`month_help_time`='0' WHERE `client_database_id`='$cldbid'");
			}
			else
			{
				$db->query("UPDATE `admins` SET `time_spent_month`=`time_spent_month`+'$time_spent' WHERE `client_database_id`='$cldbid'");
			}
			if($row['number_week']!=date('W'))
			{
				$db->query("UPDATE `admins` SET `time_spent_week`='0', `number_week`='".date('W')."', `groups_week_other`='0', `groups_week_register`='0',`help_week`='0',`week_help_time`='0' WHERE `client_database_id`='$cldbid'");
			}
			else
			{
				$db->query("UPDATE `admins` SET `time_spent_week`=`time_spent_week`+'$time_spent' WHERE `client_database_id`='$cldbid'");
			}
			
			$db->query("UPDATE `admins` SET `time_spent`=time_spent+'$time_spent' WHERE `client_database_id`='$cldbid'");

			if($grname!=$row['group_name'])
			{
				$db->query("UPDATE `admins` SET `group_name`='$grname' WHERE `client_database_id`='$cldbid'");
			}

			$found = false;
			foreach($ts->serverGroupsByClientID($cldbid)['data'] as $sgid)
			{
				if(in_array($sgid['sgid'], $cfg['admin_groups']))
				{
					$found = true;
					break;
				}
			}
			if($found==false)
			{
				$db->query("DELETE FROM `admins` WHERE `client_database_id`='$cldbid'");
			}
			unset($found);
		}

		foreach($db->query("SELECT * FROM `admins`")->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$found = false;
			foreach($ts->serverGroupsByClientID($row['client_database_id'])['data'] as $sgid)
			{
				if(in_array($sgid['sgid'], $cfg['admin_groups']))
				{
					$found = true;
					break;
				}
			}
			if($found==false)
			{
				$db->query("DELETE FROM `admins` WHERE `client_database_id`='".$row['client_database_id']."'");
			}
			unset($found);
		}

		foreach($ts->logView(50)['data'] as $log)
		{
			$log = $log['l'];
			if(isset($log) && strpos($log,'added to servergroup')!==FALSE)
			{
				$l = explode('|',$log)[4];
				preg_match_all("/(\([a-z]+\:(\d+)\))/", $l, $final);
				$returned = [];
				if(isset($final[1]))
					foreach($final[1] as $ogs)
						$returned[] = explode(':',str_replace(['(',')'],'',$ogs));
				if(isset($returned[0][1]) && isset($returned[1][1]) && isset($returned[2][1]))
				{
					$logtemplate_groups = $returned[0][1].$returned[1][1].$returned[2][1];
					if(!in_array($logtemplate_groups, self::$cache_groups))
					{
						self::$cache_groups[] = $logtemplate_groups;
						if($returned[2][1]!=1)
						{
							if(in_array($returned[1][1],$cfg['register_groups']))
							{
								$db->query("UPDATE `admins` SET `groups_day_register`=`groups_day_register`+'1',`groups_week_register`=`groups_week_register`+'1',`groups_month_register`=`groups_month_register`+'1',`groups_total_register`=`groups_total_register`+'1' WHERE `client_database_id`='".$returned[2][1]."'");
							}
							else
							{
								$db->query("UPDATE `admins` SET `groups_day_other`=`groups_day_other`+'1',`groups_week_other`=`groups_week_other`+'1',`groups_month_other`=`groups_month_other`+'1',`groups_total_other`=`groups_total_other`+'1' WHERE `client_database_id`='".$returned[2][1]."'");
							}
						}
					}
				}
			}
		}

		foreach($admins as $admin)
		{
			if(in_array($admin['cid'], $cfg['support_channels']))
			{
				if(self::count_of_channels($admin['cid'],$clients)>1)
				{
					if(!in_array($admin['client_database_id'],self::$cache_helps))
					{
						self::$cache_helps[$admin['client_database_id']]=$admin['client_database_id'];
						self::$time_help[$admin['client_database_id']]=$admin['client_database_id'];
						$db->query("UPDATE `admins` SET `help_day`=`help_day`+'1',`help_week`=`help_week`+'1',`help_month`=`help_month`+'1',`help_total`=`help_total`+'1' WHERE `client_database_id`='".$admin['client_database_id']."'");
						echo $admin['client_database_id'].END;
					}

					if(in_array($admin['client_database_id'],self::$time_help))
					{
						$db->query("UPDATE `admins` SET
							`day_help_time`=`day_help_time`+'".($sbot::interval($cfg['interval'])*1000)."',
							`week_help_time`=`week_help_time`+'".($sbot::interval($cfg['interval'])*1000)."', 
							`month_help_time`=`month_help_time`+'".($sbot::interval($cfg['interval'])*1000)."',
							`total_help_time`=`total_help_time`+'".($sbot::interval($cfg['interval'])*1000)."'
							WHERE `client_database_id`='".$admin['client_database_id']."'");
					}
				}
			}
			else
			{
				if(in_array($admin['client_database_id'],self::$cache_helps))
				{
					unset(self::$cache_helps[$admin['client_database_id']]);
				}
				if(in_array($admin['client_database_id'],self::$time_help))
				{
					unset(self::$time_help[$admin['client_database_id']]);
				}
			}
		}
	}

	private function count_of_channels($cid,$clients)
	{
		$count = 0;
		foreach($clients as $client)
		{
			if($client['client_platform']!='ServerQuery')
			{
				if($client['cid']==$cid)
				{
					$count++;
				}
			}
		}
		return $count;
	}

	private function get_group($groups,$cl,$ts)
	{
		global $sbot;
		foreach($groups as $group)
		{
			$sbot::check_ids($ts,$group,'group','get_admins');
			if(in_array($group,explode(',', $cl)))
			{
				foreach($ts->serverGroupList()['data'] as $sgid)
				{
					if($group==$sgid['sgid'])
					{
						return $sgid['name'];
					}
				}
			}
		}
		return null;
	}

	private function in_support_channel($cid,$ts)
	{
		$users = [];
		foreach($ts->clientList()['data'] as $client)
		{
			if($client['client_type'] == 1)
				continue;

			if($client['cid'] == $cid)
				$users[] = $client;
		}
		return $users;
	}
	
}



?>