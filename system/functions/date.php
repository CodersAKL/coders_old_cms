<?
function date_lt(){
	$data ='';
	$menesis=date('n');
	$mas_menesiai= array("&nbsp;Sausio&nbsp;", "&nbsp;Vasario&nbsp;", "&nbsp;Kovo&nbsp;", "&nbsp;Balandžio&nbsp;", "&nbsp;Gegužės&nbsp;", "&nbsp;Birželio&nbsp;",
	"&nbsp;Liepos&nbsp;", "&nbsp;Rugpjūčio&nbsp;", "&nbsp;Rugsėjo&nbsp;", "&nbsp;Spalio&nbsp;", "&nbsp;Lapkričio&nbsp;", "&nbsp;Gruodžio&nbsp;");
	$data .= date('Y');
	$data .= $mas_menesiai[$menesis-1];
	$data .=date('j\d.')." ";
	$data .=date('H:i');
	return $data;
}
function amzius($data) {
	if (!isset($data) || $data == '') { return "N/A"; }
		else {
		$data = explode ("-", $data);
		$amzius = time() - mktime(0,0,0,$data['1'],$data['2'],$data['0']);
		$amzius = date("Y",$amzius) - 1970;
		return $amzius;
	}
}

//bano galiojimo laikas. Rodo data iki kada +30 dienu
//echo "Galioja iki: ".galioja('12', '19', '2007');
//grazina: Galioja iki: 2008-01-17
function galioja($menuo,$diena,$metai,$kiek_galioja=30) {
	$nuo = (int)(mktime(0,0,0,$menuo,$diena,$metai)- time(void)/86400);
	$liko = $nuo + ($kiek_galioja * 24 * 60 * 60);
	return date('Y-m-d',$liko);
}
function liko($diena, $menuo, $metai){
	$until = mktime(0,0,0,$menuo,$diena,$metai);
	$now = time();
	$difference = $until - $now;
	$days = floor($difference/86400);
	$difference = $difference - ($days*86400);
	$hours = floor($difference/3600);
	$difference = $difference - ($hours*3600);
	$minutes = floor($difference/60);
	$difference = $difference - ($minutes*60);
	$seconds = $difference;
	return (int)$days + 1;
}

function naujas($data,$nick=null) {
	if (isset($_SESSION['lankesi']) && $nick != $_SESSION['username']) {
		return (($data > $_SESSION['lankesi'])?'<font color=red><b>Naujas<blink>!</blink></b></font>':'');
	}
	else { return ''; }
}

//Pries kiek laiko
function kada($ts) {
	if ($ts == '' || $ts == "0000-00-00 00:00:00") { return ''; }
	$mins = floor((strtotime(date("Y-m-d H:i:s")) - strtotime($ts)) / 60);
	$hours = floor($mins / 60);
	$mins -= $hours * 60;
	$days = floor($hours / 24);
	$hours -= $days * 24;
	$weeks = floor($days / 7);
	$days -= $weeks * 7;
	if ($weeks)
	return "pries ".$weeks ." ". ($weeks > 1 ? "sav." : "sav.");
	if ($days)
	return "pries ".$days ." ". ($days > 1 ? "d." : "d.");
	if ($hours)
	return "pries ".$hours ." ". ($hours > 1 ? "val." : "val.");
	if ($mins)
	return "pries ".$mins ." ". ($mins > 1 ? "min." : "min.");
	return "pries < 1 minute";
}

?>
