<?php
//Atspauzdinam naujienas jei nera ant niekur paspausta
if (empty($_GET['explode']) && empty($_GET['module'])) {
	$query = mysql_query("SELECT * FROM `naujienos` ORDER BY `id` DESC LIMIT 10");
	while($row = mysql_fetch_assoc($query)) { $news[] = $row; }
	$smarty->assign("news",$news);
	$mods['content'] = 'modules/news/news_main.tpl';
}
//jei ant kazko paspaude
elseif ($_GET['module'] == 'news' && empty($_GET['explode'])) {
	include_once("news_all.php");
}
else {
	include_once("news_read.php");
}

?>
