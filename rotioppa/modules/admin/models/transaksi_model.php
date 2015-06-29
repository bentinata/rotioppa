<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi_model extends CI_Model{
	var $tb_cust,$tb_cekout,$tb_order,$tb_produk,$tb_kat,$tb_sub,$tb_kota,$tb_prov,$tb_biaya,$tb_sub2,$tb_lapiklan,$tb_atk,$tb_kom_user,$tb_iklan,$tb_bkirim,$tb_lkirim,$tb_pkirim,$tb_kupon_user;
	function __construct(){
		parent::__construct();
	    $this->tb_kat = 'kategori';
		$this->tb_sub = 'kategori_sub';
		$this->tb_produk = 'produk';
		$this->tb_order = 'order';
		$this->tb_cekout = 'cekout';
        $this->tb_cust = 'customer';
        $this->tb_kota = 'kota';
        $this->tb_prov = 'provinsi';
        $this->tb_biaya = 'biaya_kirim';
        $this->tb_sub2 = 'kategori_sub2';
        $this->tb_lapiklan = 'laporan_iklan';
        $this->tb_atk = 'atribut_khusus';
        $this->tb_kom_user = 'komisi_user';
        $this->tb_iklan = 'iklan';
        $this->tb_bkirim = 'biaya_pengiriman';
        $this->tb_lkirim = 'layanan_kirim';
        $this->tb_pkirim = 'perusahaan_kirim';
        $this->tb_kupon_user = 'kupon_user';
	}
    function get_cekout($start=false,$limit=false,$justcount=false,$key=false,$filter=false){
        $c=$this->tb_cust;
        $ck=$this->tb_cekout;
        $ckp=$this->db->dbprefix($ck);
		if($filter){
			switch($filter){
				case'1': // email
					$this->db->like("$c.email",$key);
					break;
				case'2': // harga total
					$this->db->having("total",$key);
					break;
				case'3': // sudah bayar
					$this->db->where("$ck.status_bayar",$key);
					break;
				case'4': // sudah kirim
					$this->db->where("$ck.status_kirim",$key);
					break;
				case'5': // tgl
					$this->db->where("date_format(tgl,'%Y-%m-%d') between '$key[tgl1]' and '$key[tgl2]'");
					break;
				case'6': // cara bayar
					$this->db->where("$ck.cara_bayar",$key);
					break;
			}
		}
        $this->db->join($c,"$ck.id_customer=$c.id",'left');
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($ck);
			$row = $query->row();
			return $row->jml;
		}
        $this->db->select("($ckp.harga+$ckp.kode_unik+$ckp.biaya_kirim) as total"); // tuk filter dan count
        $this->db->select("$ck.id,$c.email,cara_bayar,$ck.kode_transaksi,$ckp.tgl as full_tgl_cekout,"
            ."status_bayar,status_kirim,date_format($ckp.tgl,'%d-%m-%Y') as tgl_cekout",FALSE);

        if($limit!==false)
		$this->db->limit($limit,$start);
		$this->db->order_by("$ckp.tgl desc");
		$query = $this->db->get($ck); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function list_cekout($idcekout){
        $p = $this->tb_produk;
        $c = $this->tb_order;
        $k = $this->tb_kat;
        $s = $this->tb_sub;
        $s2 = $this->tb_sub2;
        $atk = $this->tb_atk;
        $kpn = $this->tb_kupon_user;
        $s2p= $this->db->dbprefix($s2);
        $cp= $this->db->dbprefix($c);
        $this->db->select("$c.id_produk,$c.qty,$c.id_iklan,$c.id as id_order,$c.komisi,$p.nama_produk,$s.subkategori,$k.kategori,$c.harga,$p.berat,$atk.ukuran");
        $this->db->select("date_format($cp.tgl,'%Y-%m-%d') as tgl_order",FALSE);
        $this->db->select("(select subkategori2 from $s2p where id=id_subkategori2) as subkategori2",FALSE);
        $this->db->select("$kpn.kode_kupon,$kpn.persen_kupon,$kpn.potongan_harga");
        $this->db->join($p,"$c.id_produk=$p.id",'left');
        $this->db->join($s,"$p.id_subkategori=$s.id",'left');
        $this->db->join($k,"$s.id_kategori=$k.id",'left');
        $this->db->join($atk,"$atk.id=$c.id_stock_attr_khusus",'left');
        $this->db->join($kpn,"$kpn.fk_order=$c.id",'left');
        $this->db->order_by("$c.tgl");
        $query = $this->db->get_where($c,array('id_cekout'=>$idcekout));
        if($query->num_rows()>0){ #break;
            $row=$query->result();
            $query->free_result();
            return $row;
		} #break;
		return false;
    }
    function detail_kirim($idcekout){
        $c=$this->tb_cekout;
        $pp=$this->db->dbprefix($this->tb_prov);
        $k=$this->tb_kota;
        $kp=$this->db->dbprefix($k);
        $this->db->select("$c.nama as nama_lengkap,$c.alamat as alamat_kirim,$c.tlp as no_tlp,$c.zip as zip_kirim,$k.kota,"
            ."$c.biaya_kirim as regular,$c.kode_unik,$c.cara_bayar,(SELECT provinsi FROM $pp WHERE id=$kp.id_provinsi) AS provinsi,"
            ."$c.status_bayar,$c.status_kirim,$c.id,$c.total_berat,$c.kode_transaksi,$c.no_resi",FALSE);
        $this->db->join($k,"$c.id_kota=$k.id",'left');
        $query = $this->db->get_where($c,array("$c.id"=>$idcekout)); #echo $this->db->last_query();
        if($query->num_rows()>0){ #break;
            $row=$query->row();
            $query->free_result();
            return $row;
		} #break;
		return false;
    }
    function detail_layanan_by_cekout($id){
		$c=$this->tb_cekout;
		$bk=$this->tb_bkirim;
		$lk=$this->tb_lkirim;
		$pk=$this->tb_pkirim;
		$kt=$this->tb_kota;
		$p=$this->tb_prov;
		$this->db->join($bk,"$bk.id=$c.id_biaya_kirim",'left');
		$this->db->join($lk,"$lk.id=$bk.id_layanan",'left');
		$this->db->join($pk,"$pk.id=$lk.id_perusahaan",'left');
		$this->db->join($kt,"$kt.id=$bk.id_kota",'left');
		$this->db->join($p,"$p.id=$kt.id_provinsi",'left');
		$this->db->select("$pk.nama_perusahaan,$lk.layanan,$kt.kota,$p.provinsi");
        $query = $this->db->get_where($c,array("$c.id"=>$id)); #echo $this->db->last_query();
        if($query->num_rows()>0){ #break;
            $row=$query->row();
            $query->free_result();
            return $row;
		} #break;
		return false;
	}
    function get_cabang_tiki($idcekout){
        $c=$this->tb_cekout;
        $b = $this->tb_biaya;
        $k = $this->tb_kota;
        $p = $this->tb_prov;
        $this->db->select("$p.provinsi,$k.kota");
        $this->db->join($b,"$c.id_biaya_kirim=$b.id",'left');
        $this->db->join($k,"$b.id_kota=$k.id",'left');
        $this->db->join($p,"$k.id_provinsi=$p.id",'left');
        $query = $this->db->get_where($c,array("$c.id"=>$idcekout)); #echo $this->db->last_query();
        if($query->num_rows()>0){ #break;
            $row=$query->row();
            $query->free_result();
            return $row;
		} #break;
		return false;
    }
    function detail_cust_by_idcekout($id){
        $c=$this->tb_cust;
        $ck=$this->tb_cekout;
        $this->db->select('nama_lengkap,nama_panggilan,email');
        $this->db->join($ck,"$c.id=$ck.id_customer",'left');
        $query = $this->db->get_where($this->tb_cust,array("$ck.id"=>$id));
        if($query->num_rows()>0){ #break;
            $row=$query->row();
            $query->free_result();
            return $row;
		} #break;
		return false;
    }
    function update_status($id,$kirim,$bayar,$tgl_lunas=true){ // status kirim tdk di update disini, tp ke update_resi()
        if($tgl_lunas)
        $update = array(/*'status_kirim'=>$kirim,*/'status_bayar'=>$bayar,'tgl_lunas'=>date('Y-m-d'));
        else
        $update = array(/*'status_kirim'=>$kirim,*/'status_bayar'=>$bayar);
        
        $this->db->where('id',$id);
        return $this->db->update($this->tb_cekout,$update);
    }
    function update_resi($id,$resi,$kirim){
        $this->db->where('id',$id);
        return $this->db->update($this->tb_cekout,array('no_resi'=>$resi,'status_kirim'=>$kirim));
	}
    function detail_cekout($id){
        $k = $this->db->dbprefix($this->tb_kota);
    	$this->db->select("*,date_format(tgl,'%d-%m-%Y') as tanggal,"
            ."(select kota from $k where id=id_kota) as kota",FALSE);
		$this->db->where('id',$id);
		$query = $this->db->get($this->tb_cekout);
        if($query->num_rows()>0){ #break;
            $row=$query->row();
            $query->free_result();
            return $row;
		} #break;
		return false;
	}
	function detail_for_send_resi($id){
		$c=$this->tb_cekout;
		$bk=$this->tb_bkirim;
		$lk=$this->tb_lkirim;
		$pk=$this->tb_pkirim;
		$cs=$this->tb_cust;
		$this->db->select("$cs.email,$c.kode_transaksi,$pk.nama_perusahaan");
		$this->db->join($bk,"$c.id_biaya_kirim=$bk.id",'left');
		$this->db->join($lk,"$bk.id_layanan=$lk.id",'left');
		$this->db->join($pk,"$lk.id_perusahaan=$pk.id",'left');
		$this->db->join($cs,"$c.id_customer=$cs.id",'left');
		$query=$this->db->get_where($c,array("$c.id"=>$id));
        if($query->num_rows()>0){ #break;
            $row=$query->row();
            $query->free_result();
            return $row;
		} #break;
		#print_r ($query); break;
		return false;
	}
	function delete_cekout($id){
		$this->db->delete($this->tb_cekout,array('id'=>$id));
        return $this->db->delete($this->tb_order,array('id_cekout'=>$id));
	}
    function update_sales_iklan($id_iklan,$sales,$tgl){
		// get dulu datanya jika sudah ada
		$this->db->select('sales');
		$query=$this->db->get_where($this->tb_lapiklan,array('id_iklan'=>$id_iklan,'tgl'=>$tgl));
        if($query->num_rows()>0){ #break;
            $row=$query->row();
            $jml = $row->sales+$sales;
            $query->free_result();
			// do update
			$update = array('sales'=>$jml);
			$this->db->where(array('id_iklan'=>$id_iklan,'tgl'=>$tgl));
			return $this->db->update($this->tb_lapiklan,$update);
		}
		return false;
    }
	function update_sales_iklan_minus($id_iklan,$jml,$tgl){
		$li=$this->db->dbprefix($this->tb_lapiklan);
		$sql = "update $li set sales=-$jml where id_iklan='$id_iklan' and tgl='$tgl'";
		return $this->db->query($sql);
	}
	function hitung_komisi_by_cekout($idcekout){
		$o=$this->tb_order;
		$i=$this->tb_iklan;
		$this->db->join($i,"$o.id_iklan=$i.id",'left');
		$this->db->select('id_aff,sum(komisi) as jmlkomisi');
		$this->db->group_by('id_aff');
		$query = $this->db->get_where($this->tb_order,array('id_cekout'=>$idcekout));
        if($query->num_rows()>0){ #break;
            $row=$query->result();
            $query->free_result();
            return $row;
		}
		return false;
	}
	function insert_update_komisi($idaff,$komisi){
		$ku=$this->db->dbprefix($this->tb_kom_user);
		$sql="insert into $ku(id_aff,komisi) values('$idaff','$komisi') "
			."on duplicate key update komisi=komisi+$komisi";
		return $this->db->query($sql);
	}
	function update_komisi_minus($idaff,$komisi){
		$ku=$this->db->dbprefix($this->tb_kom_user);
		$sql="update $ku set komisi=komisi-$komisi where id_aff='$idaff'";
		return $this->db->query($sql);
	}
}
