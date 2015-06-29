<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rss_model extends Model{
	var $tb_produk,$tb_gbr,$tb_kvendor;
	function Rss_model(){
		parent::Model();
		$this->tb_produk = 'produk';
		$this->tb_gbr = 'gambar';
		$this->tb_kvendor = 'kode_vendor';
    }
    function new_produk(){
		$g=$this->tb_gbr;
		$p=$this->tb_produk;
		$kv=$this->tb_kvendor;
		$gp=$this->db->dbprefix($g);
		$this->db->select("$p.id,$g.id as idgbr,nama_produk,summary,gambar");
        #$this->db->where(array('id'=>$id));
        $this->db->join($g,"$g.id_produk=$p.id and $gp.is_default=1",'left');
        $this->db->orderby('tgl desc');
        $this->db->limit(20);
		$query = $this->db->get($this->tb_produk); #echo $this->db->last_query(); break;
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
    }
}
