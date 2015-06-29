<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class katalog_model extends CI_Model{
	var $tb_kat,$tb_subkat,$tb_produk,$tb_subkat2;
	function __construct(){
		parent::__construct();
		$this->tb_kat = 'katalog';
		$this->tb_produk = 'produk';
	}

	function option_kat($empty=true){
		$this->db->select('id,katalog');
		$this->db->order_by('katalog');
		$query = $this->db->get($this->tb_kat);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->katalog;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function list_kat($start=false,$limit=false,$justcount=false){
		$k = $this->tb_kat;
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$k");
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("k.*",FALSE);
		$this->db->order_by("katalog");
		$query = $this->db->get("$k as k"); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_kat($id){
		$k = $this->tb_kat;
		$this->db->select("k.*",FALSE);
		$this->db->where('id',$id);
		$query = $this->db->get("$k as k"); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_kat($id,$kat){
		$this->db->where('id',$id);
		return $this->db->update($this->tb_kat,array('katalog'=>$kat));
	}
	function get_max_id(){
		$this->db->select('max(id)+1 as id');
		$query = $this->db->get($this->tb_kat);
		$row = $query->row();
		$query->free_result();
		return $row->id;
	}
	function input_kat($id,$kat){
		return $this->db->insert($this->tb_kat,array('id'=>$id,'katalog'=>$kat));
	}
	function delete_kat($id){
		return $this->db->delete($this->tb_kat,array('id'=>$id));
	}


}

