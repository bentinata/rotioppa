<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cart extends Sites_Controller{
    var $userid;
    function __construct(){
		parent::__construct();
		/* load config */
		$this->load->config('config_home');
		/* load lang */
		$this->lang->load('home');
		/* load model */
		$this->load->model('cart_model', 'cm');
		$this->load->model('home_model', 'hm');
        $this->userid =$this->login_lib->m_get_data('id');

	}
	function index(){
        // update qty order
        if($this->input->post('_UPDATE')){
            $update = $this->input->post('qty');
            $oldqty = $this->input->post('qold');
            $idproduk = $this->input->post('idp');
            foreach($update as $idcart=>$valcart){
                $this->cm->update_qty($idcart,$valcart,$oldqty[$idcart],$idproduk[$idcart]);
            }
            java_alert(lang('update_ok'));
            redirect_java(config_item('modulename').'/'.$this->router->class);
        }
        $userid = $this->userid;
	    $userglobal=$this->globals->user_global;

        // add to chart
        if($this->input->post('idproduk')){
	        $idproduk=$this->input->post('idproduk');
            // set var
            $ck_id_iklan=false;
            $komisi=0;
			// cek dulu cookie id_iklannya ada / ga
			$this->load->helper('cookie');
			if(($ck_id_iklan = get_cookie(config_item('cok_aff_id')))){
				// cek for aff
				if(($val_komisi=$this->cm->is_for_aff($idproduk))){
					$komisi = $val_komisi;
				}else{
				// jika bukan utk aff, maka cokie iklan nya buat false kembali
					$ck_id_iklan=false;	
				}
			}
			$id_attr=$this->input->post('id_attr');
			// cek cart sudah di input ato belum
            if(!$this->cm->cek_cart($idproduk,$id_attr,$userglobal,$userid)){
                $qty=$this->input->post('jml');
                $komisi=$qty*$komisi; // komisi langsung di kali dengan qty nya
                
                // input cart
                if(($idc=$this->cm->add_cart($idproduk,$qty,$userglobal,$id_attr,$userid,$ck_id_iklan,$komisi))){
                    $data['ok']=true;$data['msg'] = lang('has_to_cart');
                    
                    // input kupon jika ada
                    $is_kupon_enable = $this->input->post('kode_kupon');
                    if($is_kupon_enable=='1'){
						$kupon=$this->input->post('kupon');
						
						// cek kupon is valid and enable
						if($this->hm->is_kupon_enable($kupon)){
							$config_kupon = config_item('jenis_kupon');
							$dkupon=$this->hm->get_detail_kupon($kupon);
							if($dkupon->jenis_kupon==$config_kupon['persen']){
								$persen_kupon = $dkupon->nilai_kupon;
								$potongan ='' ;// blum bs di ambil karena harga blum fix, fix setelah masuk ke order
							}else{
								$persen_kupon = ''; // karena bentuk value, berarti tdk perlu pakai persen
								$potongan = $dkupon->nilai_kupon;
							}
							$this->hm->add_kupon_user($userid,$kupon,$persen_kupon,$potongan,$idc);
						}
					}
                }
            }else{
                $data['ok']=false;$data['msg'] = lang('has_cart_before');
            }
            // hitung cart lg karena telah di lakukan insert cart baru
            $cart2['count_cart'] = $this->gm->count_cart($this->globals->user_global,$this->userid); #break;
            $this->template->set_params($cart2);
	    }
        $data['list'] = $this->cm->list_cart($userglobal,$userid);
		$this->template->set_view ('cart',$data,config_item('modulename_home'));
	}
	function delete($id)
	{
		if(!$id) redirect();
        $userid = $this->userid;
	    $userglobal=$this->globals->user_global;
        if($this->cm->dell_cart($id,$userglobal,$userid))
        {
			$this->hm->del_kupon_user_by_idcart($id);
		    java_alert(lang('del_ok'));
		}
		redirect_java(config_item('modulename').'/'.$this->router->class);
    }
}
