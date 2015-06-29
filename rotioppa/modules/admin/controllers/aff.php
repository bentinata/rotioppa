<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Aff extends Admin_Controller{
	function __construct(){
		parent::__construct();
		/* load lang */
		$this->lang->load('defaff');
		/* load model */
		$this->load->model('aff_model', 'am');

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
		$paging['total'] 	= $this->am->list_aff($search,$ord,false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['cust'] = $this->am->list_aff($search,$ord,$limitstart,$pg['limit']);
		$this->template->set_view ('aff',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->am->delete_aff($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function detail($id=false){
	    if($this->input->post('_SAVE')){
            $id=$this->input->post('id');
			$pass=$this->input->post('pass');
			$full=$this->input->post('fullname');
			$nick=$this->input->post('nickname');
    		$tlp=$this->input->post('tlp');
            $hp=$this->input->post('hp');
    		$jenkel=$this->input->post('jenkel');
        	$lahir=$this->input->post('thn').'-'.$this->input->post('bln').'-'.$this->input->post('tgl');
        	$alm=$this->input->post('alm');
        	$kota=$this->input->post('kota');
        	$prov=$this->input->post('prov');
            $neg=$this->input->post('negara');
            $pm=$this->input->post('paymethod');
        	$mk=$this->input->post('minkom');
            $this->am->update_aff($id,$pass,$full,$nick,$tlp,$hp,$jenkel,$lahir,$alm,$kota,$prov,$neg,$pm,$mk);
            $data['ok'] = true;$data['msg'] = lang('update_success');
	    }
		$data['method'] = 'profile';
        #$data['propinsi'] = $this->mm->option_prop();
        $data['cust'] = $this->am->detail_aff($id);
		$this->template->set_view ('aff_profile',$data,config_item('modulename'));
	}
}
