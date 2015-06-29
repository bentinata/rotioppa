<?
$arr_search = array('1'=>lang('email'),'2'=>lang('nama'));
$vl=isset($val)?$val:false;
$ky=isset($key)?$key:false;
foreach(config_item('kirim_komisi') as $a=>$b){
	$status_kirim[$b]=lang('status_komisi_'.$b);
}
?>
<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_aff')?></span>
</div>
<br class="clr" />
<form method="post" action="">
<?=lang('search')?> <?=form_dropdown('key',$arr_search,$ky)?> <input type="text" name="val" value="<?=$vl?>" />
<input type="submit" name="_CARI" value="<?=lang('search')?>" /><br /><br />
</form>
<table class="adminlist" cellspacing="1">
<thead>
<tr>
	<th class="no">#</th>
	<th><?=lang('email')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/1/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/1/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><?=lang('nama')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/2/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/2/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><?=lang('tgl_sign')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/3/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/3/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><?=lang('no_tlp')?></th>
	<th><?=lang('min_transfer')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/4/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/4/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><?=lang('tot_komisi')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/5/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/5/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><input type="checkbox" class="check_all" /></th>
</tr>
</thead>
<tbody>
<? if($cust){$i=$startnumber;foreach($cust as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->email?></td>
	<td><?=$lk->nama_lengkap?></td>
	<td><?=format_date_ina($lk->daftar,'-',' ')?></td>
	<td><?=$lk->no_tlp?></td>
	<td><?=currency($lk->min_transfer)?></td>
	<td><?=currency($lk->komisi)?></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/detail/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	<? if($lk->selisih>0){?><input type="checkbox" name="check_kom" value="<?=$lk->id_komisi?>" /><? }?>
	</td>
</tr>
<? }}else{?><tr><td colspan="6"><?=lang('no_data')?></td></tr><? }?>
</tbody>
<tfoot>
<tr><td colspan="9">
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
</td></tr>
</tfoot>
</table>
<br />
<div style="text-align:right">
<?=lang('update_has_checked').' '.form_dropdown('change_to',$status_kirim,false,'style="display:none"').lang('has_transfer')?> &nbsp;
<input type="button" name="_UPDATE" value="<?=lang('go')?>" />
<span id="load_update"></span>
</div>

<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_aff')?>")){
			return true;
		}
		return false;
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
				url: "<?=site_url(ci()->module.'/komisi/transferkomisi')?>",
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