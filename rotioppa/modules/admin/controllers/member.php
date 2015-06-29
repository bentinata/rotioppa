<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Member extends Admin_Controller{
	function __construct(){
		parent::__construct();
		/* load lang */
		$this->lang->load('defmember');
		/* load model */
		$this->load->model('member_model', 'mm');

	}
	// order 1:email 2:nama_lengkap 3:tgl_signup 4:no_tlp
	function index($order=false,$asdesc=false)
	{   $search=false;
        if($this->input->post('_CARI')){
            $data['val'] = $this->input->post('val');
            $data['key'] = $this->input->post('key');
            $search=$data;
        }
        $for_paging=$ord=false;
		if($order && $order!='page'){ // tuk menandai bukan variable dari pagination 
			$ord=array('order'=>$order,'asdesc'=>$asdesc);
			$for_paging='/'.$order.'/'.$asdesc;
		} 
        // paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->mm->list_member($search,$ord,false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.$for_paging;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['cust'] = $this->mm->list_member($search,$ord,$limitstart,$paging['limit']);
		$this->template->set_view ('member',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->mm->delete_member($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function detail($id=false){
	    if(!$id) redirect(config_item('modulename'));
	    if($this->input->post('_SAVE')){
			$email=$this->input->post('email');
			$pass=$this->input->post('pass');
			$full=$this->input->post('fullname');
			$nick=$this->input->post('nickname');
    		$tlp=$this->input->post('tlp');
    		$jenkel=$this->input->post('jenkel');
        	$lahir=$this->input->post('thn').'-'.$this->input->post('bln').'-'.$this->input->post('tgl');
        	$ktrumah=$this->input->post('kota_rumah');
            $rumah=$this->input->post('alamat_rumah');
        	$ktkirim=$this->input->post('kota_kirim');
        	$kirim=$this->input->post('alamat_kirim');
            $zk=$this->input->post('zip_kirim');
            $zr=$this->input->post('zip_rumah');
        	$se=$this->input->post('sendmail')=='yes'?true:false;
            $this->mm->update_member($id,$pass,$full,$nick,$tlp,$jenkel,$lahir,$rumah,$ktrumah,$kirim,$ktkirim,$se,$zr,$zk,$email);
            $data['ok'] = true;$data['msg'] = lang('update_success');
	    }
		$data['method'] = 'profile';
        $data['propinsi'] = $this->mm->option_prop();
        $data['cust'] = $this->mm->detail_member($id);
		$this->template->set_view ('member_profile',$data,config_item('modulename'));
	}
	function optionkota(){
		$this->template->clear_layout();
		$kat = $this->input->post('prov'); if(!$kat) exit();
		$listsub = $this->mm->option_kota($kat,false);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}
	function aktivasi(){
		$this->template->clear_layout();
		$id=$this->input->post('id');
		if(!$id){ redirect_java('poseidon/member'); exit();}
		
		$this->mm->active_member($id);
		$detail = $this->mm->detail_member($id); #print_r($detail);
		$link_login = site_url('login');

		// send mail
		$this->load->library('mail_lib');
        $this->mail_lib->act_member($detail->email,$detail->nama_panggilan,$detail->password,$link_login);

		java_alert(lang('actv_member_ok'));
	}
	function aktivasi_just_mail(){
		$this->template->clear_layout();
		$id=$this->input->post('id');
		if(!$id){ redirect_java('poseidon/member'); exit();}
		
		$detail = $this->mm->detail_member($id); #print_r($detail);
		$link_login = site_url('login');

		// send mail
		$this->load->library('mail_lib');
		$ln = site_url('home/reg/activation/'.$detail->activation_code.'/'.myEncrypt($detail->email));
        $this->mail_lib->reg_member($detail->email,$ln,$detail->nama_panggilan);

		java_alert(lang('mail_member_ok'));
	}

}
