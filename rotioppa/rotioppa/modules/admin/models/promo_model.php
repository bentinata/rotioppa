<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Promo_model extends CI_Model{
	var $tb_kat,$tb_subkat,$tb_promo,$tb_order,$tb_vendor,$tb_vcode,$tb_subkat2,
		$tb_gbr,$tb_atk,$tb_his_stock,$tb_attr,$tb_rel_diskon,$tb_cart,$tb_wishlist,$tb_rev;
	function __construct(){
		parent::__construct();
	$this->tb_promo = 'promo';
	}

	function list_promo($start=false,$limit=false,$justcount=false){
		$p = $this->tb_promo;
		
		// if($filter){
		// 	switch($filter){
		// 		case'1':
		// 			if(strlen($key)<5) return 'err_1';
		// 			$id=get_id_from_kode($key);
		// 			$this->db->where("$p.id",$id);
		// 			break;
		// 		case'2':
		// 			$this->db->like("$p.promo","$key");
		// 			break;
		// 		case'3':
		// 			$this->db->where("$p.id_subkategori","$key");
		// 			break;
		// 		#case'4':
		// 		#	$this->db->like("$sk.subkategori","$key");
		// 		#	break;
		// 		case'5':
		// 			$this->db->where("date_format(tgl,'%Y-%m-%d') between '$key[tgl1]' and '$key[tgl2]'");
		// 			$this->db->order_by('tgl '.$key['order']);
		// 			break;
		// 		case'6':
		// 			$this->db->where("$p.stock","$key");
		// 			break;
		// 		case'7':
		// 			$this->db->where("$p.id_kode_vendor","$key");
		// 			break;
		// 	}
		// }
  //       if($filter2 && $filter!='7'){
  //           $this->db->where("$p.id_kode_vendor","$filter2");
  //       }
		// $this->db->join($sk, "$p.id_subkategori=$sk.id", 'left');
		// $this->db->join($k, "$p.id_kategori=$k.id", 'left');
		// $this->db->join($kat, "$p.id_katalog=$kat.id", 'left');
		if($justcount){
		// 	$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($p);
			$row = $query->row();
			// return $row->jml;
		}
		// $this->db->join($sk2, "$p.id_subkategori2=$sk2.id", 'left');
        if($limit!==false)
		$this->db->limit($limit,$start);
		// $this->db->select("$p.id,$p.promo,$p.tgl,$k.kategori,$k.id as idkat,"
  //           ."$sk.subkategori,$sk.id as idsub,$sk2.subkategori2, $kat.katalog,"
  //           ."(SELECT kode_promo_vendor FROM $vcp WHERE id=$pp.id_kode_vendor ) AS vcode"
  //           ,FALSE);
		// $this->db->order_by("vcode,$p.id,$p.promo");
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
    function cek_order_by_promo($id){
		$this->db->select("count(*) as jml");
		$query=$this->db->get_where($this->tb_promo,array('promOID'=>$id));
		if($query->num_rows()>0){ 
			$row = $query->row();
			$query->free_result();
			if($row->jml>0) return true;
		}
		return false;
	}

	function get_max_id($tabel='promo'){
		if($tabel=='promo') $t = $this->tb_promo;
		$this->db->select('max(promoid)+1 as id');
		$query = $this->db->get($t);
		$row = $query->row();
		$query->free_result();
		return $row->id?$row->id:1;
	}

	function detail_promo($id){
		$p = $this->tb_promo;
        // query 1
		$this->db->select("$p.*");
		$this->db->where("$p.promoid",$id);
        $query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	
	function input_promo($id,$promo,$deskripsi,$image){
		$data = array(
			'promoid'=>$id,
			'judul_promo'=>$promo,
			'promo'=>$deskripsi,
			'image'=>$image
			
		);
        $res = $this->db->insert($this->tb_promo,$data); #echo $this->db->last_query();

        return $res;
	}

	function update_promo($id,$promo,$deskripsi,$image){

		if($image){
		
		$data = array(
			'promoid'=>$id,
			'judul_promo'=>$promo,
			'promo'=>$deskripsi,
			'image'=>$image
		);
	}else{

		$data = array(
			'promoid'=>$id,
			'judul_promo'=>$promo,
			'promo'=>$deskripsi,
		);
	}
        $this->db->where('promoid',$id);
        $res = $this->db->update($this->tb_promo,$data); #echo $this->db->last_query();
        return $res;
	}
	function dell_promo($id_promo){
		return $this->db->delete($this->tb_promo,array('promOID'=>$id_promo));
	}

}
