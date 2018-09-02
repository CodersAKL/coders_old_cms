<?php
class tv {
	// LTV Televizija rodo
	function ltv(&$irc,&$data) {
		$get = file_get_contents("http://www.manotv.lt/cgi-bin/tv_now.cgi");
		$poz1 = strpos($get,'COLOR="#808080">ltv');
		$poz2 = strpos($get,'COLOR="#ff3399">lnk');
		$poz2 = $poz2 - $poz1;
		$get = explode("\n", strip_tags(substr($get, $poz1, $poz2)));
		$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': ' . $get[1]);
	}
	// LNK Televizija rodo
	function lnk(&$irc,&$data) {
		$get = file_get_contents("http://www.manotv.lt/cgi-bin/tv_now.cgi");
		$poz1 = strpos($get,'COLOR="#ff3399">lnk');
		$poz2 = strpos($get,'COLOR="#ffcc00">tv3');
		$poz2 = $poz2 - $poz1;
		$get = explode("\n", strip_tags(substr($get, $poz1, $poz2)));
		$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': ' . $get[1]);
	}
	// TV3 Televizija rodo
	function tv3(&$irc,&$data) {
		$get = file_get_contents("http://www.manotv.lt/cgi-bin/tv_now.cgi");
		$poz1 = strpos($get,'COLOR="#ffcc00">tv3');
		$poz2 = strpos($get,'COLOR="#0066ff">btv');
		$poz2 = $poz2 - $poz1;
		$get = explode("\n", strip_tags(substr($get, $poz1, $poz2)));
		$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': ' . $get[1]);
	}
	// BTV Televizija rodo
	function btv(&$irc,&$data) {
		$get = file_get_contents("http://www.manotv.lt/cgi-bin/tv_now.cgi");
		$poz1 = strpos($get,'COLOR="#0066ff">btv');
		$poz2 = strpos($get,'COLOR="#000000">tango');
		$poz2 = $poz2 - $poz1;
		$get = explode("\n", strip_tags(substr($get, $poz1, $poz2)));
		$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': ' . $get[1]);
	}
	// Tango Televizija rodo
	function tango(&$irc,&$data) {
		$get = file_get_contents("http://www.manotv.lt/cgi-bin/tv_now.cgi");
		$poz1 = strpos($get,'COLOR="#000000">tango');
		$poz2 = strpos($get,'COLOR="#000000">ltv2');
		$poz2 = $poz2 - $poz1;
		$get = explode("\n", strip_tags(substr($get, $poz1, $poz2)));
		$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': ' . $get[1]);
	}
	// LTV2 Televizija rodo
	function ltv2(&$irc,&$data) {
		$get = file_get_contents("http://www.manotv.lt/cgi-bin/tv_now.cgi");
		$poz1 = strpos($get,'COLOR="#000000">ltv2');
		$poz2 = strpos($get,'COLOR="#000000">tv1');
		$poz2 = $poz2 - $poz1;
		$get = explode("\n", strip_tags(substr($get, $poz1, $poz2)));
		$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': ' . $get[1]);
	}
	// TV1 Televizija rodo
	function tv1(&$irc,&$data) {
		$get = file_get_contents("http://www.manotv.lt/cgi-bin/tv_now.cgi");
		$poz1 = strpos($get,'COLOR="#000000">tv1');
		$poz2 = strpos($get,'<!-- programa -->');
		$poz2 = $poz2 - $poz1;
		$get = explode("\n", strip_tags(substr($get, $poz1, $poz2)));
		$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': ' . $get[1]);
	}	
}
	
?>
