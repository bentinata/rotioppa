<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kategori_model extends CI_Model{
	var $tb_kat,$tb_subkat,$tb_produk,$tb_subkat2;
	function __construct(){
		parent::__construct();
		$this->tb_kat = 'kategori';
		$this->tb_subkat = 'kategori_sub';
		$this->tb_subkat2 = 'kategori_sub2';
		$this->tb_produk = 'produk';
	}

	function option_kat($empty=true){
		$this->db->select('id,kategori');
		$this->db->order_by('kategori');
		$query = $this->db->get($this->tb_kat);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->kategori;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function list_kat($start=false,$limit=false,$justcount=false){
		$k = $this->tb_kat;
		$sk = $this->db->dbprefix($this->tb_subkat);
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$k");
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("k.*",FALSE);
		$this->db->order_by("kategori");
		$query = $this->db->get("$k as k"); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_kat($id){
		$k = $this->tb_kat;
		$sk = $this->db->dbprefix($this->tb_subkat);
		$this->db->select("k.*,(select count(*) from $sk where id_kategori=k.id) as jml",FALSE);
		$this->db->where('id',$id);
		$query = $this->db->get("$k as k"); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_kat($id,$kat){
		$this->db->where('id',$id);
		return $this->db->update($this->tb_kat,array('kategori'=>$kat));
	}
	function get_max_id(){
		$this->db->select('max(kategoriID)+1 as id');
		$query = $this->db->get($this->tb_kat);
		$row = $query->row();
		if($row->id == 0){
			return 1;
		}else{
		$query->free_result();
		return $row->id;
		}
	}
	function input_kat($id,$kat){
		return $this->db->insert($this->tb_kat,array('kategoriID'=>$id,'kategori'=>$kat));
	}
	function delete_kat($id){
		return $this->db->delete($this->tb_kat,array('id'=>$id));
	}

	function option_sub($id,$empty=false){
		$this->db->where('id_kategori',$id);
		$this->db->order_by('subkategori');
		$query = $this->db->get($this->tb_subkat); #echo $this->db->last_query();
		if($query->num_rows()>0){ 
			if($empty) $data['-'] = lang('select_option');
			foreach($query->result() as $row){
				$data[$row->id] = $row->subkategori;
			}
			$query->free_result();
			return $data;
		} 
		return false;
	}
	function list_sub2($id=false,$start=false,$limit=false,$justcount=false){
		$k = $this->tb_kat;
		$sk = $this->tb_subkat;
		$skp = $this->db->dbprefix($this->tb_subkat);
		$p = $this->db->dbprefix($this->tb_produk);
		$sk2 = $this->tb_subkat2;
		$skp2 = $this->db->dbprefix($this->tb_subkat2);
		if($id)
		$this->db->where('id_subkategori',$id);
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($sk2);
			$row = $query->row();
			return $row->jml; 
		}
		$this->db->select("$sk2.id,$sk.subkategori,$k.kategori,$sk2.subkategori2,$sk2.id_subkategori,
			(select count(*) from $p where id_subkategori2=$skp2.id) as jml",FALSE);
		$this->db->join($sk,"$sk2.id_subkategori=$sk.id",'left');
		$this->db->join($k,"$sk.id_kategori=$k.id",'left');
		$this->db->order_by("$k.kategori,$sk.subkategori,$sk2.subkategori2");
		$query = $this->db->get($sk2); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_subkat2($id){
		$sk = $this->tb_subkat2;
		$skp = $this->db->dbprefix($this->tb_subkat2);
		$p = $this->db->dbprefix($this->tb_produk);
		$sk1 = $this->tb_subkat;
		$this->db->select("$sk.*,$sk1.id_kategori,(select count(*) from $p where id_subkategori=$skp.id) as jml",FALSE);
		$this->db->where("$sk.id",$id);
		$this->db->join($sk1,"$sk.id_subkategori=$sk1.id",'left');
		$query = $this->db->get("$sk"); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_subkat2($id,$idsubkat,$subkat2){
		$this->db->where('id',$id);
		return $this->db->update($this->tb_subkat2,array('id_subkategori'=>$idsubkat,'subkategori2'=>$subkat2));
	}
	function sub_get_max_id2(){
		$this->db->select('max(id)+1 as id');
		$query = $this->db->get($this->tb_subkat2); 
		$row = $query->row();
		$query->free_result();
		return $row->id;
	}
	function input_subkat2($id,$idsubkat,$subkat2){
		return $this->db->insert($this->tb_subkat2,array('id'=>$id,'id_subkategori'=>$idsubkat,'subkategori2'=>$subkat2));
	}
	function delete_subkat2($id){
		return $this->db->delete($this->tb_subkat2,array('id'=>$id));
	}

}

