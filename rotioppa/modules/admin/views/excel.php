<?=loadCss('js/calendar/theme/redmond/ui.all.css',false,true,false,true)?>
<?=loadJs('calendar/ui/ui.core.js',false,true)?>
<?=loadJs('calendar/ui/ui.datepicker.js',false,true)?>
<?=loadJs('calendar/ui/ui.datepicker-id.js',false,true)?>
<style>
.ui-datepicker {font-size:10px;}
.ui-datepicker-trigger{position:relative;top:3px;}
</style>

<fieldset>
<legend><?=lang('dl_center_excel')?></legend>

<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th style="width:250px"><?=lang('dl_member')?></th>
	<td>
	<?=lang('tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#member_tgl_1").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#member_hide_tgl_1',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<input type="text" id="member_tgl_1" name="member_tgl_1" /> 
		<input type="hidden" id="member_hide_tgl_1" name="member_tgl_key_1" />
	<?=lang('sd_tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#member_tgl_2").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#member_hide_tgl_2',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<input type="text" id="member_tgl_2" name="member_tgl_2" /> 
		<input type="hidden" id="member_hide_tgl_2" name="member_tgl_key_2" />
	</td>
	<td><?=anchor('#',loadImg('icon/excel.png','',false,config_item('modulename'),true),array('title'=>lang('download'),'class'=>'dl_now','fors'=>'member','url'=>'dl_member'))?></td>
</tr>
<tr>
	<th style="width:250px"><?=lang('dl_prospek')?></th>
	<td>
	<?=lang('tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#prospek_tgl_1").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#prospek_hide_tgl_1',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<input type="text" id="prospek_tgl_1" name="prospek_tgl_1" /> 
		<input type="hidden" id="prospek_hide_tgl_1" name="prospek_tgl_key_1" />
	<?=lang('sd_tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#prospek_tgl_2").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#prospek_hide_tgl_2',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<input type="text" id="prospek_tgl_2" name="prospek_tgl_2" /> 
		<input type="hidden" id="prospek_hide_tgl_2" name="prospek_tgl_key_2" />
	</td>
	<td><?=anchor('#',loadImg('icon/excel.png','',false,config_item('modulename'),true),array('title'=>lang('download'),'class'=>'dl_now','fors'=>'prospek','url'=>'dl_prospek'))?></td>
</tr>
<tr>
	<th><?=lang('dl_transaksi')?></th>
	<td>
	<?=lang('tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#trans_tgl_1").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#trans_hide_tgl_1',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<style>.ui-datepicker {font-size:10px;}	</style>
		<input type="text" id="trans_tgl_1" name="trans_tgl_1" /> 
		<input type="hidden" id="trans_hide_tgl_1" name="trans_tgl_key_1" />
	<?=lang('sd_tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#trans_tgl_2").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#trans_hide_tgl_2',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<style>.ui-datepicker {font-size:10px;}	</style>
		<input type="text" id="trans_tgl_2" name="trans_tgl_2" /> 
		<input type="hidden" id="trans_hide_tgl_2" name="trans_tgl_key_2" />
	</td>
	<td><?=anchor('#',loadImg('icon/excel.png','',false,config_item('modulename'),true),array('title'=>lang('download'),'class'=>'dl_now','fors'=>'trans','url'=>'dl_transaksi'))?></td>
</tr>
<tr>
	<th style="width:250px"><?=lang('dl_aff')?></th>
	<td>
	<?=lang('tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#aff_tgl_1").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#aff_hide_tgl_1',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<input type="text" id="aff_tgl_1" name="aff_tgl_1" /> 
		<input type="hidden" id="aff_hide_tgl_1" name="aff_tgl_key_1" />
	<?=lang('sd_tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#aff_tgl_2").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#aff_hide_tgl_2',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<input type="text" id="aff_tgl_2" name="aff_tgl_2" /> 
		<input type="hidden" id="aff_hide_tgl_2" name="aff_tgl_key_2" />
	</td>
	<td><?=anchor('#',loadImg('icon/excel.png','',false,config_item('modulename'),true),array('title'=>lang('download'),'class'=>'dl_now','fors'=>'aff','url'=>'dl_aff'))?></td>
</tr>
<? /*
<tr>
	<th style="width:250px"><?=lang('dl_kom')?></th>
	<td>
	<?=lang('tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#kom_tgl_1").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#kom_hide_tgl_1',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<input type="text" id="kom_tgl_1" name="kom_tgl_1" /> 
		<input type="hidden" id="kom_hide_tgl_1" name="kom_tgl_key_1" />
	<?=lang('sd_tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#kom_tgl_2").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#kom_hide_tgl_2',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<input type="text" id="kom_tgl_2" name="kom_tgl_2" /> 
		<input type="hidden" id="kom_hide_tgl_2" name="kom_tgl_key_2" />
	</td>
	<td><?=anchor('#',loadImg('icon/excel.png','',false,config_item('modulename'),true),array('title'=>lang('download'),'class'=>'dl_now','fors'=>'kom','url'=>'dl_kom'))?></td>
</tr> */?>
<tr>
	<th><?=lang('dl_produk')?></th>
	<td>
	<?=lang('tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#produk_tgl_1").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#produk_hide_tgl_1',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<style>.ui-datepicker {font-size:10px;}	</style>
		<input type="text" id="produk_tgl_1" name="produk_tgl_1" /> 
		<input type="hidden" id="produk_hide_tgl_1" name="produk_tgl_key_1" />
	<?=lang('sd_tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#produk_tgl_2").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#produk_hide_tgl_2',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<style>.ui-datepicker {font-size:10px;}	</style>
		<input type="text" id="produk_tgl_2" name="produk_tgl_2" /> 
		<input type="hidden" id="produk_hide_tgl_2" name="produk_tgl_key_2" />
	</td>
	<td><?=anchor('#',loadImg('icon/excel.png','',false,config_item('modulename'),true),array('title'=>lang('download'),'class'=>'dl_now','fors'=>'produk','url'=>'dl_list_produk'))?></td>
</tr>
<tr>
	<th><?=lang('dl_untung')?></th>
	<td>
	<?=lang('tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#untung_tgl_1").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#untung_hide_tgl_1',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<style>.ui-datepicker {font-size:10px;}	</style>
		<input type="text" id="untung_tgl_1" name="untung_tgl_1" /> 
		<input type="hidden" id="untung_hide_tgl_1" name="untung_tgl_key_1" />
	<?=lang('sd_tgl')?>
		<script type="text/javascript">
			$(function() {
				$("#untung_tgl_2").datepicker({
					showOn: "button",
					buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
					changeMonth: true,changeYear: true,
					buttonImageOnly: true,
					dateFormat: "dd MM yy",
					altField: '#untung_hide_tgl_2',
					altFormat: 'yy-mm-dd'
				}).attr("disabled", true);
			});	</script>
		<style>.ui-datepicker {font-size:10px;}	</style>
		<input type="text" id="untung_tgl_2" name="produk_tgl_2" /> 
		<input type="hidden" id="untung_hide_tgl_2" name="produk_tgl_key_2" />
	</td>
	<td><?=anchor('#',loadImg('icon/excel.png','',false,config_item('modulename'),true),array('title'=>lang('download'),'class'=>'dl_now','fors'=>'untung','url'=>'dl_list_untung'))?></td>
</tr>
</tbody>
</table>
</fieldset>

<script language="javascript">
$(function(){

	$(".dl_now").click(function(){
		var fors=$(this).attr('fors');
		var url=$(this).attr('url');
		var tgl1=$('#'+fors+'_hide_tgl_1').val();
		var tgl2=$('#'+fors+'_hide_tgl_2').val();
		if(tgl1 && tgl2){
			var url='<?=base_url().config_item('modulename').'/excel/'?>'+url+'/'+tgl1+'/'+tgl2+'<?=config_item('prefix_url')?>';
			$(this).attr('href',url);
			return true;
		}else{
			alert('<?=lang('set_tgl')?>'); 
			return false;
		}
	});
});
</script>