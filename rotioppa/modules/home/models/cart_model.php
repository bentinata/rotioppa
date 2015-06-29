<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cart_model extends CI_Model{
	var $tb_cart,$tb_produk,$tb_kat,$tb_sub,$tb_ppr,$tb_diskon,$tb_kv,$tb_atk,$tb_gbr,$tb_kupon_user;
	function __construct(){
		parent::__construct();
		$this->tb_produk = 'produk';
        $this->tb_kat = 'kategori';
        $this->tb_sub = 'kategori_sub';
        $this->tb_cart = 'cart';
        $this->tb_ppr = 'property';
        $this->tb_diskon = 'diskon';
        $this->tb_kv = 'kode_vendor';
        $this->tb_atk = 'atribut_khusus';
        $this->tb_gbr = 'gambar';
        $this->tb_kupon_user = 'kupon_user';
	}
    function add_cart($idproduk,$qty,$userglobal,$id_attr,$usercust=false,$id_iklan=false,$komisi=0){
        $data = array(
            'id_produk'=>$idproduk,
            'qty'=>$qty,
            'tgl'=>date('Y-m-d H:i:s'),
            'komisi'=>$komisi,
            'id_stock_attr_khusus'=>$id_attr
        );
        // jika sudah login
        if($usercust){ 
			$data=array_merge($data,array('user_customer'=>$usercust));
		// maka yg globalnya di kosongkan saja
		}else{
			$data=array_merge($data,array('user_global'=>$userglobal));
		}
        if($id_iklan) $data=array_merge($data,array('id_iklan'=>$id_iklan));

        if($this->db->insert($this->tb_cart,$data)){
			$_id = $this->db->insert_id();
            $this->update_stock($id_attr,$qty);
            return $_id;
        }
        return false;
    }
    function cek_cart($idproduk,$idattr,$user,$iduser=false){
        $this->db->select('count(*) as jml');
        if($iduser) $this->db->or_where("id_produk='$idproduk' and id_stock_attr_khusus='$idattr' and user_customer='$iduser'",FALSE,FALSE);
        else $this->db->or_where("id_produk='$idproduk' and id_stock_attr_khusus='$idattr' and user_global='$user'",FALSE,FALSE);
        $query = $this->db->get($this->tb_cart); #echo $this->db->last_query();break;
        $row = $query->row();
        $query->free_result();
        if($row->jml>0) return true;
		return false;
    }
    function list_cart($user,$is_customer=false){
        $p = $this->tb_produk;
        $c = $this->tb_cart;
        $k = $this->tb_kat;
        $s = $this->tb_sub;
        $atk=$this->tb_atk;
        $g = $this->tb_gbr;
        $kpn =$this->tb_kupon_user;
        $cp = $this->db->dbprefix($this->tb_cart);
        $pp = $this->db->dbprefix($p);
        $this->db->select("$c.id,$c.id_produk,$c.qty,date_format($cp.tgl,'%d-%m-%Y') as tgl,"
            ."date_format($cp.tgl,'%H:%i') as jam,$p.nama_produk,$s.subkategori,$k.kategori,"
            ."$atk.stock,id_stock_attr_khusus,$atk.ukuran,"
            ."$p.harga_awal_diskon AS ha_diskon,$p.harga_baru_diskon AS hb_diskon,"
            ."$p.harga_awal AS ha_prop,$p.harga_baru AS hb_prop,$g.id as idgbr,$g.gambar",FALSE);
        $this->db->select("$kpn.kode_kupon,$kpn.persen_kupon,$kpn.potongan_harga");
        $this->db->join($p,"$c.id_produk=$p.id",'left');
        $this->db->join($s,"$p.id_subkategori=$s.id",'left');
        $this->db->join($k,"$s.id_kategori=$k.id",'left');
        $this->db->join($atk,"$atk.id=$c.id_stock_attr_khusus",'left');
        $this->db->join($g,"$g.id=$atk.id_gambar",'left');
        $this->db->join($kpn,"$kpn.fk_cart=$c.id",'left');
        $this->db->order_by("$c.tgl");
        if($is_customer)
        $query = $this->db->get_where($c,array('user_customer'=>$is_customer));
        else
        $query = $this->db->get_where($c,array('user_global'=>$user)); #echo $this->db->last_query();
        if($query->num_rows()>0){ #break;
            $row=$query->result();
            $query->free_result();
            return $row;
		} #break;
		return false;
    }
    function get_data_cart($id){
        $this->db->select('qty,id_produk,id_stock_attr_khusus');
        $query = $this->db->get_where($this->tb_cart,array('id'=>$id));
        if($query->num_rows()>0){ #break;
        	$row = $query->row();
			$query->free_result();
            return $row;
        }
        return false;
    }
    function dell_cart($id,$userglobal,$usercust=false){
        $d=$this->get_data_cart($id);
        if($usercust) $where=array('id'=>$id,'user_customer'=>$usercust);
        else $where=array('id'=>$id,'user_global'=>$userglobal);
        if($this->db->delete($this->tb_cart,$where)){
            $this->update_stock($d->id_stock_attr_khusus,$d->qty,true);
            return true;
        }
        return false;
    }
    function update_qty($id,$qty,$old,$idp){
        if($qty==$old) return;
        $this->db->where('id', $id);
        if($this->db->update($this->tb_cart, array('qty'=>$qty))){
            if($qty>$old){
                $beda=$qty-$old;
                $this->update_stock($idp,$beda);
            }elseif($qty<$old){
                $beda=$old-$qty;
                $this->update_stock($idp,$beda,true);
            }
        }
        return true;
    }
    function update_stock($id,$qty,$plus=false){
        $this->db->where('id', $id);
        if($plus)
        $this->db->set('stock', "stock+$qty",FALSE);
        else $this->db->set('stock', "stock-$qty",FALSE);
        $query = $this->db->update($this->tb_atk); #echo $this->db->last_query();
        return $query;
    }
    /*function is_stock_zero_return_vendor($id){
        $this->db->select('stock,kode_vendor');
        $query = $this->db->get_where($this->tb_produk,array('id'=>$id));
        if($query->num_rows()>0){ #break;
        	$row = $query->row();
			$query->free_result();
            if($row->stock<1) return $row->kode_vendor;
        }
        return false;
    }
    function is_def_produk($vendor,$produk){
        $this->db->select('id_def_produk');
        $query = $this->db->get_where($this->tb_kv,array('id'=>$vendor));
        if($query->num_rows()>0){ #break;
        	$row = $query->row();
			$query->free_result();
            if($row->id_def_produk==$produk) return true;
        }
        return false;
    }
    function change_def_produk($vendor,$oldproduk){
        $this->db->select('id');
        $this->db->where("kode_vendor='$vendor' and id!='$oldproduk' and stock!='0'",FALSE,FALSE);
        $this->db->orderby('stock');
        $this->db->limit(1);
        $query=$this->db->get($this->tb_produk);
        if($query->num_rows()>0){ #break;
        	$row = $query->row();
			$query->free_result();
            $idproduknew = $row->id;
            // change old to new
            $this->db->where('id',$vendor);
            return $this->db->update($this->tb_kv,array('id_def_produk'=>$idproduknew));
        }
        return false;
    }*/
    function is_for_aff($produk){
        $this->db->select('for_affiliate,komisi');
        $query = $this->db->get_where($this->tb_produk,array('id'=>$produk));
        if($query->num_rows()>0){ #break;
        	$row = $query->row();
			$query->free_result();
            if($row->for_affiliate=='1') return $row->komisi;
        }
        return false;
    }
}
