<fieldset class="column ckalm1 boxq calc">
	<legend><?=lang('result')?></legend>
	<? if(isset($data_error)){?>
	<h5><?=$data_error?></h5>
	<? }else{?>
	<ul class="form">
		<li><label style="width:150px;"><?=lang('berat_barang')?> </label>: <?=$berat?> kg.</li>
		<li><label style="width:150px;"><?=lang('kota')?> </label>: <?=$nkota?></li>
		<?
			if($row) $harga=$row->biaya_kirim; else $harga=0;
		?>
		<li><label style="width:150px;"><?=lang('bkirim')?> </label>: Rp. <span style="color:#FF0000;font-size:16px"><?=currency(($harga*$berat))?></span></li>
	</ul>
	<? }?>
</fieldset>
