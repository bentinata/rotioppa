<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_lib
{
	var $sess_pos = '_POSEIDON';
	

    var $sess_user = '_USERNAME';        // dipertimbangkan
    var $sess_id = '_ID';
    var $sess_data = '_DATA';
    
    var $CI;

	function __construct()
	{ 
		$this->CI =& get_instance();
	}

	function pos_sess_login($data){
		$setdata[$this->sess_pos][$this->sess_id] = $data->id;
        $setdata[$this->sess_pos][$this->sess_data] = $data;
		return $this->CI->session->set_userdata($setdata);
	}
	function pos_check_has_login(){
		$data_pos = $this->CI->session->userdata($this->sess_pos);
		if($data_pos!=FALSE && isset($data_pos[$this->sess_id]) && !empty($data_pos[$this->sess_id])){ #break;
			redirect('admin');
		} #break;
	}
	function pos_check_not_login(){
		$data_pos = $this->CI->session->userdata($this->sess_pos); #echo $user;break;
		if($data_pos==FALSE or (isset($data_pos[$this->sess_id]) && empty($data_pos[$this->sess_id]))){
			return false;
		}
		return true;
	}
	function pos_has_login(){
		$data_pos = $this->CI->session->userdata($this->sess_pos);
		if($data_pos!=FALSE && isset($data_pos[$this->sess_id]) && !empty($data_pos[$this->sess_id])){ #break;
			return true;
		} return false;
	}
	function pos_get_data($key){
		$data_pos = $this->CI->session->userdata($this->sess_pos);
		if($data_pos!=FALSE && isset($data_pos[$this->sess_data]) && isset($data_pos[$this->sess_data]->$key)){ #break;
			return $data_pos[$this->sess_data]->$key;
		} return false;
	}
    function pos_logout(){
        $this->CI->session->unset_userdata($this->sess_pos);
    }


	

}
