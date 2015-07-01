<?
// for input
if(isset($input) && $input){
	$tt=lang('input_biaya');
	$prov=form_dropdown('prov',$propinsi,false);
	$kota='<select name="kota" class="kota"><option value=""> - </option></select><span id="load_kota"></span>';
	$id_kota='';
	$biaya='';
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_biaya');
	$prov=$detail_biaya['prov'];
	$kota=$detail_biaya['kota'];
	$id_kota=$detail_biaya['id_kota'];
	$biaya=$detail_biaya['layanan'];
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_biaya')?></span>
</div>
<br class="clr" />

<fieldset>
<legend><?=$tt?></legend>
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<?=form_open(current_url())?>

<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('prop')?></th>
	<td><?=$prov?></td>
</tr>
<tr>
	<th><?=lang('kota')?></th>
	<td><?=$kota?></td>
</tr>
</tbody>
</table>

<? $urutan=0;if($perusahaan_layanan){foreach($perusahaan_layanan as $id_persh=>$pl){?>
<h3><?=$pl['nama_perusahaan']?></h3>
<table class="admintable" cellspacing="1">
<tbody>
<? foreach($pl['layanan'] as $id_lay=>$ly2){$urutan++;?>
	<tr>
	<th><?=$ly2?></th>
	<td>
	<? if(!empty($ly2)){
		$biaya_print=false;
		if(isset($biaya[$id_persh]) && isset($biaya[$id_persh][$id_lay])){
			$biaya_print=$biaya[$id_persh][$id_lay]['biaya'];
			echo form_hidden("id_biaya[$urutan]",$biaya[$id_persh][$id_lay]['id_biaya']);
		}else{
			echo form_hidden("id_layanan[$urutan]",$id_lay);
			echo form_hidden("id_kota[$urutan]",$id_kota);
		}
	?>
		Rp. <input type="text" class="digit" name="biaya[<?=$urutan?>]" value="<?=currency($biaya_print)?>" />
		<input value="<?=$biaya_print?>" type="hidden" name="hid_biaya[<?=$urutan?>]" class="fixdigit" />
	<? }?>
	</td>
	</tr> 
<? }?>
</tbody>
</table>
<? } // foreach?>
<br />
	<?=$bt?> &nbsp;&nbsp;
	<?=anchor(config_item('modulename').'/'.$this->router->class,lang('back'))?>
<? } // if?>

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
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionkotanobiaya')?>",
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
	<? /*if($prov!=''){?>
	$("select[name='prov']").val('<?=$prov?>').trigger('change',["<?=$prov?>"]);
	<? }*/?>

});
</script>