<div class="left_articles"><h2>{$lang.admin_menu|default:"Admin Menu"}</h2>
	<div id="dhtmlgoodies_tabView1" style="width:700px">
		<div class="dhtmlgoodies_aTab">
			{section name=mod_install_more loop=$mod_install}
				<div class="blokas"><center><a href="{$mod_install[mod_install_more].alias}/"><img src="../{$mod_install[mod_install_more].logo}" alt="config" />{$mod_install[mod_install_more].lang}</a></center></div>
			{/section}	
		</div>
		<div class="dhtmlgoodies_aTab">
			{section name=mod_free_more loop=$mod_free}
				<div class="blokas"><center><a href="{$mod_free[mod_free_more].alias}/"><img src="../{$mod_free[mod_free_more].logo}" alt="config" />{$mod_free[mod_free_more].lang}</a></center></div>
			{/section}	
		</div>
		<div class="dhtmlgoodies_aTab">
			{section name=mod_system_more loop=$mod_system}
				<div class="blokas"><center><a href="{$mod_system[mod_system_more].alias}/"><img src="../{$mod_system[mod_system_more].logo}" alt="config" />{$mod_system[mod_system_more].lang}</a></center></div>
			{/section}	
		</div>
		<div class="dhtmlgoodies_aTab">
			{section name=mod_not_more loop=$mod_not}
				<div class="blokas"><center><a href="{$mod_not[mod_not_more].alias}/"><img src="../{$mod_not[mod_not_more].logo}" alt="config" />{$mod_not[mod_not_more].lang}</a></center></div>
			{/section}	
		</div>
	</div>	
</div>

<!-- Sios dalies nekeisti niekada -->
<script type="text/javascript">
initTabs(
	'dhtmlgoodies_tabView1',
	Array(
		'Naudojami moduliai ',
		'Nenaudojami moduliai',
		'Sisteminiai moduliai',
		'Neinstaliuoti moduliai'	
	),
	0,
	650,
	300
);
</script>
