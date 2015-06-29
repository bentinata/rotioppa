<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_vendor')?></span>
</div>
<br class="clr" />

<table class="adminlist" cellspacing="1" style="width:500px">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('vendor')?></th>
	<th><?=lang('vcode')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_kat){$i=$startnumber;foreach($list_kat as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->vendor?></td>
	<td>( <?=$lk->jml==0?$lk->jml:anchor(config_item('modulename').'/'.$this->router->class.'/vcode/'.$lk->id,$lk->jml,array('title'=>lang('list_subkat')))?> )</td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=$lk->jml==0?anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel')):''?>
	</td>
</tr>
<? }}?>
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
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_vendor')?>")){
			return true;
		}
		return false;
	});
});
</script>