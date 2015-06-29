<?
// for input
if(isset($input) && $input){
	$tt=lang('input_kat');
	$kategori='';
	$jml=0;
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_kat');
	$id=$detail_kat->id;
	$katalog=$detail_kat->katalog;
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_kat')?></span>
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
	<?=format_kode($id)?>
	<?=form_hidden('id',$id)?>
	</td>
</tr>
<tr>
	<th><?=lang('kat')?></th>
	<td><input type="text" name="kat" value="<?=$katalog?>" /></td>
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

<script language="javascript">
$(function(){
	$('.bt').click(function(){
		if($("input[name='kat']").val()!='') return true;
		alert('<?=lang('kat_must_fill')?>');
		return false;
	});
});
</script>