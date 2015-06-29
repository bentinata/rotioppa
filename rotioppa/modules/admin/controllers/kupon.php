<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Kupon extends Admin_Controller{
	function __construct(){
		parent::__construct();
	   /* load lang */
		$this->lang->load('defkupon');
		/* load model */
		$this->load->model('kupon_model', 'km');

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
		$paging['total'] 	= $this->km->list_kupon($search,$ord,false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.$for_paging;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['kupon'] = $this->km->list_kupon($search,$ord,$limitstart,$pg['limit']);
		$this->template->set_view ('kupon',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->km->delete_kupon($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function detail($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT'))
		{
			$kode=$this->input->post('kode_kupon');
			$jenis=$this->input->post('jenis_kupon');
			$nilai=$this->input->post('nilai_kupon');
			$awal=$this->input->post('tgl_awal_key');
			$akhir=$this->input->post('tgl_akhir_key');
			$status=$this->input->post('status_kupon');
			if($this->km->update_kupon($this->input->post('id_kupon'),$kode,$jenis,$nilai,$awal,$akhir,$status))
			{
				$data['ok'] = true;
				$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;
				$data['msg'] = lang('update_error');
			}
		}
		$data['kupon'] = $this->km->detail_kupon($id);
		$this->template->set_view ('kupon_edit',$data,config_item('modulename'));
	}
	function input()
	{
		if($this->input->post('_INPUT'))
		{
			$kode=$this->input->post('kode_kupon');
			$jenis=$this->input->post('jenis_kupon');
			$nilai=$this->input->post('nilai_kupon');
			$awal=$this->input->post('tgl_awal_key');
			$akhir=$this->input->post('tgl_akhir_key');
			$status=$this->input->post('status_kupon');
			if($this->km->input_kupon($kode,$jenis,$nilai,$awal,$akhir,$status))
			{
				$data['ok'] = true;
				$data['msg'] = lang('input_ok');
			}else{
				$data['ok'] = false;
				$data['msg'] = lang('input_error');
			}
		}
		$data['input'] = true;
		$this->template->set_view ('kupon_edit',$data,config_item('modulename'));
	}
}
