<?php

$article_sql = mysql_query("
							SELECT
								`straipsniai`.`pavadinimas`,
								`straipsniai`.`aprasymas`,
								`straipsniai`.`straipsnis`,
								`straipsniai`.`autorius`,
								`straipsniai`.`data`,
								`straipsniai_kategorijos`.`kategorija`,
								`straipsniai_kategorijos`.`alias`,
								`straipsniai`.`balsavimas`
							FROM
								`straipsniai`
							Inner Join `straipsniai_kategorijos` ON `straipsniai`.`kategorija_id` = `straipsniai_kategorijos`.`id`
							WHERE
								`straipsniai`.`alias` =  '" . $_GET['explode'][1] ."' AND
								`straipsniai`.`aktyvus` =  'Y'
				");
$article_show = mysql_fetch_assoc($article_sql);
$smarty->assign("article_show",$article_show);

unset($article_sql,$article_row,$article_show);


?>
