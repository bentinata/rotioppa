<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi extends Admin_Controller{
	function __construct(){
		parent::__construct();
		// load model
		$this->load->model('transaksi_model', 'tm');
		// load def lang
		$this->lang->load('deftransaksi');

	}
	function index($ajaxmode=false)
	{
		// for search
		$key=false;$filter=false;
		if($this->input->post('filter')){
			$filter=$this->input->post('filter');
			if($filter=='5'){
				$key['tgl1']=$this->input->post('tgl1');
				$key['tgl2']=$this->input->post('tgl2');
			}else
				$key=$this->input->post('search');
		}

		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $this->input->post('start')?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->tm->get_cekout(false,false,true,$key,$filter);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;
		$data['list_cek']= $this->tm->get_cekout($limitstart,$paging['limit'],false,$key,$filter);

		if($ajaxmode){
			$this->template->clear_layout();
			if($ajaxmode=='1'){
				if($filter=='5')
					$msg = sprintf(lang('search_tgl'),format_date_ina($key['tgl1'],'-',' '),format_date_ina($key['tgl2'],'-',' '),$paging['total']);
				else
					$msg = sprintf(lang('search_result'),$paging['total']);
				$respon['msg'] = $msg.' [ '.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method,lang('back')).' ]';
				$respon['view'] = $this->load->module_view(config_item('modulename'), 'transaksi2', $data, true);
				echo json_encode($respon);
			}else{
				$this->load->module_view(config_item('modulename'), 'transaksi3', $data);
			}
		}else
	        $this->template->set_view ('transaksi',$data,config_item('modulename'));
    }
	function edit($id=false){
		if(!$id) redirect(config_item('modulename').'/'.$this->router->class);

		if($this->input->post('_UPDATE')){
		    $id=$this->input->post('id');
		    $bayar=$this->input->post('is_bayar');
		    $bayar_old=$this->input->post('is_bayar_old');
            $kirim=$this->input->post('is_kirim');
            $kirim_old=$this->input->post('is_kirim_old');
            $update_ok=false;
            $send_mail=false;
			echo $bayar_old.'<br>'; 
			echo $bayar.'<br>';
            if($bayar!=$bayar_old){
				if($this->tm->update_status($id,$kirim,$bayar)){
					$update_ok=true;
					// update sales penjualan dilakukan jika kondisi sprt ini
					// update status dari belum => ke bayar
					// update status cekout ok
					$lap_iklan = $this->input->post('lap_iklan');
					if(!empty($lap_iklan)){
						$li = unserialize($lap_iklan);
						foreach($li as $_idiklan=>$_datatgl){
							foreach($_datatgl as $_tgl=>$_qty){
								if($bayar=='1')
								$this->tm->update_sales_iklan($_idiklan,$_qty,$_tgl);
								else // jika selain bayar
								$this->tm->update_sales_iklan_minus($_idiklan,$_qty,$_tgl);
						}}
					}
					// ambil total komisi dari order berdasarkan id cekout ini jika bukan nol
					// lalu tambahkan ke table komisi_user
					// jika sudah ada aff tsb di update, jika belum di input
					$total_komisi = $this->tm->hitung_komisi_by_cekout($id); #print_r($total_komisi);
					if($total_komisi){
						foreach($total_komisi as $tk){
							if($tk->jmlkomisi!=0){
								if($bayar=='1')
								$this->tm->insert_update_komisi($tk->id_aff,$tk->jmlkomisi); 
								else
								$this->tm->update_komisi_minus($tk->id_aff,$tk->jmlkomisi); #echo $this->tm->db->last_query();
						}}
					} #break;
				}
				$send_mail=true;
			}else{
				if($this->tm->update_status($id,$kirim,$bayar,false)) $update_ok=true;
			}
			$this->load->library('mail_lib');
			// update no_resi jika status kirim sudah di proses (3)
			echo $kirim.'<br>';
			echo $kirim_old.'<br>';
			
			if($kirim!=$kirim_old && $kirim=='3'){
				$resi=$this->input->post('resi');
				echo $resi.'<br>';
				$this->tm->update_resi($id,$resi,$kirim);
				// send mail for resi
				$no_resi = $this->input->post('resi');
				echo 'no resi ',$no_resi.'<br>';
				$data_for_resi = $this->tm->detail_for_send_resi($id);
				print_r ($data_for_resi).'<br>';
				$this->mail_lib->send_resi($data_for_resi->email,$data_for_resi->kode_transaksi,$no_resi,$data_for_resi->nama_perusahaan);
				//break;
			}
			if($update_ok){
				$data['ok'] = true;$data['msg'] = lang('update_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
				//print_r ($send_mail); break;
				if($send_mail){
					// send mail
					$list = $this->tm->list_cekout($id);
					//echo $list;break;
					$detail = $this->tm->detail_cekout($id); #print_r($detail);
					$cust = $this->tm->detail_cust_by_idcekout($id);
					$to = $cust->email;
					$nick = $cust->nama_panggilan;
					$this->mail_lib->proses_cekout($to,$list,$nick,$detail);
				}
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			}
        } 
        #$data['tiki'] = $this->tm->get_cabang_tiki($id); // feature ini skr di disable
        $data['list'] = $this->tm->list_cekout($id);
        $data['cust'] = $this->tm->detail_kirim($id); #print_r($data['cust']);
        $data['layanan'] = $this->tm->detail_layanan_by_cekout($id);
        $data['detailcust'] = $this->tm->detail_cust_by_idcekout($id);
		$this->template->set_view ('transaksi_edit',$data,config_item('modulename'));
    }
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->tm->delete_cekout($id)){
			java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}


}
