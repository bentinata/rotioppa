<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Member_model extends CI_Model{
	var $tb_cust,$tb_prop,$tb_kota,$tb_cart,$tb_order,$tb_cekout,$tb_review;
	function __construct(){
		parent::__construct();
		$this->tb_cust = 'customer';
        $this->tb_prop = 'provinsi';
        $this->tb_kota = 'kota';
        $this->tb_cart = 'cart';
        $this->tb_order = 'order';
        $this->tb_cekout = 'cekout';
        $this->tb_rev = 'review';

    }
    function list_member($search,$order=false,$start=false,$limit=false,$justcount=false){ 
        $this->db->select("id,email,nama_lengkap,date_format(tgl_daftar,'%d-%m-%Y') as daftar,tgl_daftar,no_tlp,status",FALSE);
        if($search){
            if($search['key']=='1') $this->db->like('email',$search['val']);
            if($search['key']=='2') $this->db->like('nama_lengkap',$search['val']);
            if($search['key']=='3') $this->db->where("date_format(tgl_daftar,'%Y-%m-%d') between '".$search['val']['tgl1']."' and '".$search['val']['tgl2']."'");
        }

        if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get($this->tb_cust);
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
				case '4':$or='no_tlp';break;
				case '5':$or='status';break;
				default:$or=false;
			}
			if($order['asdesc']=='a')$ad='asc';else $ad='desc';
			$this->db->order_by($or,$ad);
		}
        
        $query = $this->db->get($this->tb_cust); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
    function detail_member($id){
        $c=$this->tb_cust;
        $cp=$this->db->dbprefix($c);
        $kp=$this->db->dbprefix($this->tb_kota);
        $this->db->select("*,"
            ."(select id_provinsi from $kp where id=$cp.idkota_rumah) as prop_rumah,"
            ."(select id_provinsi from $kp where id=$cp.idkota_kirim) as prop_kirim,"
            ,FALSE);
        $query = $this->db->get_where($this->tb_cust,array('id'=>$id)); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
	function delete_member($id){
		$this->db->delete($this->tb_cust,array('id'=>$id));
        $this->delete_cart($id);
        $this->delete_order($id);
        $this->delete_cekout($id);
        $this->delete_review($id);
        return true;
	}
    function update_member($id,$pass,$full,$nick,$tlp,$jenkel,$lahir,$rumah,$ktrumah,$kirim,$ktkirim,$se,$zr,$zk,$email){
        $send=$se==true?'1':'2';
        $set=array(
            'password'=>$pass,
            'nama_lengkap'=>$full,
            'nama_panggilan'=>$nick,
            'no_tlp'=>$tlp,
            'jen_kel'=>$jenkel,
            'tgl_lahir'=>$lahir,
            'alamat_rumah'=>$rumah,
            'idkota_rumah'=>$ktrumah,
            'alamat_kirim'=>$kirim,
            'idkota_kirim'=>$ktkirim,
            'send_email'=>$send,
            'zip_rumah'=>$zr,
            'zip_kirim'=>$zk,
            'email'=>$email
        );
        $this->db->where('id',$id);
        return $this->db->update($this->tb_cust,$set);
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
	function active_member($id){
		$this->db->where(array('id'=>$id));
		$this->db->set(array('status'=>'1'));
		return $this->db->update($this->tb_cust);
	}

}
