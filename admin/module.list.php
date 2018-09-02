<?php

$mod_used = array();
$mod_free = array();
$mod_system = array();
$mod_not = array();

$mod_free_inc = 0;
$mod_used_inc = 0;
$mod_system_inc = 0;
$mod_not_inc = 0;

// Visi moduliai pagal ju direktorijas
foreach (glob($base."modules/*", GLOB_ONLYDIR) as $filename) {		// Jei egzistuoja modulio ini failas
		// kuris reikalingas suvesti duomenis
		if (file_exists($filename."/".basename($filename).".ini.php")) {
			$file = parse_ini_file($filename."/".basename($filename).".ini.php",true);
			// Jeigu modulis pilnai instaliuotas
			if (@$mod_install[basename($filename)] == 'Y') {				// Jei tai sisteminis modulis
				// kuris skirtas tarkim balsavimui ar panasiai ir nera redaguojamas				if (isset($file['info']['system']) && $file['info']['system'] == "system") {					$mod_system[$mod_system_inc]['lang'] = $file['info']['about'];
					$mod_system[$mod_system_inc]['alias'] = $file['info']['name'];
					$mod_system[$mod_system_inc]['logo'] = (empty($file['info']['icon'])?"images/admin/plugins.gif":$file['info']['icon']);
					$mod_system_inc++;
				}
				else {					// Is tree menu paiimamas modulis ir suriktrinama ar jis naudojamas ar ne
					// jei nenaudojamas tuomet uzklausa grazina nuli
					// kitu atveju reiskias modulis naudojamas					$mod_used_sql = mysql_query("SELECT * FROM `tree_menu` WHERE `module`='" . basename($filename) ."'");
				 	if (mysql_num_rows($mod_used_sql) != 0) {				 		$mod_used_array = mysql_fetch_assoc($mod_used_sql);				 		$mod_used[$mod_used_inc]['lang'] = $mod_used_array['lang_' . $_SESSION['lang']];
				 		$mod_used[$mod_used_inc]['alias'] = $mod_used_array['module'];
				 		$mod_used[$mod_used_inc]['logo'] = (empty($file['info']['icon'])?"images/admin/plugins.gif":$file['info']['icon']);
				 		$mod_used_inc++;
				 		unset($mod_used_sql,$mod_used_array);
				 	}
				 	// Modulis pasirodo nera naudojamas
				 	// nes nera jo tree menu irase
				 	else {				 		$mod_free_array = mysql_fetch_assoc(mysql_query("SELECT * FROM `mod_install` WHERE `mod_main`='" . basename($filename) ."'")) or die(mysql_error());
				 		$mod_free[$mod_free_inc]['lang'] = $mod_free_array['title'];
				 		$mod_free[$mod_free_inc]['alias'] = $mod_free_array['mod_main'];
				 		$mod_free[$mod_free_inc]['logo'] = (empty($mod_free_array['mod_icon'])?"images/admin/plugins.gif":$mod_free_array['mod_icon']);
				 		$mod_free_inc++;
				 		unset($mod_free_array);
				 	}
				 }
			}
			else {				if (isset($file['info']['system']) && $file['info']['system'] == "system") {					$mod_system[$mod_system_inc]['lang'] = $file['info']['about'];
					$mod_system[$mod_system_inc]['alias'] = $file['info']['name'];
					$mod_system[$mod_system_inc]['logo'] = (empty($file['info']['icon'])?"images/admin/plugins.gif":$file['info']['icon']);
					$mod_system_inc++;
				}
				else {					$mod_not[$mod_not_inc]['lang'] = $file['info']['about'];
					$mod_not[$mod_not_inc]['alias'] = $file['info']['alias'];
					$mod_not[$mod_not_inc]['logo'] = (empty($file['info']['icon'])?"images/admin/plugins.gif":$file['info']['icon']);
					$mod_not_inc++;
				}
			}
		}
}


$smarty->assign("mod_install",$mod_used);
$smarty->assign("mod_free",$mod_free);
$smarty->assign("mod_system",$mod_system);
$smarty->assign("mod_not",$mod_not);



?>
