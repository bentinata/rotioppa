<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_artikel')?></span>
</div>
<br class="clr" />
[<a href="<?=site_url(config_item('modulename').'/'.$this->router->class.'/input')?>">Tambah Artikel</a>]
<table class="adminlist" cellspacing="1" style="width:100%">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('artikel')?></th>
	<th style="width:50px;">&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_info){$i=$startnumber;foreach($list_info as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->title?></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	</td>
</tr>
<? }}?>
</tbody>
<tfoot>
<tr><td colspan="3">
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
</td></tr>
</tfoot>
</table>

<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_artikel')?>")){
			return true;
		}
		return false;
	});
});
</script>