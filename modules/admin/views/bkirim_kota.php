<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_kota')?></span>
</div>
<br class="clr" />

<table class="adminlist" cellspacing="1" style="width:500px">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('prop')?></th>
	<th><?=lang('kota')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_kota){$i=$startnumber;foreach($list_kota as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->provinsi?></td>
	<td><?=$lk->kota?></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/editkota/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/deletekota/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	</td>
</tr>
<? }}?>
</tbody>
<tfoot>
<tr><td colspan="6">
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
</td></tr>
</tfoot>
</table>

<script language="javascript">
$(function(){
	$('.butdel-').click(function(){
		if(confirm("<?=lang('sure_dell_biaya')?>")){
			return true;
		}
		return false;
	});
});
</script>