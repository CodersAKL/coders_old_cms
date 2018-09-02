<!-- Redaktoriaus isvedimo pradzia -->
		<div class="left_articles" style="height:400px"><h2>Puslapiø redaktorius</h2>
			<div id="dhtmlgoodies_tabView1" style="width:700px">
				{section name=editor_more loop=$editor}
					<div class="dhtmlgoodies_aTab">
						{$editor[editor_more].editor}	
					</div>
				{/section}
			</div>
		</div>
<!-- Redaktoriaus isvedimo pabaiga -->

<!-- Sios dalies nekeisti niekada -->
<script type="text/javascript">
initTabs(
	'dhtmlgoodies_tabView1',
	Array(	
		{section name=tab_editor loop=$editor}
			{if $editor[tab_editor].last eq "no"}
				'{$editor[tab_editor].img}{$editor[tab_editor].title} ',
			{else}
				'{$editor[tab_editor].img}{$editor[tab_editor].title} '	
			{/if}
		{/section}
	),
	1,
	650,
	500
);
</script>
