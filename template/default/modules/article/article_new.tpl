{if not $article_new}

{else}
	<div class="left_articles">
		{section name=article_more loop=$article_new}
		  	<a href="article/{$article_new[article_more].kat_alias}/{$article_new[article_more].alias}">{$article_new[article_more].pavadinimas}</a><br />
			{$lang.article_author}: <i>{$article_new[article_more].autorius} </i> {$lang.article_date}: <i>{$article_new[article_more].data}</i><br />
			{$lang.article_category}:<a href="article/{$article_new[article_more].kat_alias}">{$article_new[article_more].kategorija}</a><br /><br />
		{/section}
	</div>
{/if}