<?php

if (!empty($_GET['explode'][0])) { $smarty->assign("show_categories",TRUE); }
if (!empty($_GET['explode'][1])) { $smarty->assign("show_article_info",TRUE); }

// Per admin konfiga nustatyta ka galima daryti kitam zmogui.
// T.y. ar gali atsiusti koki nors straipsni ar ne ir.t.t
if ($mod_conf['allow_send'] == 'Y') { $smarty->assign("allow_send",$lang['article_send']); }
if ($mod_conf['allow_write'] == 'Y') { $smarty->assign("allow_write",$lang['article_write']); }
if ($mod_conf['allow_show_email'] == 'Y') { $smarty->assign("allow_send_email", $lang['article_send_email']); }
if ($mod_conf['allow_show_url'] == 'Y') { $smarty->assign("allow_show_url", $lang['article_show_url2']); }

// Jei pasirinkta kuri nors kategorija tuomet
// turime jas atvaizduoti sone visas likusias iskaitant ir pasirinkta
// kategorijas kad nereiketu per back mygtuka sokinet
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
	// Suvedamos visis kategorijos i masyva atvaizdavimui
	while($article_row = mysql_fetch_assoc($article_sql)) {
		$article_more[] = $article_row;
	}
	$smarty->assign("article_cat_more",$article_more);
}

?>
