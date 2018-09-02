<?php
/**************************************
* CodeRS TVS ©2007
* Modifikavimo data 2007-04-25
* Administravimo variklis
***************************************/

if (!isset($_SESSION)) {
	session_start();
}
$_SESSION['lang'] = 'lt';
require_once("../system/config/config.php");
require_once('../system/class/smarty/Smarty.class.php');
require_once("../system/functions/file.php");
require_once("../system/functions/main.php");
require_once("../system/functions/date.php");

//require_once("../system/class/main.class.php");

//Skirta prisijungimui
/*$name="admin";	//useris
$pass="admin";	//slaptazodis
if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER']!=$name || $_SERVER['PHP_AUTH_PW']!=$pass) {
header("WWW-Authenticate: Basic realm=\"AdminAccess\"");
header("HTTP/1.0 401 Unauthorized");
exit(klaida("Draudziama","Pasaliniams iejimas uzdraustas"));
}*/

/*
if (empty($_SESSION['lang'])) {
	$set_lang = mysql_fetch_assoc(mysql_query("SELECT `value` FROM `kalbos_nustatymai` WHERE `default`='Y' LIMIT 1"));
	$_SESSION['lang'] = $set_lang['value'];
			echo "<script>alert('".$_SESSION['lang']."')</script>";
}*/

unset($set_lang);
// Nustatoma atitinkama kalba kuria pasirinko zmogus
// kitu atveju paiimsims is DB ir nustatysim defasultine

/*
if (isset($_GET['name'])) {
	$lang_set = explode("/",$_GET['name']);
	if (isset($lang_set[0]) && isset($lang_set[1]) && $lang_set[0] == 'language' && $lang_set[1] == 'set' && isset($lang_set[2])) {
		$check_lang = mysql_query("SELECT `value` FROM `kalbos_nustatymai` WHERE `value`=" . escape($lang_set[2]) ."");
		if (mysql_num_rows($check_lang) != 0) {
			$check_lang_temp = mysql_fetch_assoc($check_lang);
			$_SESSION['lang'] = $check_lang_temp['value'];
			unset($check_lang_temp,$check_lang,$lang_set);
			redirect($_SERVER['PHP_SELF'],"java");
		}
	}
}*/

$lang_sql = mysql_query("SELECT `value`, `lang_" . $_SESSION['lang'] ."` FROM `kalbos`");

while ($lang_row = mysql_fetch_assoc($lang_sql)) {
	$lang[$lang_row['value']] = $lang_row['lang_' . $_SESSION['lang']];
}
unset($lang_sql,$lang_row);

// Smarty reikaliukai
$base = $base."/../"; //svetaines vieta

$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = "../template/default/";
$smarty->compile_dir = "../template/default/compile/";
$smarty->config_dir = "".$base."/system/config/";
$smarty->cache_dir = "".$base."/cache/";
$smarty->caching = false;

//Pagrindiniai nustatymai
$smarty->assign("site_title",$conf['Pavadinimas']." - Administravimas");
$smarty->assign("site_email",$conf['Pastas']);
$smarty->assign("site_version",'CodeRS TVS v2.002');
$smarty->assign("site_base",$true);
$smarty->assign("site_time",date_lt());

// Smarty ivedama atitinkama kalba
$smarty->assign("lang",$lang);

// Visos esamos kalbos
// Jas isvedame administravime kad butu galima pasikeist

$lang_sql = mysql_query("SELECT `value`, `title` FROM `kalbos_nustatymai`");
$lang_data = '';
while ($lang_row = mysql_fetch_assoc($lang_sql)) {
	$lang_data .= ' <a href="language/set/' . $lang_row['value'] .'/"><img src="../images/flags/' . $lang_row['value'] .'.png" alt="' . $lang_row['title'] .'" border=0></a> ';
}
$smarty->assign("lang_set",$lang_data);
unset($lang_sql,$lang_row,$lang_data);

// Modulio instaliavimo DB
// Reikalingas tolimesniems veiksmams
// Kaip pvz paziureti ar modulis instaliuotas ir ar ji aktyvuoti prie pasirinktos dalies
$mod_install_sql = mysql_query("SELECT * FROM mod_install") or die(mysql_error());
while ($mod_install_row = mysql_fetch_assoc($mod_install_sql)) {
	$mod_install[$mod_install_row['mod_main']] = $mod_install_row['mod_install'];
}
unset($mod_install_row,$mod_install_sql);


// Treemenu isvedimas
// Surenkami visi menu punktai, surasomi i masyva
// ir pateikiami Smarty
$tree_menu_sql = mysql_query("SELECT * FROM `tree_menu` WHERE `visible`='Y' ORDER BY `order` ASC");
$tree_menu = array();
while ($tree_menu_row = mysql_fetch_assoc($tree_menu_sql)) {
	if ($tree_menu_row['sub'] == 0) {
		$tree_menu[$tree_menu_row['id']] = array (
													'id' => $tree_menu_row['id'],
													'module' => (empty($tree_menu_row['module']))?"index.php":$tree_menu_row['module']. "/",
													'lang' => array (
																	'lang_lt' => $tree_menu_row['lang_lt'],
																	'lang_en' => $tree_menu_row['lang_en']
													),
													'sub' => array()
		);
	}
	else {
		$tree_menu[$tree_menu_row['sub']]['sub'][$tree_menu_row['id']] = array (
													'id' => $tree_menu_row['id'],
													'module' => (empty($tree_menu_row['module']))?"index.php":$tree_menu_row['module'] . "/",
													'lang' => array (
																	'lang_lt' => $tree_menu_row['lang_lt'],
																	'lang_en' => $tree_menu_row['lang_en']
													)
		);
	}
}
unset($tree_menu_sql,$tree_menu_row,$a);


$tree_data = '';
foreach($tree_menu as $key => $value) {
	$tree_data .= '<li><a href="' . $tree_menu[$key]['module'] .'" id="node_' . $tree_menu[$key]['id'] .'">' . $tree_menu[$key]['lang']['lang_' . $_SESSION['lang']] .'</a>';
	if (!empty($tree_menu[$key]['sub'])) {
		$tree_data .= "<ul>";
		foreach($tree_menu[$key]['sub'] as $key_sub => $value_sub) {
			$tree_data .= '<li><a href="' . $tree_menu[$key]['sub'][$key_sub]['module'] .'" id="node_' . $tree_menu[$key]['sub'][$key_sub]['id'] .'">' . $tree_menu[$key]['sub'][$key_sub]['lang']['lang_' . $_SESSION['lang']] .'</a>';
		}
		$tree_data .= "</ul>";
	}
	$tree_data .= "</li>";
}

$smarty->assign("tree_data",$tree_data);
unset($tree_data);

// Tree menu skirti mygtukas
// Sukurti puslpapi / redaguoti / istrinti
require_once("tree_menu.php");

require_once("module.list.php");

//Atvaizduojam stilingai :)
$smarty->display('admin/admin_index.tpl');

//Ziurim ka turim (koki moduli pasirinkom) pvz: (modules/update/module)
if (isset($_GET['name'])) {
	$url = explode("/",$_GET['name']);
	$debug['url'] = $url;
}

//jei kanors pasirinko tikrinam ar modulis egzistuoja
if (isset($url[0]) && file_exists("../modules/".$url[0]."/".$url[0]."_admin.php")) {
	include_once("../modules/".$url[0]."/".$url[0]."_admin.php");
}

//Jei pasirinktas modulis neegzistuoja
elseif (isset($url[0])) {
	$smarty->assign('error',"<b><u>".strtoupper(strip_tags($url[0]))."</u></b> modulis neegzistuoja <a href='http://code.google.com/p/coders/wiki/admin_module_".$url[0]."' target='_blank'><img src='../images/icons/help.png' border='0' alt='?' title='pagalba' class='middle'></a>");
	$smarty->display('none.tpl');
}
else {
	$smarty->display('admin/admin_menu.tpl');
}

//debuging
$debug['get'] = $_GET;
$debug['post'] = $_POST; //$debug['globals'] = $GLOBALS;
$debug['session'] = $_SESSION;
$smarty->assign('debug',print_r($debug,true));

//atvaizduojam apacia
$smarty->display('admin/admin_footer.tpl');
$smarty->display('debug.tpl');



?>
