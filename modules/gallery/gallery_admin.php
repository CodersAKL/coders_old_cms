<!-- Nuotraukos aprasymo editorius -->
<script language="JavaScript">
tinyMCE.init({
	mode : "textareas",
	elements : "Aprasymas",
	theme : "simple",
	mode : "exact",
});
</script>


<?php 
//Jei zmogus paspaude "publikuoti nuotrauka"
if (isset($_POST) && isset($_FILES) && !empty($_FILES) && !empty($_POST)) {
	include_once("../system/class/img.class.php");	//iterpiam reikalinga varikliuka
	$tmp = $_FILES['file']['type'];	//failo tipas
	//patkrinam ar failas tinkamo pletinio
	if ($tmp == "image/jpeg" || $tmp == "image/png" || $tmp == "image/gif") {
		$failas = failas("../images/gallery/".$_FILES['file']['name']);
		move_uploaded_file($_FILES['file']['tmp_name'],$failas);

		//uzkraunam klase
		$thumb = new Thumbnail($failas);
		$thumb->resize(300,300);	//sumazinam paveiksliuka, reikes prideti konfiguracija o ne 300x300
		//$thumb->watermark('../images/coders.png');	//copyrighto uzdejimui
		$thumb->cropFromCenter(150);	//apkerpam nuo centro i visus krastus, tam kad neliktu tusciu vietu
		$failas_th = failas($failas);	//sugeneruojam nauja failo pavadinima
		//jei nurodyta atliekam efektus
		if ($_POST['Efektai'] != "be") { (($_POST['Efektai'] == "veidrodis_remas")?$thumb->createReflection(90,10,80,true,'#000000'):$thumb->createReflection(90,10,80,false)); }
		$thumb->save($failas_th);	//issaugom rezultata
		if (substr(phpversion(), 0, 1) == 4) { $small_thumb->destruct(); }	//jei sena php versija rankiniu budu paleidziam destruct
		
		//sioje vietoje reikia iterpti info i db
		/*
			$_POST[Pavadinimas] => sdf
            $_POST[Efektai] => veidrodis_remas
            $_POST[Keywords] => sdf
            $_POST[Aprasymas] => sdfsdf
            $_POST[Kategorija] => darbai
            $_POST[Nuotrauka] => Publikuoti nuotrauką
            $failas		//dideles fotkes pavadinimas
            $failas_th	//mazos fotkes pavadinimas
		*/
		echo "<a href='$failas' rel='lightbox' title='".$_POST['Aprasymas']."'/><img src='$failas_th'/></a>";
	}
	//jei netinkamas pletinys atspauzdinam klaidos pranesima
	else {
		$smarty->assign('error',"<b>Netinkamas failas <u>".strtoupper(strip_tags($tmp))."</u> </b>Patikslinkite duomenys! <a href='http://code.google.com/p/coders/wiki/admin_module_gallery' target='_blank'><img src='../images/icons/help.png' border='0' alt='?' title='pagalba' class='middle'></a>");
		$smarty->display('none.tpl');
	}
}

//generuojamos formos su lentelem masyvas
$nustatymai = array(
	"Form"=>array(	//pagrindine forma
		"action"=>"",
		"method"=>"post",
		"enctype"=>"multipart/form-data",
		"id"=>"",
		"class"=>"",
		"name"=>"reg"
	),
	"Nuotraukos pavadinimas:"=>array(
		"type"=>"text",
		"value"=>(isset($_POST['Pavadinimas'])?input($_POST['Pavadinimas']):''),
		"name"=>"Pavadinimas",
		"style"=>"width:400px"
	),
	"Nuotrauka: <i>(tik JPG,PNG,GIF formatų)</i>"=>array(
		"type"=>"file",
		"value"=>"",
		"name"=>"file",
		"class"=>"input"
	),
	"Efektai:"=>array(
		"type"=>"select",
		"value"=>array(
				"be"=>"Be efektų",
				"veidrodis"=>"Veidrodis",
				"veidrodis_remas"=>"Veidrodis su remu"
			),
		"selected"=>(isset($_POST['Efektai'])?input($_POST['Efektai']):''),
		"name"=>"Efektai"
	),
	"Raktiniai žodžiai:<br/><i>(skirkite zodzius kableliais)</i>"=>array(
		"type"=>"textarea",
		"value"=>(isset($_POST['Keywords'])?input($_POST['Keywords']):''),
		"name"=>"Keywords",
		"rows"=>"3",
		"class"=>"input",
		"style"=>"width:400px"
	),
	"Aprašymas:"=>array(
		"type"=>"textarea",
		"value"=>(isset($_POST['Aprasymas'])?input($_POST['Aprasymas']):''),
		"name"=>"Aprasymas",
		"rows"=>"5",
		"class"=>"input",
		"style"=>"width:400px"
	),
	"Kategorija:"=>array(
		"type"=>"select",
		"value"=>array(
			"darbai"=>"Darbai",
			"photo"=>"Nuotraukos"
		),
		"selected"=>(isset($_POST['Kategorija'])?input($_POST['Kategorija']):''),
		"name"=>"Kategorija"
	),
	""=>array("type"=>"submit","name"=>"Nuotrauka","value"=>"Publikuoti nuotrauką")
);

//includinam formu generavimo varikliuka
include_once("../system/class/form.class.php");
$bla = new forma();
$table = $bla->form($nustatymai);	//suformuojam forma

echo '
<div class="left_articles" style="padding-bottom:30px">
		<div id="dhtmlgoodies_tabView1" style="">

			<div class="dhtmlgoodies_aTab" style="background-color:white">';
				//atspauzdinam forma subraizydami lenteles
				$smarty->assign('table_th',"Naujos nuotraukos įdėjimas");
				$smarty->assign('table_tr',array('bgcolor="" class="" style=""','bgcolor="" class=""'));
				$smarty->assign('table_td',array('style=""','style=""'));
				$smarty->assign('table_data',$table); unset($table);
				$smarty->display('table.tpl');
//TEST
echo '
			</div>
			<div class="dhtmlgoodies_aTab">
				Nustatymai
			</div>
';

echo '
	</div>
</div>
';

echo '<script type="text/javascript">
initTabs(
	\'dhtmlgoodies_tabView1\',
	Array(
		\'Naujos nuotraukos įkėlimas\',
		\'Galerijos nustatymai\'
	),
	0,
	670,
	500
);
</script>
';

//debugeriui priskiriam dar viena kintamaji
$debug['file'] = $_FILES;

?> 
