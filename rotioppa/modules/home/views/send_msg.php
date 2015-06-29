<fieldset class="boxq boxqbg2">
	<legend><?=lang('send_msg')?></legend>
<?=form_open_multipart('home',array('id'=>'id_send_msg'))?>
<? if(isset($msg_err)){?><div class="msg_error"><?=$msg_err?></div><? }?>
	<ul class="form">
		<li><label><?=lang('nama')?> :</label><input type="text" name="msg_nama" style="width:300px" value="<?=$this->input->post('msg_nama')?>" /></li>
		<li><label><?=lang('email')?> :</label><input type="text" name="msg_email" style="width:300px" value="<?=$this->input->post('msg_email')?>" /></li>
		<li><label><?=lang('subject')?> :</label><input type="text" name="msg_subject" style="width:300px" value="<?=$this->input->post('msg_subject')?>" /></li>
		<li><label><?=lang('msg')?> :</label><textarea name="msg_pesan" style="width:300px;height:100px"><?=$this->input->post('msg_pesan')?></textarea></li>
		<li><label><?=lang('attach')?> :</label><input type="file" name="atch" style="width:200px" /></li>
		<li><label><?=lang('code')?> :</label>
			<img src="<?=base_url().'captcha/index/sendmsg'?>" width="80px" height="30px" style="position:relative;top:8px;margin-right:10px;" />
			<input type="text" class="captcha" name="msg_capt" />
		</li>
		<li><label>&nbsp;</label><input type="button" name="_SUBMIT" value="<?=lang('send_now')?>" /> <span id="loadMsg" class="notered"></span></li>
	</ul>
<?=form_close()?>
</fieldset>

<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
	$("input[name='_SUBMIT']").click(function(){
		$('#loadMsg').html('').show();
		var subj=$("input[name='msg_subject']").val();
		var pesan=$("textarea[name='msg_pesan']").val();
		var capt=$("input[name='msg_capt']").val();
		var mail=$("input[name='msg_email']").val();
		var nama=$("input[name='msg_nama']").val();
		if(subj!='' && pesan!='' && capt!='' && mail!='' && nama!=''){
			var lanjut=true;
			var the_atch=$("input[name='atch']").val();
			if(the_atch){
				var permittedFileType = ['doc','docx','xls','xlsx','pdf','jpg','jpeg'];
				var ff = the_atch.split('.').pop().toLowerCase();
				var resultFile = validate_filetype(ff, permittedFileType);
				if(resultFile === false){ 
					alert("<?=lang('permit_file')?> 'doc','docx','xls','xlsx','pdf','jpg','jpeg'");
					lanjut = false;
				}
			}
			if(lanjut){ //alert('go');
				var the_url = "<?=site_url($this->router->module.'/'.$this->router->method.'/2')?>";
				$("input[name='_SUBMIT']").attr('disabled',true);
				$('#id_send_msg').attr('action',the_url).submit();
			} //alert('no');
		}else{
			$('#loadMsg').html('<?=lang('data_must_complete')?>').fadeOut(5000);
		}
	});
})
</script>