<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reqajax extends Sites_Controller{
	function __construct(){  
		parent::__construct(); 
		/* load config */
		#$this->load->config('config_home');
		/* load lang */
		$this->lang->load('home');
		/* load model */
		$this->load-_model('home_model', 'hm');
		
	}
	function use_kupon(){
		// cek if has login before
		if(!$this->login_lib->m_has_login()){
			#save_uri(current_url());
            redirect_java('login/index/1');exit();
		}
		$kupon = $this->input->post('kode_kupon'); 
		$iduser = $this->login_lib->m_get_data('id'); // harus sudah login
		$harga_barang = $this->input->post('harga');
		
		$result = $this->hm->cek_kupon($kupon);
		$code_result = 2; 
		// kupon error
		if($result['msg']=='2' || $result['msg']=='3') 
			$echo= '<b>'.lang('kupon_gagal').'</b><br />'.sprintf(lang('msg_kupon_'.$result['msg']),format_date($result['tgl'],'00-00-0000','-'));
		elseif($result['msg']=='4') 
			$echo= '<b>'.lang('kupon_gagal').'</b><br />'.lang('msg_kupon_'.$result['msg']);
		// kupon ok
		else{
			$data_kupon = $result['data'];
			$result2=$this->hm->cek_kupon_user($data_kupon->kode_kupon,$iduser);
			// kupon tlh dipakai
			if($result2==5) 
				$echo= '<b>'.lang('kupon_gagal').'</b><br />'.lang('msg_kupon_'.$result2);
			else{ 
				// lets go to use a kupon
				$full = $this->login_lib->m_get_data('nama_lengkap');
				$nick = $this->login_lib->m_get_data('nama_panggilan');
				$nama = empty($nick)?$full:$nick;
				$jenis_kupon = config_item('jenis_kupon');
				if($data_kupon->jenis_kupon==$jenis_kupon['persen']){
					$potongan = round((($harga_barang*$data_kupon->nilai_kupon)/100),0); 
					$_echo = sprintf(lang('msg_kupon_1_persen'),$nama,$data_kupon->nilai_kupon.'%');
				}else{ 
					$potongan = $data_kupon->nilai_kupon;
					$_echo = sprintf(lang('msg_kupon_1'),$nama,currency($potongan));
				}
				$code_result=1;
				$echo= '<b>'.lang('kupon_berhasil').'</b><br />'.$_echo;
			}
		}
		echo json_encode(array('code'=>$code_result,'msg'=>$echo));
	}
	
}
