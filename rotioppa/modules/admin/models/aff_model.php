<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Aff_model extends CI_Model{
	var $tb_aff,$tb_kom,$tb_kom_user;
	function __construct(){
		parent::__construct();
		$this->tb_aff = 'aff';
        $this->tb_kom='komisi';
        $this->tb_kom_user='komisi_user';
    }
    function list_aff($search,$order=false,$start=false,$limit=false,$justcount=false){
        $k=$this->tb_kom_user;
        $a=$this->tb_aff;
        $ap=$this->db->dbprefix($a);
        $this->db->select("$a.id,$a.email,$a.nama_lengkap,date_format($ap.tgl_daftar,'%d-%m-%Y') as daftar,$a.tgl_daftar,$a.no_tlp,$a.min_transfer,komisi,(komisi-min_transfer) as selisih,$k.id as id_komisi",FALSE);
        if($search){
            if($search['key']=='1') $this->db->like('email',$search['val']);
            if($search['key']=='2') $this->db->like('nama_lengkap',$search['val']);
            if($search['key']=='3') $this->db->where("date_format($ap.tgl_daftar,'%Y-%m-%d') between '".$search['val']['tgl1']."' and '".$search['val']['tgl2']."'");
        }
		
		$this->db->join($k,"$k.id_aff=$a.id",'left');
        if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($this->tb_aff);
			$row = $query->row();
			return $row->jml;
		}
        if($limit!==false)
		$this->db->limit($limit,$start);
		if($order){
			switch($order['order']){
				case '1':$or='email';break;
				case '2':$or='nama_lengkap';break;
				case '3':$or='tgl_daftar';break;
				case '4':$or='min_transfer';break;
				case '5':$or='komisi';break;
				#default:$or='selisih';
			}
			if($order['asdesc']=='a')$ad='asc';else $ad='desc';
			$this->db->order_by($or,$ad);
		}else
			$this->db->order_by("selisih desc");
			
        $query = $this->db->get($this->tb_aff);
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function detail_aff($id){
        $this->db->select("*");
        $query = $this->db->get_where($this->tb_aff,array('id'=>$id)); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
	function delete_aff($id){
		$this->db->delete($this->tb_aff,array('id'=>$id));
        #$this->delete_cart($id);
        #$this->delete_order($id);
        #$this->delete_cekout($id);
        #$this->delete_review($id);
        return true;
	}
    function update_aff($id,$pass,$full,$nick,$tlp,$hp,$jenkel,$lahir,$alm,$kota,$prov,$neg,$pm,$mk){
        $set=array(
            'password'=>$pass,
            'nama_lengkap'=>$full,
            'nama_panggilan'=>$nick,
            'no_tlp'=>$tlp,
            'no_hp'=>$hp,
            'jen_kel'=>$jenkel,
            'tgl_lahir'=>$lahir,
            'alamat'=>$alm,
            'kota'=>$kota,
            'provinsi'=>$prov,
            'negara'=>$neg,
            'pay_method'=>$pm,
            'min_transfer'=>$mk
        );
        $this->db->where('id',$id);
        return $this->db->update($this->tb_aff,$set);
    }
    function delete_cart($id){
        return $this->db->delete($this->tb_cart,array('user_customer'=>$id));
    }
    function delete_order($id){
        return $this->db->delete($this->tb_order,array('id_customer'=>$id));
    }
    function delete_cekout($id){
        return $this->db->delete($this->tb_cekout,array('id_customer'=>$id));
    }
    function delete_review($id){
        return $this->db->delete($this->tb_rev,array('id_customer'=>$id));
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
}
