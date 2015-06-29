<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// MX modular extension for Modules location
// base path adalah sejajar index
$config['modules_locations'] = array(
	APPPATH.'modules' => 'modules'
);
$config['modules_lctns_imp'] = array(
									APPPATH.'modules' => 'aff/banner/imp'
								);
$config['modules_lctns_klk'] = array(
									APPPATH.'modules' => 'aff/banner/klk'
								);
$config['link_banner_imp'] = $config['modules_lctns_imp'][APPPATH.'modules'];
$config['link_banner_klk']=$config['modules_lctns_klk'][APPPATH.'modules'];

//$config['cok_aff_id'] adalah nama variabel penanda session
$config['cok_aff_id']='session_aff';
$config['cok_aff_exp']=7200;

// default theme name if not set in database
$config['theme_name'] = 'simple';
$config['theme_path'] = 'themes';

// title seting
$config['site_title'] = 'rotioppa';
$config['site_keyword'] = 'rotioppa';
$config['site_desc'] = 'roptioppa';

// assets config
$config['dir_css'] = 'css';
$config['dir_img'] = 'img';
$config['dir_js'] = 'js';
$config['dir_module'] = $config['modules_locations'][APPPATH.'modules']; // harus disamakan dengan MX modular
$config['dir_assets'] = 'assets';
$config['dir_theme'] = $config['theme_path'];
$config['dir_view'] = 'views';
$config['dir_admin'] = 'admin';
$config['dir_upload'] = 'uploads'; // directory yg ada di root /upload
$config['dir_product_upload'] = 'produk'; // directory yg ada di assets/img/product
$config['dir_artikel_upload'] = 'artikel'; // directory yg ada di assets/img/product

// config untuk upload gambar karena system nya sudah ada, jadi formatnya ikutin saja
$config['upload_img_produk'] = $config['dir_assets'].'/img/produk/';
$config['upload_img_news'] = $config['dir_assets'].'/img/artikel/';
$config['view_img_produk'] = 'produk/';

// default admin template
$config['admin_theme_name'] = 'admin';
$config['admin_site_title'] = 'rotioppa - Administration';
$config['admin_site_keyword'] = 'rotioppa - Administration';
$config['admin_site_desc'] = 'rotioppa - Administration';

// config default untuk atribut
$config['names_harga_awal'] = 'harga_awal';
$config['names_harga_baru'] = 'harga_baru';

$config['jenkel'] = array('1'=>'Laki-Laki','2'=>'Perempuan');

// status pembayaran
$config['bayar'] = array('bayar'=>'1','belum'=>'2'); // fix dan ga bisa di rubah lagi value nya karena dijadikan script
// status kirim barang
$config['kirim'] = array('not_confirm'=>'1',/*'dalam perjalanan',*/'on_progress'=>'3');
// status kirim komisi
$config['kirim_komisi'] = array('sudah'=>'1','belum'=>'2');

// minimal transfer komisi untuk affiliate
$config['min_komisi'] = array(
				'200000'=>'200.000',
				'500000'=>'500.000',
				'1000000'=>'1.000.000',
				'2000000'=>'2.000.000',
				'5000000'=>'5.000.000');


// konfigurasi email followup
$config['mail_config'] = array(
	'confirm_buletin'=>array(
				'interface'=>'Konfirmasi Buletin',
				'ket'=>'Email konfirmasi ketika subscribe buletin',
				'personalisasi' => array('{(link_aktivasi_subscribe)}')
				),
	'confirm_buletin2'=>array(
				'interface'=>'Konfirmasi Buletin2',
				'ket'=>'Email konfirmasi ketika subscribe buletin',
				'personalisasi' => array('{(link_aktivasi_subscribe)}','{(name)}')
				),
	'confirm_buletin3'=>array(
				'interface'=>'Konfirmasi Buletin3',
				'ket'=>'Email konfirmasi ketika subscribe buletin',
				'personalisasi' => array('{(link_aktivasi_subscribe)}','{(email)}')
				),
	'confirm_buletin4'=>array(
				'interface'=>'Konfirmasi Buletin4',
				'ket'=>'Email konfirmasi ketika subscribe buletin'
				)
);

/*
	DETAIL dimensi image produk, tetapi belum diintegrasikan dengan system
*/
$config['img_detail'] = array(
		array('width'=>400,'height'=>400),
		array('width'=>500,'height'=>500),
		array('width'=>600,'height'=>600)
	);
$config['img_thumbnail'] = array('width'=>60,'height'=>60);
$config['img_intro'] = array('width'=>246,'height'=>246);

$config['list_banner'] = array(
							/*'1'=>array('img'=>'buku/120_240.png'),
								'1'=key yang akan diakses pada foreach di view ($klb)
								array('img'=>'buku/120_240.png') adalah valuenya ($lb)
							*/
							'1'=>array('img'=>'buku/120_240.png'),
							'2'=>array('img'=>'buku/120_600.png'),
							'3'=>array('img'=>'buku/728_90.png'),
							'4'=>array('img'=>'buku/336_280.png')
							);
$config['list_banner_aqua'] = array(
							'1'=>array('img'=>'minuman/111.jpg'),
							'2'=>array('img'=>'minuman/112.jpg'),
							);							
$config['dir_banner']='banner';							
$config['list_banner_sepatu']=array(
								'a'=>array('img'=>'sepatu/468_60.png'),
								'b'=>array('img'=>'sepatu/728_90.png')
							);
$config['modulename'] = 'aff';
$config['secret_key_banner']='d3f4u1tEncr1pti0n5alt';















