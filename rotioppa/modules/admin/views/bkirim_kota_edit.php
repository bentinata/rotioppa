<?
// for input
if(isset($input) && $input){
	$tt=lang('input_kota');
	$id='';
	$prov=false;
	$kota=false;
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_kota');
	$id=form_hidden('id',$detail_kota->id);
	$prov=$detail_kota->id_provinsi;
	$kota=$detail_kota->kota;
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_kota')?></span>
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
	<th><?=lang('prop')?></th>
	<td><?=form_dropdown('prov',$propinsi,$prov)?></td>
</tr>
<tr>
	<th><?=lang('kota')?></th>
	<td><?=form_input('kota',$kota)?></td>
</tr>
<tr>
	<th></th><td>
	<?=$bt?> &nbsp;&nbsp;
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/listkota',lang('back'))?>
	</td>
</tr>
</tbody>
</table>
<?=form_close()?>
</fieldset>
