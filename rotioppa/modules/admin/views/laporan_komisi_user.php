<?
?>

<fieldset class="boxq" style="width:500px">
	<legend><?=lang('info_account')?></legend>
	<table class="admintable" cellspacing="1">
	<tr><th><?=lang('aff')?></th><td><?=$detail_aff->nama_lengkap?></tr>	
	<tr><th><?=lang('email')?></th><td><?=$detail_aff->email?></td></tr>
	<tr><th><?=lang('no_tlp')?></th><td><?=$detail_aff->no_hp?> <?=!empty($detail_aff->no_tlp)?'tlp. '.$detail_aff->no_tlp:''?></td></tr>
	</table>
</fieldset>
<br />

<h2><?=lang('kom_aff')?></h2>
<div id="viewIklan">
<? $this->template->load_view('laporan_komisi_user2',false,config_item('modulename'))?>
</div>

<span id="bigload" class="hide"><?=loadImg('ajax-loader-big.gif','',false,$this->router->module)?></span>
<span id="smallload" class="hide"><?=loadImg('ajax-loader.gif','',false,$this->router->module)?></span>
<script language="javascript">
$(function(){
});
</script>
