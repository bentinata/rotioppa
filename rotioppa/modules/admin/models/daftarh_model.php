<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Daftarh_model extends CI_Model{
	var $tb_info,$tb_daftarh;
	function __construct(){
		parent::__construct();
		$this->tb_daftarh = 'daftarh';
		$this->tb_info = 'info';
	}
	function list_info($start=false,$limit=false,$justcount=false){
		$i = $this->tb_info;
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($i);
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("id,left(info,100) as info",FALSE);
		$this->db->order_by("tgl desc");
		$query = $this->db->get($i); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_info($id){
		$i = $this->tb_info;
		$this->db->select("id,info");
		$this->db->where("id",$id);
		$query = $this->db->get($i); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_info($id,$info){
	    $update=array('info'=>$info,'tgl'=>date('Y-m-d H:i:s'));
		$this->db->where('id',$id);
		return $this->db->update($this->tb_info,$update);
	}
	function input_info($info){
	    $data=array('info'=>$info,'tgl'=>date('Y-m-d H:i:s'));
		return $this->db->insert($this->tb_info,$data);
	}
	function delete_info($id){
		return $this->db->delete($this->tb_info,array('id'=>$id));
	}

	function list_harga($start=false,$limit=false,$justcount=false){
		$f = $this->tb_daftarh;
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($f);
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("id",FALSE);
		$query = $this->db->get($f); echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} break;
		return false;
	}
	function detail_harga($id){
		$f = $this->tb_daftarh;
		$this->db->select("id,content");
		$this->db->where("id",$id);
		$query = $this->db->get($f); echo $this->db->last_query();
		if($query->num_rows()>0){ break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} break;
		return false;
	}
	function update_harga($id,$ans){
	    $update=array('content'=>$ans);
		$this->db->where('id',$id);
		return $this->db->update($this->tb_daftarh,$update);
	}
	function input_harga($ans){
	    $data=array('content'=>$ans);
		return $this->db->insert($this->tb_daftarh,$data);
	}
	function delete_harga($id){
		return $this->db->delete($this->tb_daftarh,array('id'=>$id));
	}

}