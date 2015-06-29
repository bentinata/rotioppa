<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	new function to load img,js,css
	letak assest
	* theme 	--> $module=false, $public=false
	* public 	--> $module=false, $public=true
	* module 	--> $module=true, $public=false
*/
// path to assest (css,js,img)
function link_to_asset($content,$module=false,$public=false,$asset='css',$withoutmaindir=false){
	$CI =& get_instance();
	Switch($asset){
		case'css':
			$dir = config_item('dir_css');
			break;
		case'js':
			$dir = config_item('dir_js');
			break;
		case'img':
			$dir = config_item('dir_img');
			break;
	}
	if($withoutmaindir) $dir = '';
	if(!$module){
		if($public){ 
			$path = config_item('dir_assets').'/'.$dir.'/'.$content;
		}else{ 
            if(!empty($dir)) $content = $dir.'/'.$content;
			$path = config_item('dir_theme').'/'.$CI->curtheme.'/'.$content;
		}
	}else{
		if($withoutmaindir)
		$path = config_item('dir_module').'/'.$CI->module.'/'.config_item('dir_view').'/'.$dir.'/'.$content;
		else
		$path = config_item('dir_module').'/'.$CI->module.'/'.config_item('dir_view').'/'.$dir.'/'.$content;
	}
	return base_url().$path;
}

/* publict java loader */
function loadJs($file,$module=false,$public=false,$justpath=false,$withoutmaindir=false){
	$CI =& get_instance();
	$path = link_to_asset($file,$module,$public,'js',$withoutmaindir);
	if($justpath){
		$js = $path;
	}else{
		$js = "<script type=\"text/javascript\" src=\"";
		$js.= $path;
		$js.= "\"></script>";
	}
	return $js;
}

/* publict image loader */
function loadImg($img,$arr='',$bg=false,$module=false,$public=false,$withoutmaindir=false){
	$CI =& get_instance();
	
	// fungsi tambahan supaya tidak banyak edit di halaman masing2
	if((strpos($img,'icon/'))!==false)
	{
		// ada di template masing2
		$module=false;$public=false;
	}
	if((strpos($img,'ajax-loader.gif'))!==false)
	{
		$module=false;$public=false;
	}
	
	$path = link_to_asset($img,$module,$public,'img',$withoutmaindir);
	// return for backgroud
	if($bg) return $path;

	$def 	= "<img src=\"".$path;
	if($arr!=''){
		$def .= "\"";
		foreach($arr as $k=>$v){$def .= " $k=\"$v\"";}
	}
	$def .= ($arr=='')?"\" />":" />";
	return $def;
}
function loadImgProduk($img,$attr='',$bg=false){
	if($bg===false) $tag=true; else $tag=false;
	$def = '';
	if($attr!=''){
		$def .= '"';
		foreach($attr as $k=>$v){$def .= ' '.$k.'="'.$v.'"';}
	}
	if($tag===false) $def=false;
    return product_img($img,$def);
}
// yg di pakai hanya $img,$arr,$bg saja biar yg sudah ada tidak error
function loadImgThem($img,$arr='',$bg=false,$module=false,$public=false,$withoutmaindir=false) 
{
	return loadImg($img,$arr,$bg,false,false,$withoutmaindir);
}

/* css loader */
function loadCss($file,$module=false,$public=false,$justpath=false,$withoutmaindir=false){
	$CI =& get_instance();
	$path = link_to_asset($file,$module,$public,'css',$withoutmaindir);
	if($justpath){
		$css = $path;
	}else{
		$css = '<link href="';
		$css.= $path;
		$css.= '" rel="stylesheet" type="text/css" >';
	}
	return $css;
}


/* link to feature on views */
function link_to_default_temp($page,$theme=false,$baseurl=false){
	$CI =& get_instance();
    if(!$theme) $theme=$CI->globals->temp;
    $base=$baseurl?base_url():'';
	$path = $base.config_item('dir_theme').'/'.$theme.'/'.$page;
	return $path;
}

/* message */
function errorMsg($msg){
	$obj =& get_instance();
	$data['error_message'] = $msg;
	$obj->load->vars($data);
}

// file execution
function _read_file($filename,$mode='r'){
	$f = fopen($filename,$mode);
	$data = fread($f,filesize($filename));
	fclose($f);
	return $data;
}
function _write_file($filename,$data,$mode='a'){
	$f = fopen($filename,$mode);
	fwrite($f,$data);
	fclose($f);
}


/* encrypt */
function Int2Hex($Value){
  $Base10ToHex = "0123456789abcdef";
  $tmpResult = "";
  $tmpValue = $Value;
  while ($tmpValue > 0) 
  {
    $tmpPos = ($tmpValue % 16);
    $tmpResult = substr($Base10ToHex, $tmpPos, 1). $tmpResult;

    $tmpValue = ($tmpValue - $tmpPos) / 16;
  }
  while (strlen($tmpResult) < 2)
  {
    $tmpResult = "0". $tmpResult;
  }
  return $tmpResult;
}
function MyRandom($Value){
  $tmpResult = $Value;
  for ($i=1;$i<28;$i++)
  {
    $tmpResult = substr($tmpResult, (54 - $i), $i). substr($tmpResult, $i, (54 - ($i * 2))). substr($tmpResult, 0, $i);
  }
  return $tmpResult;
}
function MySort($Value){
  $tmpResult = $Value;
  for ($i=27;$i>0;$i--)
  {
    $tmpResult = substr($tmpResult, (54 - $i), $i). substr($tmpResult, $i, (54 - ($i * 2))). substr($tmpResult, 0, $i);
  }
  return $tmpResult;
}
function MyEncrypt($Value){
  $tmpResult = "";
  $tmpLen = strlen($Value);
  $Value = Int2Hex($tmpLen). $Value;
  $i = 97;
  while (strLen($Value) < 27)
  {
    $Value = $Value. chr($i);
    $i++;
  }
  $tmpLen = strlen($Value);
  for ($i=0;$i<$tmpLen;$i++)
  {
    $tmpResult = $tmpResult. Int2Hex(Ord(substr($Value, $i, 1)));
  }
  
  return $tmpResult;
}

/* decrypt */
function Hex2Int($Value){
  $Base10ToHex = "0123456789abcdef";
  
  $tmpValue = $Value;
  while (strlen($tmpValue) < 2)
  {
   $tmpValue = "0". $tmpValue;
  }
  
  return (strPos($Base10ToHex, substr($tmpValue, 0, 1))*16) + (strPos($Base10ToHex, substr($tmpValue, 1, 1)));
}
function MyDecrypt($Value){
  $tmpLen = strlen($Value);
  $i = 0;
  $tmpResult = '';
  while ($i < $tmpLen)
  {
    $tmpResult = $tmpResult. chr(Hex2Int(substr($Value, $i, 2)));
    $i = $i + 2;
  }
  $tmpLen = Hex2Int(substr($tmpResult, 0, 2));
  $tmpResult = substr($tmpResult, 2, $tmpLen);
  return $tmpResult;
}

// currency format
function currency($int,$symbol=false){
	
	$backto_negative='';
	if($int<0){ 
		$int=$int*-1; 
		$backto_negative='-';
	}
	$len = strlen(trim($int));
	$cur = array();
	for($i=3;$i<=$len;$i+=3){
		$part = substr($int,-$i,3);
		$cur[]= $part; 
	} 
	$c = $len%3;
	if($c!=0){ 
		$part = substr($int,0,$c);
		$cur[]= $part; 
	} 
	$rp=$symbol?'Rp. ':'';
	$end=$symbol?' ,-':'';
	
	$cur = array_reverse($cur); 
	$cur = $rp.$backto_negative.implode('.',$cur).$end;
	return $cur;
}
function clear_currency($str){
	$int 	= array('1','2','3','4','5','6','7','8','9','0');
	$data 	= str_split($str);
	$ret	= '';
	foreach($data as $val){
		if(in_array($val,$int)){
			$ret .= $val;
		}
	}
	if($ret!=''){ 
		$ret = intval($ret);
		return $ret;
	}
	return 0;
}

function format_rp($int=''){
	if($int=='') return '-';
	$len = strlen($int);
	for($o=0;$o<$len;$o++){
		$str[] = substr($int,$o,1);
	}
	#print_r($str);
	$i=0;$k=0;
	foreach($str as $angka){
		if($i==3){ $i=0;$k++;}
		if(!isset($a[$k]))$a[$k]=$angka;
		else 
		$a[$k] .= $angka;
		$i++;
	}
	$b = implode('.',$a);
	return 'Rp. '.$b.',-';
}
function format_dolar($int=''){
	if($int=='') return '-';
	return '$ '.$int;
}

/*
*	date format
*/
function format_date($date,$format='00-00-0000',$delimiter=' '){ #echo $date;
	if(!$date) return false;
	$ex = explode('-',$date); #print_r($ex);

    if(count($ex)<3){
        if(strlen($ex[0])==4){
            $thn=$ex[0];
            $bln=$ex[1];
        }else{
            $thn=$ex[1];
            $bln=$ex[0];
        }
        $iscomplete=false;
    }else{
    	if(strlen($ex[0])==4){#break;
    		$tgl = $ex[2];
    		$thn = $ex[0];
    	}else{#break;
    		$tgl = $ex[0];
    		$thn = $ex[2];
    	}
        $bln = $ex[1];
        if(strlen($tgl)==1) $tgl='0'.$tgl;
        $iscomplete=true;
    }
    if(strlen($bln)==1) $bln='0'.$bln;
	switch($format){
		case'0000-00-00':
            if($iscomplete)
			$ret = $thn.$delimiter.$bln.$delimiter.$tgl;
            else
            $ret = $thn.$delimiter.$bln;
			break;
		default:
            if($iscomplete)
			$ret = $tgl.$delimiter.$bln.$delimiter.$thn;
            else
            $ret = $bln.$delimiter.$thn;
			break;
	} #echo $ret;
	return $ret;
}
function format_date_fordb($date){
	$format = '0000-00-00';
	return format_date($date,$format,'-');
}
function format_date_ina($tgl,$spr=' ',$outputspr=false){
	$ex = explode($spr,$tgl);
	if(count($ex)!=3) return $tgl;
	$month = strtolower($ex[1]);
    $strmonth = month_name($month);
	if($outputspr or $outputspr==' ') $spr = $outputspr;
	if(strlen($ex[0])==4)
	$strmonth = $ex[2].$spr.ucfirst($strmonth).$spr.$ex[0];
	else
	$strmonth = $ex[0].$spr.ucfirst($strmonth).$spr.$ex[2];
	return $strmonth;
}
function month_name($month,$long=true){
    $pref=$long?'':'_short';
	switch($month){
		case'1':
		case'01':
		case'january':
		case'jan':
			$strmonth = lang('jan'.$pref);
			break;
		case'2':
		case'02':
		case'february':
		case'feb':
			$strmonth = lang('feb'.$pref);
			break;
		case'3':
		case'03':
		case'march':
		case'mar':
			$strmonth = lang('mar'.$pref);
			break;
		case'4':
		case'04':
		case'april':
		case'apr':
			$strmonth = lang('apr'.$pref);
			break;
		case'5':
		case'05':
		case'may':
		case'may':
			$strmonth = lang('mei'.$pref);
			break;
		case'6':
		case'06':
		case'june':
		case'jun':
			$strmonth = lang('jun'.$pref);
			break;
		case'7':
		case'07':
		case'july':
		case'jul':
			$strmonth = lang('jul'.$pref);
			break;
		case'8':
		case'08':
		case'august':
		case'aug':
			$strmonth = lang('agt'.$pref);
			break;
		case'9':
		case'09':
		case'september':
		case'sep':
			$strmonth = lang('sep'.$pref);
			break;
		case'10':
		case'october':
		case'oct':
			$strmonth = lang('okt'.$pref);
			break;
		case'11':
		case'november':
		case'nov':
			$strmonth = lang('nov'.$pref);
			break;
		case'12':
		case'december':
		case'dec':
			$strmonth = lang('des'.$pref);
			break;
		default:
			$strmonth = lang('jan'.$pref);
			break;
	}
    return $strmonth;
}
function get_week_range($day='', $month='', $year='') {
    // default empties to current values
    if (empty($day)) $day = date('d');
    if (empty($month)) $month = date('m');
    if (empty($year)) $year = date('Y');
    // do some figurin'
    $weekday = date('w', mktime(0,0,0,$month, $day, $year));
    $sunday  = $day - $weekday;
    $start_week = date('Y-m-d', mktime(0,0,0,$month, $sunday, $year));
    $end_week   = date('Y-m-d', mktime(0,0,0,$month, $sunday+6, $year));
    if (!empty($start_week) && !empty($end_week)) {
        return array('first'=>$start_week, 'last'=>$end_week);
    }
    // otherwise there was an error :'(
    return false;
}
function last_month($date){
	$dateTime = strtotime($date);
	$date = explode('-',date('n-Y',$dateTime)); #print_r($date);
	$bln=$date[0]-1;
	$thn=$date[1];
	if($date[0]==1){
		$bln=12;
		$thn=$date[1]-1;
	}
	return $bln.'-'.$thn;
}

// format id to kode
function format_kode($id,$len=2){
	$idlen = strlen($id);
	$sisa = $len-$idlen;
	$plus = '0';
	$fix=''; 
	if($sisa>0){
		for($i=0;$i<$sisa;$i++){
			$fix.=$plus; 
		}
		$ret=$fix.$id;
	}else $ret=$id;
	return $ret;
}

// get id from kode
// sample 11222xxx..
// 11 -> id kategori
// 22 -> id subkategori
// xxx.. -> id produk (semuanya pasti uniq)
function get_id_from_kode($kode){
	// karena di buat default (kategori+sub adalah 5 karakter)
	return substr($kode,5);
}

// direct refresh
function meta_refresh($url,$time=3){
	return '<meta content="'.$time.';'.$url.'" http-equiv="refresh" />';
} 

// java helper
function redirect_java($link,$base_url=true){
	if($base_url) $ln=site_url($link);
	else $ln=$link;
	echo "<script language=\"javascript\">";
	echo "window.location.href = '".$ln."';";
	echo "</script>";
}
function java_alert($msg){
	echo "<script language=\"javascript\">";
	echo "alert('$msg');";
	echo "</script>";
}


//	dir helper
function check_dir($fulldir){
	$d='';
	$ret=$fulldir;
	$exp = explode('/',$fulldir); #var_dump($exp);
	foreach($exp as $dir){
		$d .= $dir.'/';
		if($dir!='.' and $dir!=''){
			if(!is_dir($d)){
				#echo $d.'--';
				if(!mkdir($d)) $ret=false;
			}
		}
	}
	return $ret;
}
function remove_dir($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (!remove_dir($dir . "/" . $item)) {
            chmod($dir . "/" . $item, 0777);
            if (!remove_dir($dir . "/" . $item)) return false;
        };
    }
    return rmdir($dir);
} 
function move_dir($dirmaster,$todir){
	return rename($dirmaster,$todir);
}

// for generating code
function get_rand($len=4,$code=2){
	$k = mt_rand();
	$l = strlen($k); #echo '*'.$l.'-';// panjang hasil random awal
	$s = ($l-$len)-1; #echo '*'.$s.'-';// jadi start nya itu tidak boleh lebih dari panjang karakter 
	$sr = mt_rand(0,$s); #echo '*'.$sr.'-';// start nya itu di random
	$digit = substr($k,$sr,$len);
	
	$arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$a='';
	for($i=0;$i<$code;$i++){
		$a .= $arr[mt_rand(0,25)];
	}
	$huruf = $a;
	
	return $huruf.$digit;
}
function kode_transaksi($id,$long=6,$prefix='SM'){
	$plus= 0;
	$len = strlen($id);
	if($len==$long or $len>$long) return $id;
	$min = $long-$len;
	$zero= '';
	for($i=0;$i<$min;$i++){
		$zero .= $plus;
	}
	$number = $prefix.$zero.$id;
	return $number;
}



// save data to session
function save_uri($uri){
    $CI =& get_instance();
    $CI->session->set_userdata('uri_redirect',$uri);
}
function get_save_uri(){
    $CI =& get_instance();
    $uri = $CI->session->userdata('uri_redirect');
    $CI->session->unset_userdata('uri_redirect');
    return $uri;
}

// to choose the price
function get_price($hap,$hbp,$had,$hbd,$type='hb'){
    if($type=='ha'){
        if($had=='' or $had=='0'){
			if($hap=='' or $hap=='0'){
				$theprice = 0;
			}else{
				$theprice = $hap;
			}
        }else{ 
			$theprice = $had;
		}
    }else{
        if($hbd=='' or $hbd=='0'){
           	if($hbp=='' or $hbp=='0'){
           		$theprice=0;
           	}else $theprice=$hbp;
        }else $theprice=$hbd;
    }
    return $theprice;
}

// convert gr to kg if more than 1000
function convert_unit($unit){
    if($unit>1000){
        $hasil = $unit/1000;
        return array('hasil'=>$hasil,'satuan'=>'kg.');
    }else{
        return array('hasil'=>$unit,'satuan'=>'gr.');
    }
}

// get key of status bayar
function status_bayar($bayar=true){
    $status = config_item('bayar');
    if($bayar) return $status['bayar'];
    else return $status['belum'];
}

// definisikan jenis iklan
function jenis_iklan($kode=false){
    $jenis = config_item('jenis_iklan');
    if(isset($jenis[$kode])) return $jenis[$kode];
    return false;
}

// fungsi ini akan mencetak hasil generate banner affiliate
function banner_code($iklan_encrypt,$jenis){
// echo $iklan_encrypt.'-'; 
// echo $jenis.'--';
    $link = site_url(config_item('link_banner_imp').'/'.$jenis.'/'.$iklan_encrypt);
    //echo $link.'---';
	$echo = '<script src="'.$link.'"></script>';
    return $echo;
}
function banner_from_id($id){ #echo '**'.$id.'^^';
    $ban = config_item('list_banner');   #print_r($ban);
    if(isset($ban[$id])) return $ban[$id];
    $ban_sepatu = config_item('list_banner_sepatu');   #print_r($ban);
    if(isset($ban_sepatu[$id])) return $ban_sepatu[$id];
    return false;
}
// link produk
function lp_code($iklan_encrypt){
    $link = site_url(config_item('link_lp_imp').'/'.$iklan_encrypt);
    $echo = '<script src="'.$link.'"></script>';
    return $echo;
}
function lp_from_id($id){ #echo '**'.$id.'^^';
    $ban = config_item('box_linkproduk');   #print_r($ban);
    if(isset($ban[$id])) return $ban[$id];
    return false;
}

// fungsi untuk memvalidasi url jika ada karakter yg tidak di ijinkan
function en_url_save($text){
	$ret = strtr($text,
			array(
				'+' => '..',
				'=' => '--',
				'/' => '~',
				'(' => '_-',
				')' => '-_',
				' ' => '-',
				'&' => '_dan_',
				'"' => '', // dihilangkan saja, karena permalink nya tdk menjadi key
				"'" => '', // smentara khusus utk permalink produk
				"`" => '',
				',' => '',  // khusus permalink
				'!' => '',	// karakter2 yg aneh dihilangkan dulu
				';' => '',
				':' => '',
				'?' => '',
				'@' => '',
				'%' => '',
				'>' => '',
				'*' => '',
				'|' => ''
			));
	$ret = strtr($ret,
			array(
				'--'=>'-',
				'---'=>'-',
				'----'=>'-'
			));
	return strtolower($ret);
}
function de_url_save($text){
	$ret = strtr($text,
			array(
				'..' => '+',
				'--' => '=',
				'~'  => '/',
				'_-' => '(',
				'-_' => ')',
				'-'  => ' ',
				'_dan_'=>'&'
			));
	return $ret;
}
