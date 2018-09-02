<script language="JavaScript">
// Notice: The simple theme does not use all options some of them are limited to the advanced theme
tinyMCE.init({
    mode : "textareas",
    elements : "Apie,Maintenance",
    theme : "simple",
    mode : "exact",
    //content_css : "stilius/stilius.css",
    //apply_source_formatting : true,
});
</script>
<?
if (isset($_POST) && !empty($_POST) && isset($_POST['Konfiguracija'])) {
    $q = "UPDATE `nustatymai` SET
    `Apie` = ".escape($_POST['Apie']).",
    `Keywords` = ".escape($_POST['Keywords']).",
    `Pavadinimas` = ".escape($_POST['Pavadinimas']).",
    `Render` = ".escape($_POST['Render']).",
    `Copyright` = ".escape($_POST['Copyright']).",
    `Pastas` = ".escape($_POST['Pastas']).",
    `Registracija` = ".escape($_POST['Registracija']).",
    `Palaikymas` = ".escape($_POST['Palaikymas']).",
    `Style` = ".escape($_POST['Style']).",
    `Chat_limit` = ".escape($_POST['Chat_limit']).",
    `News_limit` = ".escape($_POST['News_limit']).",
    `Language` = ".escape($_POST['Language']).",
    `GD` = ".escape($_POST['GD']).",
    `Maintenance` = ".escape($_POST['Maintenance'])." LIMIT 1 ;";
    mysql_query1($q) or die (mysql_error());
    redirect('config/');
}
foreach (glob($base."template/*", GLOB_ONLYDIR) as $filename) {
	$style[basename($filename)] = basename($filename);
}

$nustatymai = array(
    "Form"=>array("action"=>"","method"=>"post","enctype"=>"","id"=>"","class"=>"","name"=>"reg"),
    "Svetainės pavadinimas:"=>array("type"=>"text","value"=>input($conf['Pavadinimas']),"name"=>"Pavadinimas","style"=>"width:400px"),
    "Trumpai apie svetainę:"=>array("type"=>"textarea","value"=>input($conf['Apie']),"name"=>"Apie","class"=>"input","rows"=>"10","style"=>"width:400px"),
    "Raktiniai žodžiai:<br/><i>(skirkite zodzius kableliais)</i>"=>array("type"=>"textarea","value"=>input($conf['Keywords']),"name"=>"Keywords","rows"=>"5","class"=>"input","style"=>"width:400px"),
    "Ar rodyti sugeneravimo laiką:"=>array("type"=>"select","value"=>array("1"=>"Taip","0"=>"Ne"),"selected"=>input($conf['Render']),"name"=>"Render"),
    "Copyright Tekstas:"=>array("type"=>"text","value"=>input($conf['Copyright']),"name"=>"Copyright","style"=>"width:400px"),
    "Svetainės e-paštas:"=>array("type"=>"text","value"=>input($conf['Pastas']),"name"=>"Pastas","style"=>"width:200px"),
    "Leisti registruotis:"=>array("type"=>"select","value"=>array("1"=>"Taip","0"=>"Ne"),"selected"=>input($conf['Registracija']),"name"=>"Registracija"),
    "Svetainė remontuojama?:"=>array("type"=>"select","value"=>array("1"=>"Taip","0"=>"Ne"),"selected"=>input($conf['Palaikymas']),"name"=>"Palaikymas"),
    "Uždarytos svetainės tekstas:"=>array("type"=>"textarea","value"=>input($conf['Maintenance']),"name"=>"Maintenance","rows"=>"10","class"=>"input","style"=>"width:400px"),
    "Svetainės stilius:"=>array("type"=>"select","value"=>$style,"selected"=>input($conf['Style']),"name"=>"Style"),
    "Svetainės kalba:"=>array("type"=>"select","value"=>array("lang_en"=>"English","lang_lt"=>"Lietuvių","lang_ru"=>"PYCKNN"),"selected"=>input($conf['Language']),"name"=>"Language"),
    "GD versija:"=>array("type"=>"select","value"=>array("gd1"=>"GD1","gd2"=>"GD2"),"selected"=>input($conf['GD']),"name"=>"GD"),
//    "Kiek rodyti ChatBox pranesimu?:"=>array("type"=>"select","value"=>array("5"=>"5","10"=>"10","15"=>"15","20"=>"20","25"=>"25","30"=>"30","35"=>"35","40"=>"40"),"selected"=>input($conf['Chat_limit']),"name"=>"Chat_limit"),
//    "Kiek rodyti naujienu?:"=>array("type"=>"select","value"=>array("5"=>"5","10"=>"10","15"=>"15","20"=>"20","25"=>"25","30"=>"30","35"=>"35","40"=>"40"),"selected"=>input($conf['News_limit']),"name"=>"News_limit"),
    ""=>array("type"=>"submit","name"=>"Konfiguracija","value"=>"Saugoti")
);

include_once("../system/class/form.class.php");
$bla = new forma();
$table = $bla->form($nustatymai);

	$smarty->assign('table_th',"Pagrindiniai nustatymai");
	$smarty->assign('table_tr',array('bgcolor="#eeeeee" class="left_articles" style="border-right:1px solid silver"','bgcolor="#dddddd" class="left_articles"'));
	$smarty->assign('table_td',array('style="border-right:1px solid silver"','style="border-right:1px solid silver"'));
	$smarty->assign('table_data',$table); unset($table);
	$smarty->display('table.tpl');

?> 
