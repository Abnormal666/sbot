<?php

##############################
#
#	AUTHOR: `Demon.
#	FUNCTION NAME: advertisement
#	DATE CREATED: 29/06/2018
#
##############################

class advertisement
{
	function __construct($ts,$cfg,$sbot,$lang,$clients,$db)
	{
		$ts->sendMessage(3,null,$cfg['messages'][rand(0,count($cfg['messages'])-1)]);
	}
	
}



?>