<?php
/*****************************************
 Modulis: Straipsniai
 Papildymas:  Visu straipsniu isvedimas pasirinkus atitinkama kategorija
*****************************************/

// Isvalom kategorija kad galetume susitikrinti ar teisinga
$cat = strip_tags($_GET['explode'][0]);

$article_sql = mysql_query("
							SELECT
								`straipsniai`.`pavadinimas`,
								`straipsniai`.`alias`,
								`straipsniai`.`aprasymas`,
								`straipsniai`.`autorius`,
								`straipsniai`.`data`,
								`straipsniai`.`balsavimas`,
								`straipsniai_kategorijos`.`kategorija`,
								`straipsniai_kategorijos`.`alias` AS `kat_alias`
							FROM
								`straipsniai`
							Inner Join `straipsniai_kategorijos` ON `straipsniai_kategorijos`.`id` = `straipsniai`.`kategorija_id`
							WHERE
								`straipsniai`.`aktyvus` =  'Y' AND
								`straipsniai_kategorijos`.`alias` =  " . escape($cat). "
							LIMIT 0, 10
") or die(mysql_error());

if (mysql_num_rows($article_sql) != 0) {
	while($article_row = mysql_fetch_assoc($article_sql)) {		$article_all[] = $article_row;
	}

	$smarty->assign('article_all',$article_all);
	$smarty->assign('article_category',$article_all[0]['kategorija']);
	unset($article_sql,$article_row,$article,$article_category);
}


?>
