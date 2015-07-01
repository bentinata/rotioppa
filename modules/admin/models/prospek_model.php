<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prospek_model extends CI_Model{
	var $tb_pros;
	function __construct(){
		parent::__construct();
		$this->tb_pros = 'prospek';

    }
    function list_member($search,$order=false,$start=false,$limit=false,$justcount=false){
        $this->db->select("id,email,nama,date_format(tgl,'%d-%m-%Y') as tgl_daftar,date_format(tgl_validate,'%d-%m-%Y') as tgl_valid,tgl,tgl_validate",FALSE);
        if($search){
            if($search['key']=='1') $this->db->like('email',$search['val']);
            if($search['key']=='2') $this->db->like('nama',$search['val']);
            if($search['key']=='3') $this->db->where("date_format(tgl,'%Y-%m-%d') between '".$search['val']['tgl1']."' and '".$search['val']['tgl2']."'");
        }

        if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($this->tb_pros);
			$row = $query->row();
			return $row->jml;
		}
        if($limit!==false)
		$this->db->limit($limit,$start);
		if($order){
			switch($order['order']){
				case '1':$or='email';break;
				case '2':$or='nama';break;
				case '3':$or='tgl';break;
				case '4':$or='tgl_validate';break;
				default:$or=false;
			}
			if($order['asdesc']=='a')$ad='asc';else $ad='desc';
			$this->db->order_by($or,$ad);
		}
        $query = $this->db->get($this->tb_pros); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
	function delete_member($id){
		$this->db->delete($this->tb_pros,array('id'=>$id));
        return true;
	}
}
