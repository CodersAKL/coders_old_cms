<?php


// Kalbos kintamasis
$smarty->assign("lang",$lang);

// Modulio konfiguracija
$mod_conf = mysql_fetch_assoc(mysql_query("SELECT * FROM `straipsniai_nustatymai`"));

// Pagal ka turime rusiuoti esamus straipsnius
// Nustatoma per Admin'a

if ($mod_conf['article_order_by'] == 'by_date') { $mod_conf['order'] = ' ORDER BY `data` DESC '; }
if ($mod_conf['article_order_by'] == 'from_new_to_old') { $mod_conf['order'] = ' ORDER BY `data` DESC '; }
if ($mod_conf['article_order_by'] == 'from_old_to_new') { $mod_conf['order'] = ' ORDER BY `data` ASC '; }
if ($mod_conf['article_order_by'] == 'by_join') { $mod_conf['order'] = ' ORDER BY `apsilankymai` ASC'; }
if ($mod_conf['article_order_by'] == 'by_abc') { $mod_conf['order'] = ' ORDER BY `pavadinimas` ASC'; }

// Papildomi moduliai, kurie leis vartotojui atsiusti straipsni
// pateikti ir t.t.
// Failas turi buti visada includinamas kad butu galima visada atvaizduoti
// Tai ka pasirinko adminas confige straipsniu.
require_once("article_more.php");

// Pradinis langas pasirinkus "Straipsniai" menu punkte
// bet daugiau niekas nepaspausta, tuomet isvedame tai
// kas nustatyta per admin'a
if(empty($_GET['explode']) && $_GET['module'] == 'article') {
    // Jei pasirinkta kad rodytu kategorijas
    // isvedame tuomet tas kategorijas
	if ($mod_conf['show_cat'] == 'Y') {		// Straipsniu kategorijos
		require_once("article_category.php");
	}

	// Jei pasirinkta kad rodytu naujausius straipsnius
	// tuomet isvedame ir juos
    if ($mod_conf['show_article'] == 'Y') {    	// Naujausi straipsniai
 		require_once("article_new.php");
 	}

	//Atvaizduojam nustatyta faila
	$smarty->assign("style",$style);
	$mods['content'] = "modules/article/article_main.tpl";
}


if(!empty($_GET['explode'])) {	// Jei pasirinktas straipsniu atsiuntimas
	// Sutikrinime ar ijungta si opcija ir includinam atitinkama faila
	if(!empty($_GET['explode'][0]) && $_GET['explode'][0] == 'send') {
		if ($mod_conf['allow_send'] == 'Y') {
			require_once("article_send.php");

			//Atvaizduojam nustatyta faila
			$smarty->assign("style",$style);
			$mods['content'] = "modules/article/article_send.tpl";
		}
		else {			Header( "HTTP/1.1 301 Moved Permanently" );
			Header( "Location: " . $_SERVER['PHP_SELF'] );
		}
	}
	// Jei pasirinkta kategorija bet ne pats straipsnis
	if (!empty($_GET['explode'][0]) && empty($_GET['explode'][1])) {		require_once("article_show_all.php");

		//Atvaizduojam nustatyta faila
		$smarty->assign("style",$style);
		$mods['content'] = "modules/article/article_show_all.tpl";
	}

	// Jei pasirinktas straipsnis ziurejimui includinam atitinkama faila
	if (!empty($_GET['explode'][0]) && !empty($_GET['explode'][1])) {
		require_once("article_show.php");

		//Atvaizduojam nustatyta faila
		$smarty->assign("style",$style);
		$mods['content'] = "modules/article/article_show.tpl";
	}

}

?>
