<div class="box-title"><h2>Calculator</h2></div>

<fieldset class="column ckalm1 boxq boxqbg2 calc">
	<table><tr><td><?=loadImg('calc.png',false,FALSE,FALSE,TRUE)?></td>
	<td style="vertical-align:middle"></td>
	</tr></table><br /><br>
	
	<b><?=lang('hitung_bkirim')?></b><br /><br />
	<ul class="form">
		<li><label style="width:150px;"><?=lang('berat_barang')?> </label>: <input type="text" name="berat" maxlength="5" style="width:50px" /> kg.</li>
		<li><label style="width:150px;"><?=lang('lay_kirim')?> </label>: <?=form_dropdown('perusahaan_kirim',$list_persh,false,'class="persh_kirim" lang="lay_kirim" url="'.site_url($this->router->class.'/cekout/optionlkirim').'"')?></li>
		<li><label style="width:150px;"><?=lang('jen_kirim')?> </label>: <select name="lay_kirim" class="lay_kirim" lang="kota_tiki"><option value=""> - </option></select><span id="load_lay_kirim"></span></li>
		<li><label style="width:150px;"><?=lang('kota')?> </label>: <input type="text" id="query_kota" /><span id="load_kota_tiki"></span><input type="hidden" name="id_kota_hid" /></li>
		<li><label style="width:150px;">&nbsp;</label>&nbsp; <input type="button" name="_HITUNG" value="<?=lang('hitung')?>" /></li>
	</ul>
</fieldset>
<div class="clear"></div>

<br />
<div id="hasilcalc"></div>

<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>

<!-- autocomplete -->
<?=loadCss('js/jquery_ui/themes/base/jquery.ui.all.css',false,true,false,true)?>
<?=loadJs('jquery_ui/ui/jquery.ui.core.js',false,true)?>
<?=loadJs('jquery_ui/ui/jquery.ui.widget.js',false,true)?>
<?=loadJs('jquery_ui/ui/jquery.ui.position.js',false,true)?>
<?=loadJs('jquery_ui/ui/jquery.ui.autocomplete.js',false,true)?>
<style>
.ui-autocomplete {
	max-height: 100px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
	/* add padding to account for vertical scrollbar */
	padding-right: 20px;
}
/* IE 6 doesn't support max-height
* we use height instead, but this forces the menu to always be this tall
*/
* html .ui-autocomplete {
	height: 100px;
}
</style>

<script language="javascript">
$(function(){
	$(".persh_kirim").val($('option:first', $(".persh_kirim")).val());
	
	$(".persh_kirim").change(function(event,ktt){
		if(ktt) thisval=ktt;
		else thisval = $(this).val(); 
		if(thisval!='-'){
			toobj=$(this).attr('lang');
			$.ajax({
				type: "POST",
				url: $(this).attr('url'),
				data: "prov="+thisval,
				beforeSend: function(){
					$("."+toobj).hide();
					$('#load_'+toobj).html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_'+toobj).html('');
					$("."+toobj).html(msg).show();
				}
			});
		}
	});

	$("input[name='_HITUNG']").click(function(){
		kota = $("input[name='id_kota_hid']").val(); 
		idlay = $('.lay_kirim').val();
		nama_kota = $('#query_kota').val();
		berat = $("input[name='berat']").val();
		if((kota!='-' || kota!='') && berat!=''){
			$.ajax({
				type: "POST",
				url: "<?=site_url('home/getbiaya')?>",
				data: "kota="+kota+"&berat="+berat+"&nkota="+nama_kota+"&lay="+idlay,
				beforeSend: function(){
					$("#hasilcalc").html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$("#hasilcalc").html(msg);
				}
			});
		}else{
			alert('<?=lang('empty_form_calc')?>');
		}
	});

	$("select[name='lay_kirim']").change(function(){
		thisval = $(this).val(); 
		if(thisval!='-'){
			toobj=$(this).attr('lang');
			$.ajax({
				type: "POST",
				url: "<?=site_url('home/cekout/getkotabylayanan')?>",
				data: "lay="+thisval,
				beforeSend: function(){
					$('#load_'+toobj).html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_'+toobj).html('');
					var auto_cl_var = msg;
		$( "#query_kota" ).autocomplete({
			minLength: 0,
			source: auto_cl_var,
			focus: function( event, ui ) {
				$( "#query_kota" ).val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {
				$( "#query_kota" ).val( ui.item.label );
				$("input[name='id_kota_hid']").val( ui.item.value );
				return false;
			}
		});
				},
				dataType:'json'
			});
		}
	});	

// auto complete
		/*var auto_cl_var = [
			{
				label: "bandung",
				value: "bdg"
			},
			{
				label: "bandar lampung",
				value: "bl"
			},
			{
				label: "d.k.i. jakarta",
				value: "jkt"
			}
		];*/ 


})
</script>
