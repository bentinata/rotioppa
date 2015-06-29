<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Test extends Controller{
	function Test(){  
		parent::Controller(); 
		/* load config */
		#$this->load->config('config_home');
		/* load lang */
		#$this->lang->load('home',$this->globals->lang);
		/* load model */
		$this->load->module_model('home', 'test_model', 'tm');
		
		/* header description */
		#$data['title'] 			= config_item('site_title');
		#$data['keyword'] 		= config_item('site_keyword');
		#$data['description'] 	= config_item('site_desc');
		#$this->template->set_params($data);
		#$this->template->set_layout();

		// load page component
		//--------------------

		// load model global
		#$this->load->model('global_model', 'gm');
		
		// component top search box
		#$var['option_kat'] = $this->gm->option_kat();
		#$this->template->load_view( 'temp/top-search-box',$var,false,'pg_search');
		
		// component top sidebar
		#$var['list_kat_sub'] = $this->gm->get_kat_sub();
		#$this->template->load_view( 'temp/top-sidebar',$var,false,'pg_topbar');

		// cart count
		#$cart['count_cart'] = $this->gm->count_cart($this->globals->user_global,$this->login_lib->m_get_data('id'));
		#$this->template->set_params($cart); 
		
		/* to check system speed and query --> just for admin */
		#$this->output->enable_profiler(TRUE);
	}
	function index(){ 
		$this->load->library('encrypt');
		echo $this->encrypt->encode('admin').'<br />';
		echo $this->encrypt->decode('RDI5WWFnWnNVenhTYmc9PQ--');
	}
	function get_time_db(){
		if(!defined('RUN_IN_CRON')) die('not in cron');
		$dt = $this->tm->get_time();
		print_r($dt);
	}
}
