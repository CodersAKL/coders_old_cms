<?php
$link = mysql_connect("localhost", "codcod7_coders", "slaptazodis") or die ("Could not connect to MySQL");
		mysql_select_db ("codcod7_coders") or die ("Could not select database");

		mysql_query("

CREATE TABLE `word_count` (
  `nick` varchar(255) collate latin1_general_ci NOT NULL,
  `channel` varchar(255) collate latin1_general_ci NOT NULL,
  `words` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

") or die(mysql_error());


?>
