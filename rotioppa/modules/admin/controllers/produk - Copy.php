<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Produk extends Admin_Controller{
	function __construct(){
		parent::__construct();
		// load model
		$this->load->model('produk_model', 'pm');
		// load def lang
		$this->lang->load('defproduk');
		
	}
	function index($ajaxmode=false,$vcode=false)
	{
		// for search
		$key=false;$filter=false;$data['forajax']='';
		if($this->input->post('filter')){
			$filter=$this->input->post('filter');
			$data['forajax']='&filter='.$filter;
			if($filter=='5'){
				$key['tgl1']=$this->input->post('tgl1');
				$key['tgl2']=$this->input->post('tgl2');
				$key['order']=$this->input->post('ord');
				$data['forajax'].='&tgl1='.$key['tgl1'].'&tgl2='.$key['tgl2'].'&ord='.$key['order'];
			}else{
				$key=$this->input->post('search');
				$data['forajax'].='&search='.$key;
			}
		}
        $filter2=false;
        if($vcode){
            $filter2=$vcode;
            $data['vcode_detail'] = $this->pm->detail_vcode($vcode);
        }

		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $this->input->post('start')?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->pm->list_produk(false,false,true,$key,$filter,$filter2);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;
		$data['list_produk']= $this->pm->list_produk($limitstart,$paging['limit'],false,$key,$filter,$filter2);
        $data['kat'] = $this->pm->option_kat();
        $data['vendor'] = $this->pm->option_vendor();

		if($ajaxmode && $ajaxmode!='false'){
			$this->template->clear_layout();
			if($ajaxmode=='1'){
				if($filter=='5')
					$msg = sprintf(lang('search_tgl'),format_date_ina($key['tgl1'],'-',' '),format_date_ina($key['tgl2'],'-',' '),$paging['total']);
                elseif($filter=='3')
                    $msg = lang('search_kat').' '.$paging['total'];
                elseif($filter=='7')
                    $msg = lang('search_vendor').' '.$paging['total'];
                else
					$msg = sprintf(lang('search_result'),$key,$paging['total']);
				if($data['list_produk']=='err_1'){
					$err=lang('invalid_code');
					$data['list_produk'] = false;
				}else $err='';
				$respon['err'] = $err;
				$respon['msg'] = $msg.' [ '.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method,lang('back')).' ]';
				$respon['view'] = $this->load->view('produk_list2', $data, true);
				echo json_encode($respon);
			}else{
				$this->load->view('produk_list3', $data, false);
				/*$this->load->module_view(config_item('modulename'), 'produk_list3', $data);*/
			}
		}else{
			$this->template
				->set_metadata('stylesheet',module_css('produk_list.css',false),'link')
				->set_view ('produk_list',$data,config_item('modulename'));
		}
	}
    function listvendor($ajaxmode=false){
		// for search
		$key=false;$filter=false;$data['for_paging']='';
		if($this->input->post('filter')){
			$filter=$this->input->post('filter');
			if($filter=='5'){ // tuk sementara option 5 ini tdk digunakan
				$key['tgl1']=$this->input->post('tgl1');
				$key['tgl2']=$this->input->post('tgl2');
			}else
				$key=$this->input->post('search');
			$data['for_paging']="filter=$filter&search=$key&";
		}

		// paging
		$this->load->helper('pagenav');
		$pg 				= GetPageNLimitVar(false,20);
		$paging['curpage'] 	= $this->input->post('start')?$this->input->post('start'):$pg['curpage'];
		$paging['limit'] 	= $pg['limit'];
		$paging['total'] 	= $this->pm->list_produk_vendor(false,false,true,$key,$filter);
		$obj				= CreatePageNav($paging);
		$limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= $obj;
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= $paging['limit'];
		$data['startnumber']= $limitstart;
		$data['list_produk']= $this->pm->list_produk_vendor($limitstart,$paging['limit'],false,$key,$filter);
        $data['vendor'] = $this->pm->option_vendor();

		if($ajaxmode){
			$this->template->clear_layout();
			if($ajaxmode=='1'){
				if($filter=='5')
					$msg = sprintf(lang('search_tgl'),format_date_ina($key['tgl1'],'-',' '),format_date_ina($key['tgl2'],'-',' '),$paging['total']);
                elseif($filter=='3')
                    $msg = lang('search_kat').' '.$paging['total'];
                elseif($filter=='7')
                    $msg = lang('search_vendor').' '.$paging['total'];
                else
					$msg = sprintf(lang('search_result'),$key,$paging['total']);
				if($data['list_produk']=='err_1'){
					$err=lang('invalid_code');
					$data['list_produk'] = false;
				}else $err='';
				$respon['err'] = $err;
				$respon['msg'] = $msg.' [ '.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method,lang('back')).' ]';
				$respon['view'] = $this->load->module_view(config_item('modulename'), 'produk_list2_vendor', $data, true);
				echo json_encode($respon);
			}else{
				$this->load->module_view(config_item('modulename'), 'produk_list3_vendor', $data);
			}
		}else
			$this->template->set_view ('produk_list_vendor',$data,config_item('modulename'));
    }
    
	function edit($id=false){
		if(!$id) redirect(config_item('modulename').'/'.$this->router->class);

		if($this->input->post('_EDIT'))
		{ 
			// upload preference
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);
			// dir img for upload
    		$id=$this->input->post('id');
    		$dir_img=config_item('upload_img_produk').$id.'/';

            // kumpulkan semua file gambar lama
            if(($big=$this->input->post('oldbig'))) $old['big']=$big;
            if(($thumb=$this->input->post('oldthumb'))) $old['thumb']=$thumb;
            if(($intro=$this->input->post('oldintro'))) $old['intro']=$intro; #print_r($old); #break;

			// kumpulkan semua file gambar yg akan di hapus
            if(($del_big=$this->input->post('delimg_big'))) $del['big']=$del_big;
            if(($del_thumb=$this->input->post('delimg_thumb'))) $del['thumb']=$del_thumb;
            if(($del_intro=$this->input->post('delimg_intro'))) $del['intro']=$del_intro; #print_r($del); #break;
            
            // id gambar
            $id_img = $this->input->post('id_img');
    
			// looping group gambar yg akan di delete, jdi proses yg lainnya yg ada di dalam group tidak perlu di jalankan
            if(($del_group=$this->input->post('dell_group_img')))
            {
				foreach($del_group as $id_group_img)
				{
					// pengahpusan pada tabel gambar, attriubut khusus, history_stock
					// lalu direktory gambar nya
					// *: dell attribut khsusu and history_stock
					$this->pm->dell_attr_his_gambar($id_group_img);
					// *: dell tb img
					$this->pm->dell_gambar($id_group_img);
					// dell the dir off image
					remove_dir($dir_img.$id_group_img);
					
					//--------- remove variable2 yg sdh tdk perlu lagi
					if(isset($old['big'][$id_group_img]))unset($old['big'][$id_group_img]);
					if(isset($old['thumb'][$id_group_img]))unset($old['thumb'][$id_group_img]);
					if(isset($old['intro'][$id_group_img]))unset($old['intro'][$id_group_img]);

					if(isset($del['big'][$id_group_img]))unset($del['big'][$id_group_img]);
					if(isset($del['thumb'][$id_group_img]))unset($del['thumb'][$id_group_img]);
					if(isset($del['intro'][$id_group_img]))unset($del['intro'][$id_group_img]);

					if(isset($_FILES['big']['name'][$id_group_img]))unset($_FILES['big']['name'][$id_group_img]);
					if(isset($_FILES['thumb']['name'][$id_group_img]))unset($_FILES['thumb']['name'][$id_group_img]);
					if(isset($_FILES['intro']['name'][$id_group_img]))unset($_FILES['intro']['name'][$id_group_img]);
					
					if(isset($id_img[$id_group_img]))unset($id_img[$id_group_img]);
				}
			}
            
            // looping ceklist image personal satu persatu dan delete
            #print_r($del);print_r($old);
            $is_update_del_img=false;
            if(isset($del)){foreach($del as $names_of_group=>$dataimg)
            {
				foreach($dataimg as $id_of_img=>$dataimg2)
				{
					// set location of img old
					$dir_old = $dir_img.$id_of_img.'/';
					
					foreach($dataimg2 as $id_array=>$the_img)
					{
						// jika di ceklis, maka langsung delete file nya dan unset file old nya
						// supaya nanti tdk dilakukan delete lagi ketika akan update (INGAT: bukan input) gambar yg baru
						if($names_of_group=='intro'){
							if(isset($old[$names_of_group][$id_of_img]))
							{ #echo 'dell img intro personal --'.$id_of_img.'<br>';
								remove_dir($dir_old.$old[$names_of_group][$id_of_img]);
								unset($old[$names_of_group][$id_of_img]);
								$is_update_del_img=true; // jika tdk ada file baru maka tabel akan tetap di update
							}
						}else{
							if(isset($old[$names_of_group][$id_of_img][$id_array]))
							{ #echo 'dell img '.$names_of_group.' personal --'.$id_of_img.'<br>';
								remove_dir($dir_old.$old[$names_of_group][$id_of_img][$id_array]);
								unset($old[$names_of_group][$id_of_img][$id_array]);
								$is_update_del_img=true; // jika tdk ada file baru maka tabel akan tetap di update
							}
						}// if $names_of_group
						// jika sudah tdk ada isi array nya, hapus sekalian dengan dir nya
						if(isset($old[$names_of_group][$id_of_img]))
							if(count($old[$names_of_group][$id_of_img])<1)
								unset($old[$names_of_group][$id_of_img]);
						// kumpulkan ig gambar mana saja yg di delete utk pengecekan ketika akan update ke table
						$id_img_del[$id_of_img]=$id_of_img;

					}// foreach $dataimg2
				}// foreach $dataimg
			}}// if isset($del) foreach $del

            #print_r($_FILES); echo '***********'; #break;
            $next=true;
            $updateimg=false;
            // --------- LOOPING $_FILES dari group img yg sudah ada
            foreach(array('big','thumb','intro') as $names){
				if(isset($_FILES[$names])){foreach($_FILES[$names]['name'] as $idgbr=>$dataurut)
				{#print_r($dataurut);echo '--------------';
					foreach($dataurut as $idurut=>$file)
					{
						// jika filenya ada, lakukan upload
						if(!empty($file)) 
						{
							// set upload dir
							$dir = $dir_img.$idgbr.'/';
							if(check_dir($dir))
							{
								$config['upload_path'] = $dir;
								$this->upload->initialize($config);
							
								// first remove old file with this img
								// khusus utk file2 gambar yg sdh ada
								if($names=='intro')
									if(isset($old[$names][$idgbr]))remove_dir($dir.$old[$names][$idgbr]);
								elseif($names=='big' || $names=='thumb')
									if(isset($old[$names][$idgbr][$idurut]))remove_dir($dir.$old[$names][$idgbr][$idurut]);
								
								// upload new img
								if($this->upload->do_upload($names,$idgbr,$idurut))
								{ #echo 'upload new image --'.$idgbr.'<br>';
									// ambil nama baru dan masukan ke kumpulan data old, karena akan di write lg ke db
									$res=$this->upload->data();
									if($names=='intro')
										$old[$names][$idgbr] = $res['file_name'];
									elseif($names=='big' || $names=='thumb')
										$old[$names][$idgbr][$idurut] = $res['file_name'];

									// set update img to true 
									$updateimg=true;
									// kumpulkan id img yg baru saja
									$update_to_db[$idgbr]=$idgbr;
								}else{
									remove_dir($dir_img); // remove dir master from idproduk
									$data['ok']=false;$data['msg'] = $this->upload->display_errors();
									$next=false;
								}
							}else{
								$data['ok']=false;$data['msg'] = lang('dir_not_exists');
								$next=false;
								break;
							} // check_dir 
						} // if !empty(file)
					} // foreach dataurut
					if(!$next)break;
				}} // if isset($_FILES[$names]) foreach $_FILES[$names][name]
			} //foreach array(big,thumb,intro)
           
            // ada/tdk img tetap di teruskan, kecuali jika gagal upload img
            if($next)
            {
				// jika ada gbr baru yg di upload kumpulkan berdasarkan idgbr
				$img=false;
				if($updateimg)
				{
					foreach($update_to_db as $idgbr)
					{
						foreach($old as $names_of_field=>$data_img)
						{
							// format gambar di db (langsung pakai serialize)
							// array (
							//   img[big][1] = img1
							// 			 [2] = img2
							// 			 [..] = ...
							//   img[thumb][1] = img1
							// 			   [2] = img2
							// 			   [..] = ...
							//   img[intro] = img1
							// )
							if(isset($data_img[$idgbr]))
							$img[$idgbr][$names_of_field]=$data_img[$idgbr];
						} // foreach $old
					} //foreach $update
 				}elseif($is_update_del_img){ 
					foreach($old as $names_of_field=>$data_img)
					{
						foreach($data_img as $idgb=>$dimg){
							$img[$idgb][$names_of_field]=$dimg;
						}
						// unset id_img_del, jadi sisanya harus di input pula ke var img
						unset($id_img_del[$idgb]);
					}
					// looping sisanya jika ada
					if(isset($id_img_del) && is_array($id_img_del))
					{
						foreach($id_img_del as $id_img_update)
						{
							$img[$id_img_update] = '';
						}
					}
				}  #print_r($img);
 				
 				// update tabel gambar (ada atau tdk gbr yg baru tdk berpengaruh krn data lainnya perlu di update)
				$def_img = $this->input->post('def_img');
				$jenis_stock = $this->input->post('jenis_stock');
				$jenis_stock_old = $this->input->post('old_jenis_stock');

				// attr khusus dan stock
				$idattr = $this->input->post('idattr'); #print_r($idattr);echo '===idattr==';
				$idattr_umum = $this->input->post('idattr_umum'); #print_r($idattr_umum);echo '===idattr==';
				$stock = $this->input->post('stock'); #print_r($stock);echo '===stock==';
				$stock_umum = $this->input->post('stock_umum'); #print_r($stock_umum);echo '===stock==';
				$ukuran = $this->input->post('ukuran'); #print_r($ukuran);echo '===ukuran==';
				$ukuran_new = $this->input->post('ukuran_new'); #print_r($ukuran_new);echo '===ukuran_new==';
				$stock_new = $this->input->post('stock_new'); #print_r($stock_new);echo '===stock_new==';
				if($id_img){foreach($id_img as $idimg)
				{ #echo 'attribut, stock khusus --'.$idimg.'<br>';
					if(isset($img[$idimg]))
					{
						if(!empty($img[$idimg]))
							$gambar=serialize($img[$idimg]);
						else
							$gambar='';
					}else{
						$gambar=false;
					}
					$is_def_img = isset($def_img[$idimg])?1:2;
					$this->pm->update_gambar($idimg,$gambar,$is_def_img,$jenis_stock[$idimg]);
					//-------------
					// PERHATIAN :
					// disini ada attribut stock, yg secara langsung berhubungan dengan history stock
					// tetapi belum ada fungsi khusus nya yg memproses history_stock dalam proses input stock
					//--------------
					// cek jenis stock yg sebelumnya, sama/tdk dengan jenis stock skr?
					// jika beda, hapus tb_atribut_khusus dan tb_history_stock berdasarkan id gbr tsb
					if($jenis_stock_old[$idimg]!=$jenis_stock[$idimg])
						$this->pm->dell_attr_his_gambar($idimg);

					if($jenis_stock[$idimg]=='1')// ------------------- STOCK UMUM -----------
					{
						if(isset($idattr_umum[$idimg]))
						{
							// hati2, delete attribut khusus artinya menghapus history stock jg
							// jika stock nya 0 maka di update saja 0, jangan hi hapus karena akan berkaitan dengan wishlist, 
							// kecuali jika string kosong maka langsung di hapus
							if(empty($stock_umum[$idimg]) && $stock_umum[$idimg]!=='0')
							$this->pm->dell_attr_khusus($idattr_umum[$idimg]);
							
							else
							$this->pm->update_attr_khusus($idattr_umum[$idimg],$stock_umum[$idimg]);
							// *kedua: hapus stock yg sudah di ekseskusi
							unset($stock_umum[$idimg]);
						}
						// *ketiga: jika masih ada stock, lakukan input
						if(isset($stock_umum[$idimg]))
						{
							if(!empty($stock_umum[$idimg]) || $stock_umum[$idimg]==0){
								$this->pm->input_attr_khusus($idimg,$stock_umum[$idimg]);
							}
						}
					}else{ // ------------- ATRIBUT dan STOCK KHUSUS
						// update attribut khusus atau insert new atribut khusus
						// *pertama: jika ada idattrnya lakukan update atau delete
						if(isset($idattr[$idimg])){foreach($idattr[$idimg] as $id_urut_attr=>$id_attr)
						{
							// hati2, delete attribut khusus artinya menghapus history stock jg
							if((empty($stock[$idimg][$id_urut_attr]) && $stock[$idimg][$id_urut_attr]!=='0') 
								|| empty($ukuran[$idimg][$id_urut_attr]))
							$this->pm->dell_attr_khusus($id_attr);
							else
							
							$this->pm->update_attr_khusus($id_attr,$stock[$idimg][$id_urut_attr],$ukuran[$idimg][$id_urut_attr]);
							// *kedua: hapus stock yg sudah di ekseskusi
							unset($stock[$idimg][$id_urut_attr]);
						}}
						// *ketiga: jika masih ada stock, lakukan looping dan input
						if(isset($stock[$idimg])){foreach($stock[$idimg] as $id_urut=>$vstock)
						{
							if( (!empty($vstock) && !empty($ukuran[$idimg][$id_urut])) || 
								($vstock=='0' && !empty($ukuran[$idimg][$id_urut]))
							){
								$this->pm->input_attr_khusus($idimg,$vstock,$ukuran[$idimg][$id_urut]);
							}
						}}
						// *keempat: looping stock new jika ada
						if(isset($stock_new[$idimg])){foreach($stock_new[$idimg] as $id_urut_new=>$val_stock)
						{
							if(	(!empty($val_stock) && !empty($ukuran_new[$idimg][$id_urut_new])) ||
								($val_stock=='0' && !empty($ukuran_new[$idimg][$id_urut_new]))
							)
							$this->pm->input_attr_khusus($idimg,$val_stock,$ukuran_new[$idimg][$id_urut_new]);
						}}
					} // if jenis stock
				}}// if id_img and foreach id_img

                // update to table produk
				$idsub = $this->input->post('subkat');
				$idsub2 = $this->input->post('subkat2');
				$katalog = $this->input->post('katalog');
				$nama = $this->input->post('produk');
				$tag = $this->input->post('tag');
				$summary = $this->input->post('summary');
				$desc = $this->input->post('desc');
                $aff = $this->input->post('for_aff');
                $kom = $aff==1?$this->input->post('hid_aff_kom'):0;
                $berat = clear_currency($this->input->post('berat'));
                $idvcode = $this->input->post('vcode');
                $mkey = $this->input->post('meta_key');
                $mdesc = $this->input->post('meta_desc');
                $hv = $this->input->post('hid_harga_vendor');
                $ha = $this->input->post('hid_harga_awal');
                $hb = $this->input->post('hid_harga_baru');
                $had = $this->input->post('hid_harga_awal_diskon');
                $hbd = $this->input->post('hid_harga_baru_diskon');
                $ket_diskon = $this->input->post('ket_diskon');
                $this->pm->update_produk($id,$idsub,$idsub2,$katalog,$idvcode,$nama,$tag,$summary,$desc,$hv,$ha,$hb,$had,$hbd,$ket_diskon,$aff,$kom,$berat,$mkey,$mdesc);

				// insert or update tabel atribut
                $attr=$this->input->post('attr');
				$isi_attr = $this->input->post('isi_attr');
				$new_attr = $this->input->post('new_attr');
				$new_isi_attr = $this->input->post('new_isi_attr');
				if($attr){foreach($attr as $idattr=>$vattr)
				{
					if(empty($vattr) || empty($isi_attr[$idattr]))
					$this->pm->dell_attr($idattr);
					else
					$this->pm->update_attr($idattr,$vattr,$isi_attr[$idattr]);
				}}
				if($new_attr){foreach($new_attr as $nidattr=>$nvattr)
				{
					if(!empty($nvattr) && !empty($new_isi_attr[$nidattr]))
					$this->pm->input_attr($id,$nvattr,$new_isi_attr[$nidattr]);
				}}

				// insert or update tabel related_diskon
				$reldisk = $this->input->post('nama_produk_tampil');
				$new_reldisk = $this->input->post('new_nama_produk_tampil');
				if($reldisk){foreach($reldisk as $idrel=>$idp_lain)
				{
					if($idp_lain=='-' or empty($idp_lain))
					$this->pm->dell_rel_diskon($idrel);
					else
					$this->pm->update_rel_diskon($idrel,$id,$idp_lain);
				}}
				if($new_reldisk){foreach($new_reldisk as $nidrel=>$nidp_lain)
				{
					if($nidp_lain!='-' and !empty($nidp_lain))
					$this->pm->input_rel_diskon($id,$nidp_lain);
				}}

				// ------- Proses input group gambar baru ------
				$new_stock = $this->input->post('new_stock'); #print_r($stock);echo '===stock==';
				$new_stock2 = $this->input->post('new_stock2'); #print_r($stock_umum);echo '===stock==';
				$new_ukuran2 = $this->input->post('new_ukuran2'); #print_r($ukuran_new);echo '===ukuran_new==';
				$new_gbr = $this->input->post('new_gbr');
				$new_def_img = $this->input->post('new_def_img');
				$new_jenis_stock = $this->input->post('new_jenis_stock');
				if($new_gbr){foreach($new_gbr as $id_urut_newimg)
				{ #echo 'attribut, stock khusus, new --'.$id_urut_newimg.'<br>';
					$is_def_img_new = isset($new_def_img[$id_urut_newimg])?1:2;
					$id_img_new = $this->pm->input_gambar($id,$is_def_img_new,$new_jenis_stock[$id_urut_newimg]);
					$array_id_img[$id_urut_newimg] = $id_img_new; // tuk looping id img gambar baru
					//--- PERHATIAN :
					// disini ada attribut stock, yg secara langsung berhubungan dengan history stock
					// tetapi belum ada fungsi khusus nya yg memproses history_stock dalam proses input stock
					//--------------
					if($new_jenis_stock[$id_urut_newimg]=='1') // jenis stock umum
					{
						// looping stock umum baru 
						if(isset($new_stock[$id_urut_newimg])){foreach($new_stock[$id_urut_newimg] as $id_urut=>$vstock)
						{
							if(!empty($vstock)){
								$this->pm->input_attr_khusus($id_img_new,$vstock);
							}
						}}
					}else{
						// looping attribut dan stock khusus baru
						if(isset($new_stock2[$id_urut_newimg])){foreach($new_stock2[$id_urut_newimg] as $id_urut2=>$vstock2)
						{
							if(!empty($vstock2) && !empty($new_ukuran2[$id_urut_newimg][$id_urut2]))
							$this->pm->input_attr_khusus($id_img_new,$vstock2,$new_ukuran2[$id_urut_newimg][$id_urut2]);
						}}
					}
				}}// if(new_gbr) foreach new_gbr

				// --------- LOOPING $_FILES dari group img BARU
				$next2=true;
				foreach(array('new_big','new_thumb','new_intro') as $names){
					if(isset($_FILES[$names])){foreach($_FILES[$names]['name'] as $idgbr_urut=>$dataurut)
					{#print_r($dataurut);echo '--------------';
						$idgbr = $array_id_img[$idgbr_urut];
						foreach($dataurut as $idurut=>$file)
						{
							// jika filenya ada, lakukan upload
							if(!empty($file)) 
							{
								// set upload dir
								$dir = $dir_img.$idgbr.'/';
								if(check_dir($dir))
								{
									$config['upload_path'] = $dir;
									$this->upload->initialize($config);
									
									// upload new img
									if($this->upload->do_upload($names,$idgbr_urut,$idurut))
									{ #echo 'upload new image --'.$idgbr.'<br>';
										// format gambar di db (langsung pakai serialize)
										// array (
										//   img[big][1] = img1
										// 			 [2] = img2
										// 			 [..] = ...
										//   img[thumb][1] = img1
										// 			   [2] = img2
										// 			   [..] = ...
										//   img[intro] = img1
										// )
										$res=$this->upload->data();
										if($names=='new_intro')
											$new[$idgbr]['intro'] = $res['file_name'];
										elseif($names=='new_big')
											$new[$idgbr]['big'][$idurut] = $res['file_name'];
										elseif($names=='new_thumb')
											$new[$idgbr]['thumb'][$idurut] = $res['file_name'];
									}else{
										remove_dir($dir); // remove dir just idimg
										$data['ok']=false;$data['msg'] = $this->upload->display_errors();
										$next2=false;
									}
								}else{
									$data['ok']=false;$data['msg'] = lang('dir_not_exists');
									$next2=false;
									break;
								} // check_dir 
							} // if !empty(file)
						} // foreach dataurut
						if(!$next2)break;
					}} // if isset($_FILES[$names]) foreach $_FILES
				} //foreach array(big,thumb,intro) 
				
				// langjutkan dengan update gambar baru ke tabel, (jika ada)
				if($next2 && isset($new))
				{
					foreach($new as $id_gbr_to_input=>$img_to_input)
					{
						$this->pm->just_update_gambar($id_gbr_to_input,serialize($img_to_input));
					}
				}
				
				// all done and show message
				$data['ok']=true;$data['msg'] = lang('input_ok');#.meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));
            } // if next
	    } // if _EDIT

		$data['id'] = $id;
		$data['produk'] = $this->pm->detail_produk($id); 
		if(!$data['produk'])
		{
			java_alert('No data available.');
			redirect_java(config_item('modulename').'/'.$this->router->class);
			die();
		}
		$data['vendor'] = $this->pm->option_vendor();
		$data['kategori'] = $this->pm->option_kat();
		$data['katalog'] = $this->pm->option_katalog();
        $data['edit'] = true;
		$this->template->set_metadata('stylesheet',module_css('produk_edit.css',false),'link')
			->set_view ('produk_edit',$data,config_item('modulename'));
	}
	function input(){
		if($this->input->post('_INPUT'))
		{ #print_r($_FILES); break;
			$id = $this->input->post('id');
			
			// upload preference
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);
			// dir img for upload
    		$id=$this->input->post('id');
    		$dir_img=config_item('upload_img_produk').$id.'/';

			// ------- Proses input group gambar baru ------
			$new_stock = $this->input->post('new_stock'); #print_r($stock);echo '===stock==';
			$new_stock2 = $this->input->post('new_stock2'); #print_r($stock_umum);echo '===stock==';
			$new_ukuran2 = $this->input->post('new_ukuran2'); #print_r($ukuran_new);echo '===ukuran_new==';
			$new_gbr = $this->input->post('new_gbr');
			$new_def_img = $this->input->post('new_def_img');
			$new_jenis_stock = $this->input->post('new_jenis_stock');
			
			if($new_gbr){foreach($new_gbr as $id_urut_newimg)
			{ #echo 'attribut, stock khusus, new --'.$id_urut_newimg.'<br>';
				$is_def_img_new = isset($new_def_img[$id_urut_newimg])?1:2;
				$id_img_new = $this->pm->input_gambar($id,$is_def_img_new,$new_jenis_stock[$id_urut_newimg]);
				$array_id_img[$id_urut_newimg] = $id_img_new; // tuk looping id img gambar baru
				//--- PERHATIAN :
				// disini ada attribut stock, yg secara langsung berhubungan dengan history stock
				// tetapi belum ada fungsi khusus nya yg memproses history_stock dalam proses input stock
				//--------------
				if($new_jenis_stock[$id_urut_newimg]=='1') // jenis stock umum
				{
					// looping stock umum baru 
					if(isset($new_stock[$id_urut_newimg])){foreach($new_stock[$id_urut_newimg] as $id_urut=>$vstock)
					{
						if(!empty($vstock)){
							$this->pm->input_attr_khusus($id_img_new,$vstock);
						}
					}}
				}else{
					// looping attribut dan stock khusus baru
					if(isset($new_stock2[$id_urut_newimg])){foreach($new_stock2[$id_urut_newimg] as $id_urut2=>$vstock2)
					{
						if(!empty($vstock2) && !empty($new_ukuran2[$id_urut_newimg][$id_urut2]))
						$this->pm->input_attr_khusus($id_img_new,$vstock2,$new_ukuran2[$id_urut_newimg][$id_urut2]);
					}}
				}
			}}// if(new_gbr) foreach new_gbr

			// --------- LOOPING $_FILES dari group img BARU
			$next2=true;
			foreach(array('new_big','new_thumb','new_intro') as $names){
				if(isset($_FILES[$names])){foreach($_FILES[$names]['name'] as $idgbr_urut=>$dataurut)
				{#print_r($dataurut);echo '--------------';
					$idgbr = $array_id_img[$idgbr_urut];
					foreach($dataurut as $idurut=>$file)
					{
						// jika filenya ada, lakukan upload
						if(!empty($file)) 
						{
							// set upload dir
							$dir = $dir_img.$idgbr.'/';
							if(check_dir($dir))
							{
								$config['upload_path'] = $dir;
								$this->upload->initialize($config);
								
								// upload new img
								if($this->upload->do_upload($names,$idgbr_urut,$idurut))
								{ #echo 'upload new image --'.$idgbr.'<br>';
									// format gambar di db (langsung pakai serialize)
									// array (
									//   img[big][1] = img1
									// 			 [2] = img2
									// 			 [..] = ...
									//   img[thumb][1] = img1
									// 			   [2] = img2
									// 			   [..] = ...
									//   img[intro] = img1
									// )
									$res=$this->upload->data();
									if($names=='new_intro')
										$new[$idgbr]['intro'] = $res['file_name'];
									elseif($names=='new_big')
										$new[$idgbr]['big'][$idurut] = $res['file_name'];
									elseif($names=='new_thumb')
										$new[$idgbr]['thumb'][$idurut] = $res['file_name'];
								}else{
									remove_dir($dir); // remove dir just idimg
									$data['ok']=false;$data['msg'] = $this->upload->display_errors();
									$next2=false;
								}
							}else{
								$data['ok']=false;$data['msg'] = lang('dir_not_exists');
								$next2=false;
								break;
							} // check_dir 
						} // if !empty(file)
					} // foreach dataurut
					if(!$next2)break;
				}} // if isset($_FILES[$names]) foreach $_FILES
			} //foreach array(big,thumb,intro) 
				
			// langjutkan dengan update gambar baru ke tabel, (jika ada)
			if($next2) 
			{
				if(isset($new))
				{
					foreach($new as $id_gbr_to_input=>$img_to_input)
					{
						$this->pm->just_update_gambar($id_gbr_to_input,serialize($img_to_input));
					}
				}
				
                // input to table produk
				$idsub = $this->input->post('subkat');
				$idsub2 = $this->input->post('subkat2');
				$katalog = $this->input->post('katalog');
				$nama = $this->input->post('produk');
				$tag = $this->input->post('tag');
				$summary = $this->input->post('summary');
				$desc = $this->input->post('desc');
                $aff = $this->input->post('for_aff');
                $kom = $aff==1?$this->input->post('hid_aff_kom'):0;
                $berat = clear_currency($this->input->post('berat'));
                $idvcode = $this->input->post('vcode');
                $mkey = $this->input->post('met_key');
                $mdesc = $this->input->post('meta_desc');
                $hv = $this->input->post('hid_harga_vendor');
                $ha = $this->input->post('hid_harga_awal');
                $hb = $this->input->post('hid_harga_baru');
                $had = $this->input->post('hid_harga_awal_diskon');
                $hbd = $this->input->post('hid_harga_baru_diskon');
                $ket_diskon = $this->input->post('ket_diskon');
                $tgl = date('Y-m-d H:i:s');
                $this->pm->input_produk($id,$idsub,$idsub2,$katalog,$idvcode,$nama,$tgl,$tag,$summary,$desc,$hv,$ha,$hb,$had,$hbd,$ket_diskon,$aff,$kom,$berat,$mkey,$mdesc);

				// insert or update tabel atribut
				$new_attr = $this->input->post('new_attr');
				$new_isi_attr = $this->input->post('new_isi_attr');
				if($new_attr){foreach($new_attr as $nidattr=>$nvattr)
				{
					if(!empty($nvattr) && !empty($new_isi_attr[$nidattr]))
					$this->pm->input_attr($id,$nvattr,$new_isi_attr[$nidattr]);
				}}

				// insert or update tabel related_diskon
				$new_reldisk = $this->input->post('new_nama_produk_tampil');
				if($new_reldisk){foreach($new_reldisk as $nidrel=>$nidp_lain)
				{
					if($nidp_lain!='-')
					$this->pm->input_rel_diskon($id,$nidp_lain);
				}}

				// all done and show message
				$data['ok']=true;$data['msg'] = lang('input_ok');#.meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));

			} // if next2
		} // if INPUT

		$data['id'] = $this->pm->get_max_id();
		$data['kategori'] = $this->pm->option_kat();
        $data['vendor'] = $this->pm->option_vendor();
		$data['katalog'] = $this->pm->option_katalog();
		$this->template
        ->set_metadata('stylesheet',module_css('produk_edit.css',false),'link')
        ->set_view ('produk_edit',$data,config_item('modulename'));
	}
	function delete($id){
		if(!$id) redirect(config_item('modulename').'/'.$this->router->class);
		// cek tabel2 yg penting bgt
		// cek order, cart, wishlist, kalau iklan affiliate itu relasi ke order
		$next=true;
		if(!$this->pm->cek_order_by_produk($id)){
			if(!$this->pm->cek_cart_by_produk($id)){
				if(!$this->pm->cek_wishlist_by_produk($id)){
					// dell review
					$this->pm->dell_review_by_produk($id);
					// dell related diskon
					$this->pm->dell_rel_diskon_by_produk($id);
					// dell attribut
					$this->pm->dell_attr_by_produk($id);
					// dell table gambar
					$this->pm->dell_gambar_by_produk($id);
					// dell table produk
					$this->pm->dell_produk($id);
					// dell file gambar
					$dir=config_item('upload_img_produk').$id;
					remove_dir($dir);
		}else $next=false;}else $next=false;}else $next=false;
		if($next){
			java_alert(lang('del_ok'));
		}else
			java_alert(lang('produk_still_have_data'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}

	// ajax method
	function optionsubkat(){
		$this->template->clear_layout();
		$kat = $this->input->post('kat'); if(!$kat) exit();
		$listsub = $this->pm->option_subkat($kat);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}
	function optionsubkat2(){
		$this->template->clear_layout();
		$kat = $this->input->post('subkat'); if(!$kat) exit();
		$listsub = $this->pm->option_subkat2($kat);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}
	function optionproduk(){
		$this->template->clear_layout();
		$sub = $this->input->post('sub'); if(!$sub) exit();
		$listproduk = $this->pm->option_produk($sub);
		$res='';
		if($listproduk){
		foreach($listproduk as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
        }}else{
            $res = '<option values=""> '.lang('no_data').' </option>';
        }
		echo $res;
	}
	function optionattr(){
		$this->template->clear_layout();
		$attr = $this->input->post('p'); if(!$attr) exit();
		$listattr = $this->pm->option_attr($attr);
		$res='';
		if($listattr){
		foreach($listattr as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values="-"> '.lang('no_data').' </option>';
		echo $res;
	}
	function namaprodukdiskon(){
		$this->template->clear_layout();
		$kat = $this->input->post('kat'); if(!$kat) exit();
		$list = $this->pm->option_nama_produk_by_kat($kat);
		$res='';
		if($list){
		foreach($list as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}
	function optionvcode(){
		$this->template->clear_layout();
		$kat = $this->input->post('vendor'); if(!$kat) exit();
		$listsub = $this->pm->option_vcode($kat);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
            $vl[] = $v;
		}$vl = implode(',',$vl);

        }else{
            $res = '<option values=""> '.lang('no_data').' </option>';
            $vl='';
        }
        $jason['res'] = $res;
        $jason['val'] = $vl;
		echo json_encode($jason);
	}
	function optionoproduk(){
		$this->template->clear_layout();
		$kat = $this->input->post('vcode'); if(!$kat) exit();
		$listsub = $this->pm->option_vcode_produk($kat);
		$res='';
		if($listsub){
		foreach($listsub as $k=>$v){
			$res .= '<option value="'.$k.'">'.$v.'</option>';
		}}else $res = '<option values=""> '.lang('no_data').' </option>';
		echo $res;
	}

}
