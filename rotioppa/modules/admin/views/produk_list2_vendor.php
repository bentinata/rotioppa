<? if($list_produk){?>
<table class="adminlist" cellspacing="1" style="width:500px">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('vendor')?></th>
	<th><?=lang('vcode')?></th>
	<th><?=lang('jml_produk')?></th>
</tr>
</thead>
<tbody id="viewajax2">
<? $this->template->load_view('produk_list3_vendor',false,config_item('modulename'))?>
</tbody>
<tfoot>
<tr><td colspan="4">
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
</td></tr>
</tfoot>
</table>

<script language="javascript">
$(function(){
	$("select[name='page']").val($('option:first', $("select[name='page']")).val());

	$('.paging').change(function(){
		$.ajax({
			type: "POST",
			url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/2')?>",
			data: "<?=$for_paging?>start="+$(this).val(),
			beforeSend: function(){
				$('#viewajax2').html($('#bigload').html());
			},
			success: function(msg){ //alert(msg);
				$('#viewajax2').html(msg);
			}
		});
	});

});
</script>
<? }?>
