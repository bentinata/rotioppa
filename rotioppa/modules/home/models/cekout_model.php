<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cekout_model extends CI_Model{
	var $tb_cart,$tb_produk,$tb_kat,$tb_sub,$tb_ppr,$tb_diskon,$tb_cust,$tb_prov,$tb_kota,$tb_cekout,$tb_order,$tb_kirim,$tb_kvendor,$tb_gbr,$tb_atk,$tb_pkirim,$tb_lkirim,$tb_kupon_user;
	function __construct(){
		parent::__construct();
		$this->tb_produk = 'produk';
        $this->tb_kat = 'kategori';
        $this->tb_sub = 'kategori_sub';
        $this->tb_cart = 'cart';
        $this->tb_ppr = 'property';
        $this->tb_diskon = 'diskon';
        $this->tb_cust = 'customer';
        $this->tb_prov = 'provinsi';
        $this->tb_kota = 'kota';
        $this->tb_cekout = 'cekout';
        $this->tb_order = 'order';
        $this->tb_kirim = 'biaya_pengiriman';
        $this->tb_kvendor = 'kode_vendor';
        $this->tb_gbr = 'gambar';
        $this->tb_atk = 'atribut_khusus';
        $this->tb_pkirim = 'perusahaan_kirim';
        $this->tb_lkirim = 'layanan_kirim';
        $this->tb_kupon_user = 'kupon_user';
	}
    function list_cekout($user){
        $p = $this->tb_produk;
        $c = $this->tb_cart;
        $k = $this->tb_kat;
        $s = $this->tb_sub;
        $kv = $this->tb_kvendor;
        $atk=$this->tb_atk;
        $g = $this->tb_gbr;
        $kpn =$this->tb_kupon_user;
        $kvp = $this->db->dbprefix($kv);
        $cp = $this->db->dbprefix($c);
        $pp = $this->db->dbprefix($p);
        $this->db->select("$c.id_produk,$c.qty,$p.nama_produk,$s.subkategori,$k.kategori,"
            ."$p.berat,id_kode_vendor as id_vendor,"
            ."$p.harga_awal_diskon AS ha_diskon,$p.harga_baru_diskon AS hb_diskon,"
            ."$p.harga_awal AS ha_prop,$p.harga_baru AS hb_prop,"
            ."$atk.ukuran,$g.id as idgbr,$g.gambar",FALSE);
        $this->db->select("$kpn.kode_kupon,$kpn.persen_kupon,$kpn.potongan_harga");
        $this->db->join($p,"$c.id_produk=$p.id",'left');
        $this->db->join($s,"$p.id_subkategori=$s.id",'left');
        $this->db->join($k,"$s.id_kategori=$k.id",'left');
        $this->db->join($kv,"$p.id_kode_vendor=$kv.id",'left');
        $this->db->join($atk,"$atk.id=$c.id_stock_attr_khusus",'left');
        $this->db->join($g,"$g.id=$atk.id_gambar",'left');
        $this->db->join($kpn,"$kpn.fk_cart=$c.id",'left');
        $this->db->order_by("$c.tgl");
        $query = $this->db->get_where($c,array('user_customer'=>$user)); #echo $this->db->last_query();
        if($query->num_rows()>0){ #break;
            $row=$query->result();
            $query->free_result();
            return $row;
		} #break;
		return false;
    }
    function list_cekout_from_id($idcekout){
        $p = $this->tb_produk;
        $c = $this->tb_order;
        $k = $this->tb_kat;
        $s = $this->tb_sub;
        $atk=$this->tb_atk;
        $g = $this->tb_gbr;
        $cp = $this->db->dbprefix($c);
        $pp = $this->db->dbprefix($p);
        $this->db->select("$c.id_produk,$c.qty,$p.nama_produk,$s.subkategori,$k.kategori,$p.berat,"
            ."$c.harga,$atk.ukuran,$g.id as idgbr,$g.gambar",FALSE);
        $this->db->join($p,"$c.id_produk=$p.id",'left');
        $this->db->join($s,"$p.id_subkategori=$s.id",'left');
        $this->db->join($k,"$s.id_kategori=$k.id",'left');
        $this->db->join($atk,"$atk.id=$c.id_stock_attr_khusus",'left');
        $this->db->join($g,"$g.id=$atk.id_gambar",'left');
        $this->db->order_by("$c.tgl");
        $query = $this->db->get_where($c,array('id_cekout'=>$idcekout)); #echo $this->db->last_query();
        if($query->num_rows()>0){ #break;
            $row=$query->result();
            $query->free_result();
            return $row;
		} #break;
		return false;
    }
    function detail_cekout($id){
    	//$this->db->select("*, date_format(tgl,'%d-%m-%Y') as tanggal");
    	$this->db->select("*");
		$this->db->where('id',$id);
		$query = $this->db->get($this->tb_cekout);
        if($query->num_rows()>0){ #break;
            $row=$query->row();
            $query->free_result();
            return $row;
		} #break;
		return false;
	}
    function detail_kota($id){
		$this->db->where('id',$id);
		$query = $this->db->get($this->tb_kota);
        if($query->num_rows()>0){ #break;
            $row=$query->row();
            $query->free_result();
            return $row;
		} #break;
		return false;
	}
	function get_data_member($idcust){
        $c = $this->tb_cust;
        $k = $this->tb_kota;
        $p = $this->tb_prov;
        $kp=$this->db->dbprefix($this->tb_kirim);
        $cp=$this->db->dbprefix($c);
        $this->db->select("$c.id,$c.nama_lengkap,$c.alamat_kirim,$k.kota,$k.id as idkota,$p.provinsi,$c.no_tlp,"
            ."$c.zip_kirim");
        $this->db->join($k,"$c.idkota_kirim=$k.id",'left');
        $this->db->join($p,"$k.id_provinsi=$p.id",'left');
        $this->db->where("$c.id",$idcust);
        $query = $this->db->get($c);
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
   }
	function option_prop($empty=true){
		$query = $this->db->get($this->tb_prov);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->provinsi;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function option_prop_by_layanan($idlay,$empty=true){
		$b = $this->tb_kirim;
        $k = $this->tb_kota;
        $p = $this->tb_prov;
        $this->db->join($k,"$b.id_kota=$k.id",'left');
        $this->db->join($p,"$k.id_provinsi=$p.id",'left');
		$this->db->where('id_layanan',$idlay);
		$this->db->group_by("$p.id");
		$query = $this->db->get($b);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->provinsi;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function option_kota($idprov,$empty=true){
	    $this->db->where('id_provinsi',$idprov);
		$query = $this->db->get($this->tb_kota);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->kota;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function option_kota_with_biaya($idprov,$lay,$empty=true){
		$k=$this->tb_kota;
		$b=$this->tb_kirim;
		$this->db->select("$k.id,$k.kota");
		$this->db->join($b,"$k.id=$b.id_kota",'inner');
	    $this->db->where(array('id_provinsi'=>$idprov,'id_layanan'=>$lay));
	    $this->db->group_by('id_kota');
		$query = $this->db->get($k); #echo $this->db->last_query();break;
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->kota;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function option_perusahaan_kirim($empty=true){
		$query = $this->db->get($this->tb_pkirim);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->nama_perusahaan;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
	function option_layanan_kirim($idp,$empty=true){
		$this->db->where('id_perusahaan',$idp);
		$query = $this->db->get($this->tb_lkirim);
		if($query->num_rows()>0){ #break;
			if($empty) $res['-'] = ' - ';
			foreach($query->result() as $row){
				$res[$row->id] = $row->layanan;
			}
			$query->free_result();
			return $res;
		} #break;
		return false;
	}
    function add_cekout($idcust,$idkota,$nama,$tlp,$alm,$zip,$harga,$bayar,$kode,$bkirim,$idkirim,$berat){
        $input=array(
            'id_customer'=>$idcust,
            'id_kota'=>$idkota,
            'nama'=>$nama,
            'tlp'=>$tlp,
            'alamat'=>$alm,
            'zip'=>$zip,
            'tgl'=>date('Y-m-d H:i:s'),
            'harga'=>$harga,
            'cara_bayar'=>$bayar,
            'kode_unik'=>$kode,
            'biaya_kirim'=>$bkirim,
			'id_biaya_kirim'=>$idkirim,
            'total_berat'=>$berat,
            'status_kirim'=>1           // belum konfirmasi
        );
        $this->db->insert($this->tb_cekout,$input);
        return $this->db->insert_id();
    }
    function update_kode_trans($id,$kode){
        $this->db->where('id',$id);
        return $this->db->update($this->tb_cekout,array('kode_transaksi'=>$kode));
    }
    function get_cart_for_order($iduser){
		$kpn =$this->tb_kupon_user;
		$this->db->select("$kpn.persen_kupon,$kpn.fk_cart");
        $this->db->select('id_produk,qty,tgl,id_iklan,komisi,id_stock_attr_khusus');
        $this->db->where('user_customer',$iduser);
        $this->db->join($kpn,"$kpn.fk_cart=id",'left');
        $query = $this->db->get($this->tb_cart);
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		}
		return false;
	}
    function add_to_order($iduser,$harga,$idcekout,$data){
		if($data){ #break;
			$o=$this->db->dbprefix($this->tb_order);
			foreach($data as $row)
			{
                $price=isset($harga[$row->id_produk])?$harga[$row->id_produk]:0;
                $input = "('$row->id_produk','$iduser','$row->qty','$price','$row->tgl','$idcekout','$row->id_iklan','$row->komisi','$row->id_stock_attr_khusus')";
                // add to order table
                $sql="insert into $o (id_produk,id_customer,qty,harga,tgl,id_cekout,id_iklan,komisi,id_stock_attr_khusus) values $input"; #echo $sql;
				if($this->db->query($sql))
				{
					$id_order = $this->db->insert_id();
					// update table kupon add order id and harga for persen
					if(!empty($row->persen_kupon))
					{	
						$diskon_kupon = round( (($harga[$row->id_produk]*$row->persen_kupon)/100),0);
						$arr_update = array('fk_order'=>$id_order,'potongan_harga'=>$diskon_kupon);
					}else{
						$arr_update = array('fk_order'=>$id_order);
					}
					$this->db->where('fk_cart',$row->fk_cart);
					$this->db->update($this->tb_kupon_user,$arr_update);
					
					// update fk_cart to empty by fk_order
					$this->db->where('fk_order',$id_order);
					$this->db->update($this->tb_kupon_user,array('fk_cart'=>''));
					
				}
			}
			// delete all data cart
            $this->db->delete($this->tb_cart,array('user_customer'=>$iduser));
		} #break;
		return false;
    }
    function get_bkirim($kota,$lay){
        $this->db->select('biaya_kirim,id');
        $this->db->where(array('id_kota'=>$kota,'id_layanan'=>$lay));
		$query = $this->db->get($this->tb_kirim); #echo $this->db->last_query();break;
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return 0;
    }	
    function get_kota_by_layanan($lay){
		$k=$this->tb_kota;
		$b=$this->tb_kirim;
		$this->db->select("$k.id,$k.kota");
		$this->db->join($k,"$k.id=$b.id_kota",'left');
		$this->db->where('id_layanan',$lay);
		$query=$this->db->get($b);
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
}
