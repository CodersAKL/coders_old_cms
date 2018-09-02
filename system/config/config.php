<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'Off');	//ijungiam klaidu rodyma
$host = "localhost";//mysql serverio adresas
$user = "codcod7_coders";		//db vartotojas
$pass = "slaptazodis";			//slaptazodis
$db = "codcod7_coders";	//Duomenu baze

$true = 'http://coders.freehostia.com/';
$base = str_replace("\\", "/", realpath(dirname($_SERVER['SCRIPT_FILENAME']))); //$base = /home/fdisk/domains/fdisk.hosting-lt.net/public_html
$file_base = realpath(dirname(__FILE__)); //$_REAL_BASE_DIR = /home/fdisk/domains/fdisk.hosting-lt.net/public_html/puslapiai
$dir = substr($base,strlen($file_base)); // /puslapiai

#Pataisom DOCUMENT_ROOT
if ( isset($_SERVER["PATH_TRANSLATED"]) && isset($_SERVER["PATH_INFO"]) ) { 
    $pt = str_replace("\\\\", "/", $_SERVER["PATH_TRANSLATED"]); 
    $l = strlen($pt) - strlen($_SERVER["PATH_INFO"]); 
    $_SERVER["DOCUMENT_ROOT"] = substr($pt, 0, $l); 
} 

$home = $dir ? substr( dirname($_SERVER['SCRIPT_NAME']), 0, -strlen($file_base) ) : dirname($_SERVER['SCRIPT_NAME']); //$home = /~fdisk

$debug = false;

//Stiliaus funkcijos
//include_once("priedai/sfunkcijos.php");

// DB Prisijungimas
mysql_pconnect($host, $user, $pass) or die("Svetainė laikinai neveikia: <h3>Negaliu prisijungti prie MySQL</h3>");
mysql_query("SET NAMES 'utf8'"); //nurodom kokia koduote skaitysim info is DB
mysql_select_db($db) or die("Svetainė laikinai neveikia: <h3>Negaliu prisijungti prie duomenų bazės</h3>");
$conf = mysql_fetch_assoc(mysql_query("SELECT * FROM `nustatymai` LIMIT 1"));
unset($user,$host,$pass,$db);

// Inkludinam tai ko mums reikia
//include_once("priedai/funkcijos.php");


function base_url1() {
	$base = realpath(dirname($_SERVER['SCRIPT_FILENAME'])); //$base = /home/fdisk/domains/fdisk.hosting-lt.net/public_html
	$file_base = realpath(dirname(__FILE__)); //$_REAL_BASE_DIR = /home/fdisk/domains/fdisk.hosting-lt.net/public_html/puslapiai
	$dir = substr( $file_base, strlen($base)); // /puslapiai

	$home = $dir ? substr( dirname($_SERVER['SCRIPT_NAME']), 0, -strlen($dir) ) : dirname($_SERVER['SCRIPT_NAME']); //$home = /~fdisk
	echo "\$base = $base <br/>";
	echo "\$file_base = $file_base <br/>";
	echo "\$dir = $dir <br/>";
	echo "\$home = $home <br/>";
}
if ($debug == true) { base_url1(); }
$_SESSION['lang'] = 'lt';
?>
