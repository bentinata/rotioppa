<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bcast_model extends Model{
	var $tb_mail,$tb_q;
	function Bcast_model(){
		parent::Model();
		$this->tb_mail = 'mail';
        $this->tb_q = 'queue';
        $this->db->dbprefix='bcast_';
    }
    function get_bcast()
    {
		$m=$this->tb_mail;
		$this->db->select('id,msg,subject');
		$this->db->where('proses','1');
		$query=$this->db->get($m);
		if($query->num_rows()>0){ 
			$row = $query->result();
			$query->free_result();
			return $row;
		} 
		return false;
	}
	function get_que($idb,$limit)
	{
		$idq=$this->get_que_id($idb,$limit);
		if($idq)
		{
			$que=$this->get_que_from_id($idq);
			$this->update_que_from_id($idq);
			return $que;
		}
		return false;
	}
	function get_que_id($idb,$limit)
	{
		$this->db->select("id as ids",FALSE,FALSE);
		$this->db->where(array('id_bcast'=>$idb,'status'=>'1'));
		$this->db->limit($limit);
		$query=$this->db->get($this->tb_q); #echo $this->db->last_query();break;
		if($query->num_rows()>0){ 
			foreach($query->result() as $row)
			{
				$data[]=$row->ids;
			}
			$query->free_result(); 
			return $data;
		} 
		return false;
	}
	function get_que_from_id($id)
	{
		$q=$this->tb_q;
		$this->db->select('id,email,id_to');
		$this->db->where_in('id',$id);
		$query=$this->db->get($q);
		if($query->num_rows()>0){ 
			$row = $query->result();
			$query->free_result();
			return $row;
		} 
		return false;
	}
	function update_que_from_id($id,$status=3)
	{ 
		$this->db->where_in('id',$id);
		$q=$this->db->update($this->tb_q,array('status'=>$status)); #echo $this->db->last_query();
		return $q;
	}
	function update_finish_mail($id)
	{
		$m=$this->db->dbprefix($this->tb_mail);
		$sql="update $m set proses='3' where id=$id";
		return $this->db->query($sql);
	}
	function delete_que_by_id($id)
	{
		$this->db->where_in('id',$id);
		return $this->db->delete($this->tb_q);
	}
	function update_mail_count($id,$ok,$er,$tot)
	{
		$m=$this->db->dbprefix($this->tb_mail);
		$sql="update $m set antri=antri-$tot,success=success+$ok,error=error+$er where id=$id"; 
		$q=$this->db->query($sql); #echo $this->db->last_query();
		return $q;
	}
}
