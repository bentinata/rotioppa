<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Home extends Sites_Controller
{
	function __construct()
	{  
		parent::__construct();
		/* load lang */
		$this->lang->load('home'); 
			$this->load->model('produk_model', 'pm');

			$this->load->model('promo_model', 'pm2');
		/* load model */
	}
	function index(){
			$data['list']		= $this->pm->list_produk2(false,false,false,false);
        
		$this->template->set($data)
		->set_partial('pg_block5','block5');

        $this->template->set_view ('home',	$data,config_item('modulename_home'));

	}
	function our_history(){
		$this->template
		->set_partial('pg_block5','block5');
        $this->template->set_view ('our_history');
	}
    function contact(){
		$this->template
        ->set_partial('pg_block5','block5');
        $this->template->set_view ('contact','',config_item('modulename_home'));
	}

	function promo(){
			$this->template
        ->set_partial('pg_block5','block5');
        $data['list']=$this->pm2->list_promo(false,false,false);
        $this->template->set_view ('promo',$data,config_item('modulename_home'));	
	}
	function kategori($id=null){
		
		$this->template
		->set_partial('pg_block5','block5');
		if($id==""){
			$data['list']="";
		}else{
			$data['list']		= $this->pm->list_produk($id,false,false,false,false);
		}
		// $data['list'] = "";
  //      $data['title'] 		= "Kategori Produk";
		// $data['ket']		= 'index';
		// $ajax="";
		// if($ajax && $ajax!='false'){
		// 	$this->template->clear_layout();
		// 	if($ajax=='1'){
		// 		$respon['view'] = $this->load->view('produk_list2', $data, true);
		// 		echo json_encode($respon);
		// 		//$this->template->set_view ('listproduk_list',$data,config_item('modulename_home'));
		// 	}else{
		// 		$this->load->view('listproduk_list', $data, false);
		// 	}
		// }else{
			$this->template
				->set_view ('test_list',$data);
		// }
	}	
	
}
