<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: record_online
#	DATE CREATED: 23/06/2018
#
##############################

class record_online
{
	
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','record_online');
		$server_info = $ts->getElement('data',$ts->serverInfo());
		
		$online = 0;
		foreach ($clients as $client)
		{
			if($client['client_platform']!='ServerQuery' && !$sbot::in_group($cfg['ignored_groups'],$client['client_servergroups']))
				$online++;
		}
		unset($client);
		//$online = $server_info['virtualserver_clientsonline'] - $server_info['virtualserver_queryclientsonline'];
		
		if(!file_exists('files/cache/record.txt'))
		{
			file_put_contents('files/cache/record.txt',$online.'-'.date('d/m/Y G:i'));
		}
		
		$record = file_get_contents('files/cache/record.txt');
		$record = explode('-',$record);
		if($record[0]<$online)
		{
			file_put_contents('files/cache/record.txt',$online.'-'.date('d/m/Y G:i'));
		}
		$db_record = $db->query("SELECT * FROM `records` ORDER BY `record` DESC")->fetchAll(PDO::FETCH_ASSOC);
		for($i=0; $i<=count($db_record);$i++)
		{
			if($i!=0 && $i!=1 && $i!=2 && $i!=3 && $i!=4 && isset($db_record[$i]['id']))
			{
				$db->query("DELETE FROM `records` WHERE `id`='".$db_record[$i]['id']."'");
			}
		}
		unset($db_record);
		$db_record = $db->query("SELECT * FROM `records` ORDER BY `record` DESC")->fetchAll(PDO::FETCH_ASSOC);

		if(!isset($db_record[0]['record']) || $db_record[0]['record']<$online)
		{
			$db->query("INSERT INTO `records` (`record`,`time`) VALUES ('$online','".time()."')");
		}
			
		#$desc = '[center][size=20][b]REKORD ONLINE[/b][/size][/center]\n\n[size=11]';
		$desc = $descriptions['record_online']['header'];
		$desc .= str_replace(['[RECORD_COUNT]','[RECORD_DATE]'], [$record[0],$record[1]], $descriptions['record_online']['desc']);
		foreach($db_record as $rcd)
		{
			$desc .= str_replace(['[RECORD_COUNT]','[RECORD_DATE]'], [$rcd['record'],date('d/m/Y G:i',$rcd['time'])], $descriptions['record_online']['top_row']);
		}
		unset($tmp_i);
		$desc .= '[/size]'.$lang['system']['footer'];
			
		$ts->channelEdit($cfg['channel_id'],['channel_name'=>str_replace('[RECORD]',$record[0],$cfg['channel_name']),'channel_description'=>$desc]);
		unset($last,$desc,$online,$server_info,$record);
	}
	
}

?>