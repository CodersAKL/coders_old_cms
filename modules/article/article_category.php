<?php
/*******************************
Modulis:    Straipsniai
Papildymas: Straipsniu kategoriju atvaizdavimas
*******************************/
$article_sql = mysql_query("
								SELECT
									`straipsniai_kategorijos`.`kategorija`,
									`straipsniai_kategorijos`.`alias`,
									Count(`straipsniai`.`id`) AS `total`
								FROM
									`straipsniai`
								Inner Join `straipsniai_kategorijos` ON `straipsniai`.`kategorija_id` = `straipsniai_kategorijos`.`id`
								GROUP BY
									`straipsniai_kategorijos`.`kategorija`,
									`straipsniai_kategorijos`.`alias`

") or die(mysql_error());

if ($mod_conf['show_cat'] == 'Y' && mysql_num_rows($article_sql) != 0) {
	// Suvedamos visis kategorijos i masyva atvaizdavimui	while($article_row = mysql_fetch_assoc($article_sql)) {
		$article[] = $article_row;
	}
	$smarty->assign("article_cat",$article);
}

unset($article_sql,$article_row,$article);
?>
