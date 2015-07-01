<?php

class Slider_model extends CI_Model{
	
	function read($table,$where=false){
		if($where) $this->db->where($where);
		$read=$this->db->get($table);
		return $read->result();
	}
	
	function read_single($table,$where=false){
		if($where) $this->db->where($where);
		$read=$this->db->get($table);
		return $read->row();
	}

	function create($table,$data){
		return $this->db->insert($table,$data);
	}
	
	function update($table,$data,$where){
		$this->db->where($where);
		return $this->db->update($table, $data); 
	}
	
	function del($table,$where)
	{
		$this->db->where($where);
		return $this->db->delete($table);
	}
	function get_max_pos(){
		$this->db->select('max(position)+1 as pos');
		$query = $this->db->get('slider');
		$row = $query->row();
		$query->free_result();
		return $row->pos;
	}
	function updatelist($id,$position){
	
		// UPDATE [Table] SET [Position] = $i WHERE [EntityId] = $value
		$this->db->where('id',$id);
		return $this->db->update('slider',array('position'=>$position));
    }
		
}
