<?php
class top10 {
		mysql_select_db ("codcod7_coders") or die ("Could not select database");

		$word_count = count($explode);
		$nick = $data->nick;
		$channel = $data->channel;
		$sql_data = mysql_query("SELECT `words` FROM `word_count` WHERE `nick`='$nick' AND `channel`='$channel'");
		if (mysql_num_rows($sql_data) == 0) {
			   mysql_query("INSERT INTO `word_count` (`nick`,`channel`,`words`) VALUES ('$nick', '$channel',$word_count)") or die(mysql_error());
		}
		else {
				$word_sql = mysql_fetch_assoc($sql_data);
				$word_count = $word_sql['words'] + $word_count;
			    mysql_query("UPDATE `word_count` SET `words`=$word_count WHERE `nick`='$nick' AND `channel`='$channel'") or die(mysql_error());
		}
	}
	// Statistika apie pasirinkta zmogu
	function stats(&$irc,&$data) {
		$link = mysql_connect("localhost", "codcod7_coders", "slaptazodis") or die ("Could not connect to MySQL");
		mysql_select_db ("codcod7_coders") or die ("Could not select database");

		$channel = $data->channel;
		$sql_data = mysql_query("SELECT `words` FROM `word_count` WHERE `nick`='$nick' AND `channel`='$channel'") or die(mysql_error());
		if (mysql_num_rows($sql_data) == 0) {
			$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': Apie jus duomenu nera');
		}
		else {
		}
	}
	// TOP10 statistika
	function top10_stat(&$irc,&$data) {
		mysql_select_db ("codcod7_coders") or die ("Could not select database");

		$channel = $data->channel;
		$sql_data = mysql_query("SELECT `words`, `nick` FROM `word_count` WHERE `channel`='$channel' ORDER BY `words` DESC") or die(mysql_error());
		$total = mysql_fetch_assoc(mysql_query("SELECT SUM(`words`) AS `total` FROM `word_count` WHERE `channel`='$channel'"));
		$a = 1;
		$total = $total['total'];
		while ($row = mysql_fetch_assoc($sql_data)) {
			$a++;
		}
		$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $top10_info);
	}
}
?>