	<div class="judul">
		KALKULATOR SHIPPING
	</div>
	<div class="garis"></div>
<br><br>
<div align="center">
<div class="calc_ship">
						<div class="head">
							Hitung Biaya Pengiriman Ke Kotamu
						</div>
						<div class="form-input">
							<?=form_open('home/addsubscribe',array('id'=>'iform'))?>
								<table class="tbl" border="0">
									<tr>
										<td rowspan="6" width="20"><img src="<?=theme_img('calc.png',false)?>"></td>
									</tr>
									<tr>
										<td width="120"><?=lang('iberat')?></td>
										<td>:</td>
										<td>
											<input type="text" class="tinput" name="berat" maxlength="5" style="width:50px" />
										</td>
									</tr>
									<tr>
										<td><?=lang('ilayanan_pengriman')?></td>	
										<td>:</td>	
										<td>
											<?=form_dropdown('perusahaan_kirim',$list_persh,false,'class="persh_kirim" lang="lay_kirim" url="'.site_url($this->router->class.'/cekout/optionlkirim').'"')?>
										</td>
									</tr>
									<tr>
										<td><?=lang('ijenis_pengiriman')?></td>	
										<td>:</td>
										<td>
											<select name="lay_kirim" class="lay_kirim" lang="kota_tiki"><option value=""> - </option></select>
										</td>
									</tr>
									<tr>
										<td><?=lang('ikota')?></td>	
										<td>:</td>
										<td>
											<input type="text" id="query_kota" /><span id="load_kota_tiki"></span><input type="hidden" name="id_kota_hid" />
										</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>
											<input type="button" name="_HITUNG" value="<?=lang('hitung')?>" />
										</td>
									</tr>
								</table>
								<?=form_close()?>
						</div>
					<br>
				</div>	
				</div>	
				<div class="clear"></div>

<br />
<div id="hasilcalc"></div>

<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>

<!-- autocomplete -->
<?=loadCss('js/jquery-ui/jquery-ui.css',false,true,false,true)?>
<?=loadJs('jquery-ui/jquery-ui.js',false,true)?>
<style type="text/css">
.ui-autocomplete {
	max-height: 100px;
	overflow-y: auto;
	overflow-x: hidden;
	padding-right: 20px;
	background-color:#fff !important;
}
.ui-autocomplete li{
	background-color:#fff !important;
}
 IE 6 doesn't support max-height
* we use height instead, but this forces the menu to always be this tall

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
