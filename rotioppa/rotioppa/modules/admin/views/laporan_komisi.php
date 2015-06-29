<?
for($b=1;$b<=12;$b++){$bln[$b]=$b;}
for($y=2010;$y<=date('Y');$y++){$year[$y]=$y;}
$status_kirim[''] = ' - ';
foreach(config_item('kirim_komisi') as $a=>$b){
	$status_kirim[$b]=lang('status_komisi_'.$b);
}
?>

<h3><?=lang('lap_komisi')?></h3>
<br />
<fieldset class="boxq" style="width:500px">
	<legend><?=lang('kom_filter')?></legend>
	<table class="admintable" cellspacing="1">
	<tr style="display:none;"><th><?=lang('lihat_bln')?></th>
	<td>
	<?=form_dropdown('bln',$bln,$this->input->post('bln')?$this->input->post('bln'):date('n'))?> 
	<?=form_dropdown('thn',$year,$this->input->post('thn')?$this->input->post('thn'):date('Y'))?>
	<?=lang('until')?>
	<?=form_dropdown('bln2',$bln,$this->input->post('bln2')?$this->input->post('bln2'):date('n'))?> 
	<?=form_dropdown('thn2',$year,$this->input->post('thn2')?$this->input->post('thn2'):date('Y'))?>
	</td></tr>
	<tr><th><?=lang('aff')?> / <?=lang('email')?></th><td> <input type="text" name="aff_cari" /></td></tr>
	<tr style="display:none;"><th><?=lang('status_kirim')?></th><td> <?=form_dropdown('status_cari',$status_kirim)?></td></tr>
	</table>

</fieldset>
<input id="doview" type="submit" name="_VIEW" value="<?=lang('view')?>" />
<br />
<br />

<h2><?=lang('list_lap_komisi')?></h2>
<div id="viewIklan">
<? $this->template->load_view('laporan_komisi2',false,config_item('modulename'))?>
</div>

<span id="bigload" class="hide"><?=loadImg('ajax-loader-big.gif','',false,$this->router->module)?></span>
<span id="smallload" class="hide"><?=loadImg('ajax-loader.gif','',false,$this->router->module)?></span>
<script language="javascript">
$(function(){
	$("select[name='page']").val($('option:first', $("select[name='page']")).val());
	
	$('#doview').click(function(){
		af=$("input[name='aff_cari']").val();
		st=$("select[name='status_cari']").val();
		t1=$("select[name='thn']").val()+'-'+$("select[name='bln']").val();
		t2=$("select[name='thn2']").val()+'-'+$("select[name='bln2']").val();
		url='&dt1='+t1+'&dt2='+t2; 
		if(af!='')url+='&aff='+af; 
		if(st!='')url+='&status='+st;
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/1')?>",
				data: "start=1"+url,
				beforeSend: function(){
					$('#viewIklan').html($('#bigload').html());
				},
				success: function(msg){ //alert(msg);
					$('#viewIklan').html(msg);
				}
			});
	});

});
</script>
