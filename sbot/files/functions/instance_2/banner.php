<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: banner
#	DATE CREATED: 26/06/2018
#
##############################

class banner
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		if(isset($cfg['elements']['online']) && $cfg['elements']['online']['enabled']==true)
		{
			$online = 0;
			foreach ($clients as $client)
			{
				if($client['client_platform']!='ServerQuery' && !$sbot::in_group($cfg['elements']['online']['ignored_groups'],$client['client_servergroups']))
					$online++;
			}
		}
		$server_info = $ts->getElement('data',$ts->serverInfo());

		$img = imagecreatefrompng('files/cache/'.$cfg['background_name']);
		imagealphablending($img, true);
		$record = explode('-',file_get_contents('files/cache/record.txt'));
		foreach($cfg['elements'] as $name => $conf)
		{
			if($conf['enabled'])
			{
				$ele ='?????';
				if($name=='online')
				{
					$ele = $online;
				}
				else if($name=='admins')
					$ele = self::admins_count($conf['admin_groups']);
				else if($name=='date')
					$ele = date($conf['format'],time());
				else if($name=='record')
					$ele = $record[0];
				else if($name=='visits')
					$ele = $server_info['virtualserver_client_connections'];
				else if($name=='fb_likes')
					$ele = json_decode(file_get_contents('https://graph.facebook.com/'.$conf['page_id'].'?access_token='.$conf['api_key'].'&fields=name,fan_count'),true);
				
				$color = imagecolorallocate($img,$conf['color'][0],$conf['color'][1],$conf['color'][2]);
				imagettftext($img, $conf['size'], 0, $conf['coordies'][0], $conf['coordies'][1], $color, 'files/cache/fonts/'.$conf['font'], $ele);
			}
		}
		
		imagepng($img, $cfg['src_generated']);
		imagedestroy($img);
		unset($online,$name,$ele,$img,$conf,$color,$record,$server_info);
	}
	
	private function admins_count($groups)
	{
		global $ts;
		
		$count = 0;
		foreach($groups as $group)
			foreach($ts->getElement('data',$ts->clientList('-groups')) as $client)
				if(in_array($group,explode(',',$client['client_servergroups'])))
					$count++;
				
		return $count;
	}
}




?>