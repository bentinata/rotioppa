<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Global_model extends CI_Model{
	var $tb_kat,$tb_subkat,$tb_cart,$tb_produk,$tb_subkat2,$tb_atk,$tb_hp,$tb_email;
	function Global_model(){
		parent::__construct();
		$this->tb_kat = 'kategori';
		$this->tb_katalog = 'katalog';
		$this->tb_subkat = 'kategori_sub';
		$this->tb_subkat2 = 'kategori_sub2';
		$this->tb_cart = 'cart';
        $this->tb_produk = 'produk';
        $this->tb_atk = 'atribut_khusus';
        $this->tb_hp = 'history_produk';
        $this->tb_email = 'email';
	}
	
	function option_kat($empty=true){
		$this->db->order_by('kategori');
		$query = $this->db->get($this->tb_kat); #echo $this->db->last_query();
		
		if($query->num_rows()>0){ #break;
			if($empty) $data[''] = ' - ';
			foreach($query->result() as $row){
				$data[$row->id] = $row->kategori;
			}
			$query->free_result();
			return $data;
		} #break;
		return false;
	}
	
	function get_kat_sub(){
		$k = $this->tb_kat;
		$s = $this->tb_subkat;
		$s2 = $this->tb_subkat2;
		$this->db->order_by("$s.subkategori");
		$this->db->select("$s.*");
		$this->db->where("id_kategori = '5'");
		$query = $this->db->get($s); #echo $this->db->last_query();
		$countkat=0;
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				if(!isset($ret[$row->id])) $countkat++;
					$ret[$row->id]['sub'] = $row->subkategori;
			}
			return $ret;
		}
		return false;
	}
	function get_katalog(){
		$k = $this->tb_katalog;
		$this->db->order_by("$k.katalog");
		$query = $this->db->get($k);
		$countkatalog = 0;
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				if(!isset($ret[$row->id])) $countkatalog++;
				$ret[$row->id]['kat'] = $row->katalog;
			}
		}
		return $ret;
	}
	function count_cart($id_user,$cust=false){
		$this->db->select('count(*) as jml');
		if($cust)
		$this->db->where('user_customer',$cust);
		else
		$this->db->where('user_global',$id_user);
		$query = $this->db->get($this->tb_cart);
		$row = $query->row();
		return $row->jml;
	}

	function get_mail_fu($code){
		$this->db->where(array('status_email'=>'1','code_email'=>$code));
		$query = $this->db->get($this->tb_email); #echo $this->db->last_query();
		if($query->num_rows()>0){
			$row = $query->row();
			$query->free_result();
			return $row;
		}
		return false;
	}
	
	function get_menu(){
		//Buat Ngisi Kategori
		$query = $this->db->get($this->tb_kat);
		if($query->num_rows()>0){
			$result = $query->result_array();
			$query->free_result();
			
			//Buat Ngisi Sub Kategori
			foreach($result as $key => $value){
				$this->db->where('id_kategori', $value['id']);
				$query = $this->db->get($this->tb_subkat);
				$result[$key]['subs'] = $query->result_array(); 
			}
			
			// var_dump($result);exit();
			return $result;
		}
		return false;
	}
	
	function get_menu_more(){
		//Buat Ngisi Kategori
		$q = $this->db->get($this->tb_kat);
		$total = $q->num_rows();
		$query = $this->db->get($this->tb_kat);
		if($query->num_rows()>0){
			$result = $query->result_array();
			$query->free_result();
			
			//Buat Ngisi Sub Kategori
			foreach($result as $key => $value){
				$this->db->where('id_kategori', $value['id']);
				$query = $this->db->get($this->tb_subkat);
				$result[$key]['subs'] = $query->result_array(); 
			}
			
			// var_dump($result);exit();
			return $result;
		}
		return false;
	}

}
