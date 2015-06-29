<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Vendor extends Admin_Controller{
	function __construct(){
		parent::__construct();
		// load model
		$this->load->model('vendor_model', 'vm');
		// load def lang
		$this->lang->load('defvendor');
		
	}
	function index()
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->vm->list_vendor(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_kat'] = $this->vm->list_vendor($limitstart,$pg['limit']);
		$this->template->set_view ('vendor',$data,config_item('modulename'));
	}
	function edit($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$kat = $this->input->post('vendor');
			if($this->vm->update_vendor($id,$kat)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}

		$data['detail_kat'] = $this->vm->detail_vendor($id);
		$this->template->set_view ('vendor_edit',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->vm->delete_vendor($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function input()
	{
		if($this->input->post('_INPUT')){
			$kat = $this->input->post('vendor');
			if($this->vm->input_vendor($kat)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}
		}
		$data['input'] = true;
		$this->template->set_view ('vendor_edit',$data,config_item('modulename'));
	}
	
	function vcode($id=false)
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->vm->list_vcode($id,false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/'.$id;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_sub'] = $this->vm->list_vcode($id,$limitstart,$pg['limit']);
		$this->template->set_view ('vendor_kode',$data,config_item('modulename'));
	}
	function vcodeedit($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$kat = $this->input->post('vendor');
			$subkat = $this->input->post('vcode');
			if($this->vm->update_vcode($id,$kat,$subkat)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		$data['kat'] = $this->vm->option_vendor();
		$data['detail_subkat'] = $this->vm->detail_vcode($id);
		$this->template->set_view ('vendor_kode_edit',$data,config_item('modulename'));
	}
	function vcodedelete($id=false,$idkat=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->vm->delete_vcode($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class.'/vcode');
	}
	function vcodeinput()
	{
		if($this->input->post('_INPUT')){
			$kat = $this->input->post('vendor');
			$subkat = $this->input->post('vcode');
			// cek dahulu
			if(!$this->vm->cek_code_vendor($kat,$subkat)){
				if($this->vm->input_vcode($kat,$subkat)){
					$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/vcode/'.$kat));
				}else{
					$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/vcode/'.$kat));
				}
			}else{
				$data['ok'] = false;$data['msg'] = lang('vcode_has_input');
			}
		}
		$data['kat'] = $this->vm->option_vendor();
		$data['input'] = true;
		$this->template->set_view ('vendor_kode_edit',$data,config_item('modulename'));
	}
}
