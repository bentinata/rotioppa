<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Broadcast extends Admin_Controller{
	function __construct(){
		parent::__construct();
		// load model
		$this->load->model('bcast_model', 'bm');
		// load def lang
		$this->lang->load('defbcast');

	}

	function index()
	{
		$data['list_mail']=$this->bm->list_mail();
		$data['list_to']=config_item('bcast_to');
		$this->template->set_view ('bcast',$data,config_item('modulename'));
	}
	function edit($id)
	{
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$to = implode(',',$this->input->post('bcast_cek'));
            $sub = $this->input->post('subject');
            $msg = $this->input->post('mail');
			if($this->bm->update_mail($id,$to,$sub,$msg)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		$data['detail_mail']=$this->bm->detail_mail($id);
		$this->template->set_view ('bcast_edit',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->bm->delete_mail($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function input()
	{
		$data['input']=TRUE;
		if($this->input->post('_INPUT')){
			$to = implode(',',$this->input->post('bcast_cek'));
            $sub = $this->input->post('subject');
            $msg = $this->input->post('mail');
			if($this->bm->input_mail($to,$sub,$msg)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}
		}
		$this->template->set_view ('bcast_edit',$data,config_item('modulename'));
	}

	function stop($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->bm->proses_mail($id,2)){
			java_alert(lang('stop_ok'));
		}else java_alert(lang('stop_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function proses($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		// cek sudah ada antrian atau belum
		$detail=$this->bm->detail_mail($id);
		$count=false;
		if($detail->proses=='2' && empty($detail->antri) && empty($detail->success))
		{
			$idto=explode(',',$detail->to);
			foreach($idto as $to)
			{
				$this->bm->insert_queue($detail->id,$to);
			}
			$count=true; // for queue antri
		}
		
		if($this->bm->proses_mail($id,'1',$count)){
			java_alert(lang('proses_ok'));
		}else java_alert(lang('proses_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}

}
