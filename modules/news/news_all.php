<?php

	$query = mysql_query("SELECT `pavadinimas`,`alias`,`data`,`naujiena`,`autorius` FROM `naujienos` ORDER BY `data` DESC");
	while($row = mysql_fetch_assoc($query)) { 
		$news[] = $row;
	}
	$smarty->assign("news",$news);
	$mods['content'] = 'modules/news/news_all.tpl';

?>
