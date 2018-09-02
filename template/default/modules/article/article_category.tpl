{if not $article_cat}
{else}
	<div class="left_articles">
		<h2>{$lang.article_categories}</h2>
		<p>&nbsp;</p>
	</div>
	<div style="width:600px">
		{section name=article_more loop=$article_cat}
		  	<div style="width:200px; float:left" align="center"><img src="{$style}images/arrow.gif" class="middle"></img> <a href="article/{$article_cat[article_more].alias}">{$article_cat[article_more].kategorija} ({$article_cat[article_more].total})</a></div>
		{/section}
	</div>
{/if}