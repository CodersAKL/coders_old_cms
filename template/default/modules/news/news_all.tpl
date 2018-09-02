
	<div id="content">
	  <div id="left">
			<div class="subheader">
				<p>{include file=$mods.sms|default:"none.tpl"}</p>
			</div>
			<!-- Pagrindine naujiena -->
		  	<div class="left_articles" align="justify">
		  	
				<div class="subheader">
					<h2>Naujienų archyvas</h2>
				</div>

				<div class="left_articles" style="margin:0">
			{section name=arch_id loop=$news }
				<p class="date"> {$news[arch_id].data|default:"N/A"} :: <a href="news/{$news[arch_id].alias|default:''}">{$news[arch_id].pavadinimas|default:'Be pavadinimo'}</a></p>
				<p>
					{* if isset($news[arch_id].image)}{html_image file=$news[arch_id].image class="image"}{/if *}
					<b>{$news[arch_id].naujiena|default:"Nera teksto"|truncate:100|links:all|bbcode}</b>
				</p>
				<hr/>
		  	{/section}
				</div>
		  	</div>
		  	<!-- pagrindines naujienos pabaiga -->
		  	
	  </div>	
	  	
		<div id="right">
			{include file=$mods.right|default:"none.tpl"}
		</div>
		
</div>
