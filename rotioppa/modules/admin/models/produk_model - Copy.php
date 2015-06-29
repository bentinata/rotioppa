<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Produk_model extends CI_Model{
	var $tb_kat,$tb_subkat,$tb_produk,$tb_order,$tb_vendor,$tb_vcode,$tb_subkat2,
		$tb_gbr,$tb_atk,$tb_his_stock,$tb_attr,$tb_rel_diskon,$tb_cart,$tb_wishlist,$tb_rev;
	function __construct(){
		parent::__construct();
		$this->tb_kat = 'kategori';
		$this->tb_subkat = 'kategori_sub';
		$this->tb_subkat2 = 'kategori_sub2';
		$this->tb_produk = 'produk';
		$this->tb_katalog = 'katalog';
        $this->tb_order = 'order';
        $this->tb_vendor = 'vendor';
        $this->tb_vcode = 'kode_vendor';
        $this->tb_gbr = 'gambar';
        $this->tb_atk = 'atribut_khusus';
        $this->tb_his_stock = 'history_stock';
        $this->tb_attr = 'atribut';
        $this->tb_rel_diskon = 'related_diskon';
        $this->tb_cart = 'cart';
        $this->tb_wishlist = 'wishlist';
        $this->tb_rev = 'review';
	}

	function list_produk($start=false,$limit=false,$justcount=false,$key=false,$filter=false,$filter2=false){
		$k = $this->tb_kat;
		$sk = $this->tb_subkat;
		$sk2 = $this->tb_subkat2;
		$p = $this->tb_produk;
		$kat = $this->tb_katalog;
        $pp = $this->db->dbprefix($p);
		$katp = $this->db->dbprefix($kat);
        $op = $this->db->dbprefix($this->tb_order);
        $vcp = $this->db->dbprefix($this->tb_vcode);

		if($filter){
			switch($filter){
				case'1':
					if(strlen($key)<5) return 'err_1';
					$id=get_id_from_kode($key);
					$this->db->where("$p.id",$id);
					break;
				case'2':
					$this->db->like("$p.nama_produk","$key");
					break;
				case'3':
					$this->db->where("$p.id_subkategori","$key");
					break;
				#case'4':
				#	$this->db->like("$sk.subkategori","$key");
				#	break;
				case'5':
					$this->db->where("date_format(tgl,'%Y-%m-%d') between '$key[tgl1]' and '$key[tgl2]'");
					$this->db->order_by('tgl '.$key['order']);
					break;
				case'6':
					$this->db->where("$p.stock","$key");
					break;
				case'7':
					$this->db->where("$p.id_kode_vendor","$key");
					break;
			}
		}
        if($filter2 && $filter!='7'){
            $this->db->where("$p.id_kode_vendor","$filter2");
        }
		$this->db->join($sk, "$p.id_subkategori=$sk.id", 'left');
		$this->db->join($k, "$sk.id_kategori=$k.id", 'left');
		$this->db->join($kat, "$p.id_katalog=$kat.id", 'left');
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$p");
			$row = $query->row();
			return $row->jml;
		}
		$this->db->join($sk2, "$p.id_subkategori2=$sk2.id", 'left');
        if($limit!==false)
		$this->db->limit($limit,$start);
		$this->db->select("$p.id,$p.nama_produk,$p.tgl,$k.kategori,$k.id as idkat,"
            ."$sk.subkategori,$sk.id as idsub,$sk2.subkategori2, $kat.katalog,"
            ."(SELECT kode_produk_vendor FROM $vcp WHERE id=$pp.id_kode_vendor ) AS vcode"
            ,FALSE);
		$this->db->order_by("vcode,$p.id,$p.nama_produk");
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
    function list_produk_vendor($start=false,$limit=false,$justcount=false,$key=false,$filter=false){
		$k = $this->tb_kat;
		$sk = $this->tb_subkat;
		$p = $this->tb_produk;
        $pp = $this->db->dbprefix($p);
        $op = $this->db->dbprefix($this->tb_order);
        #$sp = $this->db->dbprefix($this->tb_stock);
        $vc = $this->tb_vcode;
        $vcp = $this->db->dbprefix($vc);
        $v = $this->tb_vendor;

		if($filter){
			switch($filter){
				case'1':
					$this->db->where("$vc.id_vendor","$key");
					break;
				case'2':
					$this->db->like("$vc.kode_produk_vendor","$key");
					break;
			}
		}

		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$vc");
			$row = $query->row();
			return $row->jml;
		}
        $this->db->join($p, "$p.id=$vc.kode_produk_vendor", 'left');
        $this->db->join($v, "$v.id=$vc.id_vendor", 'left');
		$this->db->limit($limit,$start);
		$this->db->select("$vc.kode_produk_vendor as vcode,$vc.id,$v.vendor,(select count(*) from $pp where id_kode_vendor=$vcp.id) as jml_produk",FALSE);
		$this->db->order_by("vendor,vcode");
		$query = $this->db->get($vc); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function get_max_id($tabel='produk'){
		if($tabel=='produk') $t = $this->tb_produk;
		$this->db->select('max(id)+1 as id');
		$query = $this->db->get($t);
		$row = $query->row();
		$query->free_result();
		return $row->id?$row->id:1;
	}
	function detail_produk($id){
		$p = $this->tb_produk;
		$sk = $this->tb_subkat;
        $skp = $this->db->dbprefix($sk);
        $pp = $this->db->dbprefix($p);
        $vc = $this->tb_vcode;
        $vcp = $this->db->dbprefix($vc);
		$sk2 = $this->tb_subkat2;
        $skp2 = $this->db->dbprefix($sk2);
        // query 1
		$this->db->select("$p.*,$p.id_kode_vendor as vcode,$vc.id_vendor as vendor,"
			."$sk.id_kategori,$p.id_subkategori as id_subkat,$p.id_subkategori2 as id_subkat2");
		$this->db->where("$p.id",$id);
        $this->db->join($vc, "$p.id_kode_vendor=$vc.id", 'left');
		$this->db->join($sk2, "$p.id_subkategori2=$sk2.id", 'left');
		$this->db->join($sk, "$p.id_subkategori=$sk.id", 'left');
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			$row->gambar = $this->get_gambar($id);
			$row->atribut= $this->list_attr($id);
			$row->rel_diskon = $this->list_rel_diskon($id);
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
	function dell_gambar($id){
		$this->db->where('id',$id);
		return $this->db->delete($this->tb_gbr);
	}
	function dell_gambar_by_produk($id){
		$gp=$this->db->dbprefix($this->tb_gbr);
		$atkp=$this->db->dbprefix($this->tb_atk);
		$hp=$this->db->dbprefix($this->tb_his_stock);
		$sql="delete a,h,g from $gp as g "
			."left join $atkp as a on g.id=a.id_gambar "
			."left join $hp as h on h.id_atribut_khusus=a.id "
			."where id_produk='$id'";
		return $this->db->query($sql);
		
	}
	function dell_attr_his_gambar($idgambar){
		$atkp=$this->db->dbprefix($this->tb_atk);
		$hp=$this->db->dbprefix($this->tb_his_stock);
		$sql="delete a,h from $atkp as a "
			."left join $hp as h on h.id_atribut_khusus=a.id "
			."where id_gambar='$idgambar'";
		return $this->db->query($sql);
	}
	function update_attr_khusus($id,$stock,$ukuran=''){
		$this->db->where('id',$id);
		return $this->db->update($this->tb_atk,array('stock'=>$stock,'ukuran'=>$ukuran));
	}
	function dell_attr_khusus($id){
		$atkp=$this->db->dbprefix($this->tb_atk);
		$hp=$this->db->dbprefix($this->tb_his_stock);
		$sql="delete a,h from $atkp as a "
			."left join $hp as h on h.id_atribut_khusus=a.id "
			."where a.id='$id'";
		return $this->db->query($sql);
	}
	function input_attr_khusus($idgbr,$stock,$ukuran=''){
		return $this->db->insert($this->tb_atk,array('id_gambar'=>$idgbr,'stock'=>$stock,'ukuran'=>$ukuran));
	}
	function list_attr($id_produk){
		$p = $this->tb_attr;
		$this->db->select("id,names,vals");
		$this->db->where('id_produk',$id_produk);
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			foreach($query->result() as $row){
				$res[$row->id]['key']= $row->names;
				$res[$row->id]['val']= $row->vals;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function update_attr($id,$key,$val){
		$this->db->where('id',$id);
		return $this->db->update($this->tb_attr,array('names'=>$key,'vals'=>$val));
	}
	function input_attr($idproduk,$key,$val){
		return $this->db->insert($this->tb_attr,array('id_produk'=>$idproduk,'names'=>$key,'vals'=>$val));
	}
	function dell_attr($id){
		$this->db->where('id',$id);
		return $this->db->delete($this->tb_attr);
	}
	function dell_attr_by_produk($id){
		$this->db->where('id_produk',$id);
		return $this->db->delete($this->tb_attr);
	}
	function input_produk($id,$idsub,$idsub2,$katalog,$vcode,$nama,$tgl,$tag,$summary,$desc,$hv,$ha,$hb,$had,$hbd,$ket_diskon='',$aff=false,$kom=0,$berat=1,$mkey='',$mdesc=''){
		$data = array(
			'id'=>$id,
			'id_subkategori'=>$idsub,
            'id_subkategori2'=>$idsub2,
			'id_katalog'=>$katalog,
            'id_kode_vendor'=>$vcode,
			'nama_produk'=>$nama,
			'tgl'=>$tgl,
			'tag'=>$tag,
			'summary'=>$summary,
			'deskripsi'=>$desc,
            'meta_key'=>$mkey,
            'meta_desc'=>$mdesc,
            'berat'=>$berat,
            'for_affiliate'=>$aff,
            'komisi'=>$kom,
            'harga_vendor'=>$hv,
            'harga_awal'=>$ha,
            'harga_baru'=>$hb,
            'harga_awal_diskon'=>$had,
            'harga_baru_diskon'=>$hbd,
            'ket_diskon'=>$ket_diskon
		);
        $res = $this->db->insert($this->tb_produk,$data); #echo $this->db->last_query();
        return $res;
	}

	function update_produk($id,$idsub,$idsub2,$katalog,$vcode,$nama,$tag,$summary,$desc,$hv,$ha,$hb,$had,$hbd,$ket_diskon='',$aff=false,$kom=0,$berat=1,$mkey='',$mdesc=''){
		$data = array(
			'id_subkategori'=>$idsub,
            'id_subkategori2'=>$idsub2,
			'id_katalog'=>$katalog,
            'id_kode_vendor'=>$vcode,
			'nama_produk'=>$nama,
			//'tgl'=>$tgl,
			'tag'=>$tag,
			'summary'=>$summary,
			'deskripsi'=>$desc,
            'meta_key'=>$mkey,
            'meta_desc'=>$mdesc,
            'berat'=>$berat,
            'for_affiliate'=>$aff,
            'komisi'=>$kom,
            'harga_vendor'=>$hv,
            'harga_awal'=>$ha,
            'harga_baru'=>$hb,
            'harga_awal_diskon'=>$had,
            'harga_baru_diskon'=>$hbd,
            'ket_diskon'=>$ket_diskon
		);
        $this->db->where('id',$id);
        $res = $this->db->update($this->tb_produk,$data); #echo $this->db->last_query();
        return $res;
	}
	function dell_produk($id_produk){
		return $this->db->delete($this->tb_produk,array('id'=>$id_produk));
	}

	function list_rel_diskon($idp){
		$d=$this->tb_rel_diskon;
		$p=$this->tb_produk;
		$k=$this->tb_subkat;
		$this->db->select("$d.*,$k.id_kategori");
		$this->db->join($p,"$d.id_produk_lain=$p.id",'left');
		$this->db->join($k,"$p.id_subkategori=$k.id",'left');
		$this->db->where('id_produk',$idp);
		$query = $this->db->get($d);
		if($query->num_rows()>0){ 
			$row=$query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_rel_diskon($id,$idp,$idp_lain){
		$this->db->where('id',$id);
		return $this->db->update($this->tb_rel_diskon,array('id_produk'=>$idp,'id_produk_lain'=>$idp_lain));
	}
	function input_rel_diskon($idp,$idp_lain){
		return $this->db->insert($this->tb_rel_diskon,array('id_produk'=>$idp,'id_produk_lain'=>$idp_lain));
	}	
	function dell_rel_diskon($id){
		$this->db->where('id',$id);
		return $this->db->delete($this->tb_rel_diskon);
	}
	function dell_rel_diskon_by_produk($id){
		$this->db->where('id_produk',$id);
		return $this->db->delete($this->tb_rel_diskon);
	}
	function dell_review_by_produk($id){
		$this->db->where('id_produk',$id);
		return $this->db->delete($this->tb_rev);
	}
	// model model bantu
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
	function option_katalog($empty=true){
		$this->db->select('id,katalog');
		$this->db->order_by('katalog');
		$query = $this->db->get($this->tb_katalog);
		if($query->num_rows()>0){
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->katalog;
			}
			$query->free_result();
			return $res;
			
		}
		return false;
	}
	function option_subkat($idkat,$empty=true){
		$this->db->select('id,subkategori');
		$this->db->where('id_kategori',$idkat);
		$this->db->order_by('subkategori');
		$query = $this->db->get($this->tb_subkat);  #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->subkategori;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function option_subkat2($idkat,$empty=true){
		$this->db->select('id,subkategori2 as subkategori');
		$this->db->where('id_subkategori',$idkat);
		$this->db->order_by('subkategori2');
		$query = $this->db->get($this->tb_subkat2);  #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->subkategori;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
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
	function option_attr($idproduk,$empty=true){
		$this->db->select('id,names');
        $this->db->where("id_produk = $idproduk and names!='harga_awal'");
        $this->db->where_not_in('names',array('harga_awal','harga_baru'));
		$query = $this->db->get($this->tb_ppr);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->names;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function option_nama_produk_by_kat($idkat,$empty=true){
		$p = $this->tb_produk;
		$sk = $this->tb_subkat;
		$this->db->select("$p.id,$p.nama_produk");
		$this->db->join($sk, "$p.id_subkategori=$sk.id", 'left');
		$this->db->where("$sk.id_kategori",$idkat);
		$this->db->where("harga_awal_diskon!=''",FALSE,FALSE);
		$query = $this->db->get($p);
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
	function option_vendor($empty=true){
		$this->db->select('id,vendor');
		$this->db->order_by('vendor');
		$query = $this->db->get($this->tb_vendor);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->vendor;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function option_vcode($idvendor,$empty=true){
		$this->db->select('id,kode_produk_vendor');
		$this->db->order_by('kode_produk_vendor');
		$this->db->where('id_vendor',$idvendor);
		$query = $this->db->get($this->tb_vcode);  #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->kode_produk_vendor;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function option_vcode_produk($idvcode,$empty=true){
		$this->db->select('id,nama_produk');
		$this->db->where('kode_vendor',$idvcode);
		$query = $this->db->get($this->tb_produk);  #echo $this->db->last_query();
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
	function cek_order_by_produk($id){
		$this->db->select("count(*) as jml");
		$query=$this->db->get_where($this->tb_order,array('id_produk'=>$id));
		if($query->num_rows()>0){ 
			$row = $query->row();
			$query->free_result();
			if($row->jml>0) return true;
		}
		return false;
	}
	function cek_cart_by_produk($id){
		$this->db->select("count(*) as jml");
		$query=$this->db->get_where($this->tb_cart,array('id_produk'=>$id));
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			if($row->jml>0) return true;
		}
		return false;
	}
	function cek_wishlist_by_produk($id){
		$this->db->select("count(*) as jml");
		$query=$this->db->get_where($this->tb_wishlist,array('id_produk'=>$id));
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			if($row->jml>0) return true;
		}
		return false;
	}
    function detail_vcode($vcode)
    {
        $query = $this->db->get_where($this->tb_vcode,array('id'=>$vcode));
        return $query->row();
    }
}
