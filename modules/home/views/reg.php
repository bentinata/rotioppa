<?=loadJs('fancyslide/sliding.form.js',false,true)?>
<?=loadCss('js/fancyslide/style.css',false,true,false,true)?>

<? 
for($t=1;$t<=date('t');$t++){$tgl[$t]=$t;}
for($b=1;$b<=12;$b++){$bln[$b]=$b;}
for($y=1970;$y<=(date('Y')-10);$y++){$year[$y]=$y;}
?>
<br><div class="judula">
		MEMBER AREA
	</div>
	<div class="garis"></div><br>

<div class="wrap-ct" style="background:#fff;">
<center>

<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<div id="wrapper"><div id="steps">
<form id="formElem" name="formElem" action="" method="post">
<fieldset class="step">
	<legend id="akun"><?=lang('acc_information')?></legend>
	<p><label><?=lang('fullname')?> </label> <input type="text" required="required" name="fullname" value="<?=$this->input->post('fullname')?>" /><span class="notered">*</span></p>
	<p><label><?=lang('email')?> </label> <input type="email" required="required" name="email" class="email_reg" value="<?=$this->input->post('email')?>" maxlength="60" /><span class="notered">*</span></p>
	<p><label><?=lang('pass')?> </label> <input type="password" name="pass" required="required" class="pass_reg" value="<?=$this->input->post('pass')?>" maxlength="20" /><span class="notered">*</span></p>
	<p><label><?=lang('confirm_pass')?> </label> <input type="password" required="required" name="pass2" class="pass2_reg" value="<?=$this->input->post('pass2')?>" maxlength="20" /><span class="notered">*</span></p>
	<p class="submit"><button class="nextbutton" type="button" style="margin-right:0"><?=lang('skip')?></button></p>
</fieldset>

<fieldset class="step">
	<legend id="personal"><?=lang('personal_information')?></legend>
	<p><label><?=lang('nickname')?> </label> <input type="text" name="nickname" value="<?=$this->input->post('nickname')?>" /></p>
	<p><label><?=lang('no_tlp')?> </label> <input class="numberchar" type="text" name="tlp" value="<?=$this->input->post('tlp')?>" /></p>
	<p><label><?=lang('jen_kel')?> </label> <?=form_dropdown('jenkel',config_item('jenkel'),$this->input->post('jenkel'))?></p>
	<p><label><?=lang('tgl_lahir')?> </label> <?=form_dropdown('tgl',$tgl,$this->input->post('tgl'),'style="width:50px"')?> 
	<?=form_dropdown('bln',$bln,$this->input->post('bln'),'style="width:50px"')?> 
	<?=form_dropdown('thn',$year,$this->input->post('thn'),'style="width:100px"')?></p>
	<p class="submit"><button class="nextbutton" type="button" style="margin-right:0"><?=lang('skip')?></button></p>
</fieldset>

<fieldset class="step">
	<legend id="addrhome"><?=lang('addr_home')?></legend>
	<p><label><?=lang('prov')?> </label><input type="text" name="rumah_prov" /></p>
	<p><label><?=lang('kota')?> </label><input type="text" name="rumah_kota" /></p>
	<p><label><?=lang('addr_lengkap')?> </label><textarea name="alamat_rumah"><?=$this->input->post('alamat_rumah')?></textarea></p>
	<p><label><?=lang('zip')?> </label><input class="numberchar" type="text" name="zip_rumah" value="<?=$this->input->post('zip_rumah')?>" /></p>
	<p class="submit"><button class="nextbutton" type="button" style="margin-right:0"><?=lang('skip')?></button></p>
</fieldset>

<fieldset class="step">
	<legend id="addrsend"><?=lang('addr_kirim')?></legend>
	<p><label><?=lang('prov')?> </label><?=form_dropdown('provinsi_kirim',$propinsi,false,'class="prov" lang="kota_kirim"')?></p>
	<p><label><?=lang('kota')?> </label><select name="kota_kirim" class="kota_kirim"><option value=""> - </option></select><span id="load_kota_kirim"></span></p>
	<p><label><?=lang('addr_lengkap')?> </label><textarea name="alamat_kirim"><?=$this->input->post('alamat_kirim')?></textarea></p>
	<p><label><?=lang('zip')?> </label><input class="numberchar" type="text" name="zip_kirim" value="<?=$this->input->post('zip_kirim')?>" /></p>
	<p class="submit"><button class="nextbutton" type="button" style="margin-right:0"><?=lang('skip')?></button></p>
</fieldset>

<fieldset class="step">
	<legend id="confirm"><?=lang('confirm')?></legend>
	<p>
	<b style="display:block;text-align:center;"><?=lang('priv_pol')?></b>
	<textarea style="height:100px;width:97%;" disabled="true">
Syarat dan Ketentuan Customer kueibuhasan

1. Proses pendaftaran Customer dilakukan secara gratis.

2. Data yang diinputkan pada proses registrasi customer adalah data yang sebenarnya.

3. Jika diketahui bahwa calon customer mendaftarkan data tidak sebenarnya atau palsu maka pihak kueibuhasan berhak untuk menghapus data tersebut.

4. Pihak kueibuhasan berkewajiban untuk menjaga dan tidak menyalahgunakan data Customer.

5. Pihak kueibuhasan dapat sewaktu-waktu mengubah baik itu sebagian atau seluruh isi dari poin-poin akan Syarat dan Ketentuan bagi Calon Customer kueibuhasan. Demikian juga dengan Customer berhak menyatakan tidak setuju dengan perubahan akan Syarat dan Ketentuan bagi Calon Customer kueibuhasan dengan cara menonaktifkan akun Customer yang dimiliki.
	</textarea>
	<span class="notered" style="float:left;">*</span>
	<input style="position:relative;top:3px;width:20px;" type="checkbox" id="agree" value="1">
	<span style="float:left;"><?=lang('yes_agree')?></span>
	</p>	
	<p>
	<?=lang('to_receive_email')?>&nbsp;(<a href=""><?=lang('study_detail')?></a>)<br />
	<input type="radio" name="sendmail" value="1" checked="checked" /> <?=lang('yes_please')?><br />
	<input type="radio" name="sendmail" value="2" /> <?=lang('no_thanks')?>
	</p>
	<p>
	Kode verifikasi :<br />
	<img src="<?=base_url().'captcha'?>" width="80px" height="30px" style="position:relative;margin-right:10px;" />
	<span class="notered" style="float:left">*</span><input type="text" class="captcha" name="captcha" />
	</p><br />
	<? /*<center><a id="b1" href="javascript:void(0)" ><?=loadImg('daftar.png')?></a></center>*/?>
	<p class="submit"><button id="b1" type="button" style="margin-right:0"><?=lang('register')?></button></p>
	<input type="hidden" name="_REG" value="registrasi" />
</fieldset>

</form>
</div>

<div id="navigation" style="display:none;">
	<ul>
	<li class="selected">
		<a href="#"><?=lang('nav_acc')?><span class="notify"></span></a>
	</li>
	<li>
		<a href="#"><?=lang('personal_information')?></a>
	</li>
	<li>
		<a href="#"><?=lang('addr_home')?></a>
	</li>
	<li>
		<a href="#"><?=lang('nav_sender')?></a>
	</li>
	<li>
		<a href="#"><?=lang('confirm')?><span class="notify"></span></a>
	</li>
	</ul>
</div>

</div>
<br class="clear" />
<div class="notered" id="notify">Wajib diisi</div>

</center>
</div>

<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
	$('#b1').click(function(){
		em=$(".email_reg").val();
		ps=$(".pass_reg").val();
		ps2=$(".pass2_reg").val();
		fl=$("input[name='fullname']").val();
		cp=$("input[name='captcha']").val();
		agr=$('#agree:checked').val();
		if(em!='' && ps!='' && ps2!='' && fl!=''){
			if(cp!='' && agr){
				if(ps==ps2){
				$('#formElem').submit();
				}else
				alert('<?=lang('pass_not_same')?>');
			}else{
				alert('<?=lang('data_confirm_not_complete')?>');
				return false;
			}
		}else{
			alert('<?=lang('data_akun_not_complete')?>');
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
