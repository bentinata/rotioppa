<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banner_model extends Model{
	var $tb_track,$tb_iklan,$tb_lapiklan,$tb_diklan,$tb_produk,$tb_gbr,$tb_subkat;
	function Banner_model(){
		parent::Model();
		$this->tb_track = 'track';
        $this->tb_iklan = 'iklan';
        $this->tb_lapiklan = 'laporan_iklan';
        $this->tb_diklan = 'iklan_data';
        $this->tb_produk = 'produk';
        $this->tb_gbr = 'gambar';
        $this->tb_subkat = 'kategori_sub';
    }
    function detail_iklan($id){
		$di=$this->tb_diklan;
		$i=$this->tb_iklan;
        $this->db->where(array("$i.id"=>$id));
        $this->db->join($di,"$di.id_iklan=$i.id",'left');
		$query = $this->db->get($i); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function write_imp($iklan){
        $date = date('Y-m-d');
        // select first, jika ada ++ jika tidak insert 1
        $this->db->select('id');
        $query = $this->db->get_where($this->tb_lapiklan,array('id_iklan'=>$iklan,'tgl'=>$date)); #echo $this->db->last_query();
        if($query->num_rows()>0){
            $query->free_result();
            $lip = $this->db->dbprefix($this->tb_lapiklan);
            return $this->db->query("update $lip set impresi=impresi+1 where id_iklan='$iklan' and tgl='$date'");
        }else{
            // klik hrs di set 0 karena utk operasional add klik
            $data = array('id_iklan'=>$iklan,
                    'impresi'=>'1',
                    'tgl'=>$date);
            return $this->db->insert($this->tb_lapiklan,$data);
        }
    }
    function write_klik($iklan){
        $date = date('Y-m-d');
        // select first, jika ada ++ jika tidak insert 1
        $this->db->select('id');
        $query = $this->db->get_where($this->tb_lapiklan,array('id_iklan'=>$iklan,'tgl'=>$date));
        if($query->num_rows()>0){
            $query->free_result();
            $lip = $this->db->dbprefix($this->tb_lapiklan);
            return $this->db->query("update $lip set klik=klik+1 where id_iklan='$iklan' and tgl='$date'");
        }else{
            $data = array('id_iklan'=>$iklan,
                    'klik'=>'1',
                    'tgl'=>$date);
            return $this->db->insert($this->tb_lapiklan,$data);
        }
    }
    function get_produk_for_linkproduk($search){
		$p=$this->tb_produk;
		$g=$this->tb_gbr;
		$sk=$this->tb_subkat;
		$gp=$this->db->dbprefix($g);
		$dosql=false;
        if(!empty($search['key'])){ $dosql=true;
			$this->db->like('nama_produk',$search['key']);
		}
		if(!empty($search['kat'])){ $dosql=true;
			$this->db->where('id_kategori',$search['kat']);
		}
		if(!empty($search['subkat'])){ $dosql=true;
			$this->db->where('id_subkategori',$search['subkat']);
		}
		if($dosql){ // jika ada salah satu kriteria where
		$this->db->select("$p.id,gambar,$g.id as idgbr,nama_produk");
		$this->db->select("$p.harga_awal_diskon AS ha_diskon,$p.harga_baru_diskon AS hb_diskon,"
						 ."$p.harga_awal AS ha_prop,$p.harga_baru AS hb_prop",FALSE);
		$this->db->join($g,"$g.id_produk=$p.id and $gp.is_default='1'",'left');
		$this->db->join($sk,"$sk.id=$p.id_subkategori");
        $this->db->limit(10); // sementara hanya di tampilkan 10 produk saja
        $this->db->order_by('rand()');
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		} // dosql
		return false;
    }
}
