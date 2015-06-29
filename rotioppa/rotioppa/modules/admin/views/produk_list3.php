<? if($list_produk){$i=$startnumber;foreach($list_produk as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->menu?></td>
	<?if($lk->kategoriID==1){?>
	<td>Sweet Oppa</td>
	<?}else if($lk->kategoriID==2){?>
	<td>Salty Oppa</td>

	<?}else{?>
	<td>Beverages</td>

	<?}?>
	<td>
	<?=anchor($this->module.'/'.$this->router->class.'/edit/'.$lk->menuid,loadImgThem('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor($this->module.'/'.$this->router->class.'/delete/'.$lk->menuid,loadImgThem('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdelproduk'))?>
	</td>
</tr>
<? }}?>

<script language="javascript">
$(function(){
	$('.butdelproduk').click(function(){ 
		if(confirm("<?=lang('sure_dell_produk')?>")){
			return true;
		}
		return false;
	});
});
</script>