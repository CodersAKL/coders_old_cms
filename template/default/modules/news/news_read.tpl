
	<div id="content">
	  <div id="left">
			<div class="subheader">
				<p>{include file=$mods.sms|default:"none.tpl"}</p>
			</div>
			<!-- Pagrindine naujiena -->
		  	<div class="left_articles" align="justify">
				<h2><a href="news/">{$news.pavadinimas|default:"Nėra pavadinimo"}</a></h2>
				<p class="date"><a href="user/{$news.autorius|default:'/'}">{$news.autorius|default:"N/A"}</a> {$news.data|default:"N/A"}</p>
					{html_image file=$news.image class="bigimage"}
				<p>
					{$news.naujiena|nl2br|links:all|wordwrap:100:"\n"|bbcode|default:"Nėra teksto"}
				</p>
				<br style="clear:left"/>
		  	</div>
		  	<!-- pagrindines naujienos pabaiga -->
		  	
	  </div>	
	  	
		<div id="right">
			{include file=$mods.right|default:"none.tpl"}
		</div>
		
</div>
