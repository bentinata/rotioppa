<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Testimoni_model extends CI_Model{
	var $tb;
	function __construct(){
		parent::__construct();
		$this->tb = 'testimoni';
	}
	function list_daftar($start=false,$limit=false,$justcount=false){
		$i = $this->tb;
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($i);
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->order_by("date_input desc");
		$query = $this->db->get($i); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail($id){
		$i = $this->tb;
		$this->db->where("id",$id);
		$query = $this->db->get($i); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update($id,$update){
		$this->db->where('id',$id);
		return $this->db->update($this->tb,$update);
	}
	function input($data){
		return $this->db->insert($this->tb,$data);
	}
	function delete($id){
		return $this->db->delete($this->tb,array('id'=>$id));
	}

}