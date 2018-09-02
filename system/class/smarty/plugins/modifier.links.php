<?php

/**
 * Smarty plugin
 * ------------------------------------------------------------
 * Type:     modifier
 * Name:     ng_autolink
 * Purpose:  replaces urls and email addresses with links
 * ------------------------------------------------------------
 **/
function smarty_modifier_links($string, $esc_type = 'all')
{
    switch ($esc_type) {
        case 'url':
            // replace urls with links
            $string = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
                      "<a href=\"\\0\" target=\"_blank\">\\0</a>", $string);
            return $string;
            
        case 'email':
            // replace email with links
            $string = ereg_replace("[^<>[:space:]]+[[:alnum:]/]@[^<>[:space:]]+[[:alnum:]/]",
                      "<a href=\"mailto:\\0\" target=\"_blank\">\\0</a>", $string);
            return $string;

        case 'all':
        default:
            // replace urls with links
            $string = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
                      "<a href=\"\\0\" target=\"_blank\">\\0</a>", $string);
            // replace email with links
            $string = ereg_replace("[^<>[:space:]]+[[:alnum:]/]@[^<>[:space:]]+[[:alnum:]/]",
                      "<a href=\"mailto:\\0\" target=\"_blank\">\\0</a>", $string);
            return $string;
    }
}

?>
