<div id="content">
<div id="left">
		  <div class="left_articles">
				<strong>{$article_show.pavadinimas}</strong>
		  </div>
		  <br />
		  {$lang.article_author|default:"Autorius"}: {$article_show.autorius} {$lang.article_date|default:"Data"}: {$article_show.data} <br />
		  {$lang.article_category}:<a href="article/{$article_show.alias}">{$article_show.kategorija}</a><br />
		  {$lang.article_vote|default:"Balsavo"}: {$article_show.balsavimas} {$lang.article_from|default:"ið"} 10 <br />
		  {$article_show.straipsnis}
</div>
</div>
<div id="right">
	{include file="modules/article/article_more.tpl"|default:"none.tpl"}
</div>