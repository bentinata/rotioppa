	<div class="judul">
		KERANJANG BELANJA
	</div>
	<div class="garis"></div>
	<br/>
<div class="cart_view">
	<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?><br />

	<? $total_cart=0;$count_barang=0;if($list){?>
	<form method="post" action="" id="update_cart">
	<table class="adminlist" style="width:100%;">
	<thead>
		<tr>
			<th>#</th>
			<th colspan="2">Product</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total</th>
		</tr>
	</thead>
	<? $i=0;foreach($list as $cart){$i++?>
	<tr>
		<td align="center">
		<?php
			echo $i;
		?>
		</td>
		<td>
		<? if(!empty($cart->gambar)){
			$_gb=unserialize($cart->gambar);
			if(isset($_gb['thumb'][1])){
				echo '<a href="'.loadImgProduk($cart->id_produk.'/'.$cart->idgbr.'/'.$_gb['big'][1],'',true).'" class="showBig">';
				echo loadImgProduk($cart->id_produk.'/'.$cart->idgbr.'/'.$_gb['thumb'][1],array('style'=>'width:30px;height:30px'));
				echo '</a>';
			}
		}?>
		</td>
		<td>
		<h5><a href="<?=site_url('home/detail/index/'.$cart->id_produk.'/'.en_url_save($cart->nama_produk))?>"><?=$cart->nama_produk?></a></h5>
		<?=!empty($cart->ukuran)?lang('cart_ukuran').' "'.$cart->ukuran.'"<br />':''?>
		<?=$cart->kategori.' - '.$cart->subkategori?>
		</td>
		<?
			$theprice = get_price($cart->ha_prop,$cart->hb_prop,$cart->ha_diskon,$cart->hb_diskon);
			if($theprice==0)$theprice = get_price($cart->ha_prop,$cart->hb_prop,$cart->ha_diskon,$cart->hb_diskon,'ha');
			$jmlprice = $theprice*$cart->qty;
		?>
		<td style="width:150px;"><span>Rp. <?=currency($theprice)?></span>
		<? // jika ada kupon diskon
		if(!empty($cart->kode_kupon))
		{
			if(empty($cart->potongan_harga))
			{ // jika potongan kosong, artinya pakai persentase
				$kupon_diskon = round( (($theprice*$cart->persen_kupon)/100),0);
			}else
				$kupon_diskon = $cart->potongan_harga;
			$jmlprice_kupon = ($jmlprice>$kupon_diskon)?($jmlprice - $kupon_diskon):0;
			$jmlprice = $jmlprice_kupon;
		?>
		<br />
		(<?=lang('kode_kupon')?>)<br /> <b><?=$cart->kode_kupon?></b><br />
		(<?=lang('diskon')?>) <?=currency($kupon_diskon)?><br />
		(<?=lang('total')?>) <span class="rp"><?=currency($jmlprice_kupon)?></span>
		<? } // end if ada kupon?>
		</td>
		<td align="center">
		<input type="hidden" name="idp[<?=$cart->id?>]" value="<?=$cart->id_stock_attr_khusus?>" />
		<input type="hidden" name="qold[<?=$cart->id?>]" value="<?=$cart->qty?>" />
		<input type="text" title="Jml produk" class="jmlqty" style="width:30px;" jml="<?=$cart->stock?>" name="qty[<?=$cart->id?>]" old="<?=$cart->qty?>" value="<?=$cart->qty?>" />
		</td>
		<td><span class="rp"><?=currency($jmlprice)?></span></td>
		</tr>
	<? $total_cart+=$jmlprice;$count_barang+=$cart->qty;}?>
	<tr  style="border-top:1px solid #abbdcc">
	<td colspan="5">
		<div style="height:20px;padding-bottom:10px;">
		<span><?=lang('if_update')?></span>
		<input type="hidden" name="_UPDATE" value="1" />
		</div>
	</td>
	<td width="150"><a id="do_update" class="isubmit" href="javascript:void(0)" title="Update Transaksi">Update</a></td>
	</tr>
	</table>
	<table class="adminlist" style="width:100%">
		<tr>
			<td colspan="6">
				<div>Jumlah Produk : <?=$count_cart?></div>
				<div>Total Barang : <?=$count_barang?></div>
				<div>Total Harga : Rp. <?=currency($total_cart)?></div>
			</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp </td>
			<td width="250">
				<a class="isubmit" href="<?=site_url('home/cekout')?>">Process Transaksi</a>
			</td>
		</tr>
	</table>
	</form>
	
	
	<? }else{?>
	<p><?=lang('no_data_cart')?></p>
	<? }?>
</div>

<div class="clear"></div>

<!-- lib for fancy -->
<?=loadJs('fancybox/jquery.fancybox-1.3.0.pack.js',false,true)?>
<?=loadCss('js/fancybox/jquery.fancybox-1.3.0.css',false,true,false,true)?>

<?=loadJs('jquery.funtion.global.js',false,true)?>
<script language="javascript">
$(function(){ 
	$('#do_update').click(function(){
		if($('#jml').val()!=''){ 
			$('#update_cart').submit();
			return true;
		}
		return false;
	});
	$('.jmlqty').keyup(function(e){ 
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
			//display error message
			alert('<?=lang('justnumber')?>');
			$(this).val(clear_format_curency($(this).val()));
			return false;
		}else{
			var res = parseInt($(this).val());
			var old = parseInt($(this).attr('old'));
			var stock = parseInt($(this).attr('jml'));
			var tstock = old+stock; 
			if(res>tstock){
				alert('<?=lang('not_have_stock')?> '+tstock);
				$(this).val(old);
			}else{ 
				$(this).val(res);
			}
		}
	});
	$('.dell_cart').click(function(){
		if(confirm('<?=lang('sure_to_dell_cart')?>')) return true;
		return false;
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
