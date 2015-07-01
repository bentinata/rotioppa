<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Promo extends Admin_Controller{
	function __construct(){
		parent::__construct();
		// load model
		$this->load->model('promo_model', 'pm');
		// load def lang
		
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
		// $paging['total'] 	= $this->pm->list_promo(false,false,true);
		// $obj				= CreatePageNav($paging);W
		// $limitstart 		= GetLimitStart($paging['curpage'],$paging['limit']); #echo $limitstart;break;
		$data['paging'] 	= "";
		$data['thislink'] 	= false;#config_item('modulename').'/'.$this->router->class.'/'.$this->router->method;
		$data['limit'] 		= "";
		$data['startnumber']= "";
		$data['list_promo']= $this->pm->list_promo(false,false,false);
        
		if($ajaxmode && $ajaxmode!='false'){
			$this->template->clear_layout();
			if($ajaxmode=='1'){
				$this->load->view('promo_list3', $data, false);
				/*$this->load->module_view(config_item('modulename'), 'promo_list3', $data);*/
			}
		}else{
			$this->template
				->set_metadata('stylesheet',module_css('promo_list.css',false),'link')
				->set_view ('promo_list',$data,config_item('modulename'));
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
    		
    		$dir_img='./uploads/promo/';

			
			
			// --------- LOOPING $_FILES dari group img BARU
			
				
				if(isset($_FILES["user_file"])){
						// jika filenya ada, lakukan upload
						if(!empty($_FILES['user_file']['name'])) 
						{
							// set upload dir
							$dir = $dir_img;
							if(check_dir($dir))
							{
								$exptest=explode("/",$_FILES['user_file']['name']);
								$test=$exptest[count($exptest)-1];
								$test_ext=strtolower(substr($test,strlen($test)-3,3));
								$config['upload_path'] = $dir;
								$config['file_name']	= $id.".".$test_ext;
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
								$data['ok']=false;$data['msg'] = "Folder tidak ada";
								$next2=false;
								break;
							} // check_dir 
						} // if !empty(file)
					} // foreach dataurut
					
			// langjutkan dengan update gambar baru ke tabel, (jika ada)

                // input to table promo
				$promo = $this->input->post('promo');
				$desc = $this->input->post('desc');
				$image = $res['file_name'];
			    $this->pm->update_promo($id,$promo,$desc,$image);
				

				// all done and show message
				$data['ok']=true;
				$data['msg'] = "data terinput";#.meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));

			// upload preference
		} // if _EDIT

		$data['id'] = $id;
		$data['promo'] = $this->pm->detail_promo($id); 

		if(!$data['promo'])
		{
			java_alert('No data available.');
			redirect_java(config_item('modulename').'/'.$this->router->class);
			die();
		}

        $data['edit'] = true;
		$this->template->set_metadata('stylesheet',module_css('promo_edit.css',false),'link')
			->set_view ('promo_edit',$data,config_item('modulename'));
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
    		$dir_img="./uploads/promo/";

			
			
			// --------- LOOPING $_FILES dari group img BARU
			
				if(isset($_FILES["user_file"])){
						// jika filenya ada, lakukan upload
						if(!empty($_FILES['user_file']['name'])) 
						{
							// set upload dir
							$dir = $dir_img;
							if(check_dir($dir))
							{
								$exptest=explode("/",$_FILES['user_file']['name']);
								$test=$exptest[count($exptest)-1];
								$test_ext=strtolower(substr($test,strlen($test)-3,3));
								$config['upload_path'] = $dir;
								$config['file_name']	= $id.".".$test_ext;
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

                // input to table promo
				$promo = $this->input->post('promo');
				$desc = $this->input->post('desc');
				$image = $res['file_name'];
			    $this->pm->input_promo($id,$promo,$desc,$image);
				

				// all done and show message
				$id++;
				$data['ok']=true;
				$data['msg'] = "data terinput";#.meta_refresh(site_url(config_item('modulename').'/'.$this->router->class));

		}
		$data['id'] =$id ;
		$this->template
        ->set_metadata('stylesheet',module_css('promo_edit.css',false),'link')
        ->set_view ('promo_edit',$data,config_item('modulename'));
	}
	function delete($id){
		if(!$id) redirect(config_item('modulename').'/'.$this->router->class);
		// cek tabel2 yg penting bgt
		// cek order, cart, wishlist, kalau iklan affiliate itu relasi ke order
		$next=true;
		if($this->pm->cek_order_by_promo($id)){
			
					// dell table promo
					$this->pm->dell_promo($id);
					// dell file gambar
					$dir=config_item('upload_img_promo').$id;
					remove_dir($dir);
		}else $next=false;
		if($next){
			java_alert(lang('del_ok'));
		}else
			java_alert(lang('not_found'));
		redirect_java(config_item('modulename').'/'.$this->router->class);
	}


}
