<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bkirim_model extends CI_Model{
	var $tb_kota,$tb_prov,$tb_kirim,$tb_pkirim,$tb_lkirim,$tb_cust;
	function __construct(){
		parent::__construct();
		$this->tb_kirim = 'biaya_pengiriman';
		$this->tb_kota = 'kota';
		$this->tb_prov = 'provinsi';
		$this->tb_pkirim = 'perusahaan_kirim';
		$this->tb_lkirim = 'layanan_kirim';
		$this->tb_cust = 'customer';
	}

	// ----------------------------- BIAYA KIRIM -------------------------
	function list_biaya($idkota){
		$b = $this->tb_kirim;
        $pk = $this->tb_pkirim;
        $lk = $this->tb_lkirim;
        $this->db->where('id_kota',$idkota);
		$this->db->select("nama_perusahaan,id_perusahaan,layanan,id_layanan,biaya_kirim");
        $this->db->join($lk,"$b.id_layanan=$lk.id",'left');
        $this->db->join($pk,"$lk.id_perusahaan=$pk.id",'left');
		$this->db->order_by("nama_perusahaan,layanan");
		$query = $this->db->get($b); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			foreach($query->result() as $row){
				$data[$row->id_perusahaan]['perusahaan'] = $row->nama_perusahaan;
				$data[$row->id_perusahaan]['layanan'][$row->id_layanan]['nama_layanan'] = $row->layanan;
				$data[$row->id_perusahaan]['layanan'][$row->id_layanan]['biaya'] = $row->biaya_kirim;
			}
			$query->free_result();
			return $data;
		} #break;
		return false;
	}
	function detail_biaya($id){
		$b = $this->tb_kirim;
		$k = $this->tb_kota;
		$p = $this->tb_prov;
		$l = $this->tb_lkirim;
		$this->db->select("$p.provinsi,$k.kota,$k.id as id_kota,$l.id_perusahaan,$b.id_layanan,$b.biaya_kirim,$b.id as id_biaya");
		$this->db->where("$k.id",$id);
        $this->db->join($p,"$k.id_provinsi=$p.id",'left');
        $this->db->join($b,"$b.id_kota=$k.id",'left');
        $this->db->join($l,"$b.id_layanan=$l.id",'left');
		$query = $this->db->get($k); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			foreach ($query->result() as $row){
				$data['prov'] = $row->provinsi;
				$data['kota'] = $row->kota;
				$data['id_kota'] = $row->id_kota;
				$data['layanan'][$row->id_perusahaan][$row->id_layanan]['biaya'] = $row->biaya_kirim;
				$data['layanan'][$row->id_perusahaan][$row->id_layanan]['id_biaya'] = $row->id_biaya;
			}
			$query->free_result();
			return $data;
		} #break;
		return false;
	}
	function update_biaya($id,$biaya){
	    $update=array('biaya_kirim'=>$biaya);
		$this->db->where('id',$id);
		return $this->db->update($this->tb_kirim,$update);
	}
	function input_biaya($kota,$layanan,$biaya){
	    $data=array('id_kota'=>$kota,'id_layanan'=>$layanan,'biaya_kirim'=>$biaya);
		return $this->db->insert($this->tb_kirim,$data);
	}
	function delete_biaya($id){
		return $this->db->delete($this->tb_kirim,array('id'=>$id));
	}
    function cek_biaya_from_kota($kota){
        $this->db->select('id');
        $query = $this->db->get_where($this->tb_kirim,array('id_kota'=>$kota));
		if($query->num_rows()>0){ #break;
			#$row = $query->row();
			$query->free_result();
			return true;
		} #break;
		return false;
    }

	// ---------------------------- PROVINSI -----------------
	function list_prov($start=false,$limit=false,$justcount=false){
        $p = $this->tb_prov;
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$p");
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("$p.provinsi,$p.id");
        $this->db->order_by("$p.provinsi");
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_prov($id){
		$p = $this->tb_prov;
		$this->db->select("$p.id,$p.provinsi");
		$this->db->where("$p.id",$id);
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_prov($id,$prov){
	    $update=array('provinsi'=>$prov);
		$this->db->where('id',$id);
		$return = $this->db->update($this->tb_prov,$update); #echo $this->db->last_query();
		return $return;
	}
	function input_prov($prov){
	    $data=array('provinsi'=>$prov);
		return $this->db->insert($this->tb_prov,$data);
	}
	function delete_prov($id){
		return $this->db->delete($this->tb_prov,array('id'=>$id));
	}
    function cek_kota_by_prov($prov){
        $this->db->select('id');
        $query = $this->db->get_where($this->tb_kota,array('id_provinsi'=>$prov));
		if($query->num_rows()>0){ #break;
			#$row = $query->row();
			$query->free_result();
			return true;
		} #break;
		return false;
    }

	// ----------------------------- BIAYA KOTA -------------------------
	function list_kota($start=false,$limit=false,$justcount=false){
        $k = $this->tb_kota;
        $p = $this->tb_prov;
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$k");
			$row = $query->row();
			return $row->jml;
		}
		$this->db->limit($limit,$start);
		$this->db->select("$p.provinsi,$k.kota,$k.id");
        $this->db->join($p,"$k.id_provinsi=$p.id",'left');
		$this->db->order_by("$p.provinsi,$k.kota");
		$query = $this->db->get($k); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			$row = $query->result();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function detail_kota($id){
		$k = $this->tb_kota;
		$this->db->select("$k.id,$k.kota,$k.id_provinsi");
		$this->db->where("$k.id",$id);
		$query = $this->db->get($k); #echo $this->db->last_query();
		if($query->num_rows()==1){ #break;
			$row = $query->row();
			$query->free_result();
			return $row;
		} #break;
		return false;
	}
	function update_kota($id,$kota,$prov){
	    $update=array('kota'=>$kota,'id_provinsi'=>$prov);
		$this->db->where('id',$id);
		return $this->db->update($this->tb_kota,$update);
	}
	function input_kota($id,$kota,$prov){
	    $data=array('kota'=>$kota,'id_provinsi'=>$prov);
		return $this->db->insert($this->tb_kota,$data);
	}
	function delete_kota($id){
		return $this->db->delete($this->tb_kota,array('id'=>$id));
	}
    function cek_cust_by_kota($kota){
        $this->db->select('id');
        $query = $this->db->get_where($this->tb_cust,array('idkota_kirim'=>$kota));
		if($query->num_rows()>0){ #break;
			#$row = $query->row();
			$query->free_result();
			return true;
		} #break;
		return false;
    }


	function option_prop($empty=true){
		$query = $this->db->get($this->tb_prov);
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
		$query = $this->db->get($this->tb_kota); echo $this->db->last_query();
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
	function option_kota_no_biaya($idprov,$empty=true){
		$k=$this->tb_kota;
		$p=$this->tb_kirim;
		$this->db->select("$k.id,$k.kota");
	    $this->db->where("id_provinsi=$idprov and ".$this->db->dbprefix($p).".id is null",FALSE,FALSE);
	    $this->db->join($p,"$p.id_kota=$k.id",'left');
		$query = $this->db->get($k); #echo $this->db->last_query();
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

	function list_layanan_perusahaan($start=false,$limit=false,$justcount=false){
        $lk = $this->tb_lkirim;
        $pk = $this->tb_pkirim;
		if($justcount){
			$this->db->select('count(*) as jml',FALSE);
			$query = $this->db->get("$pk");
			$row = $query->row();
			return $row->jml;
		}
        if($limit!==false)
		$this->db->limit($limit,$start);
		$this->db->select("$pk.id as id_perusahaan,nama_perusahaan,layanan,$lk.id as id_layanan");
        $this->db->order_by("nama_perusahaan");
        $this->db->join($lk,"$lk.id_perusahaan=$pk.id",'left');
		$query = $this->db->get($pk); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			foreach($query->result() as $row){
				$data[$row->id_perusahaan]['nama_perusahaan'] = $row->nama_perusahaan;
				$data[$row->id_perusahaan]['layanan'][$row->id_layanan] = $row->layanan;
			}
			$query->free_result();
			return $data;
		} #break;
		return false;
	}
	function input_perusahaan($perusahaan){
	    $data=array('nama_perusahaan'=>$perusahaan);
		$this->db->insert($this->tb_pkirim,$data);
		return $this->db->insert_id();
	}
	function delete_perusahaan($id){
	    $this->db->where('id',$id);
		return $this->db->delete($this->tb_pkirim);
	}
	function update_perusahaan($id,$perusahaan){
	    $data=array('nama_perusahaan'=>$perusahaan);
	    $this->db->where('id',$id);
		return $this->db->update($this->tb_pkirim,$data);
	}
	function input_layanan($id_perusahaan,$layanan){
	    $data=array('id_perusahaan'=>$id_perusahaan,'layanan'=>$layanan);
		return $this->db->insert($this->tb_lkirim,$data);
	}
	function delete_biaya_by_layanan($id_layanan){
		/*$bp=$this->db->dbprefix($this->tb_kirim);
		$lp=$this->db->dbprefix($this->tb_lkirim);
		$sql="delete l,b from $bp as b "
			."inner join $lp as l on l.id=b.id_layanan "
			."where l.id=$id_layanan"; echo $sql;
		return $this->db->query($sql);*/

	    $this->db->where('id',$id_layanan);
		$this->db->delete($this->tb_lkirim);
        
   	    $this->db->where('id_layanan',$id_layanan);
		$this->db->delete($this->tb_kirim);
	}
	function delete_biaya_by_perusahaan($id_perusahaan){
		/*$pk=$this->db->dbprefix($this->tb_pkirim);
		$bp=$this->db->dbprefix($this->tb_kirim);
		$lp=$this->db->dbprefix($this->tb_lkirim);
		$sql="delete p,l,b from $bp as b "
			."inner join $lp as l on l.id=b.id_layanan "
			."inner join $pk as p on p.id=l.id_perusahaan "
			."where p.id=$id_perusahaan";
		return $this->db->query($sql);*/
        
        // get id layanan
        $query = $this->db->select('id')->from($this->tb_lkirim)->where('id_perusahaan', $id_perusahaan)->get(); #print_r($query);
        if($query->num_rows()>0){ #break;
			foreach($query->result() as $row){
			     // delete layanan and biaya
                 $this->delete_biaya_by_layanan($row->id);
			}
			$query->free_result();
		} #break;
        
        // delete perusahaan
	    $this->db->where('id',$id_perusahaan);
		$this->db->delete($this->tb_pkirim);
        
		return false;
	}
	function delete_biaya_by_kota($id_kota){
		return $this->db->delete($this->tb_kirim,array('id_kota'=>$id_kota));
	}
	function update_layanan($id,$layanan){
	    $data=array('layanan'=>$layanan);
	    $this->db->where('id',$id);
		return $this->db->update($this->tb_lkirim,$data);
	}
	function detail_perusahaan_layanan($id){
		$p = $this->tb_pkirim;
		$l = $this->tb_lkirim;
		$this->db->select("$p.id,$p.nama_perusahaan,$l.id as idlayanan,$l.layanan");
		$this->db->where("$p.id",$id);
        $this->db->join($l,"$l.id_perusahaan=$p.id",'left');
		$query = $this->db->get($p); #echo $this->db->last_query();
		if($query->num_rows()>0){ #break;
			foreach($query->result() as $row){
				$data['perusahaan'] = array('id'=>$row->id,'nama'=>$row->nama_perusahaan);
				$data['layanan'][$row->idlayanan] = $row->layanan;
			}
			$query->free_result();
			return $data;
		} #break;
		return false;
	}
}
