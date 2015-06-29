<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Code here is run before the site manager controllers
class Sites_Controller extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();

		// set default timezone for all acsess
		date_default_timezone_set('Asia/Jakarta');

		// for construction only
		if(CONSTRUCTION==TRUE && $this->controller!='construction')
		{
			$isbeta = $this->session->userdata('_IS_BETA');
			if($isbeta=='true'){}else
			redirect('construction');
		}
		elseif(CONSTRUCTION==FALSE)
		{
			// remove beta session if needed
			$this->session->unset_userdata(SESS_BETA);
		}
		
		// set user id for global
		$theid = $this->session->userdata('_GLOBAL_USER');
		if(!$theid)
		{
			$rand = mt_rand().time();
			$this->session->set_userdata('_GLOBAL_USER',$rand);
			$theid = $rand;
		}
        ci()->globals = new stdClass();
		ci()->globaluser = $theid;
        ci()->globals->user_global = $theid; // sama dengan diatas

		// load helper
		$this->load->helper(array('form','url','func'));

		// template config
		$this->load->library(array('template'));
		$this->template->add_theme_location(config_item('theme_path').'/');
		
		ci()->curtheme = config_item('theme_name');
		
		// Template configuration
		$this->template
			->enable_parser(false)
			->set('title',config_item('site_title'))
			->set('keyword',config_item('site_keyword'))
			->set('description',config_item('site_desc'))
			->set_theme(ci()->curtheme)
			->set_layout('index');

		// load model utama
		// $this->load->model('home/global_model', 'gm');

		// // component top sidebar
		// $var['list_kat_sub'] = $this->gm->get_kat_sub();
		// $var['list_katalog'] = $this->gm->get_katalog();
		// $var['cats']		 = $this->gm->get_menu();
		// $var['more']		 = $this->gm->get_menu_more();
		
		$this->template
			->append_metadata(theme_css('top-sidebar.css'))
			->set_partial( 'pg_topbar','top-sidebar');

       // hitung cart
        // $this->template->set('count_cart',$this->gm->count_cart($theid,$this->login_lib->m_get_data('id')));
	}
}