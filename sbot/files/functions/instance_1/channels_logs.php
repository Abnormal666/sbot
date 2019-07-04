<?php

class channels_logs
{
	
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$sbot::check_ids($ts,$cfg['channel_id'],'channel','channels_logs');
			foreach($ts->getElement('data', $ts->logView(50)) as $logs)
			{
				$log = $logs['l'];
				if(isset($log) && strpos($log, 'channel')!==FALSE && strpos($log, 'edited')!==FALSE)
				{
					$l = explode('|',$log);
					preg_match_all("/(\([a-z]+\:(\d+)\))/", $l[4], $final);
					$returned = [];
					if(isset($final[1]))
					{
						foreach($final[1] as $ogs)
						{
							$returned[] = explode(':',str_replace(['(',')'],'',$ogs));
						}
					}
					
					if(isset($returned[0][1]) && (isset($returned[1][1]) && $returned[1][1]!=1))
					{
						$cid = $returned[0][1];
						$cldbid = $returned[1][1];
						$cldb = $ts->clientDbInfo($cldbid)['data'];
						$check = $ts->clientFind($cldb['client_nickname'])['data'];
						if(!isset($check[0]['clid'])) continue;
						$client_info = $ts->clientInfo($check[0]['clid'])['data'];
						if($client_info['client_platform']!='ServerQuery')
						{
							$time = strtotime($l[0]);
							$data = $db->query("SELECT * FROM `channels_logs` WHERE `cid`='".$returned[0][1]."'")->fetch(PDO::FETCH_ASSOC);
							if(!$data)
							{
								$db->query("INSERT INTO `channels_logs` (`add`,`edit_dbid`,`cid`) VALUES ('$time','$cldbid','$cid')");
							}
							else
							{
								if($data['add']!=$time)
								{
									$db->query("INSERT INTO `channels_logs` (`add`,`edit_dbid`,`cid`) VALUES ('$time','$cldbid','$cid')");
								}
							}
						}
					}
				}
			}
			unset($logs,$log,$l,$returned,$cid,$cldbid,$cldb,$check,$client_info,$time,$data);

			$desc = '[center][size=20][b]Ostatnie edycje kanałów[/b][/size][/center][size=10]\n';
			$data = $db->query("SELECT * FROM `channels_logs` ORDER BY `ID` DESC LIMIT 50")->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($data))
			{
				foreach($data as $row)
				{
					$client = $ts->clientDbInfo($row['edit_dbid'])['data'];
					$channel_name = $ts->channelInfo($row['cid'])['data']['channel_name'];
					$desc .= '[b]• '.date('d/m/Y G:i',$row['add']).'[/b] | [url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] zedytował kanał o nazwie: [url=channelid://'.$row['cid'].']'.$channel_name.' (Id: '.$row['cid'].')[/url]\n';
				}
			}
			else
				$desc .= '[b]• Żaden kanał nie został edytowany[/b]\n';
			$desc .='[/size]'.$lang['system']['footer'];
			$ts->channelEdit($cfg['channel_id'],['channel_description'=>$desc]);
			unset($desc,$data,$row,$client,$channel_name);
	}
}
?>