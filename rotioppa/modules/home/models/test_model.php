<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test_model extends CI_Model{
	var $tb_cart;
	function __construct(){
		parent::__construct();
        $this->tb_cart = 'cart';
        #$this->db->query("set time_zone='+7:00'");
	}
    function get_time(){
        #$this->db->query("set time_zone='+7:00'");
        $sql = "select date_format(now(),'%d-%m-%Y %H:%i') as dt";
        $query = $this->db->query($sql);
        if($query->num_rows()>0){ #break;
        	$row = $query->row();
        	return $row;
        }
        return false;
    }
}
