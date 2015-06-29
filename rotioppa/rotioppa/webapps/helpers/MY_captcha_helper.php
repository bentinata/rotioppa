<?php

function generate_captcha($word=false,$width=100,$height=26,$expire=1800)
{
	$CI =& get_instance();
	$vals = array(
				'img_path' => './'.config_item('upload_path').'/captcha/',
				'img_url' => base_url(config_item('upload_path').'/captcha').'/',
				'img_width' => $width,
				'img_height' => $height,
				'expiration' => $expire
			); 

	if(!empty($word))
	{
		$vals = array_merge(array('word'=>strtolower($word)),$vals);
	}
	$cap = create_captcha($vals);
	$CI->session->set_userdata(array(SESS_CAPCHA=>$cap['word'],SESS_CAPTIME=>$cap['time']));
	return $cap;
}
function sess_captcha_time()
{
	$CI =& get_instance();
	return $CI->session->userdata(SESS_CAPTIME);
}
function sess_captcha_word()
{
	$CI =& get_instance();
	return $CI->session->userdata(SESS_CAPCHA);
}
function validate_captcha($word='')
{
	if(empty($word)) return false;
	if(strtolower($word)==strtolower(sess_captcha_word())) return true;
	return false;
}
