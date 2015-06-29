<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Returns the CodeIgniter object.
 *
 * Example: ci()->db->get('table');
 *
 * @return \CI_Controller
 */
function ci()
{
	return get_instance();
}

// language session
function set_lang_session($lang='')
{
	$CI =& get_instance();
	$thelang = empty($lang)?$CI->config->item('language'):$lang;
	$CI->session->set_userdata('_SESS_LANG',$thelang);
}
function get_lang_session()
{
	$CI =& get_instance();
	return $CI->session->userdata('_SESS_LANG');
}
