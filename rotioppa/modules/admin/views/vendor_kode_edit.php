<?
// for input
if(isset($input) && $input){
	$tt=lang('input_vcode');
	$id=false;
	$subkategori='';
	$kategori=false;
	$jml=0;
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_vcode');
	$id=form_hidden('id',$detail_subkat->id);
	$kategori=$detail_subkat->id_vendor;
	$subkategori=$detail_subkat->kode_produk_vendor;
	$jml=$detail_subkat->jml;
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt')).'&nbsp;&nbsp;'
		.anchor(config_item('modulename').'/'.$this->router->class.'/vcode/'.$kategori,lang('back'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_vcode')?></span>
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
	<th><?=lang('vendor')?></th>
	<td><?=form_dropdown('vendor',$kat,$kategori)?></td>
</tr>
<tr>
	<th><?=lang('vcode')?></th>
	<td><input type="text" name="vcode" value="<?=$subkategori?>" /></td>
</tr>
<tr>
	<th><?=lang('produk')?></th>
	<td>
	(<?=$jml?>) &nbsp
	<?=$jml>0?anchor(config_item('modulename').'/'.$this->router->class.'/vcode/'.$detail_subkat->id,loadImg('icon/go_to_list.png','',false,config_item('modulename'),true),array('title'=>lang('list_produk'))):''?></td>
</tr>
<tr>
	<th></th><td><?=$bt?></td>
</tr>
</tbody>
</table>
<?=form_close()?>
</fieldset>

<script language="javascript">
$(function(){
	$('.bt').click(function(){
		if($("select[name='vendor']").val()!='-' && $("input[name='vcode']").val()!='') return true;
		alert('<?=lang('subkat_must_fill')?>');
		return false;
	});
});
</script>