<?php


/* ################### Menu Tree ############################
# Autorius:     Min2liz
# Aprasymas:    class skirta isvesti Menu Tree menu.
##########################################################
*/
class MTree {
	function addToArray($id,$name,$parentID){
		if(empty($parentID))$parentID=0;
		$this->elementArray[$parentID][] = array($id,$name);
	}
	function drawSubNode($parentID) {
		if(isset($this->elementArray[$parentID])){
			echo "<ul>";
			for($no=0;$no<count($this->elementArray[$parentID]);$no++) {
				echo '<li id=\"node'.$this->elementArray[$parentID][$no][0].'\"><a href=\"#\">'.$this->elementArray[$parentID][$no][1].'</a>';
				$this->drawSubNode($this->elementArray[$parentID][$no][0]);
				echo "</li>\n";
			}
			echo "</ul>";
		}
	}
	function drawTree(){
		echo "<ul id=\"dhtmlgoodies_tree2\" class=\"dhtmlgoodies_tree\">";
		for($no=0;$no<count($this->elementArray[0]);$no++){
			echo "<li id=\"node".$this->elementArray[0][$no][0]."\"><a href=\"#\">".$this->elementArray[0][$no][1]."</a>";
			$this->drawSubNode($this->elementArray[0][$no][0]);
			echo "</li>\n";
		}
		echo "</ul>";
	}
}

/* ######################### MySQL class ##################################
# Autorius: Min2liz
# Aprasymas: class kirta prisijungimui prie MySQL serverio ir atlikti
#			jame nurodytus veiksmus.
########################################################################
*/
class MySQL {
	function connect($host,$user,$pass,$db) {
		$this->connected = mysql_connect($host, $user, $pass) or die ("Could not connect to MySQL");
		mysql_select_db($db) or die ("Could not select database");
	}
	function query($sql) {
		if (empty($this->connected)) { return "Not connected to MySQL Server"; }
		else {
			$this->result = mysql_query ($sql) or die ("Bloga užklausa. " . mysql_error());
			$this->queries++;
			unset($sql);
		}
	}
	function assoc() {
		if (empty($this->result)) { return "No Query to get result"; }
		else {
			return mysql_fetch_assoc($this->result);
			unset($this->result);
		}
	}
	function num() {
		if (empty($this->result)) { return "No Query to get result"; }
		else {
			return mysql_num_rows($this->result);
			unset($this->result);
		}
	}
	function close() {
		if (empty($this->connected)) { return "Not connected to MySQL Server"; }
		else {
			mysql_close($this->connected);
		}
	}
	function insert($table,$array) {
		$this->result = mysql_query( 'INSERT INTO `'.$table.'` ('.implode(', ',array_keys($array)).') VALUES ('.implode(', ',array_map('escape',$array)).')') or die ("Bloga užklausa. " . mysql_error());
	}
}

/* ######################### Secure class ##################################
# Autorius: Min2liz
# Aprasymas: class kirta apsaugoti gautus duomenis is vartotojo puses
########################################################################
*/
class secure {
	function sql($value) {
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		if (!is_numeric($value)) {
			$value = "'" . mysql_real_escape_string($value) . "'";
		}
		return $value;
	}
	function html2txt($text, $tags = array()) {
		$args = func_get_args();
		$text = array_shift($args);
		$tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
		foreach ($tags as $tag){
			if( preg_match_all( '/<'.$tag.'[^>]*>([^<]*)<\/'.$tag.'>/iu', $text, $found) ){
				$text = str_replace($found[0],$found[1],$text);
			}
		}
		return preg_replace( '/(<('.join('|',$tags).')(\\n|\\r|.)*\/>)/iu', '', $text);
	}
}

/* ######################### user class ##################################
# Autorius: Min2liz
# Aprasymas: class kirta sutikrinti ar vartotojas prisijunges ar ne
# 			perduoti duomenis apie vartotoja kai reikia ir laikyti juos
########################################################################
*/

class user extends MySQL {
	function loged() {
		$dev_cookie = explode(".", $_COOKIE['dev_user']);
		$user = secure::html2txt($dev_cookie[0]);
		$pass = secure::html2txt($dev_cookie[1]);
		$this->query("SELECT * FROM dev_users WHERE user='$user' AND pass='$pass'");
		if ($this->num != 0) { return TRUE; }
		else { return FALSE; }
		unset($user,$pass);
	}
	function login(c$user,$pass) {
		$user = secure::html2txt($user);
		$pass = secure::html2txt(md5($pass));
		MySQL::query("SELECT * FROM dev_users WHERE user='$user' AND pass='$pass'");
		if (MySQL::num != 0) {
			$dev_cookie  = $user . "-" . $pass;
			setcookie("dev_user",$dev_cookie,time()+60*60*24*365);
		}
		else {
			return FALSE;
		}
	}
	function logout() {
		setcookie("dev_user","n.a");
	}
}
?>
