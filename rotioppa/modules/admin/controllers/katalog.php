<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Katalog extends Admin_Controller{
	function __construct(){
		parent::__construct(); 
		// load model 
		$this->load->model('katalog_model', 'km');
		// load def lang
		$this->lang->load('defkatalog');
	}
	function index()
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->km->list_kat(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_kat'] = $this->km->list_kat($limitstart,$pg['limit']);
		$this->template->set_view ('katalog',$data,config_item('modulename'));
	}
	function edit($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$kat = $this->input->post('kat');
			if($this->km->update_kat($id,$kat)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		
		$data['detail_kat'] = $this->km->detail_kat($id);
		$this->template->set_view ('katalog_edit',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->km->delete_kat($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function input()
	{
		if($this->input->post('_INPUT')){
			$id = $this->input->post('id');
			$kat = $this->input->post('kat');
			if($this->km->input_kat($id,$kat)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}
		}
		$data['input'] = true;
		$data['id'] = $this->km->get_max_id();
		$this->template->set_view ('kategori_edit',$data,config_item('modulename'));
	}
	
	

	
	


}
