<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bcast_model extends CI_Model{
	var $tb_mail,$tb_q,$tb_cust,$tb_aff,$tb_pros;
	function __construct(){
		parent::__construct();
		// table utama
		$pref=$this->db->dbprefix;
		$this->tb_cust=$pref.'customer';
		$this->tb_aff=$pref.'aff';
		$this->tb_pros=$pref.'prospek';
		
		$this->tb_mail = 'mail';
		$this->tb_q = 'queue';
		$this->db->dbprefix='bcast_';
	}

	function list_mail(){
		$b = $this->tb_mail;
		$this->db->order_by('date_created');
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
		$this->db->where("id",$id);
		$query = $this->db->get($b); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_mail($id,$to,$subject,$msg){
	    $update=array('to'=>$to,'subject'=>$subject,'msg'=>$msg);
		$this->db->where('id',$id);
		return $this->db->update($this->tb_mail,$update);
	}
	function input_mail($to,$subject,$msg){
	    $data=array('to'=>$to,'subject'=>$subject,'msg'=>$msg,'date_created'=>date('Y-m-d H:i:s'));
		return $this->db->insert($this->tb_mail,$data);
	}
	function delete_mail($id){
		//delete queue first
		$this->db->delete($this->tb_q,array('id_bcast'=>$id));
		//delete mail
		return $this->db->delete($this->tb_mail,array('id'=>$id));
	}
	function proses_mail($id,$status='1',$count=false)
	{
		$m=$this->db->dbprefix($this->tb_mail);
		$q=$this->db->dbprefix($this->tb_q);
		$sql="update $m set proses='$status' where id=$id";
		if($count && $status=='1')
		$sql="update $m set proses='$status',antri=(select count(*) from $q where id_bcast=$id) where id=$id";
		return $this->db->query($sql);
	}
	function insert_queue($bcast,$idto)
	{
		if($idto=='1') $tb=$this->tb_cust;
		elseif($idto=='2') $tb=$this->tb_pros;
		else $tb=$this->tb_aff;
		
		$q=$this->db->dbprefix($this->tb_q);
		$sql="insert into $q (id_bcast,id_to,email) "
			."select '$bcast','$idto',email from $tb";
		return $this->db->query($sql);
	}

}
