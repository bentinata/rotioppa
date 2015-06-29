<h3 style="width:450px"><?=lang('rekomend_produk')?></h3>
<br />
<style>.tell td{line-height:30px;}.view_msg{color:#FF0000;}</style>
<div class="boxq">
<div class="view_msg"></div>
<div id="small_load" class="hide"><center><?=loadImg('small-loader.gif')?></center></div>
<table class="tell">

<tr><td>Nama Anda</td><td><input type="text" name="nama_a" /></td></tr>
<tr><td>Email Anda</td><td><input type="text" name="email_a" /></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

<tr class="in_1" ><td>Nama teman</td><td><input type="text" name="nama_f" /></td></tr>
<tr class="in_1" ><td>Email teman</td><td><input type="text" name="email_f" /></td></tr>

<tr class="in_2" style="display:none"><td>Nama teman</td><td><input type="text" name="nama_f_2" /></td></tr>
<tr class="in_2" style="display:none"><td>Email teman</td><td><input type="text" name="email_f_2" /></td></tr>

<tr class="in_3" style="display:none"><td>Nama teman</td><td><input type="text" name="nama_f_3" /></td></tr>
<tr class="in_3" style="display:none"><td>Email teman</td><td><input type="text" name="email_f_3" /></td></tr>

<tr class="in_4" style="display:none"><td>Nama teman</td><td><input type="text" name="nama_f_4" /></td></tr>
<tr class="in_4" style="display:none"><td>Email teman</td><td><input type="text" name="email_f_4" /></td></tr>

<tr class="in_5" style="display:none"><td>Nama teman</td><td><input type="text" name="nama_f_5" /></td></tr>
<tr class="in_5" style="display:none"><td>Email teman</td><td><input type="text" name="email_f_5" /></td></tr>

<tr class="bt_add"><td>&nbsp;</td><td>[ <a href="javascript:void(0)" def="1" class="add" style="font-size:11px">Tambah Teman</a> ]</td></tr>

<tr><td>Kode verifikasi</td><td>
	<img src="<?=base_url().'captcha'?>" width="80px" height="30px" style="position:relative;top:8px;margin-right:10px;" />
	<input type="text" class="captcha" name="captcha_f" />
</td></tr>
<tr><td>&nbsp;</td><td><input id="kirim_friend" type="button" name="_KIRIM" value="Rekomendasikan" /></td></tr>
</table>
<br />
<span style="color:#FF0000">* <?=lang('note_mail_friend')?></span>
</div>
<br />
<br />
<br />


<script type="text/javascript">
$(document).ready(function() {
	$('.add').click(function(){
		vl=parseInt($(this).attr('def')); 
		nvl=vl+1;
		$('.in_'+nvl).show(); 
		$(this).attr('def',nvl);
		if(nvl==5) $('.bt_add').hide();
	});
	
	$('#kirim_friend').click(function(){
		nm=$("input[name='nama_f']").val();
		em=$("input[name='email_f']").val();
		nma=$("input[name='nama_a']").val();
		ema=$("input[name='email_a']").val();
		cp=$("input[name='captcha_f']").val();
		if(nm!='' && em!='' && cp!='' && nma!='' && ema!=''){
			$.ajax({
				type: "POST",
				url: "<?=site_url('home/tellfriend')?>",
				data: "send_mail=1&captcha="+cp+"&idp=<?=$idp?>&prd=<?=$prd?>"+
						"&nama_a="+nma+"&email_a="+ema+
						"&nama_1="+nm+"&email_1="+em+
						"&nama_2="+$("input[name='nama_f_2']").val()+"&email_2="+$("input[name='email_f_2']").val()+
						"&nama_3="+$("input[name='nama_f_3']").val()+"&email_3="+$("input[name='email_f_3']").val()+
						"&nama_4="+$("input[name='nama_f_4']").val()+"&email_4="+$("input[name='email_f_4']").val()+
						"&nama_5="+$("input[name='nama_f_5']").val()+"&email_5="+$("input[name='email_f_5']").val(),
				beforeSend: function(){
					$('#small_load').show();
				},
				success: function(msg){ //alert(msg);
					$('#small_load').hide();
					$('.view_msg').html(msg.msg);
					if(msg.res=='1') $('#kirim_friend').attr('disabled',true)
				},
				error: function(){
					$('#small_load').hide();
					$('.view_msg').html('Proses');
				},
				dataType: "json"
			});
		}else alert('<?=lang('mailname_must_fill')?>');
	});
});
</script>