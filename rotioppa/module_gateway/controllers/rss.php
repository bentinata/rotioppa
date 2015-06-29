<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rss extends Controller 
{

    function Rss()
    {
        parent::Controller();
        $this->load->helper('xml');
        $this->load->module_model($this->router->module, 'rss_model', 'rm');
    }
    
    function index()
    {
        $this->load->library('ContentFeeder');
        $feed =& new ContentFeeder_RSS2;

        #$feed->setStylesheet(base_url().config_item('tag_module').config_item('dir_css').$this->router->module.'/'.config_item('tag_data_last').'rss.css','css');
        #$feed->addNamespace('dc', 'http://purl.org/dc/elements/1.1/');
    
        $feed->setElement('title', 'kueibuhasan.COM - RSS FEED');
        $feed->setElement('link', base_url());
        $feed->setElement('description', 'kueibuhasan Rss Feed Produk');
        #$feed->setElement('dc:author', 'by Joe Bloe');
        #$feed->setElementAttr('enclosure', 'url', 'http://www.foobar.com/');
        #$feed->setElementAttr('enclosure', 'length', '1234');
        #$feed->setElementAttr('enclosure', 'type', 'audio/mpeg');
    
        $image =& new ContentFeederImage;
        $image->setElement('url', loadImg('logo.png','',true));
        $image->setElement('title', 'kueibuhasan.com');
        $image->setElement('link', base_url());
        $feed->setImage($image);
    
		$data = $this->rm->new_produk();
        foreach($data as $entry)
        {
		// fecth the image
			$gbr=unserialize($entry->gambar); 
			if(isset($gbr['intro']))
				$gb=loadImgProduk($entry->id.'/'.$entry->idgbr.'/'.$gbr['intro']);
			else 
				$gb='';
			
			$item =& new ContentFeederItem;
			$item->setElement('title', $entry->nama_produk);
			$item->setElement('link', site_url('home/detail/index/'.$entry->id));
			$item->setElement('description', $gb.$entry->summary);
			#$item->setElement('image', $gb);
        
        // ensure description does not conflict with XML
			$item->setElementEscapeType('description', 'cdata');
			$item->setElementEscapeType('title', 'cdata');    
			$feed->addItem($item);
        }
    
        $feed->display();
   }

} 
