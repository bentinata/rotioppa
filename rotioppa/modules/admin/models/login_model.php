<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model{
	var $tb_user,$tb_cust,$tb_cart,$tb_produk,$tb_aff,$tb_atk,$tb_hp;

	function __construct(){
		parent::__construct();
		$this->tb_user = 'admin';
	
	}
	
	function check_admin($user){
		$where = array('username'=>$user);
		$this->db->select('id,username,password');
		$query = $this->db->get_where($this->tb_user,$where); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	

}
