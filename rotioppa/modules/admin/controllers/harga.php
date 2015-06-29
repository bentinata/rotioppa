<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Artikel extends Admin_Controller{
	function __construct(){
		parent::__construct();
        $this->lang->load('defartikel');
		/* load model */
		$this->load->model('harga_model', 'im');
	}
	function index()
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->im->list_daftar(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_info'] = $this->im->list_daftar($limitstart,$pg['limit']);
		$this->template->set_view ('artikel',$data);
    }
	function edit($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$info['summary'] = $this->input->post('summary');
            $info['title'] = $this->input->post('title');
            $info['content'] = $this->input->post('desc');
            
			if($this->im->update($id,$info)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		$data['detail_info'] = $this->im->detail($id);
		$this->template->set_view ('artikel_edit',$data);
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->im->delete($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function input()
	{
		if($this->input->post('_INPUT')){
			$info['summary'] = $this->input->post('summary');
            $info['title'] = $this->input->post('title');
            $info['content'] = $this->input->post('desc');
            $info['date_input'] = date('Y-m-d H:i:s');
            
			if($this->im->input($info)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}
		}
        $data['input'] = true;
 	    $this->template->set_view ('artikel_edit',$data);
	}


}