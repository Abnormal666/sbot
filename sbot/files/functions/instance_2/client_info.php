<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: client_info
#	DATE CREATED: 13/07/2018
#
##############################

class client_info
{
	
	function __construct($ts,$cfg,$sbot,$lang,$client,$db)
	{
		$client_info = $ts->clientInfo($client['clid'])['data'];
		$weather = null;
		$status = null;
		if($cfg['weather']['enabled'])
		{
			$weather = self::get_weather($cfg['weather']['ip_api'],$cfg['weather']['weather_api'],$client_info['connection_client_ip']);
			$status = str_replace(['Thunderstorm', 'Drizzle', 'Rain', 'Snow', 'Atmosphere', 'Clear', 'Clouds', 'Extreme'], ['Burza z piorunami', 'Mżawka', 'Deszcz', 'Śnieg', 'Zanieczyszczona atmosfera', 'Czyste niebo', 'Chmury', 'Ekstremalna pogoda'], $weather['weather'][0]['main']);

		}
		if($cfg['type_information']=='poke')
		{
			foreach ($cfg['messages'] as $msg)
			{
				$ts->clientPoke($client['clid'],self::replace($msg,$client_info,$sbot,$weather,$status,$db));
			}
		}
		elseif($cfg['type_information']=='msg')
		{
			foreach ($cfg['messages'] as $msg)
			{
				$ts->sendMessage(1,$client['clid'],self::replace($msg,$client_info,$sbot,$weather,$status,$db));
			}
		}
		
		$ts->clientKick($client['clid'],'channel');
		unset($client_info,$msg,$status,$weather,$client);
	}

	private function get_weather($api,$api2,$ip)
	{
		$ip =  curl_init("http://api.ipinfodb.com/v3/ip-city/?key=".$api."&ip=".$ip."&format=json");
		curl_setopt($ip, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ip, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ip, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ip, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ip, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ip, CURLOPT_TIMEOUT, 0);
		$ip = curl_exec($ip);
		$ip = json_decode($ip);
		$weather = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$ip->cityName.','.$ip->countryCode.'&appid='.$api2.''), true);
		$weather['city_name'] = $ip->cityName;
		unset($api,$api2,$ip);
		return $weather;
	}

	private function replace($msg,$client,$sbot,$weather=null,$status=null,$db)
	{
		$row = $db->query("SELECT * FROM `clients` WHERE `client_database_id`='".$client['client_database_id']."'")->fetch(PDO::FETCH_ASSOC);
		
		$replace = [
			'[NICKNAME]' => $client['client_nickname'],
			'[DBID]' => $client['client_database_id'],
			'[UID]' => $client['client_unique_identifier'],
			'[IP]' => $client['connection_client_ip'],
			'[PLATFORM]' => $client['client_platform'],
			'[VERSION]' => $client['client_version'],
			'[CREATED]' => date('d/m/Y',$client['client_created']),
			'[CONNECTIONS]' => $client['client_totalconnections'],
			'[TIME_SPENT]' => $sbot::convert_time($row['time_spent']/1000),
			'[IDLE_TIME]' => $sbot::convert_time($row['idle_time']/1000),
			'[CONNECTION_TIME]' => $sbot::convert_time($row['connection_time']/1000),
			'[WEATHER_TEMP]' => ($weather['main']['temp']!=null ? floor($weather['main']['temp']-273).'°C' : 'Pogoda wyłączona'),
			'[WEATHER_STATUS]' => ($status ?: 'Pogoda wyłączona'),
			'[WEATHER_CITY]' => ($weather['city_name'] ?: 'Pogoda wyłączona'),
		];
		unset($row);
		return str_replace(array_keys($replace), array_values($replace), $msg);
	}
	
}

?>