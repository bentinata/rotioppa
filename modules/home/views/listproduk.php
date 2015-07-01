	<br>
	<div class="judula">
		<?=lang('search_produk')?>
	</div>
	<div class="garis"></div>
	<br>
    <? if($list){?>
    <div id="viewajax2">
    	<? $this->template->load_view('listproduk_list',false)?>
    </div>


<div class="box-title-footer">
	<br /><br />
<center>
<div id="container">
	<div class="pagination">
	<!-- <?=$paging->Navigation('page','class="paging"',$thislink)?> -->	
	</div>
	</div>
</center>
<? }else{ ?>
<br />
<br />
<b>Barang Kosong</b>
<? }?>
</div>

<br>

<script language="javascript">
$(function(){
	
	$("select[name='page']").val($('option:first', $("select[name='page']")).val());
	
	$('.page').change(function(){
		$.ajax({
			type: "POST",
			url: "<?=site_url('home'.'/'.$this->router->class.'/'.$this->router->method.'/'.$idsub.'/'.'2')?>",
			data: "start="+$(this).val(),
			beforeSend: function(){
				$('#viewajax2').html($('#bigload').html());
			},
			success: function(msg){ //alert(msg);
				$('#viewajax2').html(msg);
			}
		});
	});
	
	$('.page').click(function(){
		var idx = $(this).attr('id');
		var lidx = $('.last').attr('id');
		var fidx = $('.first').attr('id');
		var aidx = $('.page.active').attr('id');
		$.ajax({
			type: "POST",
			url: "<?=site_url('home'.'/'.$this->router->class.'/'.$this->router->method.'/'.$idsub.'/'.'2')?>",
			data: "start="+idx,
			beforeSend: function(){
				$('#viewajax2').html($('#bigload').html());
			},
			success: function(msg){ //alert(msg);
				$('#viewajax2').html(msg);
				if(idx < eval(fidx)+1){
					$('.prev').attr("id",eval(idx));
				}else{
					$('.prev').attr("id",eval(idx)-1);
				}
				if(idx > eval(lidx)-1){
					$('.next').attr("id",eval(idx));
				}else{
					$('.next').attr("id",eval(idx)+1);
				}
				$('.'+aidx).removeClass("active");
				$('.'+aidx).addClass("gradient");
				$('.'+idx).addClass("active");
				$('.'+idx).removeClass("gradient");
			}
		});
	});

});
</script>