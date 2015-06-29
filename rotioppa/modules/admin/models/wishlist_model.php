<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wishlist_model extends CI_Model{
	var $tb_wish,$tb_produk;
	function __construct(){
		parent::__construct();
		$this->tb_wish = 'wishlist';
		$this->tb_produk = 'produk';
	}
	function list_wish($start=false,$limit=false,$justcount=false){
		$w = $this->tb_wish;
		$p = $this->tb_produk;
		$wp = $this->db->dbprefix($w);
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($w);
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("$w.id,$w.nama,$w.email,$w.id,$p.nama_produk");
		$this->db->select("date_format($wp.tgl,'%d-%m-%Y') as tgl_add",FALSE);
		$this->db->order_by("$w.tgl");
		$this->db->join($p,"$w.id_produk=$p.id",'left');
		$query = $this->db->get($w); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function delete_wish($id){
		return $this->db->delete($this->tb_wish,array('id'=>$id));
	}
	function add_wish($idp,$nama,$email)
	{
		$data=array(
			'id_produk'=>$idp,
			'tgl'=>date('Y-m-d H:i:s'),
			'nama'=>$nama,
			'email'=>$email
		);
		return $this->db->insert($this->tb_wish,$data);
	}
}

