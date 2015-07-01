<table class="adminlist" cellspacing="1">
<thead>
<tr>
    <th class="no"><?=lang('no')?></th>
    <th><?=lang('l_nama_produk')?></th>
    <th><?=lang('kat')?></th>
    <th>Aksi</th>
   
</tr>
</thead>
<tbody id="viewajax2">
<? $this->template->load_view('produk_list3',false,config_item('modulename'))?>
</tbody>
<tfoot>
<tr><td colspan="12">
    <div class="pagination">
   
    </div>
</td></tr>
</tfoot>
</table>

<script language="javascript">
$(function(){
    $("select[name='page']").val($('option:first', $("select[name='page']")).val());
	
    $('.paging').change(function(){
        var url = "<?=site_url(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/2')?>";
		alert(url);
		$.ajax({
            type: "POST",
            url: url,
            data: "start="+$(this).val()+"<?=$forajax?>",
            beforeSend: function(){
                $('#viewajax2').html($('#bigload').html());
            },
            success: function(msg){ alert(msg);
                $('#viewajax2').html(msg);
            }
        });
    });

});
</script>