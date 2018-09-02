<script language="javascript" type="text/javascript">
// Notice: The simple theme does not use all options some of them are limited to the advanced theme
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	mode : "exact",
	plugins : "flash,style,layer,table,advhr,emotions,advimage,advlink,insertdatetime,preview,media,searchreplace,contextmenu,directionality,fullscreen,noneditable,visualchars,xhtmlxtras",
	elements : "lang_lt",
	content_css : "stilius/stilius.css",
	//theme_advanced_resize_horizontal : false,
	//theme_advanced_resizing : true,
	apply_source_formatting : true,
	theme_advanced_path_location : "bottom",
	theme_advanced_buttons1_add_before : "save,newdocument,separator",
	theme_advanced_buttons1_add : "fontsizeselect",
	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "search,replace,|",
	theme_advanced_buttons3_add_before : "tablecontrols,|",
	theme_advanced_buttons3_add : "emotions,media,advhr,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops",
	theme_advanced_disable : "help"
});

</script>

<?php

// Kokios kalbos yra sukurtos vartotojo
// Tas kalbas ir includinam i tab'us
$lang_sql = mysql_query("SELECT `value`,`title` FROM `kalbos_nustatymai`");
$lang_sql_total = kiek("kalbos_nustatymai");
$a = 0;
$b = 1;
while ($lang_row = mysql_fetch_assoc($lang_sql)) {
	if ($b == $lang_sql_total) {
		$lang_editor[$a]['title'] = $lang_row['title'];
		$lang_editor[$a]['img'] = '<img src="../images/flags/'. $lang_row['value'] .'.png" class="middle" style="padding-top:4.5px">&nbsp;';
		$lang_editor[$a]['editor'] = '<textarea id="lang" name="lang_' . $lang_row['value'] .'" style="width:100%;height:100%"></textarea>';
		$lang_editor[$a]['value'] = $lang_row['value'];
		$lang_editor[$a]['last'] = 'yes';
	}
	else {
		$lang_editor[$a]['title'] = $lang_row['title'];
		$lang_editor[$a]['img'] = '<img src="../images/flags/'. $lang_row['value'] .'.png" class="middle" style="padding-top:4.5px">&nbsp;';
		$lang_editor[$a]['editor'] = '<textarea id="lang" name="lang_' . $lang_row['value'] .'" style="width:100%;height:100%"></textarea>';
		$lang_editor[$a]['value'] = $lang_row['value'];
		$lang_editor[$a]['last'] = 'no';
	}
	$a++;
	$b++;
}

// TinyMCE redaktoriaus kintamasis kuris naudojamas
// velesniam jo ukrovimui TPL failuose
$smarty->assign("editor",$lang_editor);
unset($lang_row,$lang_editor,$lang_sql,$lang_sql_total,$b,$a);

// Administravimo isvedimas
$smarty->display("modules/editor/editor_admin.tpl");

?>
