<?php
class forma {
	function table($pav,$text) {
		return "\n<table width=\"200\" border=\"0\">\n\t<tr>\n\t\t<td><fieldset style=\"border:silver solid 1px\"><legend style=\"color: silver\">$pav</legend>$text</fieldset></td>\n\t</tr>\n</table>\n";
	}
	function form($inputs,$pavadinimas='') {
		if (is_array($inputs)) {
			$return = '';
			if (isset($inputs['Form'])) {
				$return .= "\n<form".(isset($inputs['Form']['id'])?" id=\"".$inputs['Form']['id']."\"":"")."".(isset($inputs['Form']['name'])?" name=\"".$inputs['Form']['name']."\"":"")."".(isset($inputs['Form']['method'])?" method=\"".$inputs['Form']['method']."\"":"")."".(isset($inputs['Form']['action'])?" action=\"".$inputs['Form']['action']."\"":"")."".(isset($inputs['Form']['enctype'])?" enctype=\"".$inputs['Form']['enctype']."\"":"")."".(isset($inputs['Form']['class'])?" class=\"".$inputs['Form']['class']."\"":"").">\n";
			}
			$return .= "<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n\t<tr class=\"title\">\n\t\t<td colspan=\"2\" align=\"left\">".$pavadinimas."</td>\n\t</tr>";
			foreach ($inputs as $pav => $type) {
				if (!empty($type) && $pav != 'Form') {
					$return .= "\n\t<tr>\n\t\t<td align=\"right\" class=\"sarasas\">".$pav."</td>";
					$return .= "\n\t\t<td class=\"sarasas\">\n\t\t\t".$this->input($type)."\n\t\t</td>\n\t</tr>";
				}
			}
			$return .= "\n</table>\n";
		}
		if (isset($inputs['Form'])) { $return .= "</form>\n"; }
		return $return;
	}
	function input($array) {
		if (is_array($array)) {
			switch ($array['type']) {
				case "select": {
					if (is_array($array['value'])) {
						$return = "<select".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['class'])?" class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['jump'])?" onchange=\"top.location.href='".$array['jump']."' + this.value;\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"").">\n";
						foreach ($array['value'] as $val => $pav) { $return .= "\t\t\t\t<option value=\"".$val."\"".((isset($array['selected']) && $array['selected']==$val)?" selected=\"selected\"":"")."".(isset($array['disabled']) && ($array['disabled']==$val)?" disabled=\"disabled\"":"").">".$pav."</option>\n"; }
						$return .= "\t\t\t</select>";
					}
					return $return;
				}
				case "text": { return "<input type=\"".$array['type']."\" ".(isset($array['class'])?"class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['value'])?" value=\"".$array['value']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"")."/>"; }
				case "password": { return "<input type=\"".$array['type']."\" ".(isset($array['class'])?"class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['value'])?" value=\"".$array['value']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"")."/>"; }
				case "file": { return "<input type=\"".$array['type']."\" ".(isset($array['class'])?"class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['value'])?" value=\"".$array['value']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"")."/>"; }
				case "image": { return "<input type=\"".$array['type']."\" ".(isset($array['class'])?"class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['src'])?" src=\"".$array['src']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"")."/>"; }
				case "hidden": { return "<input type=\"".$array['type']."\" ".(isset($array['class'])?"class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['value'])?" value=\"".$array['value']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"")."/>"; }
				case "button": { return "<input type=\"".$array['type']."\" ".(isset($array['class'])?"class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['value'])?" value=\"".$array['value']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"")."/>"; }
				case "submit": { return "<input type=\"".$array['type']."\" ".(isset($array['class'])?"class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['value'])?" value=\"".$array['value']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"")."/>"; }
				case "radio": { return "<input type=\"".$array['type']."\" ".(isset($array['class'])?"class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['value'])?" value=\"".$array['value']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"")."/>"; }
				case "checkbox": { return "<input type=\"".$array['type']."\" ".(isset($array['class'])?"class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['value'])?" value=\"".$array['value']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"")."/>"; }
				case "textarea": { return "<".$array['type']."".(isset($array['rows'])?" rows=\"".$array['rows']."\"":"")."".(isset($array['class'])?" class=\"".$array['class']."\"":"")."".(isset($array['id'])?" id=\"".$array['id']."\"":"")."".(isset($array['name'])?" name=\"".$array['name']."\"":"")."".(isset($array['style'])?" style=\"".$array['style']."\"":"").">".(isset($array['value'])?$array['value']:"")."</".$array['type'].">"; }
			}
		}
	}
}

class Table {
	var $th;
	var $td;
	var $return;
	var $style = 1;
	function __construct() {
		$this->return .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"table\">";
	}
	function render($data) {
		//sort($data);
		$num = count($data)-1;
		$i = 0;
		foreach ($data[0] as $key=>$val) {
				$this->th.=$this->th($key);
		}
		$this->return.=$this->tr($this->th,"th");
		while ($i <= $num) {
			$this->td='';
			if ($this->style==2) { $this->style=1; }
			else { $this->style=2; }
			foreach ($data[$i] as $key=>$val) {
				$this->td.=$this->td($val);
			}
			$this->return.=$this->tr($this->td,(($this->style==1)?"tr2":"tr"));
			$i++;
		}
		$this->return.=$this->finish();
		return $this->return;
	}
	function th($key='') {
		if (!empty($key)) { return "\n\t\t<th class=\"th\" nowrap=\"nowrap\"><a href=".url("o,$key").">$key</a></th>"; }
		else { return "\n\t\t<th class=\"th\" nowrap=\"nowrap\">&nbsp;</th>"; }
	}
	function td($val) {
		return "\n\t\t<td".($this->style==2?" class=\"td\"":" class=\"td2\"").">$val</td>";
	}
	function tr($info,$type=false) {
		return "\n\t<tr".(($type!=false)?" class=\"$type\"":" class=\"tr".$this->style."\"").">$info\n\t</tr>";
	}
	function finish() {	
		return "\n</table>\n";
	}
}
?>
