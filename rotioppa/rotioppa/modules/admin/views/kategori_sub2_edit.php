<?
// for input
if(isset($input) && $input){
	$tt=lang('input_subkat2');
	$subkategori=false;
	$kategori=false;
	$subkategori2='';
	$jml=0;
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_subkat2');
	$id=$detail_subkat->id;
	$kategori=$detail_subkat->id_kategori;
	$subkategori=$detail_subkat->id_subkategori;
	$subkategori2=$detail_subkat->subkategori2;
	$jml=$detail_subkat->jml;
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt')).'&nbsp;&nbsp;'
		.anchor(config_item('modulename').'/'.$this->router->class.'/sub2/'.$subkategori,lang('back'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_subkat2')?></span>
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
	<td><select name="subkat"><option> - </option></select> <span id="loadSub" style="display:none"></span></td>
</tr>
<tr>
	<th><?=lang('subkat2')?></th>
	<td><input type="text" name="subkat2" value="<?=$subkategori2?>" /></td>
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

<div id="loadpage" style="display:none">
<?=loadImg('ajax-loader.gif',array('style','border:none'),false,config_item('modulename'),true)?>
</div>

<script language="javascript">
$(function(){
	$("select[name='kat']").val($('option:first', $("select[name='kat']")).val());
	
	$("select[name='kat']").change(function(event,at){
		if(at) var thisval=at;
		else var thisval = $(this).val();

		kt=$(this).val();
		if(kt!='-'){
		$.ajax({
			type: "POST",
			url: '<?=site_url(config_item('modulename').'/'.$this->router->class.'/option_sub')?>',
			data: 'kat='+kt,
			beforeSend: function(){
				$("select[name='subkat']").hide();
				$('#loadSub').html($('#loadpage').html());
			},
			success: function(msg){ //alert(msg);
				$('#loadSub').html('');
				$("select[name='subkat']").html( msg ).show();
				<? if($subkategori){?>
				$("select[name='subkat']").val('<?=$subkategori?>');
				<? }?>
			}
		});
		}
	});
	<? if($kategori){?>
	$("select[name='kat']").val('<?=$kategori?>').trigger('change',["<?=$kategori?>"]);
	<? }?>
	

	$('.bt').click(function(){
		if($("select[name='subkat']").val()!='-' && $("input[name='subkat2']").val()!='') return true;
		alert('<?=lang('form_complete')?>');
		return false;
	});
});
</script>