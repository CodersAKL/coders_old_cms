<?php
/************************************
Modulis 	: Straipsniai
Papildymas	: Naujausiu straipsniu pateikimas
************************************/

$article_sql = mysql_query("
								SELECT
									`straipsniai`.`pavadinimas`,
									`straipsniai`.`alias`,
									`straipsniai`.`autorius`,
									`straipsniai`.`data`,
									`straipsniai_kategorijos`.`kategorija`,
									`straipsniai_kategorijos`.`alias` AS `kat_alias`
								FROM
									`straipsniai`
									Inner Join `straipsniai_kategorijos` ON `straipsniai`.`kategorija_id` = `straipsniai_kategorijos`.`id`
								WHERE
									`straipsniai`.`aktyvus` =  'Y'
								" . $mod_conf['order'] ."
								LIMIT 0, " . $mod_conf['article_show_num'] ."
") or die(mysql_error());

while($article_row = mysql_fetch_assoc($article_sql)) {
		$article_new[] = $article_row;
}

$smarty->assign("article_new",$article_new);

unset($article_sql,$article_row,$article_new);
?>
