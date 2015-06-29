<? 
for($t=1;$t<=date('t');$t++){$tgl[$t]=$t;}
for($b=1;$b<=12;$b++){$bln[$b]=$b;}
for($y=1970;$y<=(date('Y')-10);$y++){$year[$y]=$y;}
?>

<form method="post" action="" id="form_reg">
<h3><?=lang('reg_member')?></h3><br />

<div class="boxq faq boxqbg2">
<span class="note"><?=lang('complete_your_data')?></span><br /><br />

<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<ul class="form">
	<li><label><?=lang('email')?> </label>: <input type="text" name="email" class="email_reg" value="<?=$this->input->post('email')?>" maxlength="60" /><span class="notered">*</span></li>
	<li><label><?=lang('pass')?> </label>: <input type="password" name="pass" class="pass_reg" value="<?=$this->input->post('pass')?>" maxlength="20" /><span class="notered">*</span></li>
	<li><label><?=lang('confirm_pass')?> </label>: <input type="password" name="pass2" class="pass2_reg" value="<?=$this->input->post('pass2')?>" maxlength="20" /><span class="notered">*</span></li>
	<li><label><?=lang('fullname')?> </label>: <input type="text" name="fullname" value="<?=$this->input->post('fullname')?>" /><span class="notered">*</span></li>
	<li><label><?=lang('nickname')?> </label>: <input type="text" name="nickname" value="<?=$this->input->post('nickname')?>" /><span class="notered">*</span></li>
	<li><label><?=lang('no_tlp')?> </label>: <input class="numberchar" type="text" name="tlp" value="<?=$this->input->post('tlp')?>" /><span class="notered">*</span></li>
	<li><label><?=lang('jen_kel')?> </label>: <?=form_dropdown('jenkel',config_item('jenkel'),$this->input->post('jenkel'))?></li>
	<li><label><?=lang('tgl_lahir')?> </label>: Tgl <?=form_dropdown('tgl',$tgl,$this->input->post('tgl'))?> 
	Bln <?=form_dropdown('bln',$bln,$this->input->post('bln'))?> 
	Thn <?=form_dropdown('thn',$year,$this->input->post('thn'))?></li>
</ul>
<br />

<fieldset class="column ckalm2 boxq" style="background-color:#fff;">
	<legend><?=lang('addr_home')?></legend>
	<ul class="form">
		<? /*
		<li><label><?=lang('prov')?> :</label><?=form_dropdown('provinsi_rumah',$propinsi,false,'class="prov" lang="kota_rumah"')?></li>
		<li><label><?=lang('kota')?> :</label><select name="kota_rumah" class="kota_rumah"><option value=""> - </option></select><span id="load_kota_rumah"></span></li>
		*/?>
		<li><label><?=lang('prov')?> :</label><input type="text" name="rumah_prov" /></li>
		<li><label><?=lang('kota')?> :</label><input type="text" name="rumah_kota" /></li>
		<li><label><?=lang('addr_lengkap')?> :</label><textarea name="alamat_rumah"><?=$this->input->post('alamat_rumah')?></textarea></li>
		<li><label><?=lang('zip')?> :</label><input class="numberchar" type="text" name="zip_rumah" value="<?=$this->input->post('zip_rumah')?>" /></li>
	</ul>
</fieldset>
<fieldset class="columnr ckalm2 boxq" style="background-color:#fff;">
	<legend><?=lang('addr_kirim')?></legend>
	<ul class="form">
		<li><label><?=lang('prov')?> :</label><?=form_dropdown('provinsi_kirim',$propinsi,false,'class="prov" lang="kota_kirim"')?></li>
		<li><label><?=lang('kota')?> :</label><select name="kota_kirim" class="kota_kirim"><option value=""> - </option></select><span id="load_kota_kirim"></span></li>
		<li><label><?=lang('addr_lengkap')?> :</label><textarea name="alamat_kirim"><?=$this->input->post('alamat_kirim')?></textarea></li>
		<li><label><?=lang('zip')?> :</label><input class="numberchar" type="text" name="zip_kirim" value="<?=$this->input->post('zip_kirim')?>" /></li>
	</ul>
	<span class="notered">* <?=lang('addr_must_fill')?></span>
</fieldset>
<div class="clear"></div>
<br />

<div class="agrement">
<p><?=lang('to_receive_email')?>&nbsp;
(<a href=""><?=lang('study_detail')?></a>)
</p>
<p><input type="radio" name="sendmail" value="1" checked="checked" /> <?=lang('yes_please')?></p>
<p><input type="radio" name="sendmail" value="2" /> <?=lang('no_thanks')?></p>
</div>
<br />

Kode verifikasi :<br />
<img src="<?=base_url().'captcha'?>" width="80px" height="30px" style="position:relative;top:8px;margin-right:10px;" />
<input type="text" class="captcha" name="captcha" />
<br />
<br />
</div>
<br />
<a id="b1" href="javascript:void(0)" ><?=loadImg('daftar.png')?></a>
<input type="hidden" name="_REG" value="registrasi" />
</form>

<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
	$('#b1').click(function(){
		em=$(".email_reg").val();
		ps=$(".pass_reg").val();
		ps2=$(".pass2_reg").val();
		fl=$("input[name='fullname']").val();
		nc=$("input[name='nickname']").val();
		tlp=$("input[name='tlp']").val();
		ar=$("textarea[name='alamat_rumah']").val();
		ak=$("textarea[name='alamat_kirim']").val();
		cp=$("input[name='captcha']").val();
		pr=$("select[name='provinsi_rumah']").val();
		pk=$("select[name='provinsi_kirim']").val();
		zr=$("input[name='zip_rumah']").val();
		zk=$("input[name='zip_kirim']").val();
		if(em!='' && ps!='' && ps2!='' && fl!='' && nc!='' && tlp!='' && ar!='' && ak!='' && cp!='' && pr!='' && pk!='' && zk!='' && zr!='')
			if(ps==ps2)
			$('#form_reg').submit();
			else
			alert('<?=lang('pass_not_same')?>');
		else{
			alert('<?=lang('data_not_complete')?>');
			return false;
		}
	});
	
	$(".prov").change(function(event,ktt){
		if(ktt) thisval=ktt;
		else thisval = $(this).val(); 
		if(thisval!='-'){
			toobj=$(this).attr('lang');
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionkota')?>",
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

})
</script>
