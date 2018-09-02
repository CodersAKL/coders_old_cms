<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lt" lang="lt">
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="author" content="{$site_title|strip_tags:false}" />
	<meta name="description" content="{$site_apie|strip_tags:false}" />
	<meta name="keywords" content="{$site_keywords|strip_tags:false}" />	
	<base href="{$base}" />
	<link rel="stylesheet" type="text/css" href="template/default/style.css" media="screen" />
	<title>{$site_title|strip_tags:false}</title>
</head>
<body>
	<div id="content">
	  <div id="logo">
			{include file="header.tpl"}
		</div>
				{include file=$mods.content|default:"none.tpl"}
		<div id="footer">
			{include file="footer.tpl"}
		</div>
	</div>
</body>
</html>