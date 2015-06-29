<?
$arr_jenis_kupon = lang('jenis_kupon_array');
$arr_status_kupon = lang('status_kupon_array');

// for input
if(isset($input) && $input){
	$tt=lang('input_kupon');
	$id_kupon=$kode_kupon=$jenis_kupon=$nilai_kupon=$status_kupon=$tgl_akhir=$tgl_akhir_hide=$tgl_awal=$tgl_awal_hide='';
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_kupon');
	$id_kupon=form_input(array('type'=>'hidden','name'=>'id_kupon','value'=>$kupon->id_kupon));
	$kode_kupon=$kupon->kode_kupon;
	$jenis_kupon=$kupon->jenis_kupon;
	$nilai_kupon=$kupon->nilai_kupon;
	$status_kupon=$kupon->status_kupon;
	$tgl_awal_hide=$kupon->tgl_awal;
	$tgl_akhir_hide=$kupon->tgl_akhir;
	$tgl_awal=format_date_ina($kupon->tgl_awal,'-',' ');
	$tgl_akhir=format_date_ina($kupon->tgl_akhir,'-',' ');
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_kupon')?></span>
</div>
<br class="clr" />

<fieldset>
<legend><?=$tt?></legend>
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<?=form_open(current_url())?>
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('kode_kupon')?></th>
	<td>
	<input type="text" name="kode_kupon" value="<?=$kode_kupon?>" />
	<?=$id_kupon?>
	</td>
</tr>
<tr>
	<th><?=lang('jenis_kupon')?></th>
	<td><?=form_dropdown('jenis_kupon',$arr_jenis_kupon,$jenis_kupon)?></td>
</tr>
<tr>
	<th><?=lang('nilai_kupon')?></th>
	<td><input type="text" name="nilai_kupon" value="<?=$nilai_kupon?>" /></td>
</tr>
<tr>
	<th><?=lang('tgl_awal')?></th>
	<td>		
		<input type="text" id="tgl_awal" name="tgl_awal" value="<?=$tgl_awal?>" /> 
		<input type="hidden" id="tgl_awal_hide" name="tgl_awal_key" value="<?=$tgl_awal_hide?>" />
	</td>
</tr>
<tr>
	<th><?=lang('tgl_akhir')?></th>
	<td>		
		<input type="text" id="tgl_akhir" name="tgl_akhir" value="<?=$tgl_akhir?>" /> 
		<input type="hidden" id="tgl_akhir_hide" name="tgl_akhir_key" value="<?=$tgl_akhir_hide?>" />
	</td>
</tr>
<tr>
	<th><?=lang('status_kupon')?></th>
	<td><?=form_dropdown('status_kupon',$arr_status_kupon,$status_kupon)?></td>
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

<?=loadCss('js/calendar/theme/redmond/ui.all.css',false,true,false,true)?>
<?=loadJs('calendar/ui/ui.core.js',false,true)?>
<?=loadJs('calendar/ui/ui.datepicker.js',false,true)?>
<?=loadJs('calendar/ui/ui.datepicker-id.js',false,true)?>
<style>
.ui-datepicker {font-size:10px;}
.ui-datepicker-trigger{position:relative;top:3px;}
</style>
<script type="text/javascript">
$(function() {
	$("#tgl_awal").datepicker({
		showOn: "button",
		buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
		changeMonth: true,changeYear: true,
		buttonImageOnly: true,
		dateFormat: "dd MM yy",
		altField: '#tgl_awal_hide',
		altFormat: 'yy-mm-dd'
	}).attr("disabled", true);

	$("#tgl_akhir").datepicker({
		showOn: "button",
		buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
		changeMonth: true,changeYear: true,
		buttonImageOnly: true,
		dateFormat: "dd MM yy",
		altField: '#tgl_akhir_hide',
		altFormat: 'yy-mm-dd'
	}).attr("disabled", true);

	$('.bt').click(function(){
		if($("input[name='kat']").val()!='') return true;
		alert('<?=lang('kat_must_fill')?>');
		return false;
	});
});
</script>