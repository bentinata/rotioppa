<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_layanan')?></span>
</div>
<br class="clr" />

<?=anchor(config_item('modulename').'/'.$this->router->class.'/addlayanan',loadImg('icon/add.png','',false,config_item('modulename'),true),array('title'=>lang('add_layanan')))?>
<table class="adminlist" cellspacing="1" style="width:500px">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('perusahaan_layanan')?></th>
	<th><?=lang('layanan')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_layanan){$i=$startnumber;foreach($list_layanan as $idp=>$lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk['nama_perusahaan']?></td>
	<td><ul style="padding:0;">
	<? foreach($lk['layanan'] as $ly){?><li><?=$ly?></li><? }?>
	</ul></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/editlayanan/'.$idp,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/deletelayanan/'.$idp,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	</td>
</tr>
<? }}?>
</tbody>
<tfoot>
<tr><td colspan="7">
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
</td></tr>
</tfoot>
</table>

<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_layanan')?>")){
			return true;
		}
		return false;
	});
});
</script>