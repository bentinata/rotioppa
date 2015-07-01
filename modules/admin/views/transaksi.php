<?
$arr_filter = array(
	'0'=>' - ',
	'1'=>lang('email'),
	'2'=>lang('harga'),
	'3'=>lang('is_bayar'),
	'4'=>lang('is_kirim'),
	'5'=>lang('tgl_cekout'),
	'6'=>lang('cara_bayar')
	);
$arr_bayar = array(
	'1'=>lang('status_bayar_1'),
	'2'=>lang('status_bayar_2')
);
$arr_kirim = array(
	'1'=>lang('status_kirim_1'),
	'2'=>lang('status_kirim_2'),
	'3'=>lang('status_kirim_3')
);
$arr_cara = array(
	'1'=>lang('cara_bayar_1'),
	'2'=>lang('cara_bayar_2')
);

?>
<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_trans')?></span>
</div>
<br class="clr" />

<div class="cari left">
	<b><?=lang('filter_by')?></b> <?=form_dropdown('filter',$arr_filter)?> 
	<span class="hide key"><input type="text" class="in_search" name="search" />&nbsp;</span>
	<span class="hide bayar"><?=form_dropdown('is_bayar',$arr_bayar)?></span>
	<span class="hide kirim"><?=form_dropdown('is_kirim',$arr_kirim)?></span>
	<span class="hide cara"><?=form_dropdown('is_cara',$arr_cara)?></span>
	<span class="hide tgl">
			<?=loadCss('js/calendar/theme/redmond/ui.all.css',false,true,false,true)?>
			<?=loadJs('calendar/ui/ui.core.js',false,true)?>
			<?=loadJs('calendar/ui/ui.datepicker.js',false,true)?>
			<?=loadJs('calendar/ui/ui.datepicker-id.js',false,true)?>
			<script type="text/javascript">
				$(function() {
					$("#dp_tgl").datepicker({
						showOn: "button",
						buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
						changeMonth: true,changeYear: true,
						buttonImageOnly: true,
						dateFormat: "dd MM yy",
						altField: '#tgl_hide', 
						altFormat: 'yy-mm-dd'
					}).attr("disabled", true);
				});	</script>
			<style>.ui-datepicker {font-size:10px;}	</style>
			<input type="text" name="tgl" id="dp_tgl" /> 
			<input type="hidden" id="tgl_hide" name="tgl_key" />
			&nbsp;
			<script type="text/javascript">
				$(function() {
					$("#dp_tgl2").datepicker({
						showOn: "button",
						buttonImage: "<?=loadImg('js/calendar/calendar.gif','',true,false,true,true)?>",
						changeMonth: true,changeYear: true,
						buttonImageOnly: true,
						dateFormat: "dd MM yy",
						altField: '#tgl2_hide', 
						altFormat: 'yy-mm-dd'
					}).attr("disabled", true);
				});	</script>
			<style>.ui-datepicker {font-size:10px;}	</style>
			<input type="text" name="tgl2" id="dp_tgl2" /> 
			<input type="hidden" id="tgl2_hide" name="tgl2_key" />&nbsp;
	</span>
	<input type="submit" name="_SEARCH" value="<?=lang('search')?>" />
	<span class="load1"></span>
</div>
<div class="hide left msg_success" id="msg_search"></div>
<br class="clr" /><br />

<span class="load2"></span>
<div id="viewajax1">
<? $this->template->load_view('transaksi2',false,config_item('modulename'))?>
</div>

<span id="bigload" class="hide"><?=loadImg('ajax-loader-big.gif','',false,config_item('modulename'),true)?></span>
<span id="smalload" class="hide"><?=loadImg('ajax-loader.gif','',false,config_item('modulename'),true)?></span>

<script language="javascript">
$(function(){
	$('.key','.cari').show(); 
	$("select[name='filter']").val($('option:first', $("select[name='filter']")).val())
	.change(function(){
		$("input[name='search']").val('');
		var par=$('.cari');
		if($(this).val()=='5'){ 
			$('.hide',par).hide(); 
			$('.tgl',par).show();
		}else if($(this).val()=='4'){ 
			$('.hide',par).hide(); 
			$('.kirim',par).show();
		}else if($(this).val()=='3'){ 
			$('.hide',par).hide(); 
			$('.bayar',par).show();
		}else if($(this).val()=='6'){ 
			$('.hide',par).hide(); 
			$('.cara',par).show();
		}else{
			$('.hide',par).hide(); 
			$('.key',par).show();
		}
	});
	
	$("input[name='_SEARCH']").click(function(){
		fi=$("select[name='filter']").val();
		nxt=false;
		vars='';
		if(fi=='5'){
			t1=$("#tgl_hide").val();
			t2=$("#tgl2_hide").val();
			if(t1!='' && t2!=''){ 
				nxt=true;
				vars='&tgl1='+t1+'&tgl2='+t2;
			}
		}else if(fi=='3'){
			nxt=true;
			vars='&search='+$("select[name='is_bayar']").val();
		}else if(fi=='4'){
			nxt=true;
			vars='&search='+$("select[name='is_kirim']").val();
		}else if(fi=='6'){
			nxt=true;
			vars='&search='+$("select[name='is_cara']").val();
		}else{
			ky=$("input[name='search']").val();
			if(ky!=''){ 
				nxt=true;
				vars='&search='+ky;
			}
		}
		if(nxt && fi!='0'){
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/1')?>",
				data: "filter="+fi+vars,
				beforeSend: function(){
					$('#msg_search').hide();
					$('#msg_search2').hide();
					$('#viewajax1').hide();
					$('.load2').html($('#bigload').html());
					$('.load1').html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('.load1').html('');
					$('.load2').html('');
					$('#msg_search').html(msg.msg).fadeIn();
					$('#viewajax1').html(msg.view).fadeIn();
				},
				dataType: "json"
			});
		}else
			alert('<?=lang('keyword_must_fill')?>');
	});

});
</script>