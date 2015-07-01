<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Info_model extends CI_Model{
	var $tb_info,$tb_faq;
	function __construct(){
		parent::__construct();
		$this->tb_faq = 'faq';
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

	function list_faq($start=false,$limit=false,$justcount=false){
		$f = $this->tb_faq;
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($f);
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("id,left(question,100) as question",FALSE);
		$this->db->order_by("tgl desc");
		$query = $this->db->get($f); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_faq($id){
		$f = $this->tb_faq;
		$this->db->select("id,question,answer");
		$this->db->where("id",$id);
		$query = $this->db->get($f); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_faq($id,$quest,$ans){
	    $update=array('answer'=>$ans,'question'=>$quest,'tgl'=>date('Y-m-d H:i:s'));
		$this->db->where('id',$id);
		return $this->db->update($this->tb_faq,$update);
	}
	function input_faq($quest,$ans){
	    $data=array('answer'=>$ans,'question'=>$quest,'tgl'=>date('Y-m-d H:i:s'));
		return $this->db->insert($this->tb_faq,$data);
	}
	function delete_faq($id){
		return $this->db->delete($this->tb_faq,array('id'=>$id));
	}

}