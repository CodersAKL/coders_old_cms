<div class="left_articles">
	<fieldset>
	<legend>{$lang.article_config|default:"Konfigûracija"}</legend>
			<form id="article_main" method="post" action="">
				{html_table loop=$table_data cols=2 table_attr='border="0" width="100%"'}
				<center><input name="article_config" type="submit" value="{$lang.article_save}"></center>
           		</form>
	</fieldset>
</div>
	