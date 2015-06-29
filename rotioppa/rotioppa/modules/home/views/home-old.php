<? 
// load banner
#$this->load->module_view('home','banner-home');

echo loadJs('rating/rating.js',false,true);
echo loadCss('js/rating/rating.css',false,true,false,true);
?>

<div id="jb-collection">
	<ul>
		<li class="kerudung"><div class="wrap"><p>kerudung kerudung kerudung kerudung</p><a href="">Shop Now</a><div></li>
		<li class="bergo"><div class="wrap"><p>bergo bergo bergo bergo bergo bergo </p><a href="">Shop Now</a><div></li>
		<li class="perlengkapan"><div class="wrap"><p>keterangan keterangan keterangan keterangan </p><a href="">Shop Now </a><div></li>
	</ul>
</div>


<div class="boxq boxqbg">
<h3 style="text-transform:uppercase"><span><?=lang('produk')?></span> <?=lang('laris')?></h3>
</div>
<? if($best){?>
<table class="list-produk1">
<tr>
<? $ln=0;$jml_data=count($best);
foreach($best as $lsbest){ $ln++;
	$gbr=unserialize($lsbest->gbr); 
	$ha=get_price($lsbest->ha_prop,$lsbest->hb_prop,$lsbest->ha_diskon,$lsbest->hb_diskon,'ha');
	$hb=get_price($lsbest->ha_prop,$lsbest->hb_prop,$lsbest->ha_diskon,$lsbest->hb_diskon);	
	if($ln==5){ 
		if($jml_data<=8) echo '<tr class="not">'; else echo '<tr>';
	}elseif($ln==9) echo '<tr class="not">';

	if(isset($gbr['intro'])){ $gb=$gbr['intro'];}
	elseif(isset($gbr['big'][1])){ $gb=$gbr['big'][1];}
	else $gb=false;
	?>
	<td><br /><div class="ct">
		<h5><a href="<?=site_url('home/detail/index/'.$lsbest->id.'/'.en_url_save($lsbest->nama_produk))?>"><?=$lsbest->nama_produk?></a></h5>
		<? if($gb){?><a href="<?=site_url('home/detail/index/'.$lsbest->id.'/'.en_url_save($lsbest->nama_produk))?>"><?=loadImgProduk($lsbest->id.'/'.$lsbest->idgbr.'/'.$gb)?></a><? }?><br />
		<? if($hb==0){?>
		<span class="rp">Rp. <?=currency($ha)?></span>
        <? }else{?>
		<span class="rpline">Rp. <?=currency($ha)?></span><br />
		<span class="rp">Rp. <?=currency($hb)?></span>
        <? }?>

		<? //------ rating bintang
		$def_width_star=11; // artinya 11px
		$total_width_star=0;
		if($lsbest->rate!=0){
			$res_rate=$lsbest->rate/$lsbest->cust;
			$total_width_star=ceil($def_width_star*$res_rate);
		}
		?>
	<ul style="margin-left:80px;margin-top:5px;">
		<li style="text-align:right;float:left;padding-top:3px">
			<div id="staroff" style="float:right"><div id="staron" style="width:<?=$total_width_star?>px;"></div></div>
		</li>
		<li style="text-align:left;float:left;padding-left:5px">
			<p><?=$lsbest->rate?>/<?=$lsbest->cust?></p>
		</li>
	</ul>
	<br class="clear" /><? /*
	<div style="padding-left:75px;">
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
	<fb:like href="http://www.kueibuhasan.com/home/detail/index/<?=$lsbest->id.'/'.en_url_save($lsbest->nama_produk)?>.html" layout="button_count" show_faces="false" width="150" font=""></fb:like>
	</div> */?>
		
	</div><br /></td>
<? 
if($ln==4 && $jml_data>4) echo '</tr>';}
if($ln==8 && $jml_data>8) echo '</tr>';
if($ln!=$jml_data){
	if($ln<4) $tln=4;elseif($ln<8) $tln=8;elseif($ln<12) $tln=12;
	if(isset($tln))
	for($gln=$ln;$gln<$tln;$gln++){ echo '<td><div class="ct">&nbsp;</div></td>';}
}
?>
</tr>
</table>
<? }?>
<br /><br />

<div class="boxq boxqbg">		
<h3 style="text-transform:uppercase"><span><?=lang('produk')?></span> <?=lang('terbaru')?></h3>
</div>
<? if($new){?>
<table class="list-produk1">
<tr>
<? $ln2=0;$jml_data2=count($new);
foreach($new as $lsnew){$ln2++;
	$gbr=unserialize($lsnew->gbr); 
	$ha=get_price($lsnew->ha_prop,$lsnew->hb_prop,$lsnew->ha_diskon,$lsnew->hb_diskon,'ha');
	$hb=get_price($lsnew->ha_prop,$lsnew->hb_prop,$lsnew->ha_diskon,$lsnew->hb_diskon,'hb');	
	if($ln2==5){ 
		if($jml_data2<=8) echo '<tr class="not">'; else echo '<tr>';
	}elseif($ln2==9) echo '<tr class="not">';
	
	if(isset($gbr['intro'])){ $gb=$gbr['intro'];}
	elseif(isset($gbr['big'][1])){ $gb=$gbr['big'][1];}
	else $gb=false;
	?>
	<td><br /><div class="ct"><?= $hb.'&';?>
		<h5><a href="<?=site_url('home/detail/index/'.$lsnew->id.'/'.en_url_save($lsnew->nama_produk))?>"><?=$lsnew->nama_produk?></a></h5>
		<? if($gb){?><a href="<?=site_url('home/detail/index/'.$lsnew->id.'/'.en_url_save($lsnew->nama_produk))?>"><?=loadImgProduk($lsnew->id.'/'.$lsnew->idgbr.'/'.$gb)?></a><? }?><br />
		<? if($hb==0){?>
		<span class="rp">Rp. <?=currency($ha)?></span>
        <? }else{?>
        <span class="rpline">Rp. <?=currency($ha)?></span><br />
		<span class="rp">Rp. <?=currency($hb)?></span>
        <? }?>

		<? //------ rating bintang
		$def_width_star2=11; // artinya 11px
		$total_width_star2=0;
		if($lsnew->rate!=0){
			$res_rate2=$lsnew->rate/$lsnew->cust;
			$total_width_star2=ceil($def_width_star2*$res_rate2);
		}
		?>
	<ul style="margin-left:80px;margin-top:5px;">
		<li style="text-align:right;float:left;padding-top:3px">
			<div id="staroff" style="float:right"><div id="staron" style="width:<?=$total_width_star2?>px;"></div></div>
		</li>
		<li style="text-align:left;float:left;padding-left:5px">
			<p><?=$lsnew->rate?>/<?=$lsnew->cust?></p>
		</li>
	</ul>
	<br class="clear" />
	<? /*<div style="padding-left:75px;">
		<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
		<fb:like href="http://www.kueibuhasan.com/home/detail/index/<?=$lsnew->id.'/'.en_url_save($lsnew->nama_produk)?>.html" layout="button_count" show_faces="false" width="150" font=""></fb:like>
	</div> */?>

	</div><br /></td>
<? 
if($ln2==4 && $jml_data2>4) echo '</tr>';}
if($ln2==8 && $jml_data2>8) echo '</tr>';
if($ln2!=$jml_data2){
	if($ln2<4) $tln2=4;elseif($ln2<8) $tln2=8;elseif($ln2<12) $tln2=12;
	if(isset($tln2))
	for($gln=$ln2;$gln<$tln2;$gln++){ echo '<td><div class="ct">&nbsp;</div></td>';}
}
?>
</tr>
</table>
<? }?>
<br /><br />

<div class="boxq boxqbg">
<h3 style="text-transform:uppercase"><span><?=lang('produk')?></span> <?=lang('ratinggi')?></h3>
</div>
<? if($rate){?>
<table class="list-produk1">
<tr>
<? $ln3=0;$jml_data3=count($rate);
foreach($rate as $lsrate){$ln3++;
	$gbr=unserialize($lsrate->gbr); #print_r($gbr);
	$ha=get_price($lsrate->ha_prop,$lsrate->hb_prop,$lsrate->ha_diskon,$lsrate->hb_diskon,'ha');
	$hb=get_price($lsrate->ha_prop,$lsrate->hb_prop,$lsrate->ha_diskon,$lsrate->hb_diskon);	
	if($ln3==5){ 
		if($jml_data3<=8) echo '<tr class="not">'; else echo '<tr>';
	}elseif($ln3==9) echo '<tr class="not">';

	if(isset($gbr['intro'])){ $gb=$gbr['intro'];}
	elseif(isset($gbr['big'][1])){ $gb=$gbr['big'][1];}
	else $gb=false;
	?>
	<td><br /><div class="ct">
		<h5><a href="<?=site_url('home/detail/index/'.$lsrate->id.'/'.en_url_save($lsrate->nama_produk))?>"><?=$lsrate->nama_produk?></a></h5>
		<? if($gb){?><a href="<?=site_url('home/detail/index/'.$lsrate->id.'/'.en_url_save($lsrate->nama_produk))?>"><?=loadImgProduk($lsrate->id.'/'.$lsrate->idgbr.'/'.$gb)?></a><? }?><br />
		<? if($hb==0){?>
		<span class="rp">Rp. <?=currency($ha)?></span>
        <? }else{?>
		<span class="rpline">Rp. <?=currency($ha)?></span><br />
		<span class="rp">Rp. <?=currency($hb)?></span>
        <? }?>

		<? //------ rating bintang
		$def_width_star3=11; // artinya 11px
		$total_width_star3=0;
		if($lsrate->rate!=0){
			$res_rate3=$lsrate->rate/$lsrate->cust;
			$total_width_star3=ceil($def_width_star3*$res_rate3);
		}
		?>
	<ul style="margin-left:80px;margin-top:5px;">
		<li style="text-align:right;float:left;padding-top:3px">
			<div id="staroff" style="float:right"><div id="staron" style="width:<?=$total_width_star3?>px;"></div></div>
		</li>
		<li style="text-align:left;float:left;padding-left:5px">
			<p><?=$lsrate->rate?>/<?=$lsrate->cust?></p>
		</li>
	</ul>
	<br class="clear" /> <? /*
	<div style="padding-left:75px;">
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
	<fb:like href="http://www.kueibuhasan.com/home/detail/index/<?=$lsrate->id.'/'.en_url_save($lsrate->nama_produk)?>.html" layout="button_count" show_faces="false" width="150" font=""></fb:like>
	</div> */?>

	</div><br /></td>
<? 
if($ln3==4 && $jml_data3>4) echo '</tr>';}
if($ln3==8 && $jml_data3>8) echo '</tr>';
if($ln3!=$jml_data3){
	if($ln3<4) $tln3=4;elseif($ln3<8) $tln3=8;elseif($ln3<12) $tln3=12;
	if(isset($tln3))
	for($gln=$ln3;$gln<$tln3;$gln++){ echo '<td><div class="ct">&nbsp;</div></td>';}
}
?>
</tr>
</table>
<? }?>
<br /><br />
