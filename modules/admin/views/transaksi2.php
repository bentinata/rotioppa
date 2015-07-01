<? if($list_cek){?>
<table class="adminlist" cellspacing="1">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('trans_code')?></th>
	<th><?=lang('email')?></th>
	<th><?=lang('harga')?></th>
	<th><?=lang('tgl_cekout')?></th>
	<th><?=lang('cara_bayar')?></th>
	<th><?=lang('is_bayar')?></th>
	<th><?=lang('is_kirim')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody id="viewajax2">
<? $this->template->load_view('transaksi3',false,config_item('modulename'))?>
</tbody>
<tfoot>
<tr><td colspan="9">
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
			data: "start="+$(this).val(),
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