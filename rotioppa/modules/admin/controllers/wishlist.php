<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Wishlist extends Admin_Controller{
	function __construct(){
		parent::__construct(); 
		// load model 
		$this->load->model('wishlist_model', 'wm');
		// load def lang
		$this->lang->load('defwishlist');
	}
	function index($ajax=false)
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $this->input->post('start')?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->wm->list_wish(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;

		$data['list_wish'] = $this->wm->list_wish($limitstart,$paging['limit']);
		if($ajax=='2'){
			$this->template->clear_layout();
			$this->template->set_view ('wishlist2',$data,config_item('modulename'));
		}else $this->template->set_view ('wishlist',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->wm->delete_wish($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function input()
	{
		$this->template->clear_layout();
		if($this->input->post('_INPUT')){
			$id = $this->input->post('id');
			$nama = $this->input->post('nama');
			$email = $this->input->post('email');
			if($this->wm->add_wish($id,$nama,$email)){ echo $this->wm->db->last_query();
				$data['kode'] = 1;$data['msg'] = lang('input_ok');
			}else{
				$data['kode'] = 2;$data['msg'] = lang('input_er');
			}
			echo json_encode($data);
		}
	}
	
}
