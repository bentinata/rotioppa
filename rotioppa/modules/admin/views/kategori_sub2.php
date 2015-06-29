<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_subkat2')?></span>
</div>
<br class="clr" />

<p>
<?=anchor(config_item('modulename').'/'.$this->router->class.'/subinput2',loadImg('icon/add.png',array("style"=>"position:relative;top:5px"),false,config_item('modulename'),true),array('title'=>lang('input_subkat2')))?>&nbsp;
[ <?=anchor(config_item('modulename').'/'.$this->router->class,lang('kat'))?> ]&nbsp;
[ <?=anchor(config_item('modulename').'/'.$this->router->class.'/sub',lang('subkat'))?> ]
</p>

<table class="adminlist" cellspacing="1" style="width:800px">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('kode')?></th>
	<th><?=lang('kat')?></th>
	<th><?=lang('subkat')?></th>
	<th><?=lang('subkat2')?></th>
	<th><?=lang('produk')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_sub){$i=$startnumber;foreach($list_sub as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=format_kode($lk->id)?></td>
	<td><?=$lk->kategori?></td>
	<td><?=$lk->subkategori?></td>
	<td><?=$lk->subkategori2?></td>
	<td>( <?=$lk->jml?> )</td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/subedit2/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=$lk->jml==0?anchor(config_item('modulename').'/'.$this->router->class.'/subdelete2/'.$lk->id.'/'.$lk->id_subkategori,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel')):''?>
	</td>
</tr>
<? }}else{echo '<tr><td colspan="7">'.lang('no_data').'</td></tr>';}?>
</tbody>
<tfoot>
<tr><td colspan="8">
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
</td></tr>
</tfoot>
</table>

<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_subkat2')?>")){
			return true; 
		}
		return false;
	});
});
</script>