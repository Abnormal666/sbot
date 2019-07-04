<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: elite_vip_channels_sort
#	DATE CREATED: 17/02/2019
#
##############################

class elite_vip_channels_sort
{
	function __construct($ts,$cfg,$sbot,$lang,$client,$db,$descriptions)
	{
		foreach ($cfg['zones'] as $zone_name => $type)
		{
			$num = 1;
			$channels = $db->query("SELECT * FROM `".$type."_channels` WHERE `zone_name`='$zone_name'")->fetchAll(PDO::FETCH_ASSOC);
			foreach($channels as $channel)
			{
				if($channel['number']!=$num)
				{
					if(isset($channel['big_numbers']))
					{
						$big_numbers = json_decode($channel['big_numbers'],1);
						if(!empty($big_numbers))
						{
							$bi = 1;
							foreach($big_numbers as $cid)
							{
								if($bi<5)
								{
									$ts->channelEdit($cid,['channel_name' => '[cspacer'.$num.$bi.'1]'.self::get_num($bi,$num)]);
									$bi++;
									usleep(500000);
								}
							}
						}
					}
					$ts->channelEdit($channel['main_channel'],['channel_name' => str_replace($channel['number'], $num, $ts->channelInfo($channel['main_channel'])['data']['channel_name'])]);
				}
				$db->query("UPDATE `".$type."_channels` SET `number`='$num' WHERE `id`='".$channel['id']."'");
				$num++;
			}

		}
		unset($num,$channels,$channel,$zone_name,$type);
	}
	private static function get_num($id,$number)
	{
		$spacer = [
			1 => [
				1 => '▄▀▀▀▄──▄█',
				2 => '▄▀▀▀▄─▄▀▀▀▄',
				3 => '▄▀▀▀▄─▄▀▀▀▄',
				4 => '▄▀▀▀▄────▄█─',
				5 => '▄▀▀▀▄─█▀▀▀▀',
				6 => '▄▀▀▀▄─▄▀▀▀▄',
				7 => '▄▀▀▀▄─▀▀▀▀█',
				8 => '▄▀▀▀▄─▄▀▀▀▄',
				9 => '▄▀▀▀▄─▄▀▀▀▄',
				10 => '──▄█──▄▀▀▀▄',
				11 => '──▄█───▄█',
				12 => '──▄█──▄▀▀▀▄',
				13 => '──▄█──▄▀▀▀▄',
				14 => '──▄█─────▄█─',
				15 => '──▄█──█▀▀▀▀',
				16 => '──▄█──▄▀▀▀▄',
				17 => '──▄█─▀▀▀▀█',
				18 => '──▄█──▄▀▀▀▄',
				19 => '──▄█──▄▀▀▀▄',
				20 => '▄▀▀▀▄─▄▀▀▀▄',
			],
			2 => [
				1 => '█───█─▀─█',
				2 => '█───█────▄▀',
				3 => '█───█───▄▄▀',
				4 => '█───█──▄▀─█─',
				5 => '█───█─█▄▄▄─',
				6 => '█───█─█▄▄▄─',
				7 => '█───█────█─',
				8 => '█───█─▀▄▄▄▀',
				9 => '█───█─▀▄▄▄▀',
				10 => '─▀─█──█───█',
				11 => '─▀─█──▀─█',
				12 => '─▀─█─────▄▀',
				13 => '─▀─█────▄▄▀',
				14 => '─▀─█───▄▀─█─',
				15 => '─▀─█──█▄▄▄─',
				16 => '─▀─█──█▄▄▄─',
				17 => '─▀─█────█─',
				18 => '─▀─█──▀▄▄▄▀',
				19 => '─▀─█──▀▄▄▄▀',
				20 => '───▄▀─█───█',
			],
			3 => [
				1 => '█───█───█',
				2 => '█───█──▄▀──',
				3 => '█───█─────█',
				4 => '█───█─█▄▄▄█▄',
				5 => '█───█─────█',
				6 => '█───█─█───█',
				7 => '█───█───█──',
				8 => '█───█─█───█',
				9 => '█───█─────█',
				10 => '───█──█───█',
				11 => '───█────█',
				12 => '───█───▄▀──',
				13 => '───█──────█',
				14 => '───█──█▄▄▄█▄',
				15 => '───█──────█',
				16 => '───█──█───█',
				17 => '───█───█──',
				18 => '───█──█───█',
				19 => '───█──────█',
				20 => '─▄▀───█───█',
			],
			4 => [
				1 => '▀▄▄▄▀───█',
				2 => '▀▄▄▄▀─█▄▄▄▄',
				3 => '▀▄▄▄▀─▀▄▄▄▀',
				4 => '▀▄▄▄▀─────█─',
				5 => '▀▄▄▄▀─▀▄▄▄▀',
				6 => '▀▄▄▄▀─▀▄▄▄▀',
				7 => '▀▄▄▄▀──█───',
				8 => '▀▄▄▄▀─▀▄▄▄▀',
				9 => '▀▄▄▄▀──▄▄▄▀',
				10 => '───█──▀▄▄▄▀',
				11 => '───█────█',
				12 => '───█──█▄▄▄▄',
				13 => '───█──▀▄▄▄▀',
				14 => '───█──────█─',
				15 => '───█──▀▄▄▄▀',
				16 => '───█──▀▄▄▄▀',
				17 => '───█──█───',
				18 => '───█──▀▄▄▄▀',
				19 => '───█───▄▄▄▀',
				20 => '─█▄▄▄▄▀▄▄▄▀',
			],
		];
		return $spacer[$id][$number];
	}
}



?>