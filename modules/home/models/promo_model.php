<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Promo_model extends CI_Model
{
	var $tb_promo,$tb_ppr,$tb_rev,$tb_cust,$tb_diskon,$tb_order,$tb_cekout,$tb_wish,$tb_sub,$tb_gbr,$tb_atk,$tb_kat,$tb_hp;
	function __construct()
	{
		parent::__construct();
		$this->tb_promo 	= 'promo';
    
	}

	function list_promo($start=false,$limit=false,$justcount=false,$sub2=false){
	    $p = $this->tb_promo;
       
      	$this->db->order_by("promoID","desc");
       $this->db->select("*");
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}



	
}
