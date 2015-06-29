<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Biayakirim extends Admin_Controller{
	function __construct(){
		parent::__construct();
		// load model
		$this->load->model('bkirim_model', 'bm');
		// load def lang
		$this->lang->load('defbiaya');

	}

	// ---------------------------- BIAYA KIRIM ---------------------
	function index()
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,10);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->bm->list_kota(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$kota=$this->bm->list_kota($limitstart,$pg['limit']); #print_r($kota);
		$data['list_biaya'] = $kota;
		if($kota){foreach($kota as $_kota){
			$_kota->biaya = $this->bm->list_biaya($_kota->id);
			$biaya[]=$_kota;
		}$data['list_biaya']=$biaya;}
		$this->template->set_view ('bkirim',$data,config_item('modulename'));
	}
	function edit($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){ #print_r($_POST);break;
			$biaya_kirim = $this->input->post('hid_biaya');
			$id_biaya = $this->input->post('id_biaya');
			$id_kota = $this->input->post('id_kota');
			$id_layanan = $this->input->post('id_layanan');
			
			if($biaya_kirim){foreach($biaya_kirim as $urut=>$bkirim){
				//cek jika sudah ada id biaya passing parameter dr database 
				if(isset($id_biaya[$urut])){
					// cek jika data biaya ada, artinya di update
					if(!empty($bkirim)){
						$this->bm->update_biaya($id_biaya[$urut],$bkirim);
					// jika b kirim kosong, artinya hapus biaya
					}else{
						$this->bm->delete_biaya($id_biaya[$urut]);
					}
				// jika tidak ada id biayanya, artinya input baru
				}else{
					// cek jika biaya kirimnya ada, boleh di input jika tidak , abaikan
					if(!empty($bkirim)){
						$this->bm->input_biaya($id_kota[$urut],$id_layanan[$urut],$bkirim);
					}
				}
			}}
			$data['ok'] = true;$data['msg'] = lang('update_ok');
			#$data['ok'] = false;$data['msg'] = lang('update_er');
		}
        $data['perusahaan_layanan'] = $this->bm->list_layanan_perusahaan(); #print_r($data['perusahaan_layanan']);
		$data['detail_biaya'] = $this->bm->detail_biaya($id); #print_r($data['detail_biaya']); break;
		$this->template->set_view ('bkirim_edit',$data,config_item('modulename'));
	}
	function delete($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->bm->delete_biaya_by_kota($id)){
			#java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}
	function input()
	{
		if($this->input->post('_INPUT')){
			#$id = $this->input->post('id');
			#$kota = $this->input->post('kota');
            #$biaya = $this->input->post('hid_biaya');
            #$lama = $this->input->post('hid_lama');
            #if($this->bm->cek_biaya_from_kota($kota)){
            #    $data['ok'] = false;$data['msg'] = lang('biaya_has_add');
            #}else{
			#if($this->bm->input_biaya($id,$kota,$biaya,$lama)){
			#	$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			#}else{
			#	$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
			#}}
			$biaya_kirim = $this->input->post('hid_biaya');
			$id_kota = $this->input->post('kota');
			$id_layanan = $this->input->post('id_layanan');
			
			if($biaya_kirim){foreach($biaya_kirim as $urut=>$bkirim){
				// cek jika biaya kirimnya ada, boleh di input jika tidak , abaikan
				if(!empty($bkirim)){
					$this->bm->input_biaya($id_kota,$id_layanan[$urut],$bkirim);
				}
			}}
			$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
		}
        $data['propinsi'] = $this->bm->option_prop();
		$data['input'] = true;
		$data['perusahaan_layanan'] = $this->bm->list_layanan_perusahaan(); #print_r($data['perusahaan_layanan']);
		$this->template->set_view ('bkirim_edit',$data,config_item('modulename'));
	}


	// ---------------------------- BIAYA PROVINSI ---------------------
	function listprov()
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->bm->list_prov(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_prov'] = $this->bm->list_prov($limitstart,$pg['limit']);
		$this->template->set_view ('bkirim_prov',$data,config_item('modulename'));
	}
	function editprov($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
            $prov = $this->input->post('prov');
			if($this->bm->update_prov($id,$prov)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
		$data['detail_prov'] = $this->bm->detail_prov($id);
		$this->template->set_view ('bkirim_prov_edit',$data,config_item('modulename'));
	}
	function deleteprov($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if(!$this->bm->cek_kota_by_prov($id)){
		if($this->bm->delete_prov($id)){
			#java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		}else java_alert(lang('kota_still_alive'));
		redirect_java(config_item('modulename').'/'.$this->router->class.'/listprov');
	}
	function inputprov()
	{
		if($this->input->post('_INPUT')){
            $prov = $this->input->post('prov');
			if($this->bm->input_prov($prov)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/listprov'));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/listprov'));
			}
		}
        $data['propinsi'] = $this->bm->option_prop();
		$data['input'] = true;
		$this->template->set_view ('bkirim_prov_edit',$data,config_item('modulename'));
	}


	// ---------------------------- BIAYA KOTA ---------------------
	function listkota()
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->bm->list_kota(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_kota'] = $this->bm->list_kota($limitstart,$pg['limit']);
		$this->template->set_view ('bkirim_kota',$data,config_item('modulename'));
	}
	function editkota($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if($this->input->post('_EDIT')){
			$id = $this->input->post('id');
			$kota = $this->input->post('kota');
            $prov = $this->input->post('prov');
			if($this->bm->update_kota($id,$kota,$prov)){
				$data['ok'] = true;$data['msg'] = lang('update_ok');
			}else{
				$data['ok'] = false;$data['msg'] = lang('update_er');
			}
		}
        $data['propinsi'] = $this->bm->option_prop();
		$data['detail_kota'] = $this->bm->detail_kota($id);
		$this->template->set_view ('bkirim_kota_edit',$data,config_item('modulename'));
	}
	function deletekota($id=false)
	{
		if(!$id) redirect(config_item('modulename'));
		if(!$this->bm->cek_biaya_from_kota($id)){
		if(!$this->bm->cek_cust_by_kota($id)){
		if($this->bm->delete_kota($id)){
			#java_alert(lang('del_ok'));
		}else java_alert(lang('del_er'));
		}else java_alert(lang('cust_still_alive'));
		}else java_alert(lang('biaya_still_alive'));
		redirect_java(config_item('modulename').'/'.$this->router->class.'/listkota');
	}
	function inputkota()
	{
		if($this->input->post('_INPUT')){
			$id = $this->input->post('id');
			$kota = $this->input->post('kota');
            $prov = $this->input->post('prov');
			if($this->bm->input_kota($id,$kota,$prov)){
				$data['ok'] = true;$data['msg'] = lang('input_ok').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/listkota'));
			}else{
				$data['ok'] = false;$data['msg'] = lang('input_er').meta_refresh(site_url(config_item('modulename').'/'.$this->router->class.'/listkota'));
			}
		}
        $data['propinsi'] = $this->bm->option_prop();
		$data['input'] = true;
		$this->template->set_view ('bkirim_kota_edit',$data,config_item('modulename'));
	}

	function optionkota(){
		$this->template->clear_layout();
		$kat = $this->input->post('prov'); if(!$kat) exit();
		$listsub = $this->bm->option_kota($kat,false);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}
	function optionkotanobiaya(){
		$this->template->clear_layout();
		$kat = $this->input->post('prov'); if(!$kat) exit();
		$listsub = $this->bm->option_kota_no_biaya($kat,false);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}

	function pengiriman()
	{
		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->bm->list_layanan_perusahaan(false,false,true);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($pg['curpage'],$pg['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $pg['limit'];
		$data['startnumber']= $limitstart;

		$data['list_layanan'] = $this->bm->list_layanan_perusahaan($limitstart,$pg['limit']);
		$this->template->set_view ('bkirim_layanan',$data,config_item('modulename'));
	}
	function addlayanan()
	{ 
		if($this->input->post('_INPUT')){
			$id_perusahaan=$this->bm->input_perusahaan($this->input->post('nama_perusahaan'));
			$layanan=$this->input->post('layanan');
			if($layanan){foreach($layanan as $ly){
				if(!empty($ly))$this->bm->input_layanan($id_perusahaan,$ly);
			}}
			java_alert(lang('input_layanan_ok'));
			redirect_java(config_item('modulename').'/'.$this->router->class.'/pengiriman');		
		}
		$data['input'] = true;
		$this->template->set_view ('bkirim_layanan_add',$data,config_item('modulename'));
	}
	function editlayanan($id=false)
	{ 
		if(!$id)redirect(config_item('modulename').'/'.$this->router->class.'/pengiriman');
		if($this->input->post('_EDIT')){ #print_r($_POST);
			$id_perusahaan=$this->input->post('id_perusahaan');
			$nama_perusahaan=$this->input->post('nama_perusahaan');
			$layanan=$this->input->post('layanan');
			$id_layanan=$this->input->post('id_layanan');
			// update perusahaan
			$this->bm->update_perusahaan($id_perusahaan,$nama_perusahaan); #echo $this->bm->db->last_query(); print_r($layanan);print_r($id_layanan); #break;
			// update layanan
			if($layanan){foreach($layanan as $urut=>$ly){
				if(empty($ly)){ #echo'empty-';
					if(isset($id_layanan[$urut]))$this->bm->delete_biaya_by_layanan($id_layanan[$urut]);
				}else{ #echo 'ada--';
					if(isset($id_layanan[$urut]))$this->bm->update_layanan($id_layanan[$urut],$ly);
					else $this->bm->input_layanan($id_perusahaan,$ly); #echo $this->bm->db->last_query();
				}
			}} #break;
			java_alert(lang('update_layanan_ok'));
			redirect_java(config_item('modulename').'/'.$this->router->class.'/pengiriman');		
		}
		$data['data_layanan'] = $this->bm->detail_perusahaan_layanan($id); #print_r($data['data_layanan']);
		$this->template->set_view ('bkirim_layanan_add',$data,config_item('modulename'));
	}
	function deletelayanan($id){
		if(!$id) redirect(config_item('modulename').'/'.$this->router->class.'/pengiriman');
		// delete perusahaan artinya mendelete sekaligus dengan data biaya perkota nya
		$this->bm->delete_biaya_by_perusahaan($id);

		#java_alert(lang('delete_layanan_ok'));
		#redirect_java(config_item('modulename').'/'.$this->router->class.'/pengiriman');
	}
}
