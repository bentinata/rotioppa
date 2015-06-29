<?
for($t=1;$t<=31;$t++){$tgl[$t]=$t;}
for($b=1;$b<=12;$b++){$bln[$b]=$b;}
for($y=1970;$y<=(date('Y')-10);$y++){$year[$y]=$y;}
$lahir = explode('-',$cust->tgl_lahir); 
$lahir_thn = $lahir[0];
$lahir_bln = $lahir[1];
$lahir_tgl = $lahir[2];
?>
<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('info_account')?></span>
</div>
<br class="clr" />
<br />
<form method="post" action="" id="form_reg">
<input type="hidden" name="id" value="<?=$cust->id?>" />
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<fieldset style="width:500px">
<legend><?=lang('det_aff')?></legend>
<table class="admintable" cellspacing="1">
<tbody>
<tr><th><?=lang('email')?> </th><td>: <b><?=$cust->email?></b></td></tr>
<tr><th><?=lang('pass')?> </th><td>: <input type="text" name="pass" class="pass_reg" value="<?=$cust->password?>" maxlength="20" /></td></tr>
<tr><th><?=lang('fullname')?> </th><td>: <input type="text" name="fullname" value="<?=$cust->nama_lengkap?>" /></td></tr>
<tr><th><?=lang('nickname')?> </th><td>: <input type="text" name="nickname" value="<?=$cust->nama_panggilan?>" /></td></tr>
<tr><th><?=lang('no_tlp')?> </th><td>: <input type="text" name="tlp" value="<?=$cust->no_tlp?>" /></td></tr>
<tr><th><?=lang('hp')?> </th><td>: <input type="text" name="hp" value="<?=$cust->no_hp?>" /></td></tr>
<tr><th><?=lang('alm')?> </th><td>: <textarea name="alm" style="width:300px"><?=$cust->alamat?></textarea></td></tr>
<tr><th><?=lang('kota')?> </th><td>: <input type="text" name="kota" value="<?=$cust->kota?>" /></td></tr>
<tr><th><?=lang('prov')?> </th><td>: <input type="text" name="prov" value="<?=$cust->provinsi?>" /></td></tr>
<tr><th><?=lang('negara')?> </th><td>: <input type="text" name="negara" value="<?=$cust->negara?>" /></td></tr>
<tr><th><?=lang('jen_kel')?> </th><td>: <?=form_dropdown('jenkel',config_item('jenkel'),$cust->jen_kel)?></td></tr>
<tr><th><?=lang('tgl_lahir')?> </th><td>: Tgl <?=form_dropdown('tgl',$tgl,$lahir_tgl)?> 
	Bln <?=form_dropdown('bln',$bln,$lahir_bln)?> 
	Thn <?=form_dropdown('thn',$year,$lahir_thn)?></td></tr>
<tr><th><?=lang('pay_method')?> </th><td>: <input id="c1" name="paymethod" value="1" type="radio" <?=$cust->pay_method=='1'?'checked="checked"':''?> /> Transfer Antar Bank &nbsp;&nbsp;<input id="c2" name="paymethod" type="radio" value="2" <?=$cust->pay_method=='2'?'checked="checked"':''?> /> Paypal</td></tr>
<tr><th><?=lang('min_komisi')?> </th><td>: <?=form_dropdown('minkom',config_item('min_komisi'),$cust->min_transfer)?></td></tr>	
</tbody>
</table>
</fieldset>
<input type="submit" name="_SAVE" value="<?=lang('save')?>" />
</form>

<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
})
</script>
