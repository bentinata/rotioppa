<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reg extends Sites_Controller{
	function __construct(){
		parent::__construct(); 
		/* load config */
		$this->load->config('config_home');
		/* load lang */
		$this->lang->load('home');
		/* load model */
		$this->load->model('home_model', 'hm');
		
		// cek for login
		$this->login_lib->m_check_has_login();
				
	}
	function index(){
		$toreg=true; 
		if($this->input->post('_REG')){
			$this->load->library('captcha_lib');
			if($this->captcha_lib->validate_code($this->input->post('captcha'))){
				$email=$this->input->post('email');
                $this->load->helper('email');
                if(valid_email($email)){
                    $this->load->model('login/login_model', 'lm');
                   	$data_user = $this->lm->check_member($email);
			        if(!$data_user){
        				$pass=$this->input->post('pass');
        				$full=$this->input->post('fullname');
        				$nick=$this->input->post('nickname');
        				$tlp=$this->input->post('tlp');
        				$jenkel=$this->input->post('jenkel');
        				$tgl=$this->input->post('thn').'-'.$this->input->post('bln').'-'.$this->input->post('tgl');
        				$kotar=$this->input->post('kota_rumah');
        				$almr=$this->input->post('alamat_rumah');
        				$kotak=$this->input->post('kota_kirim');
        				$almk=$this->input->post('alamat_kirim');
                        $zk=$this->input->post('zip_kirim');
                        $zr=$this->input->post('zip_rumah');
        				$se=$this->input->post('sendmail');
        				$code=get_rand(5,3).time();
                        $rk=$this->input->post('rumah_kota');
                        $rp=$this->input->post('rumah_prov');
        				$this->hm->reg_member($email,$pass,$full,$nick,$tlp,$jenkel,$tgl,$kotak,$almk,$kotar,$almr,$se,$code,$zk,$zr,$rk,$rp);

        				// send mail
        				#$this->load->library('mail_lib');
                        #$ln = site_url($this->router->module.'/'.$this->router->class.'/activation/'.$code.'/'.myEncrypt($email));
                        #$this->mail_lib->reg_member($email,$ln,$nick);

						#$data['email'] = $email;
        				#$this->template->set_view ('reg_ok',$data,config_item('modulename_home'));
        				
        				$this->activation($code,MyEncrypt($email));
        				$toreg=false;
                    }else{
        				$data['ok'] = false;$data['msg'] = lang('email_has_list');
        			}
                }else{
    				$data['ok'] = false;$data['msg'] = lang('mail_not_valid');
    			}
            }else{
				$data['ok'] = false;$data['msg'] = lang('captcha_error');
			}
		}
		if($toreg){
			$data['propinsi'] = $this->hm->option_prop();
			$this->template->set_view ('reg',$data,config_item('modulename_home'));
		}
	}
	function activation($code,$email){
		$email=myDecrypt($email);
		$this->hm->active_member($code,$email); 
		$detail = $this->hm->detail_cust($email); #print_r($detail);
		$link_login = site_url('login');

		// send mail
		$this->load->library('mail_lib');
        $this->mail_lib->act_member($email,$detail->nama_lengkap,$detail->password,$link_login);

		$data['ok'] = true;$data['msg'] = lang('actv_ok');
		$this->template->set_view ('reg_act',$data,config_item('modulename_home'));
	}
	function optionkota(){
		$this->template->clear_layout();
		$kat = $this->input->post('prov'); if(!$kat) exit();
		$listsub = $this->hm->option_kota($kat,false);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}

}
