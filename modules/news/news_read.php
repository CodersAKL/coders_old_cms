<?php
	$news = mysql_fetch_assoc(mysql_query("SELECT * FROM `naujienos` WHERE `alias`=".escape($_GET['explode'][0])." LIMIT 1"));
	$mods['content'] = 'modules/news/news_read.tpl';
	if (empty($news)) { $mods['content'] = 'modules/error/error_404.tpl'; }
	elseif (empty($news['image']) || !@getimagesize($news['image'])) { $news['image'] = 'template/default/images/bigimage.gif'; }
	$smarty->assign("news",$news);
?>
