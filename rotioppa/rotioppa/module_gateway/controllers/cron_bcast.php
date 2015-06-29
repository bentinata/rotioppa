<? if (!defined('BASEPATH')) exit('No direct script access allowed');

/* for cron : lynx -source http://www.kueibuhasan.com/ext/cron_bcast/send_bcast/cron/extr34m.html
 * used : http://localhost/kueibuhasan/ext/cron_bcast/send_bcast/user/extr34m/2
 * user --> usename in ctr
 * extr34m --> password in ctr
 * 2 --> limit of send mail
 * 
 * */

class Cron_bcast extends Controller{
	function Cron_bcast(){
		parent::Controller();
		/* load config */
		#$this->load->config('config_home');
		/* load lang */
		#$this->lang->load('home',$this->globals->lang);
		/* load model */
		$this->load->module_model($this->router->module, 'bcast_model', 'bm');

		/* to check system speed and query --> just for admin */
		#$this->output->enable_profiler(TRUE);
	}
	function index(){
        echo '';
    }
    function send_bcast($user=false,$pwd=false,$limit=false){
        if(!$user or !$pwd) die('Authentication Required!');
        if($user!='cron' and $pwd!='extr34m') die('Authentication failed!');
        
        if(!$limit) $limit=100; // default 100 email dalam sekali exekusi broadcast per satu msg
        // get broadcast email with status proses
        $bcast=$this->bm->get_bcast(); #print_r($bcast);
        if($bcast)
		{
			// get queue and update proses queue
			foreach($bcast as $k_bcast=>$e_bcast)
			{
				$que=$this->bm->get_que($e_bcast->id,$limit); #print_r($que);
				
				// jika que ada, maka simpan sebagai data que untuk bcast tsb
				if($que)
				{
					$d_que[$k_bcast]=$que;
					$d_bcast[$k_bcast]=$e_bcast;
				}
				// set bcast ke finish
				else
				{
					$this->bm->update_finish_mail($e_bcast->id);
				}
			} #print_r($d_que);print_r($d_bcast);
			
			if(isset($d_que))
			{
				// start send mail
				$this->load->library('email');				
				foreach($d_que as $k_que=>$e_que)
				{
					foreach($e_que as $eque)
					{
						$this->email->clear();
						$this->email->from('admin@kueibuhasan.com','Admin');
						$this->email->to($eque->email); 
						$this->email->subject($d_bcast[$k_que]->subject);
						$this->email->message($d_bcast[$k_que]->msg);
						if($this->email->send())
							$ok[]=$eque->id;
						else $er[]=$eque->id;
					}
					if(isset($ok))$_ok[$k_que]=$ok;
					if(isset($er))$_er[$k_que]=$er;
				}
				
				// delete queue table
				if(isset($_ok))
				{ 
					foreach($_ok as $_k=>$_v)
					{// delete email queue
						$this->bm->delete_que_by_id($_v);
						$upd[$_k]['ok']=count($_v);
					}
				}
				
				// update que to error
				if(isset($_er))
				{ 
					foreach($_er as $_k2=>$_v2)
					{ 
						$this->bm->update_que_from_id($_v2,'2');
						$upd[$_k2]['er']=count($_v2);
					}
				}
				
				
				// update to email table
				if(isset($upd))
				{ #print_r($upd);
					$ok=$er=$tot=0;
					foreach($upd as $key=>$dt)
					{
						$idmail=$d_bcast[$key]->id;
						if(isset($dt['ok']))$ok=$dt['ok'];
						if(isset($dt['er']))$er=$dt['er'];
						$tot=$ok+$er;
						$this->bm->update_mail_count($idmail,$ok,$er,$tot);

						// statistik
						$echo ='Email: '.$d_bcast[$k_que]->subject."\r\n";
						$echo.='Tgl: '.date('d-m-Y H:i:s')."\r\n";
						$echo.='Sukses: '.$ok."\r\n";
						$echo.='Error: '.$er."\r\n";
						$echo.='Total: '.$tot."\r\n";
						
					}
					echo nl2br($echo);
				}
			}
		}
    }
}
