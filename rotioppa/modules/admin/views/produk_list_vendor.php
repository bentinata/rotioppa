<?
$arr_filter = array(
	'0'=>' - ',
	'1'=>lang('vendor'),
	'2'=>lang('vcode')
	);
?>
<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_produk_vendor')?></span>
</div>
<br class="clr" />

<div class="cari left">
	<b><?=lang('filter_by')?></b> <?=form_dropdown('filter',$arr_filter)?> 
	<span class="hd key"><input type="text" class="in_search" name="search" />&nbsp;</span>
	<span class="hd hide vendor">
		<?=$vendor?form_dropdown('vendor',$vendor):''?>
	</span>
	<input type="submit" name="_SEARCH" value="<?=lang('search')?>" />
	<span class="load1"></span>
</div>
<div class="hide left msg_success" id="msg_search"></div>
<div class="hide left msg_error" id="msg_search2"></div>
<br class="clr" /><br />

<span class="load2"></span>
<div id="viewajax1">
<? $this->template->load_view('produk_list2_vendor',false,config_item('modulename'))?>
</div>

<span id="bigload" class="hide"><?=loadImg('ajax-loader-big.gif','',false,config_item('modulename'),true)?></span>
<span id="smalload" class="hide"><?=loadImg('ajax-loader.gif','',false,config_item('modulename'),true)?></span>

<script language="javascript">
$(function(){
	$("select[name='filter']").val($('option:first', $("select[name='filter']")).val())
	.change(function(){
		$('.hd').hide();
		if($(this).val()=='1'){ 
			$('.vendor').show();
		}else{ 
			$('.key').show();
		}
	});

	$("input[name='_SEARCH']").click(function(){
		fi=$("select[name='filter']").val();
		nxt=false;
		vars='';
		if(fi=='1'){
			ky=$("select[name='vendor']").val();
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
