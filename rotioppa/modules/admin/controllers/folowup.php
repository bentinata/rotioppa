<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Folowup extends Admin_Controller{
	function __construct(){
		parent::__construct();
		// load model
		$this->load->model('fu_model', 'fm');
		// load def lang
		$this->lang->load('deffu');

	}

	function index()
	{
		$data['code_mail_from_config']=config_item('mail_config');
		$data['list_mail']=$this->fm->list_mail();
		$this->template->set_view ('fu_list',$data,config_item('modulename'));
	}
	function edit($id)
	{ 
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$type = $this->input->post('type_email');
            $sub = $this->input->post('subject');
            $msg = $this->input->post('email');
            $status = $this->input->post('status_email');
			if($this->fm->update_mail($id,$type,$sub,$msg,$status)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		$code_mail_from_config=config_item('mail_config');
		$data['detail_mail']=$this->fm->detail_mail($id);
		$data['for_mail_current']=$code_mail_from_config[$data['detail_mail']->code_email];
		$this->template->set_view ('fu_edit',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->fm->delete_mail($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function input()
	{
		$data['input']=TRUE;
		if($this->input->post('_INPUT')){
			$type = $this->input->post('type_email');
            $sub = $this->input->post('subject');
            $msg = $this->input->post('email');
            $status = $this->input->post('status_email');
            $mailfor = $this->input->post('email_for');
			if($this->fm->input_mail($type,$sub,$msg,$status,$mailfor)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}
		}
		$mail_has_used = $this->fm->mail_has_used(); 
		$code_mail_from_config=config_item('mail_config');
		$code_yg_belum_terpakai=array_diff_assoc($code_mail_from_config,$mail_has_used);
		$data['code_mail']=$code_yg_belum_terpakai; 
		$this->template->set_view ('fu_edit',$data,config_item('modulename'));
	}

	function test($id=false)
	{
		$this->template->clear_layout();
		if($this->input->post('_SEND')){
			$email = $this->input->post('email');
			$tonama = 'bySystem';
			$link = '';
            $this->load->library('mail_lib');
            
            if($this->mail_lib->confirm_buletin($email,$tonama,$link))
				echo 'Send mail success.';
			else
				echo 'Send mail error.';
			die();
		}
		$this->template->set_view ('fu_test_mail',false,config_item('modulename'));
	}
}
