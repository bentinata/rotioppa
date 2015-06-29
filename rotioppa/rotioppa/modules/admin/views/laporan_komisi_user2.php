<?
foreach(config_item('kirim_komisi') as $a=>$b){
	$status_kirim[$b]=lang('status_komisi_'.$b);
}
?>
<br />
<table class="adminlist">
<thead>
<tr>
	<th class="no">#</th>
	<th><?=lang('tgl_kom')?></th>
	<th><?=lang('tot_komisi')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody id="viewajax">
<? $this->template->load_view('laporan_komisi_user3',false,config_item('modulename'))?>
</tbody>
<tfoot>
<tr>
	<td colspan="4">	
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
	</td>
</tr>
</tfoot>
</table><br />

<script language="javascript">
$(function(){
	$("select[name='page']").val($('option:first', $("select[name='page']")).val());

	$('.paging').change(function(){
		$.ajax({
			type: "POST",
			url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/2')?>",
			data: "start="+$(this).val(),
			beforeSend: function(){
				$('#viewajax').html($('#bigload').html());
			},
			success: function(msg){ //alert(msg);
				$('#viewajax').html(msg);
			}
		});
	});
	
});
</script>
