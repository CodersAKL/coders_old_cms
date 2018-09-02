<h2>Modulių administravimas</h2>
<?php
//INFORMACIJA APIE MODULIUS

if (isset($_GET['module']) && $_GET['module'] == 'admin' && isset($_GET['name']) && $_GET['name'] == 'module' && empty($_GET['pize'])) {
	//$smarty->display('admin/admin_menu.tpl');

	//Tikrinu modulius - ieskau ar yra failas [modulis]_admin.php - jei taip - uzkraunu.
	foreach (glob($base."modules/*", GLOB_ONLYDIR) as $filename) {

		//Tikrinam ar suinstaliuotas
		if (file_exists($filename."/".basename($filename)."_admin.php")) {
			//nuskaitom info apie moduli
			if (file_exists($filename."/".basename($filename).".ini.php")) { $file = parse_ini_file($filename."/".basename($filename).".ini.php",true); }
			else { $file['info']['about'] = ""; $file['info']['version'] = ""; $file['info']['url'] = "http://code.google.com/p/coders/wiki/admin_module_".basename($filename).""; }

			//tikrinam ar duombaze suinstaliuota teisingai
			//MySQL::query("SHOW TABLES LIKE 'naujienos'");
			if (isset($file['db']['name'])) {
				mysql_query1("SHOW TABLES LIKE '".$file['db']['name']."'") or die(mysql_error());
				if (mysql_affected_rows() > 0) { $info = true; } else { $info = false; }
				if ($info)
				$info = "<font color=\"green\"><b>Užkrautas</b></font> - patikrintas ir veikia";
				else 
				$info = "<font color=\"red\"><b>Neužkrautas</b></font> - patikrintas ir neveikia";
			}
		}
		else {
			$info = "<font color=\"red\"><b>Klaida</b></font> - trūksta failų";
		}

		//formuojam lentele
		$module_stats[] = ":: <b><a href='".basename($filename)."/'>".basename($filename)."</a></b> ".(isset($file['info']['version'])?$file['info']['version']:"-");
		$module_stats[] = ":: ".(isset($file['info']['about'])?$file['info']['about']:"-");
		$module_stats[] = ":: ".baitai(getfoldersize($filename));
		$module_stats[] = ":: ".(glob($filename."/".basename($filename)."_admin.php")?"<font color=\"green\"><b>Užkrautas</b></font> - patikrintas ir veikia":"<font color=\"red\"><b>Klaida</b></font> - trūksta failų");
		$module_stats[] = ":: <a href='module/update/".basename($filename)."/'><img src='../images/icons/refresh.gif' border='0' alt='?' title='Atnaujinti' class='middle'></a> <a href='module/delete/".basename($filename)."/'><img src='../images/icons/delete.png' border='0' alt='?' title='Isjungti' class='middle'></a> <a href='module/".basename($filename)."'><img src='../images/icons/information.png' border=0 alt='i' class='middle'/></a> <a href='".(isset($file['info']['url'])?$file['info']['url']:"http://code.google.com/p/coders/wiki/admin_module_".basename($filename))."' target='_blank' onClick=\"window.open('".(isset($file['info']['url'])?$file['info']['url']:"http://code.google.com/p/coders/wiki/admin_module_".basename($filename))."','help','width=600,height=400,scrollbars=yes');return false\"><img src='../images/icons/help.png' border='0' alt='?' title='pagalba' class='middle'></a>";
	}
	$smarty->assign('table_th',array('Modulis','Informacija','Dydis','Statusas','Pagalba'));
	$smarty->assign('table_tr',array('bgcolor="#eeeeee" class="left_articles" style="border-right:1px solid silver"','bgcolor="#dddddd" class="left_articles"'));
	$smarty->assign('table_td',array('style="border-right:1px solid silver"','style="border-right:1px solid silver"'));
	$smarty->assign('table_data',$module_stats); unset($module_stats);
	$smarty->display('table.tpl');
}
else {
	$file = parse_ini_file($base."modules/".basename($_GET['pize'])."/".basename($_GET['pize']).".ini.php",true);
		$module_stats[] = ":: ".$file['info']['version'];
		$module_stats[] = ":: ".$file['db']['table'];
		$module_stats[] = ":: ".$file['files']['main'];

	$smarty->assign('table_th',array('Modulis','DB','Files'));
	$smarty->assign('table_tr',array('bgcolor="#eeeeee" class="left_articles" style="border-right:1px solid silver"','bgcolor="#dddddd" class="left_articles"'));
	$smarty->assign('table_td',array('style="border-right:1px solid silver"','style="border-right:1px solid silver"'));
	$smarty->assign('table_data',$module_stats); unset($module_stats);
	$smarty->display('table.tpl');

}
?>
