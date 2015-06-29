<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends Admin_Controller{
	function __construct(){
		parent::__construct();
		// load model
		
	}
	function index($ajaxmode=false,$vcode=false)
	{
		// for search
		if($this->input->post('_INPUT'))
		{ #print_r($_FILES); break;
			$desc = $this->input->post('desc');
				
					$fp = fopen('./assets/web/profile.txt', 'w'); 
				fwrite($fp,$desc, strlen($desc)); 
				fclose($fp);
			$data['ok']=true;
				$data['msg'] = "input tersimpan";#.meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));

		}
		$data['desc'] = file_get_contents("./assets/web/profile.txt");
			$this->template
				->set_metadata('stylesheet',module_css('produk_list.css',false),'link')
				->set_view ('profile',$data,config_item('modulename'));
	}
    
	
	function input(){

	
                // input to table produk
				

				$data['ok']=true;
				$data['msg'] = lang('input_ok');#.meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));

	// 	}
	// 	$data['id'] =$id ;
	// 	$this->template
 //        ->set_metadata('stylesheet',module_css('produk_edit.css',false),'link')
 //        ->set_view ('produk_edit',$data,config_item('modulename'));
	}
	
}
