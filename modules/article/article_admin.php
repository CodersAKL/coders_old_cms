<?php

// Konfiguracijos issaugojimas per POST'a
if (isset($_POST['article_config'])) {	$show_cat 				= 	(isset($_POST['show_cat']))				?'Y':'N';
	$show_article 			= 	(isset($_POST['show_article']))			?'Y':'N';
	$allow_only_see_admin 	= 	(isset($_POST['allow_only_see_admin']))	?'Y':'N';
	$allow_send 			= 	(isset($_POST['allow_send']))			?'Y':'N';
	$allow_send_email 		= 	(isset($_POST['allow_send_email']))		?'Y':'N';
	$allow_write 			= 	(isset($_POST['allow_write']))			?'Y':'N';
	$allow_show_email 		= 	(isset($_POST['allow_show_email']))		?'Y':'N';
	$allow_show_url 		= 	(isset($_POST['allow_show_url']))		?'Y':'N';
	// Instaliuotu moduliu pasirinkimas
	// Jei modulis neisntaliuotas  jo ir nerodys,
	// tuo paciu ir nieko $_POST negrazins, jei negrazina isiraso "N"
	$allow_vote				= 	(isset($_POST['allow_vote']))			?'Y':'N';
	$allow_comment			= 	(isset($_POST['allow_comment']))		?'Y':'N';

	// Punktai kurie visada bus kazkokie pasirinkti
	// Skaicius keik straipsniu rodyti ir kaip juos rusiuoti
	$article_show_num 		= 	$_POST['article_show_num'];
	$article_order_by 		= 	$_POST['article_order_by'];
  	mysql_query("
  					UPDATE `straipsniai_nustatymai`
  					SET
  						`show_cat` 				= '$show_cat',
  						`show_article` 			= '$show_article',
  						`allow_only_see_admin` 	= '$allow_only_see_admin',
  						`allow_send` 			= '$allow_send',
  						`allow_send_email` 		= '$allow_send_email',
  						`allow_write` 			= '$allow_write',
  						`allow_show_email` 		= '$allow_show_email',
  						`allow_show_url` 		= '$allow_show_url',
  						`article_show_num` 		= '$article_show_num',
  						`article_order_by` 		= '$article_order_by',
  						`allow_vote` 			= '$allow_vote',
  						`allow_comment` 		= '$allow_comment'
  	") or die(mysql_error());
}
// KONFIGURACIJA END

// Uzklausa skirta paiimti visus konfig duomenis is straipsniu
// ir paziuret kur kas nustatyta ir taip isvesti
$article_info = mysql_fetch_assoc(mysql_query("SELECT * FROM `straipsniai_nustatymai`")) or die(mysql_error());

$show_cat_checked 				= ($article_info['show_cat'] == 'Y')			?' checked="checked"':'';
$show_article_checked 			= ($article_info['show_article'] == 'Y')		?' checked="checked"':'';
$allow_only_see_admin_checked 	= ($article_info['allow_only_see_admin'] == 'Y')?' checked="checked"':'';
$allow_send_checked 			= ($article_info['allow_send'] == 'Y')			?' checked="checked"':'';
$allow_send_email_checked 		= ($article_info['allow_send_email'] == 'Y')	?' checked="checked"':'';
$allow_write_checked 			= ($article_info['allow_write'] == 'Y')			?' checked="checked"':'';
$allow_show_email_checked 		= ($article_info['allow_show_email'] == 'Y')	?' checked="checked"':'';
$allow_show_url_checked 		= ($article_info['allow_show_url'] == 'Y')		?' checked="checked"':'';
$allow_vote_checked 			= ($article_info['allow_vote'] == 'Y')			?' checked="checked"':'';
$allow_comment_checked 			= ($article_info['allow_comment'] == 'Y')		?' checked="checked"':'';
$article_show_num_checked 		= $article_info['article_show_num'];
$article_order_by_checked 		= $article_info['article_order_by'];


// Sita vieta skirta isvesti rezultatui kuris parodys
// po kiek reikia rodyti straipsniu puslapyje
$a = 5;
while ($a <= 25) {	if ($article_show_num_checked == $a) { $article_show_num_selected = 'selected="selected" '; }
	else { $article_show_num_selected = ''; }	@$article_show_option .= '<option value="' . $a .'" ' . $article_show_num_selected .'>' . $a .'</option>';
	$a = $a + 5;
}
unset($article_show_num_selected,$article_show_num_checked);

// Masyvas skirtas isvesti pagal ka rusiuosime.
$article_order_option = '<option name="from_new_to_old" value="from_new_to_old" '; $article_order_option .= ($article_order_by_checked == 'from_new_to_old')?'selected="selected" ':''; $article_order_option .= '>' . $lang['article_from_new_to_old'] .'</option>';
$article_order_option .= '<option name="from_old_to_new" value="from_old_to_new" '; $article_order_option .= ($article_order_by_checked == 'from_old_to_new')?'selected="selected" ':''; $article_order_option .= '>' . $lang['article_from_old_to_new'] .'</option>';
$article_order_option .= '<option name="by_date" value="by_date" '; $article_order_option .= ($article_order_by_checked == 'by_date')?'selected="selected" ':''; $article_order_option .= '>' . $lang['article_order_by_date'] .'</option>';
$article_order_option .= '<option name="by_join" value="by_join" '; $article_order_option .= ($article_order_by_checked == 'by_join')?'selected="selected" ':''; $article_order_option .= '>' . $lang['article_by_join'] .'</option>';
$article_order_option .= '<option name="by_abc" value="by_abc" '; $article_order_option .= ($article_order_by_checked == 'by_abc')?'selected="selected" ':''; $article_order_option .= '>' . $lang['article_order_by_abc'] .'</option>';

if ($mod_install['vote'] == 'Y') { $article_order_option .= '<option name="by_vote" value="by_vote" ' . ($article_order_by_checked == 'by_vote')?'selected="selected" ':'' .'>' . $lang['article_order_by_vote'] .'</option>'; }

// Isvedamu punktu masyvas (Konfiguracijai)
$article_conf_check = array (
							'<label><input name="show_cat" type="checkbox" id="show_cat" value="show_cat" ' . $show_cat_checked .' />' . $lang['article_show_categories'] .'</label>',
					  		'<label><input name="show_article" type="checkbox" id="show_article" value="show_article" ' . $show_article_checked .' />' . $lang['article_show_new'] .'</label>',
					    	'<label><input name="allow_only_see_admin" type="checkbox" id="allow_only_see_admin" value="allow_only_see_admin" ' . $allow_only_see_admin_checked .' />' . $lang['article_show_only_see_admin'] .'</label>',
					  		'<label><input name="allow_send" type="checkbox" id="allow_send" value="allow_send" ' . $allow_send_checked .' />' . $lang['article_allow_send'] .'</label>',
					    	'<label><input name="allow_send_email" type="checkbox" id="allow_send_email" value="allow_send_email" ' . $allow_send_email_checked .' />' . $lang['article_inform_sebscribers'] .'</label>',
					  		'<label><input name="allow_write" type="checkbox" id="allow_write" value="allow_write" ' . $allow_write_checked .' />' . $lang['article_allow_to_write'] .'</label>',
					  		'<label><input name="allow_show_email" type="checkbox" id="allow_show_email" value="allow_show_email" ' . $allow_show_email_checked .' />' . $lang['article_allow_send_in_email'] .'</label>',
					    	'<label><input name="allow_show_url" type="checkbox" id="allow_show_url" value="allow_show_url" ' . $allow_show_url_checked .' />' . $lang['article_show_url'] .'</label>',
					    	$lang['article_show_num'] . ' <label><select name="article_show_num" class="date"> ' . $article_show_option .' </select></label> ' . $lang['article_per_page'],
					    	$lang['article_order_by'] . ' <label><select name="article_order_by" class="date"> ' . $article_order_option .'</select></lebel> '
					  );

// Patikrinamas Balsavim modulis ar instaliuotas
if (@$mod_install['vote'] == 'Y') {
	array_push($article_conf_check,'<label><input name="allow_vote" type="checkbox" id="allow_vote" value="allow_vote" ' . $allow_vote_checked .' />' . $lang['article_allow_vote'] .'</label>');
}
// Patikrinams komentaru modulis ar instaliuotas.
if (@$mod_install['comment'] == 'Y') {	array_push($article_conf_check,'<label><input name="allow_comment" type="checkbox" id="allow_comment" value="allow_comment" ' . $allow_comment_checked .' />' . $lang['article_allow_comment'] .'</label>');
}
// Konfiguracines lenteles isvedimas
$smarty->assign('table_data',$article_conf_check);

//Atvaizduojam nustatyta faila
$smarty->display("modules/article/article_admin.tpl");
echo "jo";
?>
