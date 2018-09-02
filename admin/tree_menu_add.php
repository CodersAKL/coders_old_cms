<?php

if (!isset($_SESSION)) {
	session_start();
}
ob_flush();
require_once("../system/config/config.php");
require_once("../system/functions/main.php");

echo '
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" href="../js/tab/tab-view.css" type="text/css" media="screen">
    <link rel="stylesheet" type="text/css" href="../template/default/style.css" media="screen" />
	<script type="text/javascript" src="../js/tab/ajax.js"></script>
	<script type="text/javascript" src="../js/tab/tab-view.js"></script>
	<style>body {margin:0;padding:0}</style>
';

if (!isset($_SESSION['lang'])) {
	$set_lang = mysql_fetch_assoc(mysql_query("SELECT `value` FROM `kalbos_nustatymai` WHERE `default`='Y'"));
	$_SESSION['lang'] = $set_lang['value'];
}

if(isset($_POST['tree_menu_add'])) {
	$sub_id = (int)$_POST['tree_menu_menu'];
	$module = strip_tags($_POST['tree_menu_modules']);
	$menu_visible = (!empty($_POST['tree_check'])?1:0);
	$lang_sql = mysql_query("SELECT `value` FROM `kalbos_nustatymai`");
	while ($lang_row = mysql_fetch_assoc($lang_sql)) {
		$tree_lang[$lang_row['value']] = $_POST['tree_menu_' . $lang_row['value']];
	}
	unset($lang_sql,$lang_row);

	$tree_order = mysql_fetch_assoc(mysql_query("SELECT count(*) AS `total` FROM `tree_menu`"));

	$sql_insert = "INSERT INTO `tree_menu` (`sub`,`order`,";

	foreach ($tree_lang as $key => $value) { $sql_insert .= "`lang_" . $key ."`, "; }

	$sql_insert .= "`visible`,`module`) VALUES ('" . $sub_id ."', '" . ($tree_order['total'] + 1) ."',";

	foreach ($tree_lang as $key => $value) { $sql_insert .= "'" . $_POST['tree_menu_' . $key] ."', "; }

	$sql_insert .= "'" . $menu_visible ."', '" . $module ."')";
	mysql_query($sql_insert) or die(mysql_error());
}

unset($set_lang);
// Nustatoma atitinkama kalba kuria pasirinko zmogus
// kitu atveju paiimsims is DB ir nustatysim defasultine
if (isset($_GET['name'])) {
	$lang_set = explode("/",$_GET['name']);
	if (isset($lang_set[0]) && isset($lang_set[1]) && $lang_set[0] == 'language' && $lang_set[1] == 'set' && isset($lang_set[2])) {
		$check_lang = mysql_query("SELECT value FROM `kalbos_nustatymai` WHERE `value`=" . escape($lang_set[2]) ."");
		if (mysql_num_rows($check_lang) != 0) {
			$check_lang_temp = mysql_fetch_assoc($check_lang);
			$_SESSION['lang'] = $check_lang_temp['value'];
			unset($check_lang_temp,$check_lang,$lang_set);
			redirect($_SERVER['PHP_SELF'],"java");
		}
	}
}


$lang_sql = mysql_query("SELECT `value`, `lang_" . $_SESSION['lang'] ."` FROM `kalbos`");

while ($lang_row = mysql_fetch_assoc($lang_sql)) {
	$lang[$lang_row['value']] = $lang_row['lang_' . $_SESSION['lang']];
}
unset($lang_sql,$lang_row);

// Kokios kalbos yra sukurtos vartotojo
// Tas kalbas ir includinam i tab'us
$lang_sql = mysql_query("SELECT `value`,`title` FROM `kalbos_nustatymai`");
$lang_sql_total = kiek("kalbos_nustatymai");
$a = 0;
$b = 1;
while ($lang_row = mysql_fetch_assoc($lang_sql)) {
	if ($b == $lang_sql_total) {
		$lang_tree_menu[$a]['title'] = $lang_row['title'];
		$lang_tree_menu[$a]['img'] = '<img src="../images/flags/'. $lang_row['value'] .'.png" class="" style="padding-top:4.5px">&nbsp;';
		$lang_tree_menu[$a]['value'] = $lang_row['value'];
		$lang_tree_menu[$a]['last'] = 'yes';
	}
	else {
		$lang_tree_menu[$a]['title'] = $lang_row['title'];
		$lang_tree_menu[$a]['img'] = '<img src="../images/flags/'. $lang_row['value'] .'.png" class="" style="padding-top:4.5px">&nbsp;';
		$lang_tree_menu[$a]['value'] = $lang_row['value'];
		$lang_tree_menu[$a]['last'] = 'no';
	}
	$a++;
	$b++;
}
unset($a,$lang_row,$lang_sql,$b);


// Sudedame tuos modulius kurie yra instaliuoti
// ir kuriuos galime includinti kaip atskirus puslapius

$module_sql = mysql_query("SELECT * FROM `mod_install` WHERE `include`='Y' AND `mod_install`='Y'");
$modules = '<select size="1" name="tree_menu_modules">';
while ($module_row = mysql_fetch_assoc($module_sql)) {
	$modules .= '<option value="' . $module_row['mod_main'] .'">' . $module_row['title'] .'</option>';
}
$modules .= '</select>';

echo '
	<form name="tree_menu_add" action="" method="post">
     	<div class="" style="padding:10px" align="center">
     			<div id="dhtmlgoodies_tabView1" style="">
';
unset($module_sql,$module_row);

// Kokiam menu punktui priskirti.
// T.y. ar nurodyti kaip SUb menu ar pagrindini
$module_sql = mysql_query("SELECT * FROM `tree_menu` WHERE `sub`=0 ORDER BY `order` ASC");
$tree_pages = '<select size="1" name="tree_menu_menu">';
$tree_pages .= '<option value=0>----</option>';

while ($module_row = mysql_fetch_assoc($module_sql)) {
	$tree_pages .= '<option value="' . $module_row['id'] .'">' . $module_row['lang_' . $_SESSION['lang']] .'</option>';
}
$tree_pages .= '</select>';
unset($module_row,$module_sql);

$a = 0;
while ($a <= count($lang_tree_menu) -1) {
	echo '
					<div class="dhtmlgoodies_aTab">
						<label>' . $lang['tree_menu_add'] .' : <input name="tree_menu_' . $lang_tree_menu[$a]['value'] .'" type="text" value="" style="width:165px"></label><br />
						<label>Sukurto meniu punkto puslapyje nerodyti: <input type="checkbox" name="tree_check" value="on"></label><br />
						Priskirti puslapi kuriamam emniu punktui: ' . $tree_pages .'<br />
						Priskirti moduli sukurtam puslapiui: ' . $modules .'</br>
						<center><input name="tree_menu_add" type="submit" value="Išsaugoti"></center>
					</div>

	';
	$a++;
}

echo '
			</div>
		</div>
	</form>
	';

echo '<script type="text/javascript">
		initTabs(
			\'dhtmlgoodies_tabView1\',
			Array(';
				foreach($lang_tree_menu as $key => $value) {
					if ($lang_tree_menu[$key]['last'] == 'no') {
						echo '\'' . $lang_tree_menu[$key]['img'] . ' '. $lang_tree_menu[$key]['title'] . '\',';
					}
					if ($lang_tree_menu[$key]['last'] == 'yes') {
						echo '\'' . $lang_tree_menu[$key]['img'] . ' ' . $lang_tree_menu[$key]['title'] . '\'';
					}
				}
echo '		),
			0,
			360,
			150
		);
		</script>
		';
?>

