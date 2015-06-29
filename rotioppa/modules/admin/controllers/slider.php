<? if (!defined('BASEPATH')) exit('No direct script access allowed');
class Slider extends Admin_Controller{
	function __construct()
	{
		parent::__construct(); 
		/* load lang */
		#$this->lang->load('poseidon',$this->globals->lang);

		$this->load->model('slider_model','am');
	}
	
	function index()
	{
		$config['max_width']  = '1280';
		$config['max_height']  = '500';
        $data['msg'] = $this->session->flashdata('msg');

	   if($this->input->post('tambah_img')){ 
            $config['upload_path'] = './'.config_item('dir_slider').'/';
    		$config['allowed_types'] = 'gif|jpg|png';
    
    		$this->load->library('upload', $config);
    
    		if ( ! $this->upload->do_upload2('galery'))
    		{
    			$data['msg'] = $this->upload->display_errors();
            }else{
                $data['msg'] = 'Upload success';
                $detail = $this->upload->data(); 
                
                $config2['image_library'] = 'gd2';
                $config2['source_image'] = './'.config_item('dir_slider').'/'.$detail['file_name'];
                $config2['new_image'] = './'.config_item('dir_slider_thumb').'/'.$detail['file_name'];
                $config2['create_thumb'] = TRUE;
                $config2['maintain_ratio'] = TRUE;
                $config2['width'] = 120;
                $config2['height'] = 47;
                $this->load->library('image_lib', $config2);
                $this->image_lib->resize();
                
                // add to db
				
				$pos = $this->am->get_max_pos();
                $this->am->db->select('(max(urutan)+1) as urut');
                $ur = $this->am->read_single('slider')->urut;
				$url = $this->input->post('url');
                $this->am->create('slider',array('nama_gambar'=>$detail['file_name'],'urutan'=>$ur, 'url'=>$url,'position'=>$pos));
			}
	   }
       if($this->input->post('id_img'))
       {
		   $urut = $this->input->post('urutan');
		   $urut_awal = $this->input->post('urutan_awal');
		   if($urut!=$urut_awal)
		   {
				$id_urut_destination = $this->am->read_single('slider',array('urutan'=>$urut));
				// update urutan baru
				$this->am->update('slider',array('urutan'=>$urut),array('id'=>$this->input->post('id_img'))); #echo $this->am->db->last_query();
				// update urutan image penggantinya
				$this->am->update('slider',array('urutan'=>$urut_awal),array('id'=>$id_urut_destination->id)); #echo $this->am->db->last_query();
				$data['msg'] = 'Update success';
			}
		}
       
        $data['ukuran'] = 'width '.$config['max_width'].' x height '.$config['max_height'];
       	$data['folder'] = config_item('dir_upload').'/slider/';
		$data['galery']=$this->am->read('slider');
		$this->template->build('slider',$data);
	}
	
	
	function delete($id){
		$detail = $this->am->read_single('slider',array('id'=>$id));
		$file = $detail->nama_gambar;
		
	   $fname = './'.config_item('dir_slider').'/'.$file;
		if(is_file($fname)){
		  unlink($fname);
        }

	   $fname2 = './'.config_item('dir_slider_thumb').'/'.$file;
		if(is_file($fname2)){
		  unlink($fname2);
        }
        
        $this->am->del('slider',array('id'=>$id));

		$this->session->set_flashdata('msg', 'Delete Success');
        
        redirect('admin/slider');
	}
	
	function detail($id)
	{
		$all_data = $this->am->read('slider');
		foreach($all_data as $al){
			$data['urutan'][$al->urutan] = $al->urutan;
		}
		$data['detail'] = $this->am->read_single('slider',array('id'=>$id)); #print_r($data);
		$this->template->build('slider_detail',$data);
	}
	
	// fungsi sementara utk membuat permalink dari artikel hanya di jalankan sekali saja
	function make_permalink()
	{
		// get artikel
		$this->am->db->select('id_artikel,judul');
		//$this->am->db->where('permalink IS NULL',false,false);
		$dt = $this->am->read('artikel'); 
		if($dt){foreach($dt as $d){
			// save permalink
			$this->am->update('artikel',array('permalink'=>en_url_save(trim($d->judul))),array('id_artikel'=>$d->id_artikel));

		}}
	}
	function update_url($id,$url)
	{
		$this->am->update('slider',array('url'=>$url),array('id'=>$id));
	}
	function updateOrder () {

        $i = 1;
		foreach ($_POST['item'] as $value) {
			$this->am->updatelist($value,$i);
			$i++;
		}
    }  
}
