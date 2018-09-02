		<div class="left_articles"><h2>Kalbų redagavimas</h2>
			<form name="lang_main" action="" method="post">
				<table border='0' width='100%'>
					<tr>
						<td width="50%" rowspan="2" valign="top">
							{html_table loop=$table_data cols=$table_th|default:"none" td_attr=$table_td tr_attr=$table_tr table_attr="style='width:100%;' border='0' cellpadding='5' cellspacing='0'"}
						</td>
						<td valign="top">
							{html_table loop=$table_conf_data cols=$table_conf_th|default:"none" td_attr=$table_conf_td tr_attr=$table_conf_tr table_attr="style='width:100%;' border='0' cellpadding='5' cellspacing='0'"}	
						</td>
					</tr>
					<tr>
						<td valign="top">
							{html_table loop=$table_edit_data cols=$table_edit_th|default:"none" td_attr=$table_edit_td tr_attr=$table_edit_tr table_attr="style='width:100%;' border='0' cellpadding='' cellspacing='0'"}	
						</td>
					</tr>
				</table>
				{if isset($lang_pages)}
				<center>{$lang.pages}: {$lang_pages}</center>
				{/if}
				
				{if isset($lang_data)}
				{html_table loop=$lang_data cols=$lang_th|default:"none" td_attr=$lang_td tr_attr=$lang_tr table_attr="style='width:100%;' border='0' cellpadding='' cellspacing='0'"}    
				<center><input name="lang_edit_save" type="submit" value="{$lang.button_save}"></center>
				{/if}
			</form>
		</div>
