<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vendor_model extends CI_Model{
	var $tb_vendor,$tb_vcode,$tb_produk;
	function __construct(){
		parent::__construct();
		$this->tb_vendor = 'vendor';
		$this->tb_vcode = 'kode_vendor';
		$this->tb_produk = 'produk';
	}

	function option_vendor($empty=true){
		$this->db->select('id,vendor');
		$query = $this->db->get($this->tb_vendor);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->vendor;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function list_vendor($start=false,$limit=false,$justcount=false){
		$k = $this->tb_vendor;
		$sk = $this->db->dbprefix($this->tb_vcode);
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$k");
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("k.*,(select count(*) from $sk where id_vendor=k.id) as jml",FALSE);
		$this->db->order_by("vendor");
		$query = $this->db->get("$k as k"); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_vendor($id){
		$k = $this->tb_vendor;
		$sk = $this->db->dbprefix($this->tb_vcode);
		$this->db->select("k.*,(select count(*) from $sk where id_vendor=k.id) as jml",FALSE);
		$this->db->where('id',$id);
		$query = $this->db->get("$k as k"); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_vendor($id,$vd){
		$this->db->where('id',$id);
		return $this->db->update($this->tb_vendor,array('vendor'=>$vd));
	}
	function input_vendor($vd){
		return $this->db->insert($this->tb_vendor,array('vendor'=>$vd));
	}
	function delete_vendor($id){
		return $this->db->delete($this->tb_vendor,array('id'=>$id));
	}

	function list_vcode($id=false,$start=false,$limit=false,$justcount=false){
		$k = $this->tb_vendor;
		$sk = $this->tb_vcode;
		$skp = $this->db->dbprefix($sk);
		$p = $this->db->dbprefix($this->tb_produk);
		if($id)
		$this->db->where('id_vendor',$id);
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$sk");
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("$sk.id,$sk.kode_produk_vendor,$sk.id_vendor,$k.vendor,(select count(*) from $p where kode_produk_vendor=$skp.id) as jml",FALSE);
		$this->db->join($k,"$sk.id_vendor=$k.id",'left');
		$this->db->order_by("$k.vendor,$sk.kode_produk_vendor");
		$query = $this->db->get($sk); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_vcode($id){
		$sk = $this->tb_vcode;
		$skp = $this->db->dbprefix($sk);
		$p = $this->db->dbprefix($this->tb_produk);
		$this->db->select("*,(select count(*) from $p where kode_produk_vendor=$skp.id) as jml",FALSE);
		$this->db->where('id',$id);
		$query = $this->db->get("$sk"); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_vcode($id,$idvendor,$kode){
		$this->db->where('id',$id);
		return $this->db->update($this->tb_vcode,array('id_vendor'=>$idvendor,'kode_produk_vendor'=>$kode));
	}
	function input_vcode($idvendor,$kode){
		return $this->db->insert($this->tb_vcode,array('id_vendor'=>$idvendor,'kode_produk_vendor'=>$kode));
	}
	function delete_vcode($id){
		return $this->db->delete($this->tb_vcode,array('id'=>$id));
	}
	function cek_code_vendor($vendor,$code){
		$query=$this->db->get_where($this->tb_vcode,array('id_vendor'=>$vendor,'kode_produk_vendor'=>$code));
		if($query->num_rows()>0){ #break;
			$query->free_result();
			return true;
		} #break;
		return false;
	}
}

