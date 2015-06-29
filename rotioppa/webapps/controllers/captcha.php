<?php

class Captcha extends MY_Controller {
    
    /**
    * _constructor Controller
    */
    function __construct()
    {
        parent::__construct();
        $this->load->config('sig_config');
        $this->load->library('captcha_lib');
    }
    /**
    *    Index Controller
    */
    function index($key=false)
    {
        $this->captcha_lib->create_captcha($key);
    }
}
/* End of file captcha.php */
/* Location: ./system/application/controllers/captcha.php */
