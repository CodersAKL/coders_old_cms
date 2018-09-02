
	<div id="content">
	  <div id="left">
			<div class="subheader">
				<p>{include file=$mods.sms|default:"none.tpl"}</p>
			</div>
			<!-- Pagrindine naujiena -->
		  	<div class="left_articles" align="justify">
				<h2><a href="news/{$news[0].alias}/">{$news[0].pavadinimas|default:"Nėra pavadinimo"}</a></h2>
				<p class="date"><a href="user/{$news[0].autorius}">{$news[0].autorius|default:"N/A"}</a> {$news[0].data|default:"N/A"}</p>
				<img src="{$news[0].image|default:"template/default/images/image.gif"}" class="bigimage"/>
				<p>
				{if $news[0].naujiena|@count_characters gt 500}
					{$news[0].naujiena|nl2br|wordwrap:100:"\n"|truncate:500|links:all|bbcode|default:"Nėra teksto"} <a href="news/{$news[0].alias}/">Skaityti toliau...</a>
				{else}
					{$news[0].naujiena|nl2br|links:all|wordwrap:100:"\n"|bbcode|default:"Nėra teksto"}
				{/if}
				</p>
				<br style="clear:left"/>
		  	</div>
		  	<!-- pagrindines naujienos pabaiga -->
		  	
			{section name=more_news loop=4 start=1 }
			<div class="thirds" align="justify">
				<p><b><a href="news/{$news[more_news].alias}/" class="title">{$news[more_news].pavadinimas|truncate:50}</a></b><br />
			    {if $news[more_news].naujiena|@count_characters gt 200}
					{$news[more_news].naujiena|truncate:200|wordwrap:30|links} <a href="news/{$news[more_news].alias}/">Plačiau...</a>
				{else}
					{$news[more_news].naujiena|wordwrap:30:"\n":true|links}
				{/if}
				</p>
		    </div>
		  	{/section}
	  </div>	
	  	
		<div id="right">
			{include file=$mods.right|default:"none.tpl"}
		</div>
		
</div>
