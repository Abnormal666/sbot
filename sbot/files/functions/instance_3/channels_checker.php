<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: channels_checker
#	DATE CREATED: 19/07/2018
#
##############################

class channels_checker
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		$free =[];
		$locked=[];
		$subchannels = [];
		$number = 1;
		$main = [];
		foreach($ts->channelList()['data'] as $channel)
		{
			if($channel['pid']==$cfg['private_zone'])
			{
				if($cfg['check_numbering'])
				{
					$chname = explode('.', $channel['channel_name']);
					if($number!=$chname[0])
					{
						$ts->channelEdit($channel['cid'],['channel_name'=>$number.'.'.(!isset($chname[1]) ? 'Błędna nazwa' : $chname[1]),'channel_description'=>str_replace('[b]'.$chname[0].'[/b]', '[b]'.$number.'[/b]', $ts->channelInfo($channel['cid'])['data']['channel_description'])]);
					}
					unset($chname,$desc);
					$number++;
				}
			}
		}
		foreach($ts->channelList('-topic -info')['data'] as $channel)
		{
			if($channel['pid']==$cfg['private_zone'])
			{

				if($channel['channel_topic']=='#empty')
				{
					$free[]=$channel['cid'];
				}
				elseif($channel['channel_topic']!='#empty')
				{
					if($cfg['date_checker']['enabled'])
					{
						$channel_num = explode('.', $channel['channel_name'])[0];
						if(!isset($channel['channel_topic']))
						{
							$ts->channelEdit($channel['cid'],['channel_topic'=>date('d/m/Y')]);
						}
						$channel_date = strtotime(str_replace('/','.',$channel['channel_topic']));
						if($channel['total_clients']>0)
						{
							if($cfg['date_checker']['refresh'] && $channel_date<=strtotime('-1 day'))
							{
								$ts->channelEdit($channel['cid'],['channel_topic'=>date('d/m/Y')]);
							}
						}
						else
						{
							if($channel_date<strtotime('-7 day'))
							{
								$ts->channelEdit($channel['cid'],['channel_name'=>self::check_name($channel['channel_name'],$cfg['date_checker']['warning'])]);
							}
							
							if($channel_date<=strtotime('-10 days'))
							{
								$ts->channelDelete($channel['cid'],1);
								$ts->channelCreate([
									'channel_name' => $channel_num.'. Wolny kanał prywatny',
									'cpid' => $cfg['private_zone'],
									'channel_order' => $channel['channel_order'],
									'channel_topic'=>'#empty',
									'channel_description' => str_replace('[NUM]', $channel_num, $descriptions['channels_checker']['channel_description']).$lang['system']['footer'],
									'channel_maxclients' => 0,
									'channel_maxfamilyclients' => 0,
									'channel_flag_permanent' => 1,
									'channel_flag_maxclients_unlimited' => 0,
									'channel_flag_maxfamilyclients_unlimited' => 0,
								]);
							}
							if($channel_date>time())
								$ts->channelEdit($channel['cid'],['channel_topic'=>date('d/m/Y')]);
						}
						unset($channel_date,$channel_num);
					}
					if($cfg['delete_badword'])
					{
						foreach($lang['bad_words'] as $word)
						{
							if(strpos(strtolower($channel['channel_name']), strtolower($word))!==FALSE)
							{
								$ts->channelEdit($channel['cid'],['channel_name' => $channel_num.'. Niepoprawna nazwa kanału.']);
							}
						}
						$main[]=$channel;
					}
					if($cfg['date_checker']['enabled']==true && $cfg['date_checker']['refresh']==true && strpos($channel['channel_name'], $cfg['date_checker']['warning'])!==FALSE && strtotime(str_replace('/','.',$channel['channel_topic']))>strtotime('-7 day'))
					{
						$ts->channelEdit($channel['cid'],['channel_name' => str_replace($cfg['date_checker']['warning'],'Kanał',$channel['channel_name'])]);
					}
				}
			}

			foreach($main as $ch)
			{
				if($cfg['date_checker']['enabled'])
				{
					if($channel['pid']==$ch['cid'])
					{
						if(!isset($ch['channel_topic']))
						{
							$ts->channelEdit($ch['cid'],['channel_topic'=>date('d/m/Y')]);
						}
						$channel_date = strtotime(str_replace('/','.',$ch['channel_topic']));
						if($channel['total_clients']>0)
						{
							if($cfg['date_checker']['refresh'] && $channel_date<=strtotime('-1 day'))
							{
								$ts->channelEdit($ch['cid'],['channel_topic'=>date('d/m/Y')]);
							}
						}
					}
				}

				if($cfg['delete_badword'])
				{
					if($channel['pid']==$ch['cid'])
					{
						foreach($lang['bad_words'] as $word)
						{
							if(strpos(strtolower($channel['channel_name']), strtolower($word))!==FALSE)
							{
								if(!($ts->channelEdit($channel['cid'],['channel_name' => 'Niepoprawna nazwa podkanału'])['success']))
								{
									$ts->channelEdit($channel['cid'],['channel_name' => 'Niepoprawna nazwa podkanału1']);
								}
							}
						}
					}
				}
			}
		}

		if(count($free)<$cfg['channels_count'])
		{
			for($i=count($free); $i<$cfg['channels_count']; $i++)
			{
				$ts->channelCreate([
					'channel_name' => $number.'. Wolny kanał prywatny',
					'cpid' => $cfg['private_zone'],
					'channel_topic'=>'#empty',
					'channel_description' => str_replace('[NUM]', $number, $descriptions['channels_checker']['channel_description']).$lang['system']['footer'],
					'channel_maxclients' => 0,
					'channel_maxfamilyclients' => 0,
					'channel_flag_permanent' => 1,
					'channel_flag_maxclients_unlimited' => 0,
					'channel_flag_maxfamilyclients_unlimited' => 0,
				]);
				$number++;
				sleep(1);
			}
		}
		elseif(count($free)>$cfg['channels_count'])
		{
			$i = count($free);
			foreach(array_reverse($free) as $cid)
			{
				if($i!=$cfg['channels_count'])
				{
					$ts->channelDelete($cid,1);
					$i--;
				}

			}
		}

		unset($main,$channel,$free,$number,$locked,$subchannels);
	}
	
	private function check_name($name,$zm)
	{
		if(strlen($name.$zm)>=24)
		{
			return substr($name, 0, strlen($zm)).$zm;
		}
		return $name.$zm;
	}
}



?>