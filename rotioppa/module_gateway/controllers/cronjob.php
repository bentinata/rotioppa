<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cronjob extends Controller{
	function Cronjob(){
		parent::Controller();
		/* load config */
		#$this->load->config('config_home');
		/* load lang */
		#$this->lang->load('home',$this->globals->lang);
		/* load model */
		$this->load->module_model($this->router->module, 'cron_model', 'cm');

		/* to check system speed and query --> just for admin */
		#$this->output->enable_profiler(TRUE);
	}
	function index(){
        echo '';
    }
    // dijalankan setiap tgl 31 jam 23:00, karena akan menghitung periode bulan sekarang saja
    // note: belum di jalankan masih ada yg belum fix system nya
    function reviewkomisi($user=false,$pwd=false){
        if(!$user or !$pwd) die('Authentication Required!');
        if($user!='cron' and $pwd!='extr34m') die('Authentication failed!');
        $my = date('06-Y');
        if(!$this->cm->review_komisi($my)) echo date('d-m-Y H:i:').' >> query review komisi error';
        echo $this->cm->db->last_query();
    }
    
    // dijalankan setiap jam 00:05
    // proses ini sekaligus clear order
    function clearcekout($user=false,$pwd=false)
    {
        if(!$user or !$pwd) die('Authentication Required!');
        if($user!='cron' and $pwd!='extr34m') die('Authentication failed!');
        $day=3; // sementara di seting langsung 3 hari
		if(($formail=$this->cm->clear_order_and_cekout($day))){
			// send to email
			// mail libararies
			$this->load->library('mail_lib');
			foreach($formail as $mail){
				$this->mail_lib->del_cekout($mail['email'],$mail['invoice']);
			}
		}
    }
    
    // reminder cekout dijalankan setiap jam 00:10
    function remindercekout($user=false,$pwd=false)
    {
        if(!$user or !$pwd) die('Authentication Required!');
        if($user!='cron' and $pwd!='extr34m') die('Authentication failed!');
        $day=3; // sementara di seting langsung 3 hari
        $hari_ke = array('1'=>'pertama','2'=>'kedua','3'=>'ketiga'); // sementara setting 3 hari dulu
        
		if(($data_cekout=$this->cm->get_cekout_pending()))
		{
			// mail libararies
			$this->load->library('mail_lib');
			// cekout model
			$this->load->module_model('home', 'cekout_model', 'ckm');
			
			foreach($data_cekout as $ck)
			{
				$list_order = $this->ckm->list_cekout_from_id($ck->id_cekout);
				$sisa_hari = ($ck->today_now-$ck->today_cekout); // min 1, tgl ketika cekout tdk di hitung karena msg dikirim tengah malam ketika tgl sdh berbeda

				if($sisa_hari>$day)
				{ // kirim message terakhir, untuk cekout yg telah lama / lbh dari "n" hari
					// send mail
					$this->mail_lib->rem_cekout($ck,$list_order,$hari_ke,$day,$day); #echo 'msg akhir '.$day.'<br />';
					
				}elseif($sisa_hari>0){ // kirim message sesuai hari
					// send mail
					$this->mail_lib->rem_cekout($ck,$list_order,$hari_ke,$sisa_hari,$day); #echo 'msg urut '.($sisa_hari+1).'<br />';
				}
			}
		}
		// tdk ada pesan yg di tampilkan ke email cronjob
	}
	
	// clear cart sekaligus clear history produk, all user
	// dijalankan setiap 00:01
	function clearcart($user=false,$pwd=false)
	{
        if(!$user or !$pwd) die('Authentication Required!');
        if($user!='cron' and $pwd!='extr34m') die('Authentication failed!');
        // clear all cart
		$this->cm->clear_cart();
		// clear all history produk
		#$this->cm->clear_history_produk();
		// tdk ada pesan yg di tampilkan ke email
	}
}
