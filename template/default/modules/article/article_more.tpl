<div class="right_articles">
	{if not $allow_send}
	
	{else}
		<img src="{$style}images/arrow.gif" class="middle"></img> <a href="article/send">{$allow_send}</a><br />
	{/if}
	{if not $allow_write}
	
	{else}
		<img src="{$style}images/arrow.gif" class="middle"></img> <a href="article/write">{$allow_write}</a><br />
	{/if}
	{if not $allow_send_email}
	
	{else}
		<img src="{$style}images/arrow.gif" class="middle"></img> <a href="article/send_email">{$allow_send_email}</a><br />
	{/if}
	{if not $allow_show_url}
	
	{else}
		<img src="{$style}images/arrow.gif" class="middle"></img> <a href="article/show_url">{$allow_show_url}</a><br />
	{/if}
</div>

{if not $show_categories}
{else}
	{if not $article_cat_more}
	{else}
		<div class="right_articles">
			{section name=article_more loop=$article_cat_more}
		  		<img src="{$style}images/arrow.gif" class="middle"></img> <a href="article/{$article_cat_more[article_more].alias}">{$article_cat_more[article_more].kategorija} ({$article_cat_more[article_more].total})</a><br />
			{/section}
		</div>
	{/if}	
{/if}

{if not $show_article_info}
{else}
	{if not $article_cat_more}
	{else}
		<div class="right_articles">
			{section name=article_more loop=$article_cat_more}
		  		<img src="{$style}images/arrow.gif" class="middle"></img> <a href="article/{$article_cat_more[article_more].alias}">{$article_cat_more[article_more].kategorija} ({$article_cat_more[article_more].total})</a><br />
			{/section}
		</div>
	{/if}	
{/if}


