<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_vcode')?></span>
</div>
<br class="clr" />

<? /*<p>[ <?=anchor(config_item('modulename').'/'.$this->router->class,lang('vendor'))?> ]</p>*/?>

<table class="adminlist" cellspacing="1" style="width:700px">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('vendor')?></th>
	<th><?=lang('vcode')?></th>
	<th><?=lang('produk')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_sub){$i=$startnumber;foreach($list_sub as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->vendor?></td>
	<td><?=$lk->kode_produk_vendor?></td>
	<td>( <?=$lk->jml?> )</td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/vcodeedit/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=$lk->jml==0?anchor(config_item('modulename').'/'.$this->router->class.'/vcodedelete/'.$lk->id.'/'.$lk->id_vendor,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel')):''?>
	</td>
</tr>
<? }}else{echo '<tr><td colspan="5">'.lang('no_data').'</td></tr>';}?>
</tbody>
<tfoot>
<tr><td colspan="5">
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
</td></tr>
</tfoot>
</table>

<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_vcode')?>")){
			return true; 
		}
		return false;
	});
});
</script>