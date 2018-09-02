;<? exit();?>
[info]
name="Editor"
version="v0.1"
about="Redaktoriaus valdymas"
url=""
icon="images/admin/plugins.gif"
system="system"

[db]
table = "
CREATE TABLE `straipsniai` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `alias` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `aprasymas` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `straipsnis` longtext character set utf8 collate utf8_unicode_ci NOT NULL,
  `autorius` varchar(25) character set utf8 collate utf8_unicode_ci NOT NULL,
  `data` date NOT NULL,
  `kategorija_id` int(11) NOT NULL,
  `aktyvus` varchar(1) character set utf8 collate utf8_unicode_ci NOT NULL default 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
CREATE TABLE `straipsniai_kategorijos` (
  `id` int(11) NOT NULL,
  `kategorija` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  `alias` varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
"
insert = "
INSERT INTO `straipsniai` VALUES (0, 'dfsd', '', 'dfsdfsd', 'dsfsdfsd', 'dfsdfsdfsd', '2007-04-01', 0, 'Y');
INSERT INTO `straipsniai` VALUES (0, 'dfgsdgdf', '', 'fgsfgs', 'fgsfgsf', 'fsgsfgsf', '2007-04-01', 1, 'Y');
INSERT INTO `straipsniai_kategorijos` VALUES (0, 'PHP Straipsniai', 'php');
INSERT INTO `straipsniai_kategorijos` VALUES (1, 'JavaScript straipsniai', 'javascript');
"
update = ""

[files]
admin="editor_admin.php"
main="editor_main.php"
