<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
	public function module_model($mod,$model,$alias)
	{
		$this->model($model,$alias);
	}
    
    public function module_view($mod,$view)
    {
        $this->load->view($view);
    }
}
