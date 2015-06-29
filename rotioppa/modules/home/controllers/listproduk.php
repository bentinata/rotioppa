<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Listproduk extends Sites_Controller
{
	function __construct(){  
		parent::__construct();
        $this->lang->load('home'); 
		/* load config */
		$this->load->config('config_home');
		/* load model */
		$this->load->model('produk_model', 'pm');
		
	}
	function index($idsub=false,$ajax=false,$sub2=false){ // var sub2 tdk di pake lg, tp biarkan sja sprti itu tkutnya ada yg error
		#if(!$idsub) redirect(); 

		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $this->input->post('start')?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->pm->list_produk($idsub,false,false,true,false);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;
		$data['list']		= $this->pm->list_produk($idsub,$limitstart,$paging['limit'],false,false);
        $data['idsub']		= empty($idsub)? "false":$idsub;
		$data['title'] 		= "Kategori Produk";
		$data['ket']		= 'index';
		if($ajax && $ajax!='false'){
			$this->template->clear_layout();
			if($ajax=='1'){
				$respon['view'] = $this->load->view('produk_list2', $data, true);
				echo json_encode($respon);
				//$this->template->set_view ('listproduk_list',$data,config_item('modulename_home'));
			}else{
				$this->load->view('listproduk_list', $data, false);
			}
		}else{
			$this->template
				->set_partial('pg_block5','block5')
				->set_view ('listproduk',$data,config_item('modulename_home'));
		}
	}
	

	function katalog($idkat,$ajax=false){ // khusus untuk list by kategori
		if(!$idkat) redirect('home/listproduk/');
		
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $this->input->post('start')?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->pm->katalog($idkat,false,false,true); #echo $paging['total'];
	
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;
		$data['list']= $this->pm->katalog($idkat,$limitstart,$paging['limit']);
        $data['idkat']= $idkat; // utk pagging, tp pada akhirnya akan masuk lg ke ctr ini sbg idkat
		$data['idsub']= $idkat;
		$data['title'] 		= "Katalog Produk";
		$data['ket'] 		= "katalog";
		
        if($ajax && $ajax!='false'){
			$this->template->clear_layout();
			if($ajax=='1'){
				$respon['view'] = $this->load->view('produk_list2', $data, true);
				echo json_encode($respon);
				//$this->template->set_view ('listproduk_list',$data,config_item('modulename_home'));
			}else{
				$this->load->view('listproduk_list', $data, false);
			}
		}else{
			$this->template
				->set_view ('listproduk',$data,config_item('modulename_home'));
		}
	}


	function indexsub($idsub,$ajax=false){
		if(!$idsub) redirect();
		$sub2=false; // ini controller khusus utk subkategori level 2
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $this->input->post('start')?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->pm->list_produk($idsub,false,false,true,$sub2);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;
		$data['list']= $this->pm->list_produk($idsub,$limitstart,$paging['limit'],false,$sub2); 
        $data['idsub']= $idsub;
		$data['ket']		= 'sub';

        if($ajax && $ajax!='false'){
			$this->template->clear_layout();
			if($ajax=='1'){
				$respon['view'] = $this->load->view('produk_list2', $data, true);
				echo json_encode($respon);
				//$this->template->set_view ('listproduk_list',$data,config_item('modulename_home'));
			}else{
				$this->load->view('listproduk_list', $data, false);
			}
		}else{
			$this->template
				->set_view ('listproduk',$data,config_item('modulename_home'));
		}
	}
	
	function indexkat($idkat,$ajax=false){ // khusus untuk list by kategori
		if(!$idkat) redirect();
		
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $this->input->post('start')?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->pm->list_produk_bykat($idkat,false,false,true); #echo $paging['total'];
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;
		$data['list']		= $this->pm->list_produk_bykat($idkat,$limitstart,$paging['limit']); 
        $data['idsub']		= $idkat; // utk pagging, tp pada akhirnya akan masuk lg ke ctr ini sbg idkat
		$data['ket']		= 'kategori';
		
        if($ajax && $ajax!='false'){
			$this->template->clear_layout();
			if($ajax=='1'){
				$respon['view'] = $this->load->view('produk_list2', $data, true);
				echo json_encode($respon);
				//$this->template->set_view ('listproduk_list',$data,config_item('modulename_home'));
			}else{
				$this->load->view('listproduk_list', $data, false);
			}
		}else{
			$this->template
				->set_view ('listproduk',$data,config_item('modulename_home'));
		}
	}
	
}
