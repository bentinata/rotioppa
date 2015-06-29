<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Prospek extends Admin_Controller{
	function __construct(){
		parent::__construct();
		/* load lang */
		$this->lang->load('defprospek');
		/* load model */
		$this->load->model('prospek_model', 'mm');

	}
	function index($order=false,$asdesc=false)
	{   $search=false;
        if($this->input->post('_CARI')){
            $data['val'] = $this->input->post('val');
            $data['key'] = $this->input->post('key');
            $search=$data;
        }
        $for_paging=$ord=false;
		if($order && $order!='page'){ // tuk menandai bukan variable dari pagination 
			$ord=array('order'=>$order,'asdesc'=>$asdesc);
			$for_paging='/'.$order.'/'.$asdesc;
		} 

        // paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->mm->list_member($search,$ord,false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.$for_paging;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['cust'] = $this->mm->list_member($search,$ord,$limitstart,$pg['limit']);
		$this->template->set_view ('prospek',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->mm->delete_member($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
}
