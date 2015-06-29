	<div class="judul">
		KONFIRMASI PEMBAYARAN
	</div>
	<div class="garis"></div>
	<br/>
<div class="notecolored">* <?=lang('pastikan')?></div><br /><br />
<form method="post" action="" id="form_cekout_now">
<table class="adminlist" style="width:100%;">
	<thead>
		<tr>
			<th>#</th>
			<th>Product</th>
			<th>Jumlah Produk</th>
			<th>Harga Satuan</th>
			<th>Total Harga</th>
		</tr>
	</thead>
	<?$cust->regular=0; // biaya kirim di buat nol dulu karena nanti harus di pilih cabang layanan pengiriman terdekat
	$plus_bkirim=false;
	$i=0;$tot_biaya=0;$tot_berat=0;
	if($list){foreach($list as $ck){$i++;
		if(!$plus_bkirim && $ck->id_vendor==config_item('id_elexmedia')){
			$plus_bkirim=true;
		}
	?>
	<tr>
	<td align="center">
		<?php
			echo $i;
		?>
		</td>
		<td>
			<ul>
				<li class="cart-kiri">
					<? if(!empty($ck->gambar)){
						$_gb=unserialize($ck->gambar);
						if(isset($_gb['thumb'][1])){
							echo '<a href="'.loadImgProduk($ck->id_produk.'/'.$ck->idgbr.'/'.$_gb['big'][1],'',true).'" class="showBig">';
							echo loadImgProduk($ck->id_produk.'/'.$ck->idgbr.'/'.$_gb['thumb'][1],array('style'=>'width:30px;height:30px;float:left;margin-right:15px;'));
							echo '</a>';
						}
					}?>
				</li>
				<li class="cart-kanan">
					<h5><a href="<?=site_url('home/detail/index/'.$ck->id_produk.'/'.en_url_save($ck->nama_produk))?>"><?=$ck->nama_produk?></a></h5>
					<?=!empty($ck->ukuran)?lang('cart_ukuran').' "'.$ck->ukuran.'"<br />':''?>
					<label><?=lang('kat_produk')?> </label>: <?=$ck->kategori?> - <?=$ck->subkategori?><br>
					<label><?=lang('berat')?> </label>: <? $cv=convert_unit($ck->berat);echo $cv['hasil'].' '.$cv['satuan'];?><br>
					<label><?=lang('berat_total')?> </label>: <? $bt=$ck->berat*$ck->qty; $cv2=convert_unit($bt);echo $cv2['hasil'].' '.$cv2['satuan'];?>
				</li>
			</td>
			<?
				$theprice = get_price($ck->ha_prop,$ck->hb_prop,$ck->ha_diskon,$ck->hb_diskon);
				if($theprice==0)$theprice = get_price($ck->ha_prop,$ck->hb_prop,$ck->ha_diskon,$ck->hb_diskon,'ha');
				$jmlprice = $theprice*$ck->qty;
			?>
			<td align="center"><?=$ck->qty?></td>
			<td align="center">Rp <?=currency($theprice)?></td>
			<td align="center"><span class="rp">Rp <?=currency($jmlprice)?></span></td>
		
	</tr>
	<?
	$tot_biaya+=$jmlprice;
	$tot_berat+=$bt;

	}}?>
</table>

<div class="wrap-ct">
	<div class="head-title-member">
		<h3><?=lang('delivery_to')?></h3>
	</div>
	<div class="alamatkirim" style="padding:15px;">
		<p><b><?=$cust->nama_lengkap?></b></p>
		<p><?=$cust->alamat_kirim?></p>
		<p><?=$cust->kota.' '.$cust->zip_kirim?>, <?=$cust->provinsi?></p>
		<p><?=$cust->no_tlp?></p>
	</div>
</div>
<br>
<div class="wrap-ct">
	<div class="head-title-member">
		<h3><input type="checkbox" class="otheraddr" name="otheraddr" value="1" /> <?=lang('use_other_addr')?></h3>
	</div>
	<ul class="form"  style="padding:15px;">
		<li><label><?=lang('nama')?> :</label><input type="text" name="nama" /></li><br>
		<li><label><?=lang('addr_lengkap')?> :</label><textarea name="alamat"></textarea></li><br>
		<li><label><?=lang('prov')?> :</label><?=form_dropdown('provinsi',$propinsi,false,'class="prov" lang="kota" url="'.site_url(config_item('modulename').'/'.$this->router->class.'/optionkota').'"')?></li><br>
		<li><label><?=lang('kota')?> :</label><select name="kota" class="kota"><option value=""> - </option></select><span id="load_kota"></span></li><br>
		<li><label><?=lang('zip')?> :</label><input type="text" name="zip" /></li><br>
		<li><label><?=lang('hp')?> :</label><input type="text" name="hp" /></li>
	</ul>
</div>
<br>
<div class="wrap-ct">
	<div class="head-title-member">
		<h3><?=lang('choose_tiki')?></h3>
	</div>
	<ul class="form" style="padding:15px;">
		<li><label style="width:150px;"><?=lang('lay_kirim')?> :</label><?=form_dropdown('perusahaan_kirim',$list_persh,false,'class="persh_kirim" lang="lay_kirim" url="'.site_url(config_item('modulename').'/'.$this->router->class.'/optionlkirim').'"')?></li><br>
		<li><label style="width:150px;"><?=lang('jen_kirim')?> :</label><select name="lay_kirim" url="<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionpropbylayanan')?>" class="lay_kirim" lang="prov_tiki"><option value=""> - </option></select><span id="load_lay_kirim"></span></li><br>
		<li><label style="width:150px;"><?=lang('prov')?> :</label><select name="prov_tiki" url="<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionkotabiaya')?>" class="prov_tiki" lang="kota_tiki"><option value=""> - </option></select><span id="load_prov_tiki"></span></li><br>
		<li><label style="width:150px;"><?=lang('kota')?> :</label><select name="kota_tiki" class="kota_tiki"><option value=""> - </option></select><span id="load_kota_tiki"></span></li>
	</ul>
</div>
<br>
<div class="wrap-ct">
	<div class="head-title-member">
		<h3>Detail Pembelian</h3>
	</div>
	<ul class="form" style="padding:15px;">
	<? 
		$kode_unik=get_rand(2,0);
		$cv3=convert_unit($tot_berat); // convert unit berat ke gr-->kg
		$total_berat_real = $cv3['hasil']; // dlm satuan kg, dlm satuan gr nya adl ($total_berat)
		$satuan_total_berat = $cv3['satuan'];
		$total_berat_perkalian = ceil(($tot_berat/1000)); // dlm satuan kg yg sdh di bulatkan ke atas
		$total_biaya_kirim = $total_berat_perkalian*$cust->regular; // total keseluruhan
		$tot=$tot_biaya+$kode_unik+$total_biaya_kirim;
	?>
	<?=lang('tot_order')?> : Rp <?=currency($tot_biaya)?><br />
	<?=lang('total_berat_barang')?> : <label id="total_berat"><?=$total_berat_real.' '.$satuan_total_berat;?></label><br />
	<?=lang('biaya_kirim')?> : Rp <label id="biaya_kirim"><?=currency($cust->regular)?> </label><span class="load_biaya_kirim"></span><br />
	<?=lang('total_biaya_kirim')?> : Rp <label id="total_biaya_kirim"><?=currency($total_biaya_kirim)?> </label><span class="load_biaya_kirim"></span><br />
    	<?=lang('kode_unik_trans')?> : Rp <label><?=currency($kode_unik)?> </label><br />
	<?=lang('transfer_unik')?> <b><span>Rp. <span id="biaya_total"><?=currency($tot)?></span> <span class="load_biaya_kirim"></span></span></b>
	</ul>
</div>
<br>
<div class="wrap-ct">
	<div class="head-title-member">
		<h3><?=lang('chose_bayar')?></h3>
	</div>
	<ul class="form" style="padding:15px;">
		<h6><input id="c1" type="checkbox" name="bayar" value="1" /> <?=lang('tansfer_bank')?></h6>
	<div style="padding-bottom:20px;padding-left:18px;">
	<div class="i_logo"><?=loadImg('logo-bca.jpg')?></div>
	<div class="i_logo"><?=loadImg('logo-mandiri.jpg')?></div>
	<? /*<div class="i_logo"><?=loadImg('logo-bni.jpg')?></div>
	<div class="i_logo"><?=loadImg('logo-bri.jpg')?></div>*/?>
	</div>
	<div class="clear"></div>
	<div id="antar-bank" style="display:none">
		<p class="list-atas-nama">
			<b class="rp">Bank Central Asia (BCA)</b><br />
			Cab. KCU Garut<br />
			A/n. Nurdin Nurdiansyah<br />
			No.rek. 148 073 4498<br />
		</p>
		<p class="list-atas-nama">
			<b class="rp">Bank Mandiri</b><br />
			Cab. KCU Garut<br />
			A/n. Nurdin Nurdiansyah<br />
			No.rek. 131 00 1169749 9<br />
		</p>
	</div>
	<h6><input id="c2" type="checkbox" name="bayar" value="2" /> <?=lang('paypal')?></h6>
	<div class="i_logo"><?=loadImg('logo-paypal.jpeg')?></div>
	</ul>
</div>

<div class="clear"></div>

<div id="total_biaya">
	
</div>
<?=form_hidden('total',$tot_biaya)?>
<?=form_hidden('kode_unik',$kode_unik)?>
<?=form_hidden('biaya_kirim',$total_biaya_kirim)?>
<?=form_hidden('id_biaya_kirim','0') // diaktifkan lagi?>
<?=form_hidden('total_berat',$tot_berat) // total berat yg dipakai dalam satuan gr untuk di input ke database?>
<label id="temp_tot_order" class="hide"><?=$tot_biaya?></label>
<label id="temp_biaya_kirim" class="hide"><?=$cust->regular?></label>
<label id="temp_biaya_kirim_total" class="hide"><?=$total_biaya_kirim?></label>
<label id="temp_total_biaya" class="hide"><?=$tot?></label>
<br />

<input type="hidden" name="_CEKOUT" value="1" />
<button class="go" id="b1" title="<?=lang('do_transaction')?>" style="display:none">PROSES PEMBAYARAN</button>
</form>
<br>
<? /*<input class="go" id="b2" url="paypal.com" type="button" value="PAYPALL" style="display:none" />*/?>
<div class="boxq" id="b2" style="display:none">
Mohon maaf untuk saat ini metode pembayaran Paypall masih dalah proses persiapan
</div>
<div style="display:none">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="paypal@kueibuhasan.com">
<input type="hidden" name="lc" value="ID">
<input type="hidden" name="item_name" value="kueibuhasan.com Transaksi Pembelian">
<input type="hidden" name="item_number" value="001">
<input type="hidden" name="amount" value="<?=round(($tot/10000),2)?>">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="cn" value="Add special instructions to the seller">
<input type="hidden" name="no_shipping" value="2">
<input type="hidden" name="shipping" value="5.00">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>

<!-- lib for fancy -->
<?=loadJs('fancybox/jquery.fancybox-1.3.0.pack.js',false,true)?>
<?=loadCss('js/fancybox/jquery.fancybox-1.3.0.css',false,true,false,true)?>

<?=loadJs('jquery.funtion.global.js',false,true)?>
<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
	$("input[name='biaya_kirim']").val('0');
	$('#c1').click(function(){
			
		if($('#c1').is(":checked")){
			$('#antar-bank,#b1').show();
			$('#b2').hide();
			$('#c2').attr('checked',false);
		}else
			$('#antar-bank,#b1').hide();
	});
	$('#c2').click(function(){
		if($('#c2').is(":checked")){
			$('#antar-bank,#b1').hide();
			$('#b2').show();
			$('#c1').attr('checked',false);
		}else
			$('#b2').hide();
	});
	
	$('.otheraddr').attr('checked',false);
	$("input[type='text'],textarea,select",$('.ckalm2')).attr('disabled',true);
	$('.otheraddr').click(function(){
		if($(this).attr('checked'))
			$("input[type='text'],textarea,select",$('.ckalm2')).attr('disabled',false);
		else{
			bkirimold=$("#temp_biaya_kirim").html();
			bkirimold_total=$("#temp_biaya_kirim_total").html();
			biayaold=$("#temp_total_biaya").html();
			$('#biaya_kirim').html(format_to_curency((bkirimold))).show();
			$('#total_biaya_kirim').html(format_to_curency((bkirimold_total))).show();
			$('#biaya_total').html(format_to_curency((biayaold))).show();
			$("input[name='biaya_kirim']").val(bkirimold);
			$("input[type='text'],textarea,select",$('.ckalm2')).attr('disabled',true).val('');
		}
	});

	$(".prov_tiki,.prov,.persh_kirim,.lay_kirim").change(function(event,ktt){
		if(ktt) thisval=ktt;
		else thisval = $(this).val(); 
		if(thisval!='-'){
			toobj=$(this).attr('lang');
			$.ajax({
				type: "POST",
				url: $(this).attr('url'),
				data: "prov="+thisval,
				beforeSend: function(){
					$("."+toobj).hide();
					$('#load_'+toobj).html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_'+toobj).html('');
					$("."+toobj).html(msg).show();
				}
			});
		}
	});
	$("select[name='prov_tiki']").change(function(event,ktt){
		if(ktt) thisval=ktt;
		else thisval = $(this).val(); 
		if(thisval!='-'){
			toobj=$(this).attr('lang');
			$.ajax({
				type: "POST",
				url: $(this).attr('url'),
				data: "prov="+thisval+"&idlay="+$("select[name='lay_kirim']").val(),
				beforeSend: function(){
					$("."+toobj).hide();
					$('#load_'+toobj).html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_'+toobj).html('');
					$("."+toobj).html(msg).show();
				}
			});
		}
	});
	$("select[name='kota_tiki']").change(function(){
		thisval = $(this).val();
		plus_bkirim = '<?=$plus_bkirim?config_item('bkirim_elexmedia'):0?>'; 
		if(thisval!='-'){
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/bkirim')?>",
				data: "kota="+thisval+"&idlay="+$("select[name='lay_kirim']").val(),
				beforeSend: function(){
					$('#biaya_kirim').hide();
					$('#total_biaya_kirim').hide();
					$('#biaya_total').hide();
					$('.load_biaya_kirim').html($('#smalload').html());
				},
				success: function(msg){ 
					idkirim=msg.id;
					bkirim=parseInt(msg.biaya);//+parseInt(plus_bkirim);
					berat=<?=$total_berat_perkalian?>;
					totbkirim=parseInt(bkirim)*parseInt(berat);
					totorder=parseInt($("#temp_tot_order").html()); 
					kodeunik=parseInt($("input[name='kode_unik']").val());
					biaya=totorder+totbkirim+kodeunik; 
					$('.load_biaya_kirim').html('');
					$('#total_biaya_kirim').html(format_to_curency((totbkirim+''))).show();
					$('#biaya_kirim').html(format_to_curency((bkirim+''))).show();
					$('#biaya_total').html(format_to_curency((biaya+''))).show();
					$("input[name='biaya_kirim']").val(totbkirim);
					$("input[name='id_biaya_kirim']").val(idkirim);
				},
				dataType: "json"
			});
		}
	});
	
	$('.go').click(function(){
		terus=true;
		if($('.otheraddr').is(':checked')){
			nm=$("input[name='nama']").val();
			al=$("textarea[name='alamat']").val();
			pr=$("select[name='kota']").val();
			zp=$("input[name='zip']").val();
			hp=$("input[name='hp']").val();
			if(nm!='' && al!='' && pr!='' && zp!='' && hp!='') terus=true;
			else{
				alert('<?=lang('addr_must_complete')?>');
				terus=false;
			}
		}
		bkirim=$("input[name='biaya_kirim']").val(); 
		if(bkirim==0 || bkirim==''){
			terus=false;
			alert('<?=lang('mistake_with_prov_kota')?>');
		}
		if(terus){
			$('#form_cekout_now').attr('action',$(this).attr('url')).submit();
		} 
	});
	$("a.showBig").fancybox({
		'titleShow'     : false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'/*,
		'width':500,	// di buat auto
		'height':500*/
	});
})
</script>
