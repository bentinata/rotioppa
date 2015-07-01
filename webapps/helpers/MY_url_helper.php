<?php

function admin_url($uri='')
{
	$CI =& get_instance(); 
	return $CI->config->site_url($CI->config->item('dir_admin').'/'.$uri);
}
function upload_url($uri)
{
	$CI =& get_instance(); 
	return $CI->config->base_url($CI->config->item('dir_upload').'/'.$uri);
}
function theme_url($uri)
{
	$CI =& get_instance(); 
	return $CI->config->base_url($CI->config->item('theme_path').'/'.$CI->curtheme.'/'.$uri);
}
function assets_url($uri)
{
	$CI =& get_instance(); 
	return $CI->config->base_url($CI->config->item('dir_assets').'/'.$uri);
}
function module_url($uri)
{
	$CI =& get_instance(); 
	return $CI->config->base_url($CI->config->item('dir_module').'/'.$CI->module.'/'.config_item('dir_view').'/'.$uri);
}
function assets_dir($type='img') // img,css,js
{
	$CI =& get_instance();
	switch ($type) {
		case 'js':
			$folder = $CI->config->item('dir_js');
			break;
		case 'css':
			$folder = $CI->config->item('dir_css');
			break;
		default:
			$folder = $CI->config->item('dir_img');
			break;
	}
	return $folder;
}

function upload_img($uri, $size='thumb', $tag=true) // full, medium, small, thumb 
{
	switch ($size) {
		case 'full':$type='full';break;
		case 'medium':$type='medium';break;
		case 'small':$type='small';break;
		default:$type='thumbnails';break;
	}
	$path_img = upload_url($type.'/'.$uri);
	return _img($path_img,$uri,$tag);
}
function upload_page_banner($img='')
{
	return base_url().config_item('folder_banner_maincat').'/'.$img;
}
function upload_news_thumb($img='')
{
	return base_url().config_item('folder_news_thumb').'/'.$img;
}
function upload_main_banner($img='')
{
	return base_url().config_item('folder_banner_home').'/'.$img;
}

//to generate an image tag, set tag to true. you can also put a string in tag to generate the alt tag
function theme_img($uri, $tag=true)
{
	$path_img = theme_url(assets_dir('img').'/'.$uri);
	return _img($path_img,$uri,$tag);
}
function assets_img($uri, $tag=true)
{
	$path_img = assets_url(assets_dir('img').'/'.$uri);
	return _img($path_img,$uri,$tag);
}
function module_img($uri, $tag=true)
{
	$path_img = module_url(assets_dir('img').'/'.$uri);
	return _img($path_img,$uri,$tag);
}
function product_img($uri, $tag=true)
{ 
	$base_produk = config_item('dir_product_upload');
	$path_img = assets_url(assets_dir('img').'/'.$base_produk.'/'.$uri);
	return _img($path_img,$uri,$tag);
}
function _img($full_uri, $uri, $tag=true)
{
	if($tag===false)
	{
		return $full_uri;
	}else{
		if($tag===true) $tag='';
		$post = strpos($tag,'alt=');
		$alt = '';
		if($post===false) $alt = 'alt="'.$uri.'" ';
		return '<img src="'.$full_uri.'" '.$alt.$tag.' />';
	}
	
	
	
}

function theme_js($uri, $tag=true)
{
	$path_js = theme_url(assets_dir('js').'/'.$uri);
	return _js($path_js,$uri,$tag);
}
function assets_js($uri, $tag=true)
{
	$path_js = assets_url(assets_dir('js').'/'.$uri);
	return _js($path_js,$uri,$tag);
}
function module_js($uri, $tag=true)
{
	$path_js = module_url(assets_dir('js').'/'.$uri);
	return _js($path_js,$uri,$tag);
}
function _js($full_uri, $uri, $tag=true)
{
	if($tag)
	{
		return '<script type="text/javascript" src="'.$full_uri.'"></script>';
	}
	else
	{
		return $full_uri;
	}
}

//you can fill the tag field in to spit out a link tag, setting tag to a string will fill in the media attribute
function theme_css($uri, $tag=true)
{
	$path_css = theme_url(assets_dir('css').'/'.$uri);
	return _css($path_css,$tag);
}
function assets_css($uri, $tag=true)
{
	$path_css = assets_url(assets_dir('css').'/'.$uri);
	return _css($path_css,$tag);
}
function module_css($uri, $tag=true)
{
	$path_css = module_url(assets_dir('css').'/'.$uri);
	return _css($path_css,$tag);
}
function _css($full_uri, $tag=true)
{
	if($tag)
	{
		$media=false;
		if(is_string($tag))
		{
			$media = 'media="'.$tag.'"';
		}
		return '<link href="'.$full_uri.'" type="text/css" rel="stylesheet" '.$media.'/>';
	}
	
	return $full_uri;
}
