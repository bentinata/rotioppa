<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Produk_model extends CI_Model{
	var $tb_kat,$tb_subkat,$tb_produk,$tb_order,$tb_vendor,$tb_vcode,$tb_subkat2,
		$tb_gbr,$tb_atk,$tb_his_stock,$tb_attr,$tb_rel_diskon,$tb_cart,$tb_wishlist,$tb_rev;
	function __construct(){
		parent::__construct();
	$this->tb_produk = 'menu';
	}

	function list_produk($start=false,$limit=false,$justcount=false){
		$p = $this->tb_produk;
		
		// if($filter){
		// 	switch($filter){
		// 		case'1':
		// 			if(strlen($key)<5) return 'err_1';
		// 			$id=get_id_from_kode($key);
		// 			$this->db->where("$p.id",$id);
		// 			break;
		// 		case'2':
		// 			$this->db->like("$p.nama_produk","$key");
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
		// $this->db->select("$p.id,$p.nama_produk,$p.tgl,$k.kategori,$k.id as idkat,"
  //           ."$sk.subkategori,$sk.id as idsub,$sk2.subkategori2, $kat.katalog,"
  //           ."(SELECT kode_produk_vendor FROM $vcp WHERE id=$pp.id_kode_vendor ) AS vcode"
  //           ,FALSE);
		// $this->db->order_by("vcode,$p.id,$p.nama_produk");
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
    
	function get_max_id($tabel='menu'){
		if($tabel=='menu') $t = $this->tb_produk;
		$this->db->select('max(menuid)+1 as id');
		$query = $this->db->get($t);
		$row = $query->row();
		$query->free_result();
		return $row->id?$row->id:1;
	}

	function detail_produk($id){
		$p = $this->tb_produk;
        // query 1
		$this->db->select("$p.*");
		$this->db->where("$p.menuid",$id);
        $query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function get_gambar($idproduk){
		$g=$this->tb_gbr;
		$at=$this->tb_atk;
		$this->db->select("$g.id as idgbr,is_default,gambar,jenis_stock,$at.id as idattr,stock,ukuran");
		$this->db->join($at, "$at.id_gambar=$g.id", 'left');
		$this->db->where("$g.id_produk",$idproduk);
		$this->db->order_by("$g.id");
		$query = $this->db->get($g); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			foreach($query->result() as $row){
				if($row->is_default==1){
					$data['def'][$row->idgbr]['gbr'] = $row->gambar;
					$data['def'][$row->idgbr]['jenis_stock'] = $row->jenis_stock;
					$data['def'][$row->idgbr]['attr'][$row->idattr] = array('stock'=>$row->stock,'ukuran'=>$row->ukuran);
				}else{
					$data['other'][$row->idgbr]['gbr'] = $row->gambar;
					$data['other'][$row->idgbr]['jenis_stock'] = $row->jenis_stock;
					$data['other'][$row->idgbr]['attr'][$row->idattr] = array('stock'=>$row->stock,'ukuran'=>$row->ukuran);
				}
			}
			$query->free_result();
			return $data;
		} #break;
		return false;
	}
	function update_gambar($id,$gambar,$def,$jenis_stock){
		$data = array(
			'is_default'=>$def,
			'jenis_stock'=>$jenis_stock
		);
		if($gambar!=false)$data=array_merge($data,array('gambar'=>$gambar));
        $this->db->where('id',$id);
        $res = $this->db->update($this->tb_gbr,$data); #echo $this->db->last_query();
        return $res;
	}
	function just_update_gambar($id,$gambar){
		$data = array(
			'gambar'=>$gambar
		);
        $this->db->where('id',$id);
        $res = $this->db->update($this->tb_gbr,$data); #echo $this->db->last_query();
        return $res;
	}
	function input_gambar($id_produk,$def,$jenis_stock,$gambar=false){
		$data = array(
			'id_produk'=>$id_produk,
			'is_default'=>$def,
			'jenis_stock'=>$jenis_stock
		);
		if($gambar)$data=array_merge($data,array('gambar'=>$gambar));
        $res = $this->db->insert($this->tb_gbr,$data); #echo $this->db->last_query();
        return $this->db->insert_id();
	}
	
	function input_produk($id,$idkat,$menu,$deskripsi,$image){
		$data = array(
			'menuid'=>$id,
			'kategoriID'=>$idkat,
			'menu'=>$menu,
			'deskripsi'=>$deskripsi,
			'image'=>$image
			
		);
        $res = $this->db->insert($this->tb_produk,$data); #echo $this->db->last_query();

        return $res;
	}

	function update_produk($id,$idkat,$menu,$deskripsi,$image){
		$data = array(
						'menuid'=>$id,
			'kategoriID'=>$idkat,
			'menu'=>$menu,
			'deskripsi'=>$deskripsi,
			'image'=>$image
		);
        $this->db->where('menuid',$id);
        $res = $this->db->update($this->tb_produk,$data); #echo $this->db->last_query();
        return $res;
	}
	function dell_produk($id_produk){
		return $this->db->delete($this->tb_produk,array('id'=>$id_produk));
	}

	function option_produk($idsub,$empty=true){
		$this->db->select('id,nama_produk');
        $this->db->where('id_subkategori',$idsub);
        $this->db->order_by('nama_produk');
		$query = $this->db->get($this->tb_produk);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->nama_produk;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}

}
