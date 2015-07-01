<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends Controller 
{
	var $linebreak="\r\n";
    function Sitemap()
    {
        parent::Controller();
   		// load model global
		$this->load->model('global_model', 'gm');
    }
    
    function index()
    {
		$this->output->set_header('Content-type: text/plain');
		
		// base url
		$this->output->append_output(site_url().$this->linebreak); 
		
		// get sub kategori level 1
		$query = $this->gm->db->get($this->gm->tb_subkat); #echo $this->gm->db->last_query();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$this->output->append_output(site_url('home/listproduk/index/'.$row->id.'/'.en_url_save($row->subkategori)).$this->linebreak);
			}
			$query->free_result();
		}

		// get sub kategori level 2
		$query = $this->gm->db->get($this->gm->tb_subkat2); #echo $this->gm->db->last_query();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$this->output->append_output(site_url('home/listproduk/indexsub/'.$row->id.'/'.en_url_save($row->subkategori2)).$this->linebreak);
			}
			$query->free_result();
		}

		// get produk
		$query = $this->gm->db->get($this->gm->tb_produk); #echo $this->gm->db->last_query();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$this->output->append_output(site_url('home/detail/index/'.$row->id.'/'.en_url_save($row->nama_produk)).$this->linebreak);
			}
			$query->free_result();
		}

	}

} 
