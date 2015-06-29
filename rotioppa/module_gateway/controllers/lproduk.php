<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Lproduk extends Controller{
	function Lproduk(){
		parent::Controller(); 
		$this->load->module_model($this->router->module, 'banner_model', 'bm');
		$this->lang->load('ext',$this->globals->lang);
		/* to check system speed and query --> just for admin */
		#$this->output->enable_profiler(TRUE);
	}
	function index(){
        echo '';
    }
    function imp($id=false){
        $this->load->library('user_agent');
        if($this->agent->is_referral() and $this->agent->is_browser()){
            if(!$id) redirect();
            $this->load->library('encrypt');
            $key_enc = config_item('secret_key_lp');
            $idiklan = $this->encrypt->decode($id,$key_enc);
            $detail = $this->bm->detail_iklan($idiklan); #break;
            if($detail){ 
                $box_lp = lp_from_id($detail->id_banner);
                $list_produk=false;
                if(!empty($detail->data)){
					$search_data = unserialize($detail->data);
					$list_produk = $this->bm->get_produk_for_linkproduk($search_data);
				}
				$view_box_produk=lang('no_data_produk');
				if($list_produk){
					$array_for_view = array_merge(array('_list_produk'=>$list_produk,'id_iklan_crypt'=>$id),$box_lp);
					$view_box_produk = $this->load->module_view('aff','mtools_linkproduk_view',$array_for_view,true);
					//write impresion
					$this->bm->write_imp($idiklan);
				}
                //print img
                header("content-type: application/x-javascript");
				$dr=str_replace(array("\r", "\n", "\r\n"), "", $view_box_produk); // jadikan script nya satu baris, supaya tdk eror di javascript
				echo "document.write('$dr');";
            }
        }else echo lang('no_direct_access');
    }
    function klk($idproduk=false,$id=false,$tagurl=''){
        $this->load->library('user_agent');
        if($this->agent->is_referral() and $this->agent->is_browser()){
            if(!$id and !$idproduk) redirect();
            $this->load->library('encrypt');
            $key_enc = config_item('secret_key_lp');
            $idiklan = $this->encrypt->decode($id,$key_enc); #echo $idiklan;
            //write klik
            $this->bm->write_klik($idiklan); #echo $this->bm->db->last_query();
            //write cookie
            $this->load->helper('cookie');
            set_cookie(config_item('cok_aff_id'), $idiklan, config_item('cok_aff_exp'));
            redirect('home/detail/index/'.$idproduk.'/'.$tagurl);
        }else echo lang('no_direct_access');
    }
}
