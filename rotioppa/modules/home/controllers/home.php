<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Home extends Sites_Controller
{
	function __construct()
	{  
		parent::__construct();
		/* load lang */
		$this->lang->load('home'); 
			$this->load->model('produk_model', 'pm');
		/* load model */
	}
	function index(){
	    $data['best'] ="";
        $data['new'] = "";
        $data['rate'] ="";
		$data['berita'] ="";
		$data['artikel'] = "";
		
		$data['testimoni'] = "";
        
        
		$this->template->set($data)
		->set_partial('pg_banner','slider')
		->set_partial('pg_sidebar','sidebar')
		->set_partial('pg_block4','block4')
		->set_partial('pg_block5','block5')
		->set_partial('pg_block6','block6')
		->set_partial('pg_berita_lain','berita_lain')
		->set_partial('pg_berita_lain2','berita_lain2')
		
        ->build('home');
	}
	function our_history(){
		$this->template
		->set_partial('pg_block5','block5');
		// $data['best'] = $this->hm->best_seller();
        $folder = config_item('dir_upload').'/page/';
        $this->load->helper('file');
        $data['his_blok1'] = read_file($folder.'his_blok1.txt');
        $data['his_blok2'] = read_file($folder.'his_blok2.txt');
        $data['his_blok3'] = read_file($folder.'his_blok3.txt');
        $data['his_blok4'] = read_file($folder.'his_blok4.txt');
        $this->template->set_view ('our_history');
	}
    function contact(){
		$this->template
        ->set_partial('pg_block5','block5');

        $folder = config_item('dir_upload').'/page/';
        $this->load->helper('file');
        $data['read'] = read_file($folder.'contact.txt');
        $this->template->set_view ('contact',$data,config_item('modulename_home'));
	}
	function kategori($id){
		
		$this->template
		->set_partial('pg_block5','block5');
			$data['list']		= $this->pm->list_produk($id,false,false,false,false);
       $data['title'] 		= "Kategori Produk";
		$data['ket']		= 'index';
		$ajax="";
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
				->set_view ('listproduk',$data);
		}
	}	
	
}
