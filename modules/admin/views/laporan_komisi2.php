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
	<th><?=lang('aff')?></th>
	<th><?=lang('min_transfer')?></th>
	<th><?=lang('tot_komisi')?></th>
	<th><input type="checkbox" class="check_all" /></th>
</tr>
</thead>
<tbody id="viewajax">
<? $this->template->load_view('laporan_komisi3',false,config_item('modulename'))?>
</tbody>
<tfoot>
<tr>
	<td colspan="5">	
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
	</td>
</tr>
</tfoot>
</table><br />
<div style="text-align:right">
<?=lang('update_has_checked').' '.form_dropdown('change_to',$status_kirim,false,'style="display:none"').lang('has_transfer')?> &nbsp;
<input type="button" name="_UPDATE" value="<?=lang('go')?>" />
<span id="load_update"></span>
</div>

<script language="javascript">
$(function(){
	$("select[name='page']").val($('option:first', $("select[name='page']")).val());

	$('.paging').change(function(){
		$.ajax({
			type: "POST",
			url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/2')?>",
			data: "start="+$(this).val()+"&<?=$forajax?>",
			beforeSend: function(){
				$('#viewajax').html($('#bigload').html());
			},
			success: function(msg){ //alert(msg);
				$('#viewajax').html(msg);
			}
		});
	});
	
	$('.check_all').click(function(){
		if($(this).is(':checked'))
			$("input[name='check_kom']").attr('checked',true);
		else
			$("input[name='check_kom']").attr('checked',false);
	});

	$("input[name='_UPDATE']").click(function(){
		if($("input[name='check_kom']").is(':checked')){
			var ids=Array();
			$("input[name='check_kom']:checked").each(function(i){
				ids[i]=$(this).val();
			});
			id=ids.join('-'); //alert(ids);
			$.ajax({
				type: "POST",
				url: "<?=site_url($this->router->module.'/'.$this->router->class.'/transferkomisi')?>",
				data: "id="+id+"&status="+$("select[name='change_to']").val(),
				beforeSend: function(){
					$('#load_update').html($('#smallload').html()).show();
				},
				success: function(msg){ //alert(msg);
					$('#load_update').html(msg).fadeOut(5000);
					$("input[name='check_kom']:checked").remove();
				}
			});
		}else{
			alert('<?=lang('check_the_one')?>');
		}
	});
});
</script>
