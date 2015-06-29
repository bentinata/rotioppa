<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fu_model extends CI_Model{
	var $tb_mail;
	function __construct(){
		parent::__construct();
		$this->tb_mail = 'email';
	}

	function list_mail(){
		$b = $this->tb_mail;
		$query = $this->db->get($b); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_mail($id){
		$b = $this->tb_mail;
		$this->db->where("id_email",$id);
		$query = $this->db->get($b); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_mail($id,$type,$subject,$msg,$status){
	    $update=array('type_email'=>$type,'subject'=>$subject,'message'=>$msg,'status_email'=>$status);
		$this->db->where('id_email',$id);
		return $this->db->update($this->tb_mail,$update);
	}
	function input_mail($type,$subject,$msg,$status,$mailfor){
	    $data=array('type_email'=>$type,'subject'=>$subject,'message'=>$msg,'status_email'=>$status,'code_email'=>$mailfor);
		return $this->db->insert($this->tb_mail,$data);
	}
	function delete_mail($id){
		return $this->db->delete($this->tb_mail,array('id_email'=>$id));
	}
	function mail_has_used()
	{
		$this->db->select('code_email');
		$b = $this->tb_mail;
		$query = $this->db->get($b); #echo $this->db->last_query();
		if($query->num_rows()>0)
		{
			$data=false;
			foreach($query->result() as $row)
			{
				if(!empty($row->code_email))
				$data[$row->code_email]= array($row->code_email); // data ny harus dijadikan array karena untuk fungsi arraydiff, ngambil dr config yg berupa data array
			}
			$query->free_result();
			return $data;
		} #break;
		return false;
	}
}
