<?
echo loadJs('rating/rating.js',false,true);
echo loadCss('js/rating/rating.css',false,true,false,true);
?>
<br>
	<div class="judul">
		<?=lang('search_produk')?>
	</div>
	<div class="garis"></div>
	<br>
<div id="wrap_wrap_collect">
	<ul>

<? if($list){?>
<? $this->template->load_view('search_list',false,ci()->module)?>
	</ul>
    </dev>

<br /><br />
<center>
	<div class="pagination">
	<?=$paging->Navigation('page','class="paging"',$thislink)?> <?=lang('from').' '.$paging->total_page.', '.lang('total').' '.$paging->total.' '.lang('item')?>
	</div>
</center>

<? }else{?>
<br />
<br />
<b><?=lang('no_data_search')?> <span class="tag-search"><?=$key?></span></b>
<? }?>

<script language="javascript">
$(function(){
	$("select[name='page']").val($('option:first', $("select[name='page']")).val());

	$('.paging').change(function(){
		$.ajax({
			type: "POST",
			url: "<?=site_url(ci()->module.'/'.ci()->method.$urlget)?>",
			data: "start="+$(this).val()+"<?=$postdata?>",
			beforeSend: function(){
				$('#viewajax2').html($('#bigload').html());
			},
			success: function(msg){ //alert(msg);
				$('#viewajax2').html(msg);
			}
		});
		return false;
	});

});
</script>
