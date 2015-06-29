<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model{
	var $tb_user,$tb_cust,$tb_cart,$tb_produk,$tb_aff,$tb_atk,$tb_hp;

	function __construct(){
		parent::__construct();
		$this->tb_user = 'poseidonuser';
		$this->tb_cust = 'customer';
        $this->tb_cart = 'cart';
        $this->tb_produk = 'produk';
        $this->tb_aff = 'aff';
        $this->tb_atk = 'atribut_khusus';
        $this->tb_hp = 'history_produk';
	}
	
	function check_admin($user){
		$where = array('username'=>$user);
		$this->db->select('id,username,password');
		$query = $this->db->get_where($this->tb_user,$where); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function check_member($mail){
		$this->db->select('id,password,status,nama_lengkap,email,nama_panggilan');
		$query = $this->db->get_where($this->tb_cust,array('email'=>$mail)); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function check_aff($mail){
		$this->db->select('id,password,status,nama_lengkap,email,nama_panggilan');
		$query = $this->db->get_where($this->tb_aff,array('email'=>$mail)); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	
	// for cart proses
    function update_cart_idcust($global,$id){
        // ambil id_produk dr user global dan user customernya belum diisi
        $this->db->select('id_produk,id_stock_attr_khusus');
        $this->db->where("user_global='$global' and user_customer IS NULL",FALSE,FALSE);
        $query = $this->db->get($this->tb_cart);
		if($query->num_rows()>0){ #break;
            foreach($query->result() as $row){
                // cek jika ada produk yg telah di pilih oleh user member
                $this->db->select('id,qty');
                $query2 = $this->db->get_where($this->tb_cart,array('id_produk'=>$row->id_produk,'id_stock_attr_khusus'=>$row->id_stock_attr_khusus,'user_customer'=>$id));
                if($query2->num_rows()>0){
                    $row2 = $query2->row();
                    $query2->free_result();
					// jika ada, maka hapus yg sdh ada karena akan di ganti dengan yg baru
                    // delete dr yg user customernya yg dah diisi dan id produknya ada
                    $this->db->where(array('id'=>$row2->id)); #echo $this->db->last_query();
                    $this->db->delete($this->tb_cart);

                    // update stock
                    $qty=$row2->qty;
                    $this->db->set('stock', "stock+$qty",FALSE);
                    $this->db->where(array('id'=>$row->id_stock_attr_khusus));
                    $this->db->update($this->tb_atk);      #echo $this->db->last_query();
                }
            }
            $query->free_result();

            // update user customer yg masih kosong, berdasarkan user global
            $this->db->where('user_global',$global);
            $this->db->update($this->tb_cart,array('user_customer'=>$id)); #echo $this->db->last_query(); break;

            // kosongkan user global
            $this->db->where('user_customer',$id);
            $this->db->update($this->tb_cart,array('user_global'=>NULL)); #echo $this->db->last_query(); break;

            return true;
		} #break;
		return false;
    }

	// for history produk proses
	function change_history_global_to_cust($userglobal,$usercust){
		$this->db->where('user_global',$userglobal);
		return $this->db->update($this->tb_hp,array('user_customer'=>$usercust,'user_global'=>NULL));
	}
	function clear_history_by_user($usercust){
		$this->db->where('user_customer',$usercust);
		$this->db->delete($this->tb_hp);
	}
	// for cart
	function clear_cart_by_user($user){
        // get id and stock
        $this->db->select('id,id_produk,qty,id_stock_attr_khusus');
        // for all
        $this->db->where('user_customer',$user);
        $query=$this->db->get($this->tb_cart); #echo $this->db->last_query();
        if($query->num_rows()>0){ #break;
        	$row = $query->result();
			$query->free_result();

            // loop and update stock
            $at=$this->db->dbprefix($this->tb_atk);
            foreach($row as $data)
            {
				if(!empty($data->id_stock_attr_khusus) || $data->id_stock_attr_khusus!=0)
				{
					$sql="update $at set stock=stock+".$data->qty." where id='".$data->id_stock_attr_khusus."'";
					$this->db->query($sql); #echo $this->db->last_query();
				}
                $idfordell[]=$data->id;
            }
            // delete chart
            $this->db->where_in('id',$idfordell);
            return $this->db->delete($this->tb_cart);
        }
        return false;
		
	}

}
