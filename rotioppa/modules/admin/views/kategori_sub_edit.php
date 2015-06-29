<?
// for input
if(isset($input) && $input){
	$tt=lang('input_subkat');
	$subkategori='';
	$kategori=false;
	$jml=0;
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_subkat');
	$id=$detail_subkat->id;
	$kategori=$detail_subkat->id_kategori;
	$subkategori=$detail_subkat->subkategori;
	$jml=$detail_subkat->jml;
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt')).'&nbsp;&nbsp;'
		.anchor(config_item('modulename').'/'.$this->router->class.'/sub/'.$kategori,lang('back'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_subkat')?></span>
</div>
<br class="clr" />

<fieldset>
<legend><?=$tt?></legend>
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<?=form_open(current_url())?>
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('kode')?></th>
	<td>
	<?=format_kode($id,3)?>
	<?=form_hidden('id',$id)?>
	</td>
</tr>
<tr>
	<th><?=lang('kat')?></th>
	<td><?=form_dropdown('kat',$kat,$kategori)?></td>
</tr>
<tr>
	<th><?=lang('subkat')?></th>
	<td><input type="text" name="subkat" value="<?=$subkategori?>" /></td>
</tr>
<tr>
	<th><?=lang('produk')?></th>
	<td>
	(<?=$jml?>) &nbsp
	<?=$jml>0?anchor(config_item('modulename').'/'.$this->router->class.'/sub/'.$id,loadImg('icon/go_to_list.png','',false,config_item('modulename'),true),array('title'=>lang('list_produk'))):''?></td>
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
		if($("select[name='kat']").val()!='-' && $("input[name='subkat']").val()!='') return true;
		alert('<?=lang('subkat_must_fill')?>');
		return false;
	});
});
</script>