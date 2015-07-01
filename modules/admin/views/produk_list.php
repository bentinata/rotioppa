
<div class="header">
	<?=loadImgThem('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_produk').' ';?></span>
</div>
<br class="clr" />

<div class="cari left">
	
	<span class="load1"></span>
</div>
<?=anchor(config_item('modulename').'/'.$this->router->class.'/input',loadImg('icon/add.png',array("style"=>"position:relative;top:5px"),false,config_item('modulename'),true),array('title'=>"input produk"))?>

<br class="clr" /><br />

<span class="load2"></span>
<div id="viewajax1">
<? $this->template->load_view('produk_list2',false,config_item('modulename'))?>
</div>

<span id="bigload" class="hide"><?=loadImgThem('ajax-loader-big.gif','',false,config_item('modulename'),true)?></span>
<span id="smalload" class="hide"><?=loadImgThem('ajax-loader.gif','',false,config_item('modulename'),true)?></span>

<!-- autocomplete -->
<?=loadJs('autocomplete/jquery.autocomplete.js',false,true)?>
<?=loadCss('js/autocomplete/styles.css',false,true,false,true)?>

<script language="javascript">
$(function(){
	$("select[name='kat']").val($('option:first', $("select[name='kat']")).val());
	$("select[name='vendor']").val($('option:first', $("select[name='vendor']")).val());
	$("select[name='filter']").val(7)
	.change(function(){
		$('.hd').hide();
		if($(this).val()=='5'){ 
			$('.tgl').show();
		}else if($(this).val()=='3'){ 
			$('.kat').show();
		}else if($(this).val()=='7'){ 
			$('.vendor').show();
		}else{ 
			$('.key').show();
		}
	});

	$("select[name='kat']").change(function(event,kt){
		if(kt) thisval=kt;
		else thisval = $(this).val();
		if(thisval!='-'){
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionsubkat')?>",
				data: "kat="+thisval,
				beforeSend: function(){
					$("select[name='subkat']").hide();
					$('#load_subkat').html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_subkat').html('');
					$("select[name='subkat']").html(msg).show();
				}
			});
		}
	});
	$("select[name='vendor']").change(function(event,kt){
		if(kt) thisval=kt;
		else thisval = $(this).val();
		if(thisval!='-'){
			$.ajax({
				type: "POST",
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionvcode')?>",
				data: "vendor="+thisval,
				beforeSend: function(){
					$("select[name='vcode']").hide();
					$('#load_vcode').html($('#smalload').html());
				},
				success: function(msg){ //alert(msg);
					$('#load_vcode').html('');
					$("select[name='vcode']").html(msg.res).show();
					a2.setOptions({ lookup: msg.val.split(',') });
				},
				dataType:'json'
			});
		}
	});
	// input and keep selected
	var a2 = $('#query').autocomplete({
		lookup: '',
		onSelect: function (value, data){ 
			$("select[name='vcode'] option:contains("+value+")").attr("selected", true);
			var ids=$("select[name='vcode'] option:contains("+value+")").val();
			$("select[name='vcode']").trigger('change',[ids]);
		}
	});
	
	$("input[name='_SEARCH']").click(function(){
		fi=$("select[name='filter']").val();
		nxt=false;
		vars='';
		if(fi=='5'){
			t1=$("#tgl_hide").val();
			t2=$("#tgl2_hide").val();
			ords=$("select[name='order']").val();
			if(t1!='' && t2!=''){ 
				nxt=true;
				vars='&tgl1='+t1+'&tgl2='+t2+'&ord='+ords;
			}
		}else if(fi=='3'){
			ky=$("select[name='subkat']").val();
			if(ky!='-'){ 
				nxt=true;
				vars='&search='+ky;
			}
		}else if(fi=='7'){
			ky=$("select[name='vcode']").val();
			if(ky!='-'){ 
				nxt=true;
				vars='&search='+ky;
			}
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
				url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/1'.$ivd)?>",
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
					if(msg.err!=''){ 
						$('#msg_search2').html(msg.err).fadeIn();
						$('#viewajax1').fadeIn();
					}else{
						$('#msg_search').html(msg.msg).fadeIn();
						$('#viewajax1').html(msg.view).fadeIn();
					}
				},
				dataType: "json"
			});
		}else
			alert('<?=lang('keyword_must_fill')?>');
	});

});
</script>
