<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Banner extends Controller{
	function Banner(){
		parent::Controller(); 
		/* load config */
		#$this->load->config('config_home');
		/* load lang */
		#$this->lang->load('home',$this->globals->lang);
		/* load model */
		$this->load->module_model($this->router->module, 'banner_model', 'bm');

		/* header description */
		#$data['title'] 			= config_item('site_title');
		#$data['keyword'] 		= config_item('site_keyword');
		#$data['description'] 	= config_item('site_desc');
		#$this->template->set_params($data);
		#$this->template->set_layout();

		// load page component
		//--------------------

		// load model global
		#$this->load->model('global_model', 'gm');
		
		// component top search box
		#$var['option_kat'] = $this->gm->option_kat();
		#$this->template->load_view( 'temp/top-search-box',$var,false,'pg_search');

		// component top sidebar
		#$var['list_kat_sub'] = $this->gm->get_kat_sub();
		#$this->template->load_view( 'temp/top-sidebar',$var,false,'pg_topbar');

		// cart count
	    #$cart['count_cart'] = $this->gm->count_cart($this->globals->user_global,$this->login_lib->m_get_data('id'));
		#$this->template->set_params($cart);

		/* to check system speed and query --> just for admin */
		#$this->output->enable_profiler(TRUE);
	}
	function index(){
        //echo '';
		$this->load->view(coba);
    }
    function imp($jenis,$id=false){ 
        $this->load->library('user_agent');
        if($this->agent->is_referral() and $this->agent->is_browser()){
            if(!$id) redirect();
            $this->load->library('encrypt');
            $key_enc = config_item('secret_key_banner'); //echo $key_enc;
            $idiklan = $this->encrypt->decode($id,$key_enc);
            $detail = $this->bm->detail_iklan($idiklan); //print_r($detail);break;
            if($detail){
                $banner_img = banner_from_id($detail->id_banner);
				echo $banner_img;
                $array_for_view['img_banner'] = $banner_img['img'];
                $array_for_view['link_banner'] = site_url(config_item('link_banner_klk').'/'.$jenis.'/'.$id);
                $view_banner = $this->load->module_view('aff','mtools_banner_view',$array_for_view,true); #print_r($view_banner); break;
                //write impresion
                $this->bm->write_imp($idiklan);
                //print img
                header("content-type: application/x-javascript");
				$dr=str_replace(array("\r", "\n", "\r\n"), "", $view_banner); // jadikan script nya satu baris, supaya tdk eror di javascript
				echo "document.write('$dr');";
            }
        }else echo lang('no_direct_access');
    }
    function klk($jenis,$id=false){
        $this->load->library('user_agent');
        if($this->agent->is_referral() and $this->agent->is_browser()){
            if(!$id) redirect();
            $this->load->library('encrypt');
            $key_enc = config_item('secret_key_banner');
            $idiklan = $this->encrypt->decode($id,$key_enc); #echo $idiklan;
            //write klik
            $this->bm->write_klik($idiklan);
            //write cookie
            $this->load->helper('cookie');
            set_cookie(config_item('cok_aff_id'), $idiklan, config_item('cok_aff_exp'));
            // define what the type of kategori
            // baru ada 2 jenis kategori, sepatu dan buku
            if($jenis=='2') // tuk subkategori sepatu pria
            redirect('home/listproduk/index/49');
            if($jenis=='1') // tuk kategori buku
            redirect('home/listproduk/indexkat/15');
            else redirect(); // jika tdk ada option jenis
        }else echo lang('no_direct_access');
    }
}
