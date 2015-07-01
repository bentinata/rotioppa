<?
$id='';
$perusahaan='';
$loop_layanan=false;
// for input
if(isset($input) && $input){
	$tt=lang('add_layanan');
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_layanan');
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt'));
	if($data_layanan){
		$id=form_hidden('id_perusahaan',$data_layanan['perusahaan']['id']);
		$perusahaan=$data_layanan['perusahaan']['nama'];
		$loop_layanan=$data_layanan['layanan'];
	}
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('layanan_kirim')?></span>
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
	<th><?=lang('nama_perusahaan')?></th>
	<td><input type="text" name="nama_perusahaan" value="<?=$perusahaan?>" /></td>
</tr>
<tr>
	<th><?=lang('layanan')?></th>
	<td>
	<ul style="padding:0;">
	<? $lp=0;if($loop_layanan){foreach($loop_layanan as $idl=>$ly){if(!empty($ly)){?>
		<li style="padding-bottom:2px;"><input type="text" name="layanan[<?=$lp?>]" value="<?=$ly?>" />
		<input type="hidden" name="id_layanan[<?=$lp?>]" value="<?=$idl?>" /></li>
	<? $lp++;}}}?>
	<? for($loop=$lp;$loop<5;$loop++){?>
		<li style="padding-bottom:2px;"><input type="text" name="layanan[<?=$loop?>]" /></li>
	<? }?>
	</ul>
	</td>
</tr>
<tr>
	<th></th><td>
	<?=$bt?> &nbsp;&nbsp;
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/pengiriman',lang('back'))?>
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
});
</script>