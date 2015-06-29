<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Kategori extends Admin_Controller{
	function __construct(){
		parent::__construct(); 
		// load model 
		$this->load->model('kategori_model', 'km');
		// load def lang
		$this->lang->load('defkategori');
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
		$this->template->set_view ('kategori',$data,config_item('modulename'));
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
		$this->template->set_view ('kategori_edit',$data,config_item('modulename'));
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
	
	function sub($id=false)
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->km->list_sub($id,false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_sub'] = $this->km->list_sub($id,$limitstart,$pg['limit']);
		$this->template->set_view ('kategori_sub',$data,config_item('modulename'));
	}
	function subedit($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$kat = $this->input->post('kat');
			$subkat = $this->input->post('subkat');
			if($this->km->update_subkat($id,$kat,$subkat)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		$data['kat'] = $this->km->option_kat();
		$data['detail_subkat'] = $this->km->detail_subkat($id);
		$this->template->set_view ('kategori_sub_edit',$data,config_item('modulename'));
	}
	function subdelete($id=false,$idkat=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->km->delete_subkat($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class.'/sub');
	}
	function subinput()
	{
		if($this->input->post('_INPUT')){
			$id = $this->input->post('id');
			$kat = $this->input->post('kat');
			$subkat = $this->input->post('subkat');
			if($this->km->input_subkat($id,$kat,$subkat)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/sub/'.$kat));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/sub/	'.$kat));
			}
		}
		$data['kat'] = $this->km->option_kat();
		$data['input'] = true;
		$data['id'] = $this->km->sub_get_max_id();
		$this->template->set_view ('kategori_sub_edit',$data,config_item('modulename'));
	}

	function option_sub(){
		$this->template->clear_layout();
		$idkat = $this->input->post('kat'); 
		$listsub = $this->km->option_sub($idkat,true);
		$res='';
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}
		echo $res;
	}
	function sub2($id=false)
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->km->list_sub2($id,false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_sub'] = $this->km->list_sub2($id,$limitstart,$pg['limit']);
		$this->template->set_view ('kategori_sub2',$data,config_item('modulename'));
	}
	function subedit2($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$subkat = $this->input->post('subkat');
			$subkat2 = $this->input->post('subkat2');
			if($this->km->update_subkat2($id,$subkat,$subkat2)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		$data['kat'] = $this->km->option_kat();
		$data['detail_subkat'] = $this->km->detail_subkat2($id);
		$this->template->set_view ('kategori_sub2_edit',$data,config_item('modulename'));
	}
	function subdelete2($id=false,$idsub=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->km->delete_subkat2($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class.'/sub2/'.$idsub);
	}
	function subinput2()
	{
		if($this->input->post('_INPUT')){
			$id = $this->input->post('id');
			$subkat = $this->input->post('subkat');
			$subkat2 = $this->input->post('subkat2');
			if($this->km->input_subkat2($id,$subkat,$subkat2)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/sub2/'.$subkat));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/sub2/	'.$subkat));
			}
		}
		$data['kat'] = $this->km->option_kat();
		$data['input'] = true;
		$data['id'] = $this->km->sub_get_max_id2();
		$this->template->set_view ('kategori_sub2_edit',$data,config_item('modulename'));
	}


}
