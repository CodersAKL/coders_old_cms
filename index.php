<?php
/**************************************
* CodeRS TVS ©2007
*
*
***************************************/

require_once "system/config/config.php";
require_once "system/functions/main.php";

require 'system/class/smarty/Smarty.class.php';

$smarty = new Smarty;

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $base."/template/".$conf['Style']."/";
$smarty->compile_dir = $base."/template/".$conf['Style']."/compile/";
//$smarty->config_dir = "/system/config/";
$smarty->cache_dir = "".$base."/cache/";
$smarty->caching = false;


$smarty->assign("site_title",$conf['Pavadinimas']);
$smarty->assign("site_about",$conf['Apie']);
$smarty->assign("site_email",$conf['Pastas']);
$smarty->assign("site_version",'CodeRS TVS v2.001');

$smarty->assign("site_base",$base);


$smarty->assign("base",$true);
$smarty->assign("site_copyright",$conf['Copyright']);


//Nustatom koks stilius
$style = 'template/default/';

//Seip masyvas su moduliais
$mods = array(
	'sms' => 'modules/adds/adds_sms.tpl',
	'news' => 'modules/news/news_main.tpl',
	'content' => 'modules/article/article_main.tpl',
	'adds' => 'modules/adds/adds_sms.tpl',
	'right' => 'right.tpl',
	'articles' => 'modules/article/article_main.tpl',
	'article_category' => 'modules/article/article_category.tpl',
	'article_new' => 'modules/article/article_new.tpl'
);

// Gaunama pasirinkta kalba
$lang_sel = "lt";
$lang_sql = mysql_query("SELECT `value`, `lang_" . $lang_sel ."` FROM `kalbos`");

while ($lang_row = mysql_fetch_assoc($lang_sql)) {	$lang[$lang_row['value']] = $lang_row['lang_' . $lang_sel];
}
unset($lang_sql,$lang_row);


// Susprogdinam visa gauta info is &explode=$2
// kuris yra .htaccess
if (!empty($_GET['explode'])) {
	$_GET['explode'] = explode("/",$_GET['explode']);
}


// Modulio paskirstymas. Jei modulis egzistuoja tuomet ji icludinam
if (empty($_GET['module'])) {
	include_once("modules/news/news_main.php");
}
else {
	// Jei modulis egzistuoja tuomet ji ir includinam
	// Kur toliau jau pats modulis paskirstys kas kur priklauso
	if (is_file("modules/" . strip_tags($_GET['module']) ."/" . strip_tags($_GET['module']) ."_main.php") == TRUE) {
		include_once("modules/" . strip_tags($_GET['module']) ."/" . strip_tags($_GET['module']) ."_main.php");
	}
	// Kitu atveju 404
	else {
		include_once("modules/error/error_404.php");
	}
}


$smarty->assign('mods',$mods);

//debugeris
$debug['get'] = $_GET;
$debug['post'] = $_POST;
//$debug['server'] = $_SERVER;
$smarty->assign('debug',print_r($debug,true));

$smarty->display('index.tpl');
//$smarty->display('debug.tpl');

?>
