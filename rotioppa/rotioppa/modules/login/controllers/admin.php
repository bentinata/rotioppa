<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Sites_Controller{
	function __construct(){  
		parent::__construct(); 
		/* load config */
		$this->load->config('conf_login');
		/* load lang */
		$this->lang->load('login');
		/* load model */
		$this->load->model('login_model', 'lm');

		/* to check system speed and query --> just for admin */
		//$this->output->enable_profiler(TRUE);
	}
	function index(){  #break;
		// cek if has login before
		$this->login_lib->pos_check_has_login();
		/* header description */
		$data['title'] 			= 'Login';
		$data['keyword'] 		= 'Login';
		$data['description'] 	= 'Login';
		$this->template->set_params($data); 
		$this->template->set_layout('blankpage',config_item('modulename_login'));

		/* proses data */
		if($this->input->post('do_login')){ #break;
            $user=$this->input->post('username');
            $pass=$this->input->post('password');
            if(($data=$this->lm->check_admin($user))){
                if($data->password==$pass){
    				$this->login_lib->pos_sess_login($data);
    				redirect('admin');
    			}else{
    		   		errorMsg($this->lang->line('invalid_pass'));
    			}
			}else{
		   		errorMsg($this->lang->line('invalid_user'));
			}
		} #break;
		$this->template->set_view ('form_login_poseidon',false,config_item('modulename_login'));
	}

	function logout(){
		$this->login_lib->pos_logout();
		redirect('admin');
	}
}
?>