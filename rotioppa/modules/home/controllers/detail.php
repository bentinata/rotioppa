<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Detail extends Sites_Controller{
	function __construct(){  
		parent::__construct(); 
		/* load config */
		$this->load->config('config_home');
		/* load lang */
		$this->lang->load('home');
		/* load model */
		$this->load->model('produk_model', 'pm');
        $this->load->model('home_model', 'hm');
	}
	function index($id=false){
		$this->template
		->set_partial('pg_block5','block5')
		->set_partial('pg_best_seller','best_seller');
		
		if(!$id) redirect();
        $userid = $this->login_lib->m_get_data('id');
        $userglobal = $this->globals->user_global;
		// di taruh di atas sebagai filter juga
		$data['detail'] = $this->pm->detail_produk($id); #print_r($data['detail']);break;
		if(!$data['detail']) redirect();
        
        if($this->input->post('_REVIEW')){
            if(!$userid) redirect();
			$this->load->library('captcha_lib');
			if($this->captcha_lib->validate_code($this->input->post('captcha'),'ratethis')){
                $id=$this->input->post('idproduk');
                $rate=$this->input->post('bintang');
                $rev=$this->input->post('review');
                if($this->pm->add_review($userid,$id,$rev,$rate)){
                    java_alert(lang('thank_for_review'));
                    redirect_java(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/'.$id);
                }else{
                    $data['ok'] = false;$data['msg'] = lang('review_er');
                }
            }else{
				$data['ok'] = false;$data['msg'] = lang('captcha_error');
			}
        }else{
			// history detail produk di catat hanya ketika view detail saja, tidak pada review
			// cek apakah id produk tsb sdh belum terdaftar di history
		    if(!$this->pm->cek_history($id,$userglobal,$userid)){
				// lakukan filter, jika sudah melebihi maksimal, hapus yg paling lama
				$this->pm->filter_history_by_user($userglobal,$userid,config_item('max_history_produk'));
				// do add history
                $this->pm->add_history($id,$userglobal,$userid);
            }
		}
        
        // set title, keyword,description
        $this->template->set_params(array('title'=>$data['detail']['nama_produk'].' | '.config_item('site_title')));
		if(!empty($data['detail']['meta_key']))
		$this->template->set_params(array('keyword'=>$data['detail']['meta_key']));
		if(!empty($data['detail']['meta_desc']))
		$this->template->set_params(array('description'=>$data['detail']['meta_desc']));

        if($userid)
        $data['is_review'] = $this->pm->is_review($userid,$id);
        else
        $data['is_review'] = false;

        $data['best'] = $this->hm->best_seller();
        $data['rel_tag'] = $this->pm->get_related_tag($data['detail']['tag'],$data['detail']['id_subkategori'],$data['detail']['id_kode_vendor']);
        $data['is_kupon_enable'] = $this->hm->is_kupon_enable();

		$this->template->set_view ('detail',$data,config_item('modulename_home'));
	}

    function addwish(){
        if($this->input->post('_WSUBMIT')){
			$this->load->library('captcha_lib');
			if($this->captcha_lib->validate_code($this->input->post('wcaptcha'))){
                $this->load->helper('email');
                $email = $this->input->post('wmail');
                if(valid_email($email)){
                    $tonama = $this->input->post('wnama');
                    $idp = $this->input->post('idproduk');
                    $idattr = $this->input->post('idstockattr');

                    // save to db prospek
                    $this->pm->add_wish($idp,$idattr,$tonama,$email);

                    $msg = lang('wish_success');
                }else{
    				$msg = lang('mail_not_valid');
    			}
            }else{
				$msg= lang('captcha_error');
			}
            java_alert($msg);
            redirect_java('home/detail/index/'.$idp);
        }
    }

}
