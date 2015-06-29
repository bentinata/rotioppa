<?
// for input
if(isset($input) && $input){
	$tt=lang('make_bcast');
	$id='';
	$db_to=array();
	$subj='';
	$dbmsg='';
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_bcast');
	$id=form_hidden('id',$detail_mail->id);
	$db_to=explode(',',$detail_mail->to);
	$subj=$detail_mail->subject;
	$dbmsg=$detail_mail->msg;
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('bcast')?></span>
</div>
<br class="clr" />

<fieldset>
<legend><?=$tt?></legend>
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<?=form_open(current_url())?>
<?=$id?>
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('to')?>: </th>
	<td>
	<? foreach(config_item('bcast_to') as $idto=>$to){
		$ck='';if(in_array($idto,$db_to))$ck='checked="checked"';
	?>
		<input type="checkbox" <?=$ck?> name="bcast_cek[<?=$idto?>]" value="<?=$idto?>" style="position:relative;top:3px;" /> <?=ucfirst($to)?><br />
	<? }?>
	</td>
</tr>
<tr>
	<th><?=lang('subject')?></th>
	<td><input type="text" name="subject" style="width:400px" value="<?=$subj?>" /></td>
</tr>
<tr>
	<th><?=lang('mail')?></th>
	<td><textarea name="mail" style="width:400px;height:400px"><?=$dbmsg?></textarea></td>
</tr> 
<tr>
	<th></th><td>
	<?=$bt?> &nbsp;&nbsp;
	<?=anchor(config_item('modulename').'/'.$this->router->class,lang('back'))?>
	</td>
</tr>
</tbody>
</table>
<?=form_close()?>
</fieldset>

<?=loadJs('jquery.funtion.global.js',false,true)?>
<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
	$('.bt').click(function(){
		kt=$('.kota').val();
		by=$("input[name='biaya']").val();
		if(kt!='' && by!='') return true;
		alert('<?=lang('data_must_fill')?>');
		return false;
	});
	$("select[name='prov']").change(function(event,ktt){
		if(ktt) var thisval=ktt;
		else var thisval = $(this).val(); 
		if(thisval!='-'){
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionkota')?>",
				data: "prov="+thisval,
				beforeSend: function(){
					$('.kota').hide();
					$('#load_kota').html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_kota').html('');
					$('.kota').html(msg).show();
				}
			});
		}
	});
	// auto trigger
	<? if($prov!=''){?>
	$("select[name='prov']").val('<?=$prov?>').trigger('change',["<?=$prov?>"]);
	<? }?>

	$(".digit").keyup(function(e){ 
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
		{
			//display error message
			alert('<?=lang('justnumber')?>');
			$(this).val(clear_format_curency($(this).val(),'.'));
			return false;
		}else{
			var digit = $(this).val();
			var res = format_to_curency(digit);
			$(this).val(res);

			var res_val = clear_format_curency($(this).val());
			$(this).next(".fixdigit").val(res_val);
		}
	});
});
</script>