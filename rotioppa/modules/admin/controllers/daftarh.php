<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Daftarh extends Admin_Controller{
	function __construct(){
		parent::__construct();
		/* load lang */
		$this->lang->load('definfo');
		/* load model */
		$this->load->model('daftarh_model', 'im');
	}
	function index()
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->im->list_info(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_info'] = $this->im->list_info($limitstart,$pg['limit']);
		$this->template->set_view ('daftarh',$data,config_item('modulename'));
    }
	function edit($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$info = $this->input->post('info');
			if($this->im->update_info($id,$info)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		$data['detail_info'] = $this->im->detail_info($id);
		$this->template->set_view ('daftarh_edit',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->im->delete_harga($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function input()
	{
		if($this->input->post('_INPUT')){
			$info = $this->input->post('content');
			if($this->im->input_harga($content)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}
		}
        $data['input'] = true;
 	    $this->template->set_view ('daftarh_edit',$data,config_item('modulename'));
	}


	function harga()
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->im->list_harga(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_harga'] = $this->im->list_harga($limitstart,$pg['limit']);
		$this->template->set_view ('daftarh',$data,config_item('modulename'));
    }
	function editharga($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
            $jawab = $this->input->post('jawab');
			if($this->im->update_harga($id,$jawab)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		$data['detail_harga'] = $this->im->detail_harga($id);
		$this->template->set_view ('daftarh_edit',$data,config_item('modulename'));
	}
	function deleteharga($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->im->delete_harga($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class.'/harga');
	}
	function inputharga()
	{
		if($this->input->post('_INPUT')){
            $content = $this->input->post('content');
			if($this->im->input_harga($content)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/harga'));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/harga'));
			}
		}
        $data['input'] = true;
 	    $this->template->set_view ('daftarh_edit',$data,config_item('modulename'));
	}

}