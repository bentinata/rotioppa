<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Komisi extends Admin_Controller{
	function __construct(){
		parent::__construct();
		/* load lang */
		$this->lang->load('defaff');
		/* load model */
		$this->load->model('komisi_model', 'km');

	}
	function index($ajax=false){
        $forajax='';
        $search['range']['first'] = $this->input->post('dt1')?$this->input->post('dt1'):date('Y-n');
        $search['range']['last'] = $this->input->post('dt2')?$this->input->post('dt2'):date('Y-n');
        if($this->input->post('aff') && $this->input->post('aff')!=''){
            $search['aff'] = $this->input->post('aff');
            $forajax.='&aff='.$search['aff'];
        }
        if($this->input->post('status') && $this->input->post('status')!=''){
            $search['status'] = $this->input->post('status');
            $forajax.='&status='.$search['status'];
        }
        $data['forajax'] = '&dt1='.$search['range']['first'].'&dt2='.$search['range']['last'].$forajax;

		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20); #print_r($pg);
		$paging['curpage'] 	= $this->input->post('start')!=''?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->km->list_komisi($search,false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;
        $data['list_iklan']=$this->km->list_komisi($search,$limitstart,$paging['limit'],false);#print_r($data['list_iklan']);

        if($ajax){
            $this->template->clear_layout();
            if($ajax=='1')
                $this->template->set_view ('laporan_komisi2',$data,config_item('modulename'));
            else
                $this->template->set_view ('laporan_komisi3',$data,config_item('modulename'));
        }else{
             $this->template->set_view ('laporan_komisi',$data,config_item('modulename'));
        }
	}
    function transferkomisi(){
        $this->template->clear_layout();
        $id=explode('-',$this->input->post('id'));
        if($id){foreach($id as $_id){
        $this->km->transfer_komisi($_id); 
		}}
        echo lang('update_success');
    }
    function listkomisiaff($idaff=false){
		if(!$idaff) redirect(config_item('modulename').'/'.$this->router->class);
		// load model 
		$this->load->module_model(config_item('modulename'), 'aff_model', 'am');
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20); #print_r($pg);
		$paging['curpage'] 	= $this->input->post('start')!=''?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->km->list_komisi_byaff($idaff,false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;
		
        $data['list_komisi']=$this->km->list_komisi_byaff($idaff,$limitstart,$paging['limit'],false);#print_r($data['list_iklan']);
		$data['detail_aff']=$this->am->detail_aff($idaff);
		$this->template->set_view ('laporan_komisi_user',$data,config_item('modulename'));
	}
    function deletekom($idkom=false){
        $this->template->clear_layout();
        if(!$idkom) redirect(config_item('modulename').'/'.$this->router->class.'/listkomisiaff');
        // get detail kom
        $detkom=$this->km->get_detail_kom($idkom);
        $idaff='';
        if($detkom){
			$idaff='/'.$detkom->id_aff;
			// cek id aff on kom user, jika ada update
			if($this->km->cek_aff_has_kom($detkom->id_aff)){
				// update kom user
				$this->km->update_kom_aff($detkom->id_aff,$detkom->komisi);
			}else{
				// input kom user
				$this->km->input_kom_aff($detkom->id_aff,$detkom->komisi);
			}
			// delete komisi list
			$this->km->delete_komisi_user($idkom);
		}
        echo java_alert(lang('update_success')).redirect_java(config_item('modulename').'/'.$this->router->class.'/listkomisiaff'.$idaff);
    }
}
