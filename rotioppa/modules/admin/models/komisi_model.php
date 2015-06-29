<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Komisi_model extends CI_Model{
	var $tb_kom,$tb_kom_user,$tb_aff;
	function __construct(){
		parent::__construct();
        $this->tb_kom='komisi';
        $this->tb_kom_user='komisi_user';
        $this->tb_aff='aff';
    }
    function list_komisi($search,$start=false,$limit=false,$justcount=false){
        $k=$this->tb_kom_user;
        $a=$this->tb_aff;
        //$this->db->where("date_format(tgl,'%Y-%m') between '".format_date_fordb($search['range']['first'])."' and '".format_date_fordb($search['range']['last'])."'",FALSE,FALSE);
        if(isset($search['aff'])){
            $this->db->where("(nama_lengkap like '%".$search['aff']."%' or nama_panggilan like '%".$search['aff']."%' or email like '%".$search['aff']."%')");
        }
        if(isset($search['status'])){
            $this->db->where('status_kirim',$search['status']);
        }
        $this->db->join($k,"$k.id_aff=$a.id",'left');
		if($justcount){
			$this->db->select('count(*) as jml');
			$query = $this->db->get($a); #echo $this->db->last_query();
            if($query->num_rows>0){
                $row = $query->row();
			    return $row->jml;
            }
            return 0;
		}
		//$this->db->select("date_format(tgl,'%Y-%m') as tgl,total_item,total_harga,total_komisi,status_kirim",FALSE);
        $this->db->select("$k.id,$a.id as id_aff,$a.email,$a.nama_panggilan,$a.min_transfer,komisi,(komisi-min_transfer) as selisih");
        if($limit!==false)
        $this->db->limit($limit,$start);
        $this->db->order_by("selisih desc");
        $query=$this->db->get($a); echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result(); print_r($row);
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function list_komisi_byaff($idaff,$start=false,$limit=false,$justcount=false){
        $k=$this->tb_kom;
        $this->db->where("id_aff",$idaff);
		if($justcount){
			$this->db->select('count(*) as jml');
			$query = $this->db->get($k); #echo $this->db->last_query();
            if($query->num_rows>0){
                $row = $query->row();
			    return $row->jml;
            }
            return 0;
		}
        $this->db->select("id,komisi,date_format(tgl,'%d-%m-%Y') as tgl_kom",FALSE);
        if($limit!==false)
        $this->db->limit($limit,$start);
        $this->db->order_by("tgl");
        $query=$this->db->get($k); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function transfer_komisi($id){
		// get data from komisi user
        $ku=$this->tb_kom_user;
        $this->db->where('id',$id);
        $query=$this->db->get($ku); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			// insert to list komisi aff
			$input=array('id_aff'=>$row->id_aff,'tgl'=>date('Y-m-d'),'komisi'=>$row->komisi);
			if($this->db->insert($this->tb_kom,$input)){
				// del komisi user by id
				return $this->db->delete($ku,array('id'=>$id));
			}
		} #break;
		return false;
    }
    function get_detail_kom($id){
        $this->db->select("*");
        $query = $this->db->get_where($this->tb_kom,array('id'=>$id)); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function cek_aff_has_kom($id){
        $this->db->select("id");
        $query = $this->db->get_where($this->tb_kom_user,array('id_aff'=>$id)); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			return true;
		} #break;
		return false;
    }
    function update_kom_aff($id_aff,$komisi){
		$ku=$this->db->dbprefix($this->tb_kom_user);
		$sql="update $ku set komisi=komisi+$komisi where id_aff=$id_aff";
		return $this->db->query($sql);
	}
    function input_kom_aff($id_aff,$komisi){
		$input=array('id_aff'=>$id_aff,'komisi'=>$komisi);
		return $this->db->insert($this->tb_kom_user,$input);
	}
    function delete_komisi_user($idkom){
		$this->db->where('id',$idkom);
		return $this->db->delete($this->tb_kom);
	}
}
