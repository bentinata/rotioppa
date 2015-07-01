<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_wish')?></span>
</div>
<br class="clr" />
<p>
<? #=anchor(config_item('modulename').'/'.$this->router->class.'/input',loadImg('icon/add.png',array("style"=>"position:relative;top:5px"),false,config_item('modulename'),true),array('title'=>lang('input_kat')))?>
</p>

<table class="adminlist" cellspacing="1">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('nama')?></th>
	<th><?=lang('email')?></th>
	<th><?=lang('tgl_add')?></th>
	<th><?=lang('produk')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody id="viewajax2">
<? $this->template->load_view('wishlist2',false,config_item('modulename'))?>
</tbody>
<tfoot>
<tr><td colspan="6">
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
</td></tr>
</tfoot>
</table>

<span id="bigload" class="hide"><?=theme_img('ajax-loader-big.gif',false)?></span>
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
