<?php

// Jei pasirinko zmogus kalba redagavimui ka nors pakeite
// ir dabar nori issaugoti

if (isset($_POST['lang_edit_save'])) {
	// redaguojama kalba
	$edit_lang = strip_tags($_GET['pize']);
	$a = 0;
	foreach ($_POST as $key => $value) {
		if ($a >= 3 && $a) {
			mysql_query("UPDATE `kalbos` SET `lang_" . $edit_lang."`=".escape($value)." WHERE `value`=".escape($key)) or die(mysql_error()." - SQLNum: ".$a." - Eilute: ".__LINE__." - Failas: ".basename(__FILE__));
		}
		$a++;
	}
	//redirect("language/","header");
}


// Pagal kokia kalba norima redaguoti kita kalba arba ja sukurti
// jei si knopke papsauta tuomet issaugom pasirinkima
if(isset($_POST['lang_edit_default_save'])) {
	$lang_edit_sel = strip_tags($_POST['lang_edit']);
	$lang_edit_was = mysql_fetch_assoc(mysql_query("SELECT `value` FROM `kalbos_nustatymai` WHERE `default_edit`='Y'")) or die(mysql_error()." - SQLNum: ".$a." - Eilute: ".__LINE__." - Failas: ".basename(__FILE__));
	mysql_query("UPDATE `kalbos_nustatymai` SET `default_edit`='N' WHERE `value`=" . escape($lang_edit_was['value'])) or die(mysql_error()." - SQLNum: ".$a." - Eilute: ".__LINE__." - Failas: ".basename(__FILE__));
	mysql_query("UPDATE `kalbos_nustatymai` SET `default_edit`='Y' WHERE `value`=" . escape($lang_edit_sel)) or die(mysql_error()." - SQLNum: ".$a." - Eilute: ".__LINE__." - Failas: ".basename(__FILE__));
	unset($lang_edit_sql,$lang_edit_was);
	redirect("language/","header");
}


// Jei vartotojas nori sukurti nauja kalba
// sutikriname viska ir ivedam nauja kalba
if (isset($_POST['create_new_lang'])) {
	$lang_title = ucfirst(input(strip_tags($_POST['lang_name1'])));
	$lang_value = input(strtolower(normalizuoti(strip_tags($_POST['lang_value1']))));
	if (!empty($lang_title) && !empty($lang_value)) {
		mysql_query("ALTER TABLE `kalbos` ADD `lang_".$lang_value."` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL") or die(mysql_error()." - SQLNum: ".$a." - Eilute: ".__LINE__." - Failas: ".basename(__FILE__));
		mysql_query("INSERT INTO `kalbos_nustatymai` ( `value` , `title` , `default` ) VALUES (".escape($lang_value).", ".escape($lang_title).", 'N')") or die(mysql_error()." - SQLNum: ".$a." - Eilute: ".__LINE__." - Failas: ".basename(__FILE__));
	}
	unset($lang_title,$lang_value);
	redirect("language/","header");
}

// Jei vartotojas nori istrinti kalba
// sutikrinam viska ir pranesame ar gali istrinti
if (isset($url[0]) && $url[0] == "language" && isset($url[1]) && $url[1] == "delete" && isset($_GET['pize'])) {
	$lang_del = strip_tags($_GET['pize']);
	$lang_sql = mysql_query("SELECT `default` FROM `kalbos_nustatymai` WHERE `value`=".escape($lang_del));
	// Pasitikrinam ar kalba tikrai egzistuoja ir ar a kalba nera default...
	if (mysql_num_rows($lang_sql) != 0 && $lang_sql['default'] != 'Y') {
		mysql_query("DELETE FROM `kalbos_nustatymai` WHERE `kalbos_nustatymai`.`value` = ".escape($lang_del)) or die(mysql_error()." - SQLNum: ".$a." - Eilute: ".__LINE__." - Failas: ".basename(__FILE__));
		mysql_query("ALTER TABLE `kalbos` DROP `lang_".$lang_del."`");
	}
	unset($lang_del, $lang_sql);
	redirect("language/","header");
}

// Pasirinktos kalbos redagavimui isvedimas
// jei zinoma pasirinktas paveiksliukas is "veiksmai" skilties
if (isset($url[0]) && $url[0] == "language" && isset($url[1]) && $url[1] == "edit" && isset($_GET['pize'])) {
	$count_per_page_start = 0;
	$count_per_page_end = 2000;	//2000 - nes kolkas neveikia puslapiavimas
	// Jei nustatytas ir 3 kintamasis reiskias persokom puslapi
	if (!empty($url[2])) {
		$count_per_page_start = (int)$_GET['pize'];
		$count_per_page_end = $count_per_page_start + 10;
		$lang_edit = $url[2];
	}
	else {
		$lang_edit = $_GET['pize'];
	}
	// Sudarom puslapiavima
	$lang_sql_pusl_total = kiek("kalbos");
	//function puslapiai($start,$count,$total,$link="",$range=0)
	if ($lang_sql_pusl_total >= $count_per_page_end) { $smarty->assign("lang_pages",puslapiai($count_per_page_start,50,$lang_sql_pusl_total,"language/edit/" . $lang_edit ."")); }
	unset($lang_sql_pusl_total);

	// Pagal kokia kalba redaguojama
	$lang_edit_default = mysql_fetch_assoc(mysql_query("SELECT `value`,`title` FROM `kalbos_nustatymai` WHERE `default_edit`='Y'"));
	// Kalbu redagavimo uzklausa, grazinanti abi kalbas
	$lang_sql = mysql_query("SELECT `value`, `lang_" . $lang_edit ."`, `lang_" . $lang_edit_default['value'] ."` FROM `kalbos` LIMIT " .$count_per_page_start . ", " . $count_per_page_end ."");
	while ($lang_row = mysql_fetch_assoc($lang_sql)) {
		$lang_table[] = "<span title=\"".$lang_row['value']."\">".$lang_row['lang_' . $lang_edit_default['value']]."</span>";
		$lang_table[] = '<input name="' . input($lang_row['value']) .'" type="text" value="' . input($lang_row['lang_'.$lang_edit]) .'" title="'.$lang_row['value'].'" size="70">';
	}
	$smarty->assign('lang_th',array($lang['lang_default'],$lang['lang_translate']));
	$smarty->assign('lang_tr',array('bgcolor="#eeeeee" class="left_articles" style="border-right:1px solid silver"','bgcolor="#dddddd" class="left_articles"'));
	$smarty->assign('lang_td',array('style="border-right:1px solid silver"','style="border-right:1px solid silver"'));
	$smarty->assign('lang_data',$lang_table);
	$smarty->assign('lang_button_save',$lang['button_save']);

	unset($lang_edit_default,$lang_sql,$lang_row,$lang_table);
}


// Esamu kalbu isvedimas
// Kalbu isvedimas is DB lenteliu ir atvaizdavimas
$lang_sql = mysql_query("SELECT * FROM `kalbos_nustatymai`");

while ($lang_row = mysql_fetch_assoc($lang_sql)) {
	$lang_info[] = '<img src="../images/flags/' . $lang_row['value'] . '.png"> ' . $lang_row['title'];
	$lang_info[] = $lang_row['value'];
	if ($lang_row['default'] == 'Y') {
		$lang_info[] = '<center><img src="../images/icons/accept.png"></center>';
	}
	else {
		$lang_info[] = '<center><img src="../images/icons/delete.png"></center>';
	}
	// Kalbos veiksmai
	// Kalbos trynimas
	// Kalbos redagavimas
	$lang_info[] = '
				<a href="language/delete/' . $lang_row['value'] .'" onClick="return confirm(\'Ar tikrai trinti pasirinktą kalbą? Trinimas galutinis ir neatšaukiamas. Mes to daryti nerekomenduojame.\')"><img src="../images/icons/delete.png" border=0></a>
				<a href="language/edit/' . $lang_row['value'] .'"><img src="../images/icons/icon-edit.png" border=0 width=16 height=16></a>
	';
}

$smarty->assign('table_th',array('Kalba','Trumpinys','Pagrindinė','Veiksmai'));
$smarty->assign('table_tr',array('bgcolor="#eeeeee" class="left_articles" style="border-right:1px solid silver"','bgcolor="#dddddd" class="left_articles"'));
$smarty->assign('table_td',array('style="border-right:1px solid silver"','style="border-right:1px solid silver"'));
$smarty->assign('table_data',$lang_info);

unset($lang_info,$lang_row,$lang_sql);


// Naujai kalbai skirta lentele
// Sioje lenteleje bus imanoma sukurti nauja kalba
if (isset($lang_edit)) { $lang_edit_default = mysql_fetch_assoc(mysql_query("SELECT `title` FROM `kalbos_nustatymai` WHERE `value`=".escape($lang_edit)."")); }
$lang_create = $lang['lang_name'] .' <input name="lang_name1" type="text" value="'.(isset($lang_edit_default['title'])?$lang_edit_default['title']:"").'"><br/>
			   ' . $lang['lang_value'] .' <input name="lang_value1" type="text" value="'.(isset($lang_edit)?$lang_edit:"").'" size="5">
			   <a href="http://sunsite.berkeley.edu/amher/iso_639.html#laname" target="_blank" onclick="window.open(\'http://sunsite.berkeley.edu/amher/iso_639.html#laname\',\'help\',\'width=600,height=400,scrollbars=yes\');return false"><img src="../images/icons/help.png" alt="[?]" border="0"/></a><br/>
			   <input name="create_new_lang" type="submit" value="' . (isset($lang_edit)?$lang['button_save']:$lang['lang_create_new']) .'">
			   ';
$smarty->assign('table_conf_th',array($lang['lang_new_create']));
$smarty->assign('table_conf_tr',array('bgcolor="#eeeeee" class="left_articles" style="border-right:1px solid silver"','bgcolor="#dddddd" class="left_articles"'));
$smarty->assign('table_conf_td',array('style="border-right:1px solid silver"','style="border-right:1px solid silver"'));
$smarty->assign('table_conf_data',$lang_create);

unset($lang_create,$lang_edit_default,$lang_edit);

// Pagal kokia kalba bus redaguojama kita kalba
// Tarkim norime paredaguoti LT kalba paziurint kaip buvo pries tai LT kalboje
// Tam naudojamas sis dalis. Ji nustatome dauflt tokia kokia yra nustatyta admin'e defaultine
$lang_sql = mysql_query("SELECT * FROM `kalbos_nustatymai`");

$lang_edit_info = $lang['lang_edit_info'] . ' <select size="1" lenght="50" name="lang_edit" width="50">';
while ($lang_row = mysql_fetch_assoc($lang_sql)) {
	if ($lang_row['default_edit'] == 'Y') {
		$lang_default = ' selected="selected"';
	}
	else {
		$lang_default = ' ';
	}
	$lang_edit_info .= '<option value="' . $lang_row['value'] .'" ' . $lang_default .'>' . $lang_row['title'] .'</option>';
}
$lang_edit_info .= '</select> <input name="lang_edit_default_save" type="submit" value="' . $lang['button_save'] .'">';

$smarty->assign('table_edit_th',array($lang['lang_edit']));
$smarty->assign('table_edit_tr',array('bgcolor="#eeeeee" class="left_articles" style="border-right:1px solid silver"','bgcolor="#dddddd" class="left_articles"'));
$smarty->assign('table_edit_td',array('style="border-right:1px solid silver"','style="border-right:1px solid silver"'));
$smarty->assign('table_edit_data',$lang_edit_info);

unset($lang_edit_info,$lang_sql,$lang_default);


//Atvaizduojam nustatyta faila
$smarty->display("modules/language/language_admin.tpl");
?>
