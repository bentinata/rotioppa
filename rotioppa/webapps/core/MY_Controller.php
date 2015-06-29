<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();

		//load base libraries, helpers and models
		$this->load->database();

		// load the migrations class & settings model
		$this->load->library('migration');

		if ( ! ($schema_version = $this->migration->current()))
		{
			show_error($this->migration->error_string());
		}

		//load the default libraries
		$this->load->library(array('session','login/login_lib')); 
		$this->load->helper(array('language','system'));

		// load lang from session
		$lang = ci()->curlang = get_lang_session();
		if(!$lang) 
		{
			set_lang_session();
			$lang = ci()->curlang = get_lang_session();
		}
		$this->config->set_item('language',$lang);

		// Work out module, controller and method and make them accessable throught the CI instance
		ci()->module = $this->router->fetch_module();
		ci()->controller = ci()->class = $this->router->fetch_class();
		ci()->method = $this->router->fetch_method();

	}
}

