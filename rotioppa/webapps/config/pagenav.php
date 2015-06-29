<?
/**
* Page Navigation Helper Config File
**/

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$config['pagenav_page'] = 'page';
$config['pagenav_offset'] = 'limit';
$config['pagenav_counter_text'] = '<div class="%s">Menampilkan <span class="%s">%s</span> - <span class="%s">%s</span> dari <span class="%s">%s</span></div>';
$config['pagenav_pagecounter_text'] = '<div class="%s">Halaman <span class="%s">%s</span> dari <span class="%s">%s</span></div>';

$config['pages']['show_limit'] 	= false;
$config['pages']['limit'] 		= 10;
$config['pages']['num_links'] 	= 3;
$config['pages']['first_text']	= lang("first");			// 'First' Text
$config['pages']['prev_text']	= lang("prev");				// 'Previous' Text
$config['pages']['next_text']	= lang("next");				// 'Next' Text
$config['pages']['last_text']	= lang("last");				// 'Last' Text
$config['pages']['full_class'] 	= 'full-pagenav';
$config['pages']['fnl_class'] 	= 'fnl-pagenav';
$config['pages']['pnn_class']	= 'pnn-pagenav';			// Class for Prev and Next Link
$config['pages']['num_class']	= 'num-pagenav';			// Class for Page Number Links
$config['pages']['cur_class']	= 'cur-pagenav';			// Class for Current Page Number


?>