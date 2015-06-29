<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model{
	var $tb_prop,$tb_kota,$tb_cust,$tb_sub,$tb_produk,$tb_order,$tb_ppr,$tb_diskon,$tb_review,$tb_cekout,$tb_vcode,$tb_prospek,$tb_gbr,$tb_kupon,$tb_kupon_user,$tb_testimoni,$tb_mitra;
	function Home_model(){
		parent::__construct();
		$this->tb_artikel 		= 'artikel';
		$this->tb_prop 			= 'provinsi';
		$this->tb_kota 			= 'kota';
		$this->tb_cust 			= 'customer';
        $this->tb_sub 			= 'kategori_sub';
        $this->tb_produk 		= 'produk';
        $this->tb_order 		= 'order';
        $this->tb_ppr 			= 'property';
        $this->tb_diskon 		= 'diskon';
        $this->tb_review 		= 'review';
		$this->tb_cekout 		= 'cekout';
        $this->tb_vcode 		= 'kode_vendor';
        $this->tb_prospek 		= 'prospek';
        $this->tb_gbr 			= 'gambar';
        $this->tb_gbr2 			= 'gambar2';
        $this->tb_kupon 		= 'kupon';
        $this->tb_kupon_user 	= 'kupon_user';
		$this->tb_testimoni		= 'testimoni';
		$this->tb_katalog		= 'katalog';
		$this->tb_mitra			= 'mitra';
	}

	function option_prop($empty=true){
		$query = $this->db->get($this->tb_prop);
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
	function reg_member($email,$pass,$full,$nick,$tlp,$jenkel,$tgl,$kotak,$almk,$kotar,$almr,$se,$code,$zk,$zr,$rk='',$rp=''){
        $data=array(
			'email'=>$email,
			'password'=>$pass,
			'nama_lengkap'=>$full,
			'nama_panggilan'=>$nick,
			'no_tlp'=>$tlp,
			'jen_kel'=>$jenkel,
			'tgl_lahir'=>$tgl,
			'tgl_daftar'=>date('Y-m-d H:i:s'),
			'alamat_rumah'=>$almr,
			'idkota_rumah'=>$kotar,
			'alamat_kirim'=>$almk,
			'idkota_kirim'=>$kotak,
			'activation_code'=>$code,
            'zip_rumah'=>$zr,
            'zip_kirim'=>$zk,
            'send_email'=>$se,
            'rumah_kota'=>$rk,
            'rumah_prov'=>$rp
		);
		return $this->db->insert($this->tb_cust,$data);
	}
	function active_member($code,$email){
		$this->db->where(array('activation_code'=>$code,'email'=>$email));
		$this->db->set(array('status'=>'1'));
		return $this->db->update($this->tb_cust);
	}
	function list_produk($search,$idkat=false,$best=false,$new=false,$rate=false,$diskon=false,$price1=false,$price2=false,$start=false,$limit=false,$justcount=false){
	    $p  = $this->tb_produk;
        $pp = $this->db->dbprefix($this->tb_produk);
        $s  = $this->tb_sub;
        $op = $this->db->dbprefix($this->tb_order);
        $rp = $this->db->dbprefix($this->tb_review);
        $g  = $this->tb_gbr;
        $gp = $this->db->dbprefix($g);

		$this->db->where("($pp.nama_produk like '%$search%' or "
					."$pp.summary like '%$search%')",FALSE,FALSE);
        if($idkat){
			$this->db->where("$s.id_kategori",$idkat);
			$this->db->join($s,"$p.id_subkategori=$s.id",'left');
        }
        if($diskon){
            $this->db->where("harga_awal_diskon!=''",FALSE,FALSE);
        }
        if($price1 or ($price1==0 and $price2!=0)){
            $this->db->select(
				"if(harga_baru_diskon!='',harga_baru_diskon,"
					."if(harga_awal_diskon!='',harga_awal_diskon,"
						."if(harga_baru!='',harga_baru,harga_awal))) "
				."as harga",FALSE);
            $this->db->having("harga between $price1 and $price2");
        }
        if($best){
            $this->db->select("(select sum(qty) from $op where id_produk=$pp.id) as jml_best",FALSE);
            $this->db->order_by("jml_best");
        }
        if($new){
            $this->db->order_by("$p.tgl");
        }
        if($rate){
            $this->db->select("(select sum(rating) from $rp where id_produk=$pp.id) as rate",FALSE);
            $this->db->order_by("rate");
        }
		if($justcount){
			$this->db->select("$p.id as idp");
			$query = $this->db->get("$p"); #echo $this->db->last_query();
            if(($row=$query->num_rows())>0){
				return $row;
            }else return 0;
		}

        $this->db->select("$p.harga_awal_diskon AS ha_diskon,$p.harga_baru_diskon AS hb_diskon,"
            ."$p.harga_awal AS ha_prop,$p.harga_baru AS hb_prop",FALSE);
        $this->db->select("$p.id,$p.nama_produk,$p.summary,$g.gambar,$g.id as idgbr,"
			."(SELECT IFNULL( SUM(rating),0) FROM $rp WHERE id_produk=$pp.id) AS rate,"	
			."(SELECT COUNT(*) FROM $rp WHERE id_produk=$pp.id) AS cust,"
			."(SELECT COUNT(*) FROM $rp WHERE id_produk=$pp.id AND review!='') AS review",FALSE);

		$this->db->join($g,"$g.id_produk=$p.id and $gp.is_default='1'",'left');
        $this->db->limit($limit,$start);
        $query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
    function list_produk_tag($tag,$start=false,$limit=false,$justcount=false){
	    $p = $this->tb_produk;
        $pp = $this->db->dbprefix($this->tb_produk);
        $s = $this->tb_sub;
        $op = $this->db->dbprefix($this->tb_order);
        $rp = $this->db->dbprefix($this->tb_review);
        $g = $this->tb_gbr;
        $gp = $this->db->dbprefix($g);
        
        $this->db->where("$pp.tag like '%$tag%'",FALSE,FALSE);
        $this->db->group_by("$p.id_kode_vendor");
        
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$p"); #echo $this->db->last_query();
            if(($row=$query->num_rows())>0){
				return $row;
            }else return 0;
		}

        $this->db->select("$p.harga_awal_diskon AS ha_diskon,$p.harga_baru_diskon AS hb_diskon,"
            ."$p.harga_awal AS ha_prop,$p.harga_baru AS hb_prop",FALSE);
        $this->db->select("$p.id,$p.nama_produk,$p.summary,$g.gambar,$g.id as idgbr,"
			."(select IFNULL( SUM(rating),0) from $rp WHERE id_produk=$pp.id) AS rate,"	
			."(SELECT COUNT(*) FROM $rp WHERE id_produk=$pp.id) AS cust,"
			."(SELECT COUNT(*) FROM $rp WHERE id_produk=$pp.id AND review!='') AS review",FALSE);
        $this->db->select("(select IFNULL( SUM(rating),0) from $rp WHERE id_produk=$pp.id) AS rate,"	
			."(select COUNT(*) from $rp WHERE id_produk=$pp.id) AS cust,"
			."(SELECT COUNT(*) FROM $rp WHERE id_produk=$pp.id AND review!='') AS review"
			,FALSE);

        $this->db->join($g,"$g.id_produk=$p.id and $gp.is_default='1'",'left');
        $this->db->limit($limit,$start);
        $query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function best_seller(){
        $tgl1 = date('Y-m-1');
        $tgl2 = date('Y-m-').date('t');
        $o = $this->tb_order;
        $p = $this->tb_produk;
		$c = $this->tb_cekout;
		$g = $this->tb_gbr;
        $pp = $this->db->dbprefix($p);
        $op = $this->db->dbprefix($o);
		$cp = $this->db->dbprefix($c);
		$rp=$this->db->dbprefix($this->tb_review);
		$gp = $this->db->dbprefix($g);
        $this->db->select("(select IFNULL( SUM(rating),0) from $rp WHERE id_produk=$pp.id) AS rate,"	
			."(select COUNT(*) from $rp WHERE id_produk=$pp.id) AS cust,"
			."(SELECT COUNT(*) FROM $rp WHERE id_produk=$pp.id AND review!='') AS review"
			,FALSE);
        $this->db->select("$p.id,SUM(qty) AS jml,$p.nama_produk,$p.summary,"
            ."$g.gambar AS gbr,$g.id as idgbr,"
            ."$p.harga_awal_diskon AS ha_diskon,$p.harga_baru_diskon AS hb_diskon,"
            ."$p.harga_awal AS ha_prop,$p.harga_baru AS hb_prop",FALSE);
        $this->db->where("$o.tgl BETWEEN '$tgl1' AND '$tgl2' AND $cp.status_kirim='3'");
        $this->db->group_by("$o.id_produk");
        $this->db->order_by('jml desc');
        $this->db->limit(5);
        $this->db->join($p,"$o.id_produk=$p.id",'left');
        $this->db->join($g,"$g.id_produk=$p.id and $gp.is_default='1'",'left');
		$this->db->join($c,"$o.id_cekout=$c.id",'left');
        $query = $this->db->get($o); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function new_produk(){
        $g = $this->tb_gbr;
        $p = $this->tb_produk;
        $pp = $this->db->dbprefix($p);
        $gp = $this->db->dbprefix($g);
        $rp=$this->db->dbprefix($this->tb_review);
        $this->db->select("(select IFNULL( SUM(rating),0) from $rp WHERE id_produk=$pp.id) AS rate,"	
			."(select COUNT(*) from $rp WHERE id_produk=$pp.id) AS cust,"
			."(SELECT COUNT(*) FROM $rp WHERE id_produk=$pp.id AND review!='') AS review"
			,FALSE);
        $this->db->select("$p.id,$p.nama_produk,"
            ."$g.gambar AS gbr,$g.id as idgbr,"
            ."$p.harga_awal_diskon AS ha_diskon,$p.harga_baru_diskon AS hb_diskon,"
            ."$p.harga_awal AS ha_prop,$p.harga_baru AS hb_prop",FALSE);
        //$this->db->where("$pp.stock!=0",FALSE,FALSE);
        $this->db->join($g,"$g.id_produk=$p.id and $gp.is_default='1'",'left');
        $this->db->order_by("$p.tgl desc");
        $this->db->limit(3);
        $query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function top_rate(){
        $tgl1 = date('Y-m-1');
        $tgl2 = date('Y-m-').date('t');
        $r = $this->tb_review;
        $g = $this->tb_gbr;
        $p = $this->tb_produk;
        $pp = $this->db->dbprefix($p);
        $rp = $this->db->dbprefix($r);
        $gp = $this->db->dbprefix($g);
        
        $this->db->select("(select IFNULL( SUM(rating),0) from $rp WHERE id_produk=$pp.id) AS rate,"	
			."(select COUNT(*) from $rp WHERE id_produk=$pp.id) AS cust,"
			."(SELECT COUNT(*) FROM $rp WHERE id_produk=$pp.id AND review!='') AS review"
			,FALSE);
        $this->db->select("$p.id,SUM(rating) AS jml,$p.nama_produk,"
            ."$g.gambar AS gbr,$g.id as idgbr,"
            ."$p.harga_awal_diskon AS ha_diskon,$p.harga_baru_diskon AS hb_diskon,"
            ."$p.harga_awal AS ha_prop,$p.harga_baru AS hb_prop",FALSE);
        $this->db->where("$r.tgl BETWEEN '$tgl1' AND '$tgl2'"/* AND stock!=0"*/);
        $this->db->group_by("$r.id_produk");
        $this->db->order_by('jml desc');
        $this->db->limit(12);
        $this->db->join($p,"$r.id_produk=$p.id",'left');
        $this->db->join($g,"$g.id_produk=$p.id and $gp.is_default='1'",'left');
        $query = $this->db->get($r); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function detail_cust($email){
		$this->db->where('email',$email);
		$query = $this->db->get($this->tb_cust);
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
    function add_prospek($email,$nama,$valid='2',$code=''){
        $this->db->select('id');
        $query = $this->db->get_where($this->tb_prospek,array('email'=>$email));
		if($query->num_rows()==0){ #break;
			$query->free_result();
            $insert=array(
                        'email'=>$email,
                        'nama'=>$nama,
                        'tgl'=>date('Y-m-d H:i:s'),
                        'isvalid'=>$valid
                    );
            if(!empty($code)){
                $insert=array_merge($insert,array('kode'=>$code,'tgl_validate'=>date('Y-m-d H:i:s')));
            }
            $this->db->insert($this->tb_prospek,$insert);
			return true;
		} #break;
		return false;
    }
	function active_prospek($code,$email){
		$this->db->where(array('kode'=>$code,'email'=>$email));
		$this->db->set(array('isvalid'=>'1'));
		$return=$this->db->update($this->tb_prospek); #echo $this->db->last_query();
        return $return;
	}
	
## ---------------- kupon function -----------------	
	function cek_kupon($kupon){
		$this->db->where("BINARY kode_kupon = '$kupon'",FALSE,FALSE);
		$this->db->where('status_kupon','1'); // hanya kupon yg "enable" saja yg di pilih
		$query = $this->db->get($this->tb_kupon);
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			if(strtotime(date('Y-m-d')) < strtotime($row->tgl_awal)) return array('msg'=>2,'tgl'=>$row->tgl_awal); // kupon belum bisa di gunakan
			else if(strtotime(date('Y-m-d')) > strtotime($row->tgl_akhir)) return array('msg'=>3,'tgl'=>$row->tgl_akhir); // kupon sudah kadaluarsa
			return array('msg'=>1,'data'=>$row); // ok, kupon bisa digunakan
		} #break;
		return array('msg'=>4); // kode kupon salah
	}
	function cek_kupon_user($kode_kupon,$id_user){
		$this->db->where('kode_kupon',$kode_kupon);
		$this->db->where('fk_customer',$id_user);
		$query = $this->db->get($this->tb_kupon_user);
		if($query->num_rows()>0){ #break;
			$query->free_result();
			return 5; // kupon sudah digunakan
		} #break;
		return false; // ok, kupon boleh dipakai
	}
	function is_kupon_enable($kupon=false){
		if($kupon)$this->db->where('kode_kupon',$kupon);
		$this->db->where('status_kupon','1');
		$this->db->where('tgl_akhir>=',"date_format(now(),'%Y-%m-%d')",FALSE,FALSE);
		$this->db->select('count(*) as jml',FALSE);
		$query = $this->db->get($this->tb_kupon);
		$data = $query->row();
		if($data->jml>0)
			return true; 
		else
			return false;
	}
	function get_detail_kupon($kupon){
		$this->db->where('kode_kupon',$kupon);
		$query = $this->db->get($this->tb_kupon);
		if($query->num_rows()>0){ #break;
			$data = $query->row();
			$query->free_result();
			return $data;
		} 
		return false;
	}
	function add_kupon_user($cust,$kupon,$persen,$potongan,$cart=false,$order=false){
		$insert=array('fk_customer'=>$cust,'kode_kupon'=>$kupon,'persen_kupon'=>$persen,'potongan_harga'=>$potongan);
		if($cart) $insert=array_merge($insert,array('fk_cart'=>$cart));
		if($order) $insert=array_merge($insert,array('fk_order'=>$order));
		return $this->db->insert($this->tb_kupon_user,$insert);
	}
	function del_kupon_user_by_idcart($idcart)
	{
		$this->db->where('fk_cart',$idcart);
		return $this->db->delete($this->tb_kupon_user);
	}
    function list_faq($start=false,$limit=false,$justcount=false){
		$i = 'faq';
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($i);
			$row = $query->row();
			return $row->jml;
		}
        if($limit)
		$this->db->limit($limit,$start);
		$this->db->order_by("tgl desc");
		$query = $this->db->get($i); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function list_harga($start=false,$limit=false,$justcount=false){
		$i = 'daftarh';
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($i);
			$row = $query->row();
			return $row->jml;
		}
        if($limit)
		$this->db->limit($limit,$start);
		$query = $this->db->get($i); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
    function list_artikel($start=false,$limit=false,$justcount=false){
		$i = 'artikel';
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($i);
			$row = $query->row();
			return $row->jml;
		}
        if($limit)
		$this->db->limit($limit,$start);
	$this->db->limit(12);
		$this->db->order_by("date_input desc");
		$query = $this->db->get($i); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
     function list_artikel2($start=false,$limit=false,$justcount=false){
		$i = 'artikel';
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($i);
			$row = $query->row();
			return $row->jml;
		}
        if($limit)
		$this->db->limit($limit,$start);
	$this->db->limit(3);
		$this->db->order_by("date_input desc");
		$query = $this->db->get($i); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_artikel($id){
		$this->db->where('id',$id);
		$query = $this->db->get('artikel');
		if($query->num_rows()>0){ #break;
			$data = $query->row();
			$query->free_result();
			return $data;
		} 
		return false;
	}
	function list_testimoni($start=false,$limit=false,$justcount=false){
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($this->tb_testimoni);
			$row = $query->row();
			return $row->jml;
		}
        if($limit)
		$this->db->limit($limit,$start);
		$this->db->select('*');
		$this->db->from('testimoni');
		$this->db->order_by("testimoni.id","desc");
		$query = $this->db->get(); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function daftar_mitra($nama,$email,$rumah,$tlp,$pekerjaan){
		$data=array(
            'nama'=>$nama,
            'email'=>$email,
            'alamat'=>$rumah,
            'no_tlp'=>$tlp,
            'pekerjaan'=>$pekerjaan
        );
        return $this->db->insert($this->tb_mitra,$data);
	}
	 function tambahpesan(){
		$nama = $this->input->post('nama');
		$email  = $this->input->post('email');
		$pesan = $this->input->post('pesan');
		$data = array (
		'nama' => $nama, 
		'email'  => $email,
		'pesan'=> $pesan
		);
		$this->db->insert('tpesan',$data);
	}
	
}
