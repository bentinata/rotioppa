<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		// set default timezone for all acsess
		date_default_timezone_set('Asia/Jakarta');

		// load helper
		$this->load->helper(array('form','url','func','language'));
		$this->lang->load('globals');

        #if(ci()->controller=='reg')
        #$this->login_lib->pos_check_has_login();
        #else
        if($this->uri->segment(2) !="" and 
        $this->login_lib->pos_check_not_login() == false){
        	redirect("admin");
		}
		// template config
		$this->load->library(array('template'));
		$this->template->add_theme_location(config_item('theme_path').'/');
		
		ci()->curtheme = config_item('admin_theme_name');
		
		// Template configuration
		$this->template
			->enable_parser(false)
			->set('title',config_item('admin_site_title'))
			->set('keyword',config_item('admin_site_keyword'))
			->set('description',config_item('admin_site_desc'))
			->set_theme(ci()->curtheme)
			->set_partial('menu','menu')
			->set_layout('index');
	}

	private function _check_access()
	{
		// These pages get past permission checks
		$ignored_pages = array('admin/login', 'admin/logout', 'admin/help');

		// Check if the current page is to be ignored
		$current_page = $this->uri->segment(1, '') . '/' . $this->uri->segment(2, 'index');

		// Dont need to log in, this is an open page
		if (in_array($current_page, $ignored_pages))
		{
			return true;
		}

		if ( ! $this->current_user)
		{
			// save the location they were trying to get to
			$this->session->set_userdata('admin_redirect', $this->uri->uri_string());
			redirect('admin/login');
		}

		// Admins can go straight in
		if ($this->current_user->group === 'admin')
		{
			return true;
		}

		// Well they at least better have permissions!
		if ($this->current_user)
		{
			// We are looking at the index page. Show it if they have ANY admin access at all
			if ($current_page == 'admin/index' && $this->permissions)
			{
				return true;
			}

			// Check if the current user can view that page
			return array_key_exists($this->module, $this->permissions);
		}

		// god knows what this is... erm...
		return false;
	}

}
