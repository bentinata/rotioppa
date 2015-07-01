<?
foreach(config_item('bayar') as $k){
$arr_bayar[$k] = lang('status_bayar_'.$k);
}
foreach(config_item('kirim') as $k2){
$arr_kirim[$k2] = lang('status_kirim_'.$k2);
}
?>
<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_trans')?> (<?=$cust->kode_transaksi?>)</span>
</div>
<br class="clr" />
dasdad
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<fieldset class="list_order">
<legend><?=lang('cust_detail')?></legend>
<ul class="form-label">
<li><label><b><?=lang('fullname')?></b> </label>: <?=$detailcust->nama_lengkap?></li>
<li><label><b><?=lang('nickname')?></b> </label>: <?=$detailcust->nama_panggilan?></li>
<li><label><b><?=lang('email')?></b> </label>: <?=$detailcust->email?></li>
</fieldset>

<fieldset class="list_order">
<legend><?=lang('list_produk')?></legend>

<? 
$lap_iklan_update=false;$lap_iklan='';
$tot_biaya=0;
if($list){foreach($list as $ck){?>
	<h4>
	<?=loadImg('icon/arrow_right.png','',false,config_item('modulename'))?> 
	<a target="_blank" href="<?=site_url('home/detail/index/'.$ck->id_produk.'/'.en_url_save($ck->nama_produk))?>"><?=$ck->nama_produk?></a> 
	<a class="add_wish" href="<?=site_url('poseidon/wishlist/input')?>" id="<?=$ck->id_produk?>" nama="<?=$detailcust->nama_panggilan?>" email="<?=$detailcust->email?>">
		<?=loadImg('icon/basket.png',array('title'=>lang('add_to_wish')),false,config_item('modulename'),true)?>
	</a>
	<span class="load_wish<?=$ck->id_produk?>"></span>
	</h4>
	<ul class="form-label">
	<? if(!empty($ck->ukuran)){?>
	<li><label><?=lang('ukuran')?> </label>: <?=$ck->ukuran?></li>
	<? }?>
	<li><label><?=lang('kat_produk')?> </label>: <?=$ck->kategori?> - <? echo$ck->subkategori;echo !empty($ck->subkategori2)?' - '.$ck->subkategori2:''?></li>
	<li><label><?=lang('jml_produk')?> </label>: <?=$ck->qty?></li>
	<li><label><?=lang('berat')?> </label>: <? $cv=convert_unit($ck->berat);echo $cv['hasil'].' '.$cv['satuan'];?></li>
	<li><label><?=lang('berat_total')?> </label>: <? $bt=$ck->berat*$ck->qty; $cv3=convert_unit($bt);echo $cv3['hasil'].' '.$cv3['satuan'];?></li>
		<?
		$theprice = $ck->harga;
		$jmlprice = $theprice*$ck->qty;
		?>
	<li><label><?=lang('hrg_satuan')?> </label>: Rp <?=currency($theprice)?></li>
	<li><label><?=lang('tot_harga')?> </label>: <span class="rp">Rp <?=currency($jmlprice)?></span></li>
	<? // jika ada kupon diskon
	if(!empty($ck->kode_kupon))
	{	$is_persen=false;
		if($ck->persen_kupon>0)
		{ // jika potongan kosong, artinya pakai persentase
			$is_persen=true;
		}
		$kupon_diskon = $ck->potongan_harga;
		$jmlprice_kupon = ($jmlprice>$kupon_diskon)?($jmlprice - $kupon_diskon):0;
		$jmlprice = $jmlprice_kupon;
	?>
	<li><label><?=lang('kode_kupon')?></label>: <b><?=$ck->kode_kupon?></b></li>
	<? if($is_persen){?><li><label><?=lang('persen_diskon')?></label>: <?=$ck->persen_kupon?>% (<?=lang('from_one_produk')?>)</li><? }?>
	<li><label><?=lang('diskon_kupon')?></label>: Rp. <?=currency($kupon_diskon)?></li>
	<li><label><?=lang('total_after_diskon')?></label>: <span class="rp">Rp. <?=currency($jmlprice)?></span></li>
	<? } // end kupon?>
	</ul>
	<br />
	<? $tot_biaya+=$jmlprice;
	// var for update iklan
	if(!empty($ck->id_iklan) && !empty($ck->komisi) && $ck->komisi!=0){
		if(isset($lap_iklan_update[$ck->id_iklan])){		
			$lap_iklan_update[$ck->id_iklan][$ck->tgl_order] += $ck->qty;
		}else{ 
			$lap_iklan_update[$ck->id_iklan][$ck->tgl_order] = $ck->qty;
		}
	}
	if($lap_iklan_update) $lap_iklan = serialize($lap_iklan_update);
}}?>
</fieldset>
<br />

<fieldset class="">
	<legend><?=lang('addres_delivery')?></legend>
	<div class="alamatkirim">
		<p><b><?=$cust->nama_lengkap?></b></p>
		<p><?=$cust->alamat_kirim?></p>
		<p><?=$cust->kota.' '.$cust->zip_kirim?>, <?=$cust->provinsi?></p>
		<p><?=$cust->no_tlp?></p>
		<? /* langsung menggunakan kota dan provinsi alamat pengiriman dari customer
		<p>------------------------</p>
		<p><b><?=lang('tiki_terdekat')?></b></p>
		<p><?=lang('prov_tiki')?> <?=isset($tiki->provinsi)?$tiki->provinsi:''?></p>
		<p><?=lang('cabang')?> <?=isset($tiki->kota)?$tiki->kota:''?></p>
		*/ ?>
	</div>
</fieldset>
<br />

<fieldset class="bayar">
	<legend><?=lang('detail_layanan_kirim')?></legend>
	<ul class="form-label">
	<li><label><?=lang('pkirim')?> </label>: <?=$layanan->nama_perusahaan?></li>
	<li><label><?=lang('lkirim')?> </label>: <?=$layanan->layanan?></li>
	<li><label><?=lang('prov_tiki')?> </label>: <?=$layanan->provinsi?></li>
	<li><label><?=lang('kota_tiki')?> </label>: <?=$layanan->kota?></li>
	</ul>
</fieldset>
<br />

<fieldset class="bayar">
	<legend><?=lang('pembayaran')?></legend>
	<? 
		$kode_unik=$cust->kode_unik;
		$totbiayakirim=$cust->regular;
		$tot=$tot_biaya+$kode_unik+$totbiayakirim;
	?>
	<ul class="form-label">
	<li><label><?=lang('metode_bayar')?> </label>: <?=lang('cara_bayar_'.$cust->cara_bayar)?></li>
	<li><label><?=lang('tot_order')?> </label>: Rp <?=currency($tot_biaya)?></li>
	<li><label><?=lang('tot_berat_barang')?> </label>: <? $cv2=convert_unit($cust->total_berat);echo $cv2['hasil'].' '.$cv2['satuan'];?></li>
	<li><label><?=lang('biaya_kirim')?> </label>: Rp <?=currency($totbiayakirim)?></li>
	<li><label><?=lang('unik_code_trans')?> </label>: Rp <?=$kode_unik?></li>
	</ul>
	<p><?=lang('transfer_unik')?> <b><span>Rp. <?=currency($tot)?></span></b></p>
</fieldset>
<br />
<form method="post" action="">
<?=form_hidden('id',$cust->id)?>
<?=form_hidden('lap_iklan',$lap_iklan)?>
<?=form_hidden('is_bayar_old',$cust->status_bayar)?>
<?=form_hidden('is_kirim_old',$cust->status_kirim)?>
<fieldset>
	<legend><?=lang('update_status')?></legend>
	<ul class="form-label">
	<li style="padding-bottom:3px"><label><?=lang('is_bayar')?> </label>: <?=form_dropdown('is_bayar',$arr_bayar,$cust->status_bayar)?></li>
	<li style="padding-bottom:3px"><label><?=lang('is_kirim')?> </label>: <?=form_dropdown('is_kirim',$arr_kirim,$cust->status_kirim)?></li>
	<? if(!empty($cust->no_resi)){?>
	<li><label><?=lang('no_resi')?> </label>: <b><?=$cust->no_resi?></b></li>
	<? }?>
	</ul>
</fieldset>
<br />
<fieldset id="no_resi" style="display:none;">
	<legend><?=lang('add_resi')?></legend>
	<?=lang('no_resi')?> <input type="text" name="resi" />
</fieldset>
<input type="submit" name="_UPDATE" value="<?=lang('update')?>" /> &nbsp;&nbsp;
[<?=anchor(site_url(config_item('modulename').'/'.$this->router->class),lang('back'))?>]
</form>
<?=loadJs('jquery.funtion.global.js',false,true)?>

<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
	$(".add_wish").click(function(){
		var idp=$(this).attr('id');
		$('.load_wish'+idp).html(' ').show();
		if(confirm('<?=lang('sure_to_add_wish')?>')){
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/wishlist/input')?>",
				data: "_INPUT=true&id="+idp+"&nama="+$(this).attr('nama')+"&email="+$(this).attr('email'),
				beforeSend: function(){
					$('.load_wish'+idp).html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('.load_wish'+idp).html('');
					if(msg.kode=='1') $('.load_wish'+idp).html(msg.msg).fadeOut(5000); 
					else $('.load_wish'+idp).html(msg.msg);
				},
				dataType:'json'
			});
		}
		return false;
	});
	$("select[name='is_kirim']").change(function(){
		if($(this).val()=='3'){
			$('#no_resi').show();
		}else $('#no_resi').hide();
	});
})
</script>
