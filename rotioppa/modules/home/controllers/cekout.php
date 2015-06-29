<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cekout extends Sites_Controller{
    var $userid;
	function __construct(){
		parent::__construct(); 
		/* load config */
		$this->load->config('config_home');
		/* load lang */
		$this->lang->load('home');
		/* load model */
		$this->load->model('cekout_model', 'cm');
        $this->userid =$this->login_lib->m_get_data('id');

	}
	function index(){
		// cek if has login before
		if(!$this->login_lib->m_has_login()){
            save_uri(current_url());
            redirect('login/index/1');
		}
        $tocek=true;
	    $user=$this->userid;
        if($this->input->post('_CEKOUT')){ //print_r($_POST); break;
        if(($data_cart=$this->cm->get_cart_for_order($user))){
            $harga=$this->input->post('total');
            $bayar=$this->input->post('bayar');
            $kode=$this->input->post('kode_unik');
            $bkirim=$this->input->post('biaya_kirim');
			$idkirim=$this->input->post('id_biaya_kirim');
            $berat=$this->input->post('total_berat');
            if($this->input->post('otheraddr')){
                $idkota=$this->input->post('kota');
                $nama=$this->input->post('nama');
                $tlp=$this->input->post('hp');
                $alm=$this->input->post('alamat');
                $zip=$this->input->post('zip');
            }else{
                $cust=$this->cm->get_data_member($user);
                $idkota=$cust->idkota;
                $nama=$cust->nama_lengkap;
                $tlp=$cust->no_tlp;
                $alm=$cust->alamat_kirim;
                $zip=$cust->zip_kirim;
            }

            $idcekout=$this->cm->add_cekout($user,$idkota,$nama,$tlp,$alm,$zip,$harga,$bayar,$kode,$bkirim,$idkirim,$berat);
            $kodetrans=kode_transaksi($idcekout);
            $this->cm->update_kode_trans($idcekout,$kodetrans);

            // add to table order and delete table cart
            $harga=$this->input->post('price');
            $this->cm->add_to_order($user,$harga,$idcekout,$data_cart);

    		// send mail
    		$list = $this->cm->list_cekout_from_id($idcekout);
    		$detail = $this->cm->detail_cekout($idcekout);
    		$to = $this->login_lib->m_get_data('email');
    		$nick = $this->login_lib->m_get_data('nama_panggilan');
    		$this->load->library('mail_lib');
            $this->mail_lib->cekout($to,$list,$nick,$detail);

    		redirect('home/cekout/cekoutok');
        }else{
			java_alert(lang('no_data_cart'));
			redirect_java('home/cart');
		}$tocek=false;}
        if($tocek){
        $data['propinsi'] = $this->cm->option_prop();
        $data['list'] = $this->cm->list_cekout($user);
        $data['cust'] = $this->cm->get_data_member($user);
        $data['list_persh'] = $this->cm->option_perusahaan_kirim();
		$this->template->set_view ('cekout',$data,config_item('modulename_home'));
        }
	}
    function cekoutok(){
        $this->template->set_view ('cekout_ok',false,config_item('modulename_home'));
    }
	function optionkota(){
		$this->template->clear_layout();
		$kat = $this->input->post('prov'); if(!$kat) exit();
		$listsub = $this->cm->option_kota($kat);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}
	function optionkotabiaya(){
		$this->template->clear_layout();
		$kat = $this->input->post('prov'); if(!$kat) exit();
		$lay = $this->input->post('idlay');
		$listsub = $this->cm->option_kota_with_biaya($kat,$lay);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}
    function bkirim(){
		$this->template->clear_layout();
		$kota = $this->input->post('kota'); if(!$kota) exit();
		$lay = $this->input->post('idlay');
        $row = $this->cm->get_bkirim($kota,$lay);
		if($row){
			$data['id'] = $row->id;
			$data['biaya'] = $row->biaya_kirim;
		}else{
			$data['id'] = 0;
			$data['biaya'] = 0;
		}
		echo json_encode($data); 
    }
	function optionlkirim(){
		$this->template->clear_layout();
		$prsh = $this->input->post('prov'); if(!$prsh) exit(); // var nya aneh, karena ajaxnya bersatu denga provinsi
		$listsub = $this->cm->option_layanan_kirim($prsh);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}
	function optionpropbylayanan(){
		$this->template->clear_layout();
		$lay = $this->input->post('prov'); if(!$lay) exit(); // var nya aneh, karena ajaxnya bersatu denga provinsi
		$listsub = $this->cm->option_prop_by_layanan($lay);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}
	function getkotabylayanan(){
		$this->template->clear_layout();
		$lay = $this->input->post('lay'); if(!$lay) exit(); 
		$listsub = $this->cm->get_kota_by_layanan($lay);
		$vl=array();
		if($listsub){
		foreach($listsub as $v){
            $vl[] = array('label'=> $v->kota,'value' => $v->id);
		}}
		echo json_encode($vl);
	}
}
