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
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<table class="admintable" cellspacing="1">
<tbody>
<tr><th><?=lang('email')?> </th><td>: <input type="text" name="email" value="<?=$cust->email?>" /><span class="notered">*</span></td></tr>
<tr><th><?=lang('pass')?> </th><td>: <input type="text" name="pass" class="pass_reg" value="<?=$cust->password?>" maxlength="20" /><span class="notered">*</span></td></tr>
<tr><th><?=lang('fullname')?> </th><td>: <input type="text" name="fullname" value="<?=$cust->nama_lengkap?>" /><span class="notered">*</span></td></tr>
<tr><th><?=lang('nickname')?> </th><td>: <input type="text" name="nickname" value="<?=$cust->nama_panggilan?>" /><span class="notered">*</span></td></tr>
<tr><th><?=lang('no_tlp')?> </th><td>: <input type="text" name="tlp" value="<?=$cust->no_tlp?>" /><span class="notered">*</span></td></tr>
<tr><th><?=lang('jen_kel')?> </th><td>: <?=form_dropdown('jenkel',config_item('jenkel'),$cust->jen_kel)?></td></tr>
<tr><th><?=lang('tgl_lahir')?> </th><td>: Tgl <?=form_dropdown('tgl',$tgl,$lahir_tgl)?> 
	Bln <?=form_dropdown('bln',$bln,$lahir_bln)?> 
	Thn <?=form_dropdown('thn',$year,$lahir_thn)?></td></tr>
<tr><th><?=lang('status_member')?> </th><td>: <b class="notered"><?=lang('status_member_'.$cust->status)?></b></td></tr>
</tbody>
</table>
<br />

<fieldset class="left ckalm">
	<legend><?=lang('addr_home')?></legend>
	<table class="admintable" cellspacing="1">
	<tbody>
		<tr><th><?=lang('prov')?> :</th><td><?=form_dropdown('provinsi_rumah',$propinsi,false,'class="prov" lang="kota_rumah"')?></td></tr>
		<tr><th><?=lang('kota')?> :</th><td><select name="kota_rumah" class="kota_rumah"><option value=""> - </option></select><span id="load_kota_rumah"></span></td></tr>
		<tr><th><?=lang('addr_lengkap')?> :</th><td><textarea name="alamat_rumah"><?=$cust->alamat_rumah?></textarea></td></tr>
		<tr><th><?=lang('zip')?> :</th><td><input type="text" name="zip_rumah" value="<?=$cust->zip_rumah?>" /></td></tr>
	</tbody></table>
</fieldset>
<fieldset class="right ckalm">
	<legend><?=lang('addr_kirim')?></legend>
	<table class="admintable" cellspacing="1">
	<tbody>
		<tr><th><?=lang('prov')?> :</th><td><?=form_dropdown('provinsi_kirim',$propinsi,false,'class="prov" lang="kota_kirim"')?></td></tr>
		<tr><th><?=lang('kota')?> :</th><td><select name="kota_kirim" class="kota_kirim"><option value=""> - </option></select><span id="load_kota_kirim"></span></td></tr>
		<tr><th><?=lang('addr_lengkap')?> :</th><td><textarea name="alamat_kirim"><?=$cust->alamat_kirim?></textarea></td></tr>
		<tr><th><?=lang('zip')?> :</th><td><input type="text" name="zip_kirim" value="<?=$cust->zip_kirim?>" /></td></tr>
	</tbody></table>
</fieldset>
<div class="clear"></div>
<br />

<div class="agrement">
<h4><?=lang('send_email_update')?></h4>
<p><input type="radio" name="sendmail" value="yes" <?=($cust->send_email=='1')?'checked="checked"':''?> /> <?=lang('yes')?></p>
<p><input type="radio" name="sendmail" value="no" <?=($cust->send_email=='2')?'checked="checked"':''?> /> <?=lang('no')?></p>
</div>
<br />

<a id="b1" href="javascript:void(0)"><?=loadImg('save.png')?></a> 
<input type="hidden" name="_SAVE" value="1" />
</form>

<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
	$('#b1').click(function(){
		ps=$(".pass_reg").val();
		em=$("input[name='email']").val();
		fl=$("input[name='fullname']").val();
		nc=$("input[name='nickname']").val();
		tlp=$("input[name='tlp']").val();
		ar=$("textarea[name='alamat_rumah']").val();
		ak=$("textarea[name='alamat_kirim']").val();
		pr=$("select[name='provinsi_rumah']").val();
		pk=$("select[name='provinsi_kirim']").val();
		zr=$("input[name='zip_rumah']").val();
		zk=$("input[name='zip_kirim']").val();
		if(em!='' && ps!='' && fl!='' && nc!='' && tlp!='' && ar!='' && ak!='' && pr!='' && pk!='' && zk!='' && zr!='')
			$('#form_reg').submit();
		else{
			alert('<?=lang('data_not_complete')?>');
			return false;
		}
	});
	
	$("select[name='provinsi_rumah']").change(function(event,ktt){
		if(ktt) var thisval=ktt;
		else var thisval = $(this).val(); 
		if(thisval!='-'){
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionkota')?>",
				data: "prov="+thisval,
				beforeSend: function(){
					$('.kota_rumah').hide();
					$('#load_kota_rumah').html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_kota_rumah').html('');
					$('.kota_rumah').html(msg).show();
				}
			});
		}
	});
	$("select[name='provinsi_kirim']").change(function(event,ktt2){
		if(ktt2) var thisval2=ktt2;
		else var thisval2 = $(this).val(); 
		if(thisval2!='-'){
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionkota')?>",
				data: "prov="+thisval2,
				beforeSend: function(){
					$('.kota_kirim').hide();
					$('#load_kota_kirim').html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_kota_kirim').html('');
					$('.kota_kirim').html(msg).show();
				}
			});
		}
	});
	// auto trigger
	<? if($cust->prop_kirim){?>
	$("select[name='provinsi_kirim']").val('<?=$cust->prop_kirim?>').triggerHandler('change',["<?=$cust->prop_kirim?>"]);
	<? }?>
	<? if($cust->prop_rumah){?>
	$("select[name='provinsi_rumah']").val('<?=$cust->prop_rumah?>').triggerHandler('change',["<?=$cust->prop_rumah?>"]);
	<? }?>

})
</script>
