<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lt" lang="lt">
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="author" content="{$site_title|strip_tags:false}" />
	<base href="{$site_base|strip_tags:false}admin/" />
	<link rel="stylesheet" type="text/css" href="../template/default/style.css" media="screen" />
	<title>{$site_title|strip_tags:false}</title>

	<link rel="stylesheet" href="../js/tab/tab-view.css" type="text/css" media="screen">

	<link rel="stylesheet" href="../js/dtree/css/folder-tree-static.css" type="text/css">
	<link rel="stylesheet" href="../js/imagefx/lightbox.css" type="text/css" media="screen" />

	<link rel="stylesheet" type="text/css" href="../js/modal/style.css" />
	<link rel="stylesheet" type="text/css" href="../js/modal/subModal.css" />

	<script type="text/javascript" src="../js/tab/ajax.js"></script>
	<script type="text/javascript" src="../js/tab/tab-view.js">

	<script type="text/javascript" src="../js/dtree/ajax.js"></script>
	<script type="text/javascript" src="../js/dtree/folder-tree-static.js"></script>
	<script type="text/javascript" src="../js/dtree/context-menu.js"></script>

	<script src="../js/imagefx/prototype.js" type="text/javascript"></script>
	<script src="../js/imagefx/scriptaculous.js?load=effects" type="text/javascript"></script>
	<script src="../js/imagefx/lightbox.js" type="text/javascript"></script>

	<script language="javascript" type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>

	<script type="text/javascript" src="../js/modal/common.js"></script>
	<script type="text/javascript" src="../js/modal/subModal.js"></script>
</head>
<body>

<div id="content">
<div id="logo">
	{include file="admin/admin_header.tpl"}
</div>
<div class="left_articles" style="border:1px solid silver;width:200px;float:left;margin:5px">
	<form name="tree_menu_main" action="" method="post">
		<img onClick="showPopWin('tree_menu_add.php', 400, 200, null);" src="../images/dtree/add_folder.png" name="tree_menu_add">
		<input onclick="" type=image src="../images/dtree/edit_folder.png" name="tree_menu_edit">
		<input type=image src="../images/dtree/delete_folder.png" name="tree_menu_delete">
	</form>
	<div style="border:1px solid silver; background-color: #CCFFCC; font-size:9pt">
		<ul id="dhtmlgoodies_tree" class="dhtmlgoodies_tree"></ul>
		<ul id="dhtmlgoodies_tree2" class="dhtmlgoodies_tree">
		{$tree_data}
		</ul>
	</div>
</div>
<div id="right" style="float:left;width:700px;border:1px solid silver;margin:5px">

