<?php

// Prisijungimas prie IRC class'es includinimas
include_once('SmartIRC.php');

// class'e skaiciuojati zodzius, sudaranti statistika
include_once('top10.class.php');

// class'e skirta isversti zodzius.
include_once('translate.class.php');

// class skirta TV rodymui infos
include_once('tv.class.php');


// Klase skirta bendrauti su botu
class botas {
    function logout(&$irc, &$data) {
    	$irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': kill me :( By Bye all!');
        $irc->disconnect();
    }
}



// KOnfiguraciniai duomenys prisijungimui
$host = "irc.data.lt";
$port = 6667;
$nick = "CodeRS[Bot]";
$chan = "#CodeRS";

$bot = new botas();

// Class sudaranti statistika
$top10 = new top10();

// Class modulis skirtas vertimui
$translate = new translate();

// Class TV laidom info
$tv = new tv();

// Prisijungimo prie IRC class
$irc = new Net_SmartIRC( );
$irc->setUseSockets( TRUE );

// Vykdome kokia nors komanda
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.logout', $bot, 'logout');

// Vertimo funkcija
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.trans', $translate, 'versti');

// Televizijos informacija ka rodo siuo metu
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.lnk', $tv, 'lnk');
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.ltv', $tv, 'ltv');
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.tv3', $tv, 'tv3');
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.btv', $tv, 'btv');
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.tango', $tv, 'tango');
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.ltv2', $tv, 'ltv2');
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.tv1', $tv, 'tv1');
// Top10 zodzius skaiciuoja ir grazina statistika

$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.stats', $top10, 'stats');
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^.top10', $top10, 'top10_stat');
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '', $top10, 'count');

// Prisijungimas prie IRC Serverio
$irc->connect( $host, $port );
$irc->login( $nick, 'CodeRS PHP Bot', 0, $nick );
$irc->join( array( $chan ) );
$irc->listen( );
$irc->disconnect( );
?>
