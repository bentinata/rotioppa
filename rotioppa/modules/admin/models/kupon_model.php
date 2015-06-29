<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kupon_model extends CI_Model{
	var $tb_kupon;
	function __construct(){
		parent::__construct();
		$this->tb_kupon = 'kupon';

    }
    function list_kupon($search,$order=false,$start=false,$limit=false,$justcount=false){
        $this->db->select("*");
        if($search){
            $this->db->like('kode_kupon',$search['val']);
        }

        if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($this->tb_kupon);
			$row = $query->row();
			return $row->jml;
		}
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
        $query = $this->db->get($this->tb_kupon); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
	function delete_kupon($id)
	{
		$this->db->delete($this->tb_kupon,array('id_kupon'=>$id));
        return true;
	}
	function detail_kupon($id)
	{
        $query = $this->db->get_where($this->tb_kupon,array('id_kupon'=>$id)); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_kupon($id,$kode,$jenis,$nilai,$awal,$akhir,$status)
	{
		$update = array(
			'kode_kupon'=>$kode,
			'jenis_kupon'=>$jenis,
			'nilai_kupon'=>$nilai,
			'tgl_awal'=>$awal,
			'tgl_akhir'=>$akhir,
			'status_kupon'=>$status
		);
		$this->db->where('id_kupon',$id);
		return $this->db->update($this->tb_kupon,$update); #echo $this->db->last_query();
	}
	function input_kupon($kode,$jenis,$nilai,$awal,$akhir,$status)
	{
		$input = array(
			'kode_kupon'=>$kode,
			'jenis_kupon'=>$jenis,
			'nilai_kupon'=>$nilai,
			'tgl_awal'=>$awal,
			'tgl_akhir'=>$akhir,
			'status_kupon'=>$status
		);
		return $this->db->insert($this->tb_kupon,$input); #echo $this->db->last_query();
	}
}
