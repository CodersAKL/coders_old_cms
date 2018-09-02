<?php

class translate {
	// Isverciam teksta
	function versti(&$irc, &$data) {		$lang = $data->messageex[1];
		if ($lang == "lt") {			$word = $data->messageex[2];
			$get = strip_tags(file_get_contents("http://www.lietuviu-anglu.com/?word=$word"));
		}
		elseif ($lang == "en") {			$word = $data->messageex[2];
			$get = strip_tags(file_get_contents("http://www.anglu-lietuviu.com/?word=$word"));
		}
		else {			$word = "lame";
			$get = strip_tags(file_get_contents("http://www.anglu-lietuviu.com/?word=$word"));
		}
		$poz1 = strpos($get,"[taisyti]");
		$poz2 = strpos($get,"draugai:");

		$vertimas = substr($get, $poz1, $poz2 - 142);

		$vertimas =  str_replace("[taisyti]"," ",$vertimas);
		$vertimas = str_replace($word,"" . $word ." ",$vertimas);

		$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': ' . $vertimas);
	}
}

?>
