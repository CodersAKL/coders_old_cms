<?
//patikrinimui ar puslapaia atveriami taip kaip reikia
//if (!defined("OK") { header('location: ../'); }
define("OK",TRUE);


/// ASPAUGA - NETRINk
// Prevent any possible XSS attacks via $_GET.
/*
foreach ($_GET as $check_url) {
	if ((eregi("<[^>]*script*\"?[^>]*>", $check_url)) || (eregi("<[^>]*object*\"?[^>]*>", $check_url)) ||
	(eregi("<[^>]*iframe*\"?[^>]*>", $check_url)) || (eregi("<[^>]*applet*\"?[^>]*>", $check_url)) ||
	(eregi("<[^>]*meta*\"?[^>]*>", $check_url)) || (eregi("<[^>]*style*\"?[^>]*>", $check_url)) ||
	(eregi("<[^>]*form*\"?[^>]*>", $check_url)) || (eregi("\([^>]*\"?[^)]*\)", $check_url)) ||
	(eregi("\"", $check_url))) {
	$radau = 1;
	}
}
unset($check_url);
*/
// Sanitise $_SERVER globals
$_SERVER['PHP_SELF'] = cleanurl($_SERVER['PHP_SELF']);
$_SERVER['QUERY_STRING'] = isset($_SERVER['QUERY_STRING']) ? cleanurl($_SERVER['QUERY_STRING']) : "";
$_SERVER['REQUEST_URI'] = isset($_SERVER['REQUEST_URI']) ? cleanurl($_SERVER['REQUEST_URI']) : "";
$PHP_SELF = cleanurl($_SERVER['PHP_SELF']);
// Common definitions

// Clean URL Function, prevents entities in server globals
function cleanurl($url) {
	$bad_entities = array("&", "\"", "'", '\"', "\'", "<", ">", "(", ")");
	$safe_entities = array("&amp;", "", "", "", "", "", "", "", "");
	$url = str_replace($bad_entities, $safe_entities, $url);
	return $url;
}

/// ASPAUGA - END

//sutvarkom nuorodas
if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) { $url = url_arr($_SERVER['QUERY_STRING']); }
else { $url = array(); }



// bandom skaiciuoti mysql uzklausas TESTAS
function mysql_query1($query) {
	global $mysql_num;
	if (defined("LEVEL") && LEVEL > 20) {
		#copyright("mysql $mysql_num");
	}
	$mysql_num++;
	return mysql_query($query);
}




$conf = mysql_fetch_assoc(mysql_query1("SELECT * FROM `nustatymai` LIMIT 1"));

//Nuskaitom info is URL
function http_get( $url ) {
	$request = fopen( $url, "rb" );
	$result = "";
	while( !feof( $request ) ) {
		$result .= fread( $request, 8192 );
	}
	fclose( $request );
	return $result;
}

//imam info is XML
function get_tag_contents( $xml, $tag ) {
  $result = "";
  $s_tag = "<$tag>";
  $s_offs = strpos( $xml, $s_tag );

  // If we found a starting offset, then look for the end-tag.
  //
  if( $s_offs ) {
   $e_tag = "</$tag>";
   $e_offs = strpos( $xml, $e_tag, $s_offs );

   // If we have both tags, then dig out the contents.
   //
   if( $e_offs ) {
     $result = substr(
       $xml,
       $s_offs + strlen( $s_tag ),
       $e_offs - $s_offs - strlen( $e_tag ) + 1 );
   }
  }

  return $result;
}

//Suskaiciuojam kiek nurodytoje lenteleje yra yrasu
function kiek($table,$where='',$as="viso") {
	$viso = mysql_fetch_assoc(mysql_query("SELECT count(*) AS $as FROM $table $where"));
	return $viso[$as];
}

//puslapiavimui
function puslapiai($start,$count,$total,$link="",$range=0){
	$res="";
	$pg_cnt=ceil($total / $count);
	if ($pg_cnt > 1) {
		$idx_back = $start - $count;
		$idx_next = $start + $count;
		$cur_page=ceil(($start + 1) / $count);
		$res.="";
		//$res.="<span class='sarasas'>Puslapis $cur_page iš $pg_cnt\n";
		$res.="<center>\n";
		if ($idx_back >= 0) {
			if ($cur_page > ($range + 1)) $res.='<a href="' . $link .'/0">««</a> ';
			$res.='<a href="' . $link . '/' .$idx_back .'">«</a> ';
		}
		$idx_fst=max($cur_page - $range, 1);
		$idx_lst=min($cur_page + $range, $pg_cnt);
		if ($range==0) {
			$idx_fst = 1;
			$idx_lst=$pg_cnt;
		}
		for($i=$idx_fst;$i<=$idx_lst;$i++) {
			$offset_page=($i - 1) * $count;
			if ($i==$cur_page) {
				$res.="<b>$i</b>\n";
			} else {
				$res.='<a href="' .$link .'/' . $offset_page .'">' . $i .'</a> ';
			}
		}
		if ($idx_next < $total) {
			$res.='<a href="' . $link .'/' . $idx_next .'">»</a> ';
			if ($cur_page < ($pg_cnt - $range)) $res.='<a href="' . $link .'/' . ($pg_cnt-1)*$count .'">»»</a> ';
		}
		//$res.="</span>\n";
		$res.="</center>\n";

	}
	return $res;
}

/**
 * Tikrina ar kintamasis teigiamas skaicius
 *
 * @param num $value
 * @return 1 or NULL
 */
function isNum($value) {
	if (!is_array($value)) { return (preg_match("/^[0-9]+$/", $value)); }
	else { return false; }
}

function getip(){
	if(getenv('HTTP_X_FORWARDED_FOR')){
		$ip = $_SERVER['REMOTE_ADDR'];
		if(preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", getenv('HTTP_X_FORWARDED_FOR'), $ip3)){
			$ip2 = array('/^0\./', '/^127\.0\.0\.1/', '/^192\.168\..*/', '/^172\.16\..*/', '/^10..*/', '/^224..*/', '/^240..*/');
			$ip = preg_replace($ip2, $ip, $ip3[1]);
		}
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	if($ip == ""){ $ip = "0.0.0.0"; }
	return $ip;
}
function random_name($i=10) {
	$chars = "abcdefghijkmnopqrstuvwxyz023456789";
	srand((double)microtime()*1000000);
	$name = '' ;
	while ($i >= 0) {
		$num = rand() % 33;
		$tmp = substr($chars, $num, 1);
		$name = $name . $tmp;
		$i--;
	}
	return $name;
}
//Sutvarko SQL uzklausa

function escape($sql) {
   // Stripslashes
   if (get_magic_quotes_gpc()) {
       $sql = stripslashes($sql);
   }
   // Quote if not a number or a numeric string
   //if (!isnum($sql) || $sql[0] == '0') {
   if (!isnum($sql)) {
       $sql = "'" . mysql_real_escape_string($sql) . "'";
   }
   return $sql;
}


//ismeto visokius nereikalingus simbolius
//sito reikia jei nori grainti i inputa informacija.
//daznai tai buna su visokiais \\\'? ir pan
function input ($s) {
   /*$s = stripslashes($s);
   $s = htmlentities($s);
   $s = htmlspecialchars($s, ENT_QUOTES);*/
   	if (ini_get('magic_quotes_gpc')) $s = stripslashes($s);
	$search = array("\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;");
	$replace = array("&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " ");
	$s = str_replace($search, $replace, $s);

	//$s = htmlentities($s,null,"UTF-8");
	//$s = preg_replace('/[^\x00-\x7F]/e', '"&#".ord("$0").";"', $s);
   return $s;
}

/////////////////////////////////////////////////////////
//////// URL APDOROJIMUI
////////////////////////////////////////////////////////
//is QUERY_STRING padarom masyva
function url_arr($params) {
	if (!isset($params)) { $params = $_SERVER['QUERY_STRING']; }
	$params = explode(";", $params);
	foreach ($params as $key => $value) {
		$str1 = explode(",",$value);
		@$str2[$str1[0]] = @$str1[1];
	}
	return $str2;
}
//is masyvo padarom nuoroda
function arr_url($arr) {
	$return = '';
	if (is_array($arr)) {
		$str = '';
		foreach ($arr as $key => $value) {
			if (strlen($value) != 0) {
				$return .= $str.$key.','.$value;
			}
			$str = ';';
		}
	}
	return $return;
}

//funkcija apdorojanti nuorodas
function url($str,$link=''){
	if (!empty($_SERVER['QUERY_STRING'])) {
		$url = url_arr($_SERVER['QUERY_STRING']);
	}
	else { $url = array(); }
	if (!is_array($str)) {
		$str = url_arr($str);
	}
	return $link."?".arr_url(array_merge($url,$str));
}
/////////////////////////////////////////////////////////////
///////// URL PABAIGA
/////////////////////////////////////////////////////////////

//peradresavimo budai
function redirect($location, $type="header") {
    if ($type == "header") {
        header("Location: ".$location);
    }
    if ($type == "meta") {
        echo "<meta http-equiv='Refresh' content='4;url={$location}'>";
    }
    else {
        echo "<script type=\"text/javascript\">document.location.href=\"$location\"</script>\n";
    }
}

function descript($text,$striptags=true) {
	// Convert problematic ascii characters to their true values
	$search = array("40","41","58","65","66","67","68","69","70",
		"71","72","73","74","75","76","77","78","79","80","81",
		"82","83","84","85","86","87","88","89","90","97","98",
		"99","100","101","102","103","104","105","106","107",
		"108","109","110","111","112","113","114","115","116",
		"117","118","119","120","121","122","239"
		);
	$replace = array("(",")",":","a","b","c","d","e","f","g","h",
		"i","j","k","l","m","n","o","p","q","r","s","t","u",
		"v","w","x","y","z","a","b","c","d","e","f","g","h",
		"i","j","k","l","m","n","o","p","q","r","s","t","u",
		"v","w","x","y","z",""
		);
	$entities = count($search);
	for ($i=0;$i < $entities;$i++) $text = preg_replace("#(&\#)(0*".$search[$i]."+);*#si", $replace[$i], $text);
	$text = str_replace(chr(32).chr(32), "&nbsp;", $text);
    $text = str_replace(chr(9), "&nbsp; &nbsp; &nbsp; &nbsp;", $text);
	// the following is based on code from bitflux (http://blog.bitflux.ch/wiki/)
	// Kill hexadecimal characters completely
	$text = preg_replace('#(&\#x)([0-9A-F]+);*#si', "", $text);
	// remove any attribute starting with "on" or xmlns
	$text = preg_replace('#(<[^>]+[\\"\'\s])(onmouseover|onmousedown|onmouseup|onmouseout|onmousemove|onclick|ondblclick|onload|xmlns)[^>]*>#iU', ">", $text);
	// remove javascript: and vbscript: protocol
	$text = preg_replace('#([a-z]*)=([\`\'\"]*)script:#iU', '$1=$2nojscript...', $text);
	$text = preg_replace('#([a-z]*)=([\`\'\"]*)javascript:#iU', '$1=$2nojavascript...', $text);
	$text = preg_replace('#([a-z]*)=([\'\"]*)vbscript:#iU', '$1=$2novbscript...', $text);
        //<span style="width: expression(alert('Ping!'));"></span> (only affects ie...)
	$text = preg_replace('#(<[^>]+)style=([\`\'\"]*).*expression\([^>]*>#iU', "$1>", $text);
	$text = preg_replace('#(<[^>]+)style=([\`\'\"]*).*behaviour\([^>]*>#iU', "$1>", $text);
	if ($striptags) {
		do {
	        $thistext = $text;
			$text = preg_replace('#</*(applet|meta|xml|blink|link|style|script|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i', "", $text);
		} while ($thistext != $text);
	}
	return $text;
}

//Sulauzom zodi jei perilgas - lauzo net ir jei zodis turi tarpus
function wrap1($text,$chars=25) {
        $text = wordwrap($text, $chars, "<br />\n", 1);
        return $text;
}
//Sulauzo zodi tik jei jis yra be tarpu ir perilgas
function wrap($string,$width,$break="\n") {
   $string = preg_replace('/([^\s]{'.$width.'})/i',"$1$break",$string);
   return $string;
}

//tikrinam ar kintamasis sveikas skaicius ar normalus zodis
function tikrinam($txt) {
	return (preg_match("/^[0-9a-zA-Z]+$/",$txt));
}

//sutvarko url iki linko
function linkas($str) {
	//return preg_replace_callback("#([\n ])([a-z]+?)://([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]+)#si", "linkai", $str);
	return preg_replace("`((http)+(s)?:(//)|(www\.))((\w|\.|\-|_)+)(/)?(\S+)?`i", "<a href=\"http://\\5\\6\" title=\"\\0\" target=\"_blank\" >\\5\\6</a>", $str);
}

// apvalinti:
// suapvalina nurodyta skaičiu
// (išesmės veikia kaip ceil() tik leidžia nurodyti dešimtainę)
function apvalinti($sk, $kiek) {
	if ($kiek < 0) { $kiek = 0; }
	$mult = pow(10, $kiek);
	return ceil($sk * $mult) / $mult;
}

function insert($table,$array) {
	return 'INSERT INTO `'.$table.'` ('.implode(', ',array_keys($array)).') VALUES ('.implode(', ',array_map('escape',$array)).')';
}

?>
