<style>
#box-buletin{background:#ffffff ;width:400px;min-height:400px; margin:auto auto}
#form-buletin{margin-top:10px;padding-left:20px;width:380px;padding-top:10px;}
#form-buletin li{clear:both;margin-bottom:2px;}
#form-buletin label{display:block;float:left;width:100px;color:#ccc;font-size:22px;font-weight:bold;font-family:Tahoma, sans-serif;}
#form-buletin .tinput{font-size:18px;font-weight:bold;line-height:24px;width:180px;height:24px;}

#bt-buletin{color:#FFF;margin-top:5px;text-indent:-1000px;}
#img-captcha{position:relative;top:3px;margin-right:10px;}
#form-captcha{position:relative;top:-6px;}
#bulajax{font-size:12px;color:#ff0000;vertical-align:middle;}

#box-anggota{background-color:#0D416A;height:25px; width:400px}
#anggota{color:#fff;font-weight:bold;padding-left:15px;line-height:25px;vertical-align:center; width:100%;}
#link_anggota{color:#eee;font-style:italic;}
#link_anggota:hover{text-decoration:underline;}
</style>

<div id="box-buletin">
<div id="logo-buletin">
	<div id="text-buletin">
	<div id="box-form-buletin">
		<?=form_open('home/addsubscribe',array('id'=>'iform'))?>
		<ul id="form-buletin" style="background-color:#0D416A">
			<li><label><?=lang('inama')?></label><input class="tinput" type="text" name="inama" /></li>
			<li><label><?=lang('imail')?></label><input class="tinput" type="text" name="imail" /></li>
			<li><label>&nbsp;</label>
			<img id="img-captcha" src="<?=base_url().'captcha/index/buletin'?>" width="70px" height="30px" />
			<input id="form-captcha" type="text" class="captcha" name="icaptcha" maxlength="4" />
			</li>
            
		<a id="bt-buletin" href="">SUBMIT</a>
		</ul>
		<label><span id="bulajax"></span></label>
		<?=form_close()?>
	</div></div>
	<div id="box-anggota">
		<p id="anggota"><?=lang('has_a_member')?> <a id="link_anggota" href="<?=site_url('login')?>"><?=lang('come_here')?></a></p>
	</div>
</div>
</div>

<span id="smallload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script type="text/javascript">
$(document).ready(function() {
	$("#bt-buletin").click(function(){
		nama=$("input[name='inama']").val();
		mail=$("input[name='imail']").val();
		cpt=$("input[name='icaptcha']").val();
		if(nama!='' && mail!='' && cpt!=''){
			$.ajax({
				type: "POST",
				url: "<?=site_url('home/addsubscribe')?>",
				data: "postajax=true&inama="+nama+"&imail="+mail+"&icaptcha="+cpt,
				beforeSend: function(){
					$('#bulajax').html($('#smallload').html());
				},
				success: function(msg){ //alert(msg);
					$('#bulajax').html('');
					if(msg.code=='1'){
						alert(msg.msg);
						$('.add_sub').hide();
						parent.$.fancybox.close();
					}else
					alert(msg.msg);
				},
				dataType: 'json'
			});
		}else{
			alert('Lengkapi semua form input!');
		}
		return false;
	});
	$('#box-buletin').corner('10px');
});
</script>
