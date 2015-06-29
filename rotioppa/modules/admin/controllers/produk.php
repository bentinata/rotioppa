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
	
// $filter2="";
		// paging
		// $this->load->helper('pagenav');
		// $pg 				= GetPageNLimitVar(false,20);
		// $paging['curpage'] 	= $this->input->post('start')?$this->input->post('start'):$pg['curpage'];
		// $paging['limit'] 	= $pg['limit'];
		// $paging['total'] 	= $this->pm->list_produk(false,false,true);
		// $obj				= CreatePageNav($paging);
		// $limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= "";
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= "";
		$data['startnumber']= "";
		$data['list_produk']= $this->pm->list_produk(false,false,false);
        
		if($ajaxmode && $ajaxmode!='false'){
			$this->template->clear_layout();
			if($ajaxmode=='1'){
				$this->load->view('produk_list3', $data, false);
				/*$this->load->module_view(config_item('modulename'), 'produk_list3', $data);*/
			}
		}else{
			$this->template
				->set_metadata('stylesheet',module_css('produk_list.css',false),'link')
				->set_view ('produk_list',$data,config_item('modulename'));
		}
	}
    
	function edit($id=false){
		if(!$id) redirect(config_item('modulename').'/'.$this->router->class);

		if($this->input->post('_EDIT'))
		{ 

			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);
			// dir img for upload
    		
    		$dir_img='./uploads/produk/'.$id.'/';

			
			
			// --------- LOOPING $_FILES dari group img BARU
			
				
				if(isset($_FILES["user_file"])){
						// jika filenya ada, lakukan upload
						if(!empty($_FILES['user_file']['name'])) 
						{
							// set upload dir
							$dir = $dir_img;
							if(check_dir($dir))
							{
								$config['upload_path'] = $dir;
								$this->upload->initialize($config);
								
								// upload new img
								if($this->upload->do_upload('user_file'))
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
									if(!file_exists($dir."thumbnail/")){
									mkdir($dir."thumbnail/");
									}
															$this->load->library('image_lib');
										$config['image_library'] = 'gd2';
						            $config['source_image'] = $dir.$res['file_name'];
						            $config['new_image'] = $dir."thumbnail/";
						            $config['maintain_ratio'] = TRUE;
						            $config['create_thumb'] = FALSE;
						            $config['overwrite'] = TRUE;
						            $config['width'] = 200;
						            $config['height'] = 124;

						            $this->image_lib->clear();
						            $this->image_lib->initialize($config);
						            $this->image_lib->resize();
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
					
			// langjutkan dengan update gambar baru ke tabel, (jika ada)

                // input to table produk
				$idkat = $this->input->post('kat');
				$nama = $this->input->post('produk');
				$desc = $this->input->post('desc');
				$image = $_FILES['user_file']['name'];
                $this->pm->update_produk($id,$idkat,$nama,$desc,$image);
				

				// all done and show message
				$data['ok']=true;
				$data['msg'] = lang('input_ok');#.meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));

			// upload preference
		} // if _EDIT

		$data['id'] = $id;
		$data['produk'] = $this->pm->detail_produk($id); 
		if(!$data['produk'])
		{
			java_alert('No data available.');
			redirect_java(config_item('modulename').'/'.$this->router->class);
			die();
		}

        $data['edit'] = true;
		$this->template->set_metadata('stylesheet',module_css('produk_edit.css',false),'link')
			->set_view ('produk_edit',$data,config_item('modulename'));
	}
	function input(){

			$id = $this->pm->get_max_id();
		if($this->input->post('_INPUT'))
		{ #print_r($_FILES); break;
			
			// upload preference
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$this->load->library('upload', $config);
			// dir img for upload
    		$id=$this->input->post('id');
    		$dir_img="./uploads/produk/".$id.'/';

			
			
			// --------- LOOPING $_FILES dari group img BARU
			
				if(isset($_FILES["user_file"])){
						// jika filenya ada, lakukan upload
						if(!empty($_FILES['user_file']['name'])) 
						{
							// set upload dir
							$dir = $dir_img;
							if(check_dir($dir))
							{
								$config['upload_path'] = $dir;
								$this->upload->initialize($config);
								
								// upload new img
								if($this->upload->do_upload('user_file'))
								{ #echo 'upload new image --'.$idgbr.'<br>';
							// break;
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
									if(!file_exists($dir."thumbnail/")){
									mkdir($dir."thumbnail/");
									}
													$this->load->library('image_lib');
										$config['image_library'] = 'gd2';
						            $config['source_image'] = $dir.$res['file_name'];
						            $config['new_image'] = $dir."thumbnail/";
						            $config['maintain_ratio'] = TRUE;
						            $config['create_thumb'] = FALSE;
						            $config['overwrite'] = TRUE;
						            $config['width'] = 200;
						            $config['height'] = 124;

						            $this->image_lib->clear();
						            $this->image_lib->initialize($config);
						            $this->image_lib->resize();
								}else{
									// break;
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
					
			// langjutkan dengan update gambar baru ke tabel, (jika ada)

                // input to table produk
				$idkat = $this->input->post('kat');
				$nama = $this->input->post('produk');
				$desc = $this->input->post('desc');
				$image = $_FILES['user_file']['name'];
                $this->pm->input_produk($id,$idkat,$nama,$desc,$image);
				

				// all done and show message
				$data['ok']=true;
				$data['msg'] = lang('input_ok');#.meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));

		}
		$data['id'] =$id ;
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
