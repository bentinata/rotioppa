<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Admin_Controller{
	function __construct()
	{
		parent::__construct(); 
		/* load lang */
		#$this->lang->load('poseidon',$this->globals->lang);
		/* load model */
		#$this->load->module_model('login', 'login_model', 'lm');
    $this->lang->load('login');
        /* load model */
        $this->load->model('login_model');
		 // header description 
		$data['title'] 			= config_item('site_title_pos');
		$data['keyword'] 		= config_item('site_keyword_pos');
		$data['description'] 	= config_item('site_desc_pos');
		$this->template->set($data); 
		
	}
	function index()
	{

        if($this->login_lib->pos_check_not_login() == false){
                $data['title']          = 'Login';
            $data['keyword']        = 'Login';
            $data['description']    = 'Login';
            $this->template->set_params($data); 
            $this->template->set_layout('blankpage',config_item('modulename_login'));

            /* proses data */
            if($this->input->post('do_login')){ #break;
                $user=$this->input->post('username');
                $pass=$this->input->post('password');
                if($data=$this->login_model->check_admin($user)){
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
            $this->template->set_view('form_login_poseidon',false,config_item('modulename_login'));
        }else{
      	$this->lang->load('home');
		$this->template->set_view ('home',false,config_item('modulename'));
        }
      
	}
	
    function update_pass()
    {
        $data = false;
        if($this->input->post('_CHANGE_PASS'))
        {
            $this->load->model('info_model','mod');
            
            $oldpass = trim($this->input->post('oldpass'));
            $newpass = trim($this->input->post('newpass'));
            $confpass = trim($this->input->post('confpass'));
                        
            $q = $this->mod->db->get_where('admin',array('username'=>$this->login_lib->pos_get_data('username'),'password'=>$oldpass));
            if($q->num_rows()>0)
            {
                if($newpass==$confpass){
                    $this->mod->db->update('admin',array('password'=>$newpass));
                    $data['ok'] = '1';
                    $data['msg'] = 'Edit berhasil';
                }else
                    $data['msg'] = 'Confirmasi password tidak sama';
            }else
                $data['msg'] = 'Password lama salah';
        }
        $this->template->set_view('password',$data);
    }
}
