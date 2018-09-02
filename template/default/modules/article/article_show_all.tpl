<div id="content">
{if not $article_all}

{else}
	<div id="left">
		  <div class="left_articles">
		  {section name=article_more loop=$article_all}
		  	<a href="article/{$article_all[article_more].kat_alias}/{$article_all[article_more].alias}">{$article_all[article_more].pavadinimas}</a> {$lang.article_vote}: {$article_all[article_more].balsavimas} {$lang.article_from} 10<br />
			{$lang.article_author}: <i>{$article_all[article_more].autorius} </i> {$lang.article_date}: <i>{$article_all[article_more].data}</i> <br />
			{$article_all[article_more].aprasymas}<br /><br />
		 {/section}
             </div>
	</div>
{/if}
</div>
<div id="right">
	{include file="modules/article/article_more.tpl"|default:"none.tpl"}
</div>
