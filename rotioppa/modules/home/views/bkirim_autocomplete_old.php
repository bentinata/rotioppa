<?=loadImg('calculator-shipping.jpg',false,FALSE,FALSE,TRUE)?>
<br />
<br />

<fieldset class="column ckalm1 boxq boxqbg2">
	<table><tr><td><?=loadImg('calc.png',false,FALSE,FALSE,TRUE)?></td>
	<td style="vertical-align:middle"></td>
	</tr></table><br /><br>
	
	<b><?=lang('hitung_bkirim')?></b><br /><br />
	<ul class="form">
		<li><label style="width:150px;"><?=lang('berat_barang')?> </label>: <input type="text" name="berat" maxlength="5" style="width:50px" /> kg.</li>
		<li><label style="width:150px;"><?=lang('lay_kirim')?> </label>: <?=form_dropdown('perusahaan_kirim',$list_persh,false,'class="persh_kirim" lang="lay_kirim" url="'.site_url($this->router->class.'/cekout/optionlkirim').'"')?></li>
		<li><label style="width:150px;"><?=lang('jen_kirim')?> </label>: <select name="lay_kirim" class="lay_kirim" lang="kota_tiki"><option value=""> - </option></select><span id="load_lay_kirim"></span></li>
		<li><label style="width:150px;"><?=lang('kota')?> </label>: <input type="text" name="q" id="query" /><select style="display:none;" class="kota_tiki" name="kota_tiki" ><option value=""> - </option></select><span id="load_kota_tiki"></span>
<input type="hidden" name="id_kota_hid" />
</li>
		<li><label style="width:150px;">&nbsp;</label>&nbsp; <input type="button" name="_HITUNG" value="<?=lang('hitung')?>" /></li>
	</ul>
</fieldset>
<div class="clear"></div>

<br />
<div id="hasilcalc"></div>

<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<!-- autocomplete -->
<?=loadJs('autocomplete/jquery.autocomplete.js',false,true)?>
<?=loadCss('js/autocomplete/styles.css',false,true,false,true)?>

<script language="javascript">
$(function(){
	$(".persh_kirim").val($('option:first', $(".persh_kirim")).val());
	
	/*$(".prov_tiki").change(function(event,ktt){
		if(ktt) thisval=ktt;
		else thisval = $(this).val(); 
		if(thisval!='-'){
			toobj=$(this).attr('lang');
			$.ajax({
				type: "POST",
				url: "<? //=site_url(config_item('modulename').'/cekout/optionkota')?>",
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
	});*/

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
		nama_kota = $('option:selected', $(".kota_tiki")).html();
		berat = $("input[name='berat']").val();
		if((kota!='-' || kota!='') && berat!=''){
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/getbiaya')?>",
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
				url: "<?=site_url(config_item('modulename').'/cekout/getkotabylayanan')?>",
				data: "lay="+thisval,
				beforeSend: function(){
					$('#load_'+toobj).html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_'+toobj).html('');
					$("select[name='kota_tiki']").html(msg.res);
					a2.setOptions({ lookup: msg.val.split(',') });
				},
				dataType:'json'
			});
		}
	});	// input and keep selected
	var a2 = $('#query').autocomplete({
		lookup: '',
		onSelect: function (value, data){ //alert(value);
			//$("select[name='kota_tiki'] option:contains("+value+")").attr("selected", true); //alert($('.kota_tiki').val());
			//$("select[name='kota_tiki']").find("option:contains('"+value+"')").attr("selected", "selected");
$("select[name='kota_tiki'] option:contains("+value+")").each(function(idx){
	if($(this).text()==value){
		$(this).attr("selected", true); //alert($(this).text());
	}
});
			var oo = $("select[name='kota_tiki']").val(); //alert(oo);
			$("input[name='id_kota_hid']").val(oo);
		}
	});

})
</script>
