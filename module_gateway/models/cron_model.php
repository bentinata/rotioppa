<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron_model extends Model{
	var $tb_order,$tb_cekout,$tb_produk,$tb_iklan,$tb_track,$tb_cust,$tb_atk,$tb_cart,$tb_hp;
	function Cron_model(){
		parent::Model();
		$this->tb_order = 'order';
        $this->tb_cekout = 'cekout';
        $this->tb_produk = 'produk';
        $this->tb_iklan = 'iklan';
        $this->tb_track = 'track';
        $this->tb_cust = 'customer';
        $this->tb_atk = 'atribut_khusus';
        $this->tb_cart = 'cart';
        $this->tb_hp = 'history_produk';
        $this->db->query("set time_zone='+7:00'"); // for setting to local time
    }
    function review_komisi($monthyear){
        $o=$this->db->dbprefix($this->tb_order);
        $p=$this->db->dbprefix($this->tb_produk);
        $i=$this->db->dbprefix($this->tb_iklan);
        $t=$this->db->dbprefix($this->tb_track);
        $c=$this->db->dbprefix($this->tb_cekout);

        $sql="insert into sam_laporan_komisi(id_aff,tgl,total_harga,total_item,total_komisi) "
            ."select t.id_aff,date_format(c.tgl_lunas,'%Y-%m-01') as tgl, "
            ."sum(o.harga*o.qty) as harga,sum(o.qty) as jml,sum(o.komisi) as komisi "
            ."from $o as o "
            ."inner join $c as c on o.id_cekout=c.id "
            ."left join $p as p on o.id_produk=p.id "
            ."inner join $i as i on o.id_iklan=i.id "
            ."inner join $t as t on i.id_track=t.id "
            ."where c.status_bayar='1' and date_format(c.tgl_lunas,'%m-%Y')='$monthyear' "
            ."and p.for_affiliate='1' "
            ."group by id_aff";
        return $this->db->query($sql);
    }
    function get_cekout_pending()
    {
		$cu=$this->tb_cust;
		$ck=$this->tb_cekout;
		$cup=$this->db->dbprefix($cu);
		$ckp=$this->db->dbprefix($ck);
		
		$this->db->select("to_days(now()) as today_now,to_days($ckp.tgl) as today_cekout,$cup.email,$cup.nama_panggilan,"
			."$ckp.id as id_cekout,$ckp.kode_transaksi,$ckp.harga,$ckp.kode_unik,$ckp.biaya_kirim,$ckp.status_kirim,$ckp.total_berat");
		$this->db->select("date_format($ckp.tgl,'%d-%m-%Y') as tgl_transaksi",FALSE);
		$this->db->join($cu,"$ck.id_customer=$cu.id",'left');
		$this->db->where("$ck.status_bayar",'2');
		#$this->db->where("$ck.id",'49');
		$query=$this->db->get($ck); #echo $this->db->last_query(); break;
		if($query->num_rows()>0){
			$row=$query->result();
			$query->free_result();
			return $row;
		}
		return false;
	}
	function clear_order_and_cekout($longday)
	{
		$o=$this->tb_order;
		$ck=$this->tb_cekout;
		$cust=$this->tb_cust;
		$op=$this->db->dbprefix($o);
		$ckp=$this->db->dbprefix($ck);
		$custp=$this->db->dbprefix($cust);

		$this->db->select("$o.id as id_order,$o.id_cekout,$o.qty,$o.id_stock_attr_khusus,$cust.email,$ck.kode_transaksi");
		$this->db->join($ck,"$o.id_cekout=$ck.id",'left');
		$this->db->join($cust,"$cust.id=$ck.id_customer",'left');
		$this->db->where("$ckp.status_bayar=2 and to_days(now())-to_days($ckp.tgl)>$longday",FALSE,FALSE);
		#$this->db->where("$ck.id",'49');
		$query=$this->db->get($o); #echo $this->db->last_query().'<br /><br />';
		if($query->num_rows()>0){
			$row=$query->result();
			$query->free_result();

            // loop and update stock
            $at=$this->db->dbprefix($this->tb_atk);
            $data_formail=false;
            foreach($row as $data)
            {
				if(!empty($data->id_stock_attr_khusus) || $data->id_stock_attr_khusus!=0)
				{
					$sql="update $at set stock=stock+".$data->qty." where id='".$data->id_stock_attr_khusus."'"; #echo $sql.'<br /><br />';
					$this->db->query($sql); #echo $this->db->last_query();
				}
                $idfordell[]=$data->id_order;
                $idfordell_cekout[$data->id_cekout]=$data->id_cekout;
                $data_formail[$data->id_cekout]=array('email'=>$data->email,'invoice'=>$data->kode_transaksi);
                
            } #print_r($idfordell);print_r($idfordell_cekout);print_r($data_formail);
            // delete order
            $this->db->where_in('id',$idfordell);
            $this->db->delete($o);
            // delete cekout
            $this->db->where_in('id',$idfordell_cekout);
            $this->db->delete($ck);
            return $data_formail;
		}
		return false;
	}
    function clear_cart(){
        // get id and stock
        $this->db->select('id,id_produk,qty,id_stock_attr_khusus');
        // for all
        $this->db->where("to_days(now())-to_days(tgl)>0",FALSE,FALSE); // artinya setelah harinya berbeda
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
					$sql="update $at set stock=stock+".$data->qty." where id='".$data->id_stock_attr_khusus."'"; #echo $sql;
					$this->db->query($sql); #echo $this->db->last_query();
				}
                $idfordell[]=$data->id;
            } #print_r($idfordell);
            // delete chart
            $this->db->where_in('id',$idfordell);
            return $this->db->delete($this->tb_cart);
        }
        return false;
    }
    function clear_history_produk(){
        $this->db->where("to_days(now())-to_days(tgl_view)>0",FALSE,FALSE); // artinya setelah harinya berbeda
        return $query=$this->db->delete($this->tb_hp); #echo $this->db->last_query();
    }

}
