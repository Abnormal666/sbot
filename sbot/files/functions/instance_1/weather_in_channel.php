<?Php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: weather_in_channel
#	DATE CREATED: 29/06/2018
#
##############################

class weather_in_channel
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db,$descriptions)
	{
		foreach($cfg['channels'] as $city_name => $more)
		{
			$sbot::check_ids($ts,$more['channel_id'],'channel','weather_in_channel');
			$content = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$city_name.','.$more['country_tag'].'&appid='.$cfg['api_key'].'&lang=pl'), true);
			if(!empty($content) && isset($content['name']))
			{
				$img = '[img]http://openweathermap.org/img/w/'.$content['weather'][0]['icon'].'.png[/img]';
				$desc = str_replace('[CITY_NAME]', $city_name, $descriptions['weather_in_channel']['header']);
				$desc .= str_replace(['[WEATHER_ICON]', '[TEMP]', '[STATE]', '[WIND_SPEED]', '[VISIBILITY]', '[HUMIDITY]', '[PRESSURE]'], [$img, floor($content['main']['temp']-273), $content['weather'][0]['main'], $content['wind']['speed'], ($content['visibility'] ?: 'brak informacji' ), $content['main']['humidity'], $content['main']['pressure']], $descriptions['weather_in_channel']['desc']);
				$desc .= '[/size]'.$lang['system']['footer'];
				
				$ts->channelEdit($more['channel_id'],['channel_description'=>$desc]);
				$ts->channelEdit($more['channel_id'],['channel_name'=>str_replace('[CITY_NAME]',$city_name,$more['channel_name'])]);
			}
		}
	}
}


?>