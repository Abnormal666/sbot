<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: get_private_channel
#	DATE CREATED: 19/07/2018
#
##############################

class get_private_channel
{
	function __construct($ts,$cfg,$sbot,$lang,$client,$db,$descriptions)
	{
		global $profiles;
		if(!$sbot::in_group($cfg['needed_groups'],$client['client_servergroups']))
		{
			$ts->clientKick($client['clid'],'channel');
			$ts->clientPoke($client['clid'],$lang['get_private_channel']['not_has_group']);
			return;
		}
		foreach ($ts->channelList('-topic')['data'] as $channel)
		{
			if($channel['pid']==$cfg['private_zone'])
			{
				$channel_owner = $ts->channelGroupClientList($channel['cid'],$client['client_database_id'],$cfg['owner_channel_group'])['data'];
				if(isset($channel_owner[0]))
				{
					$ts->clientMove($client['clid'],$channel['cid']);
					$ts->clientPoke($client['clid'],$lang['get_private_channel']['has_channel']);
					break;
				}
				if($channel['channel_topic']=='#empty')
				{
					$num = explode('.',$channel['channel_name'])[0];
					$ts->channelEdit($channel['cid'],[
						'channel_name' => $num.'. Kanał - '.$client['client_nickname'],
						'channel_topic' => date('d/m/Y'),
						'channel_description' => str_replace(['[NUM]','[NICKNAME]','[CREATED]','[PROFILE]'], [$num,$client['client_nickname'],date('d/m/Y'),($profiles['enabled']==true ? '[url='.$profiles['url'].$client['client_database_id'].']Profil[/url]' : '')], $descriptions['get_private_channel']['channel_description']).$lang['system']['footer'],
						'channel_password'=>$cfg['channel_password'],
						'channel_flag_permanent' => 1,
						'channel_flag_maxclients_unlimited' => 1,
						'channel_flag_maxfamilyclients_unlimited' => 1,
					]);
					$ts->channelGroupAddClient($cfg['owner_channel_group'],$channel['cid'],$client['client_database_id']);
					for($i=1;$i<=$cfg['sub_channels_count'];$i++)
					{
						$ts->channelCreate([
							'cpid' => $channel['cid'],
							'channel_name' => $i.'. Podkanał',
							'channel_description' => str_replace(['[NUM]','[NICKNAME]','[CREATED]'], [$i,$client['client_nickname'],date('d/m/Y')], $descriptions['get_private_channel']['subchannel_description']).$lang['system']['footer'],
							'channel_password'=>$cfg['channel_password'],
							'channel_flag_permanent' => 1,
						]);
					}
					$ts->clientMove($client['clid'],$channel['cid']);
					$ts->sendMessage(1,$client['clid'],str_replace('[NUM]',$num,$lang['get_private_channel']['message']));
					$sbot::add_action($db,'[url=client://0/'.$client['client_unique_identifier'].']'.$client['client_nickname'].'[/url] otrzymał kanał prywatny o numerze: [b]'.$num.'[/b]');
					break;
				}

			}
		}
	}
	
}



?>