<? if($list_wish){$i=$startnumber;foreach($list_wish as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->nama?></td>
	<td><?=$lk->email?></td>
	<td><?=$lk->tgl_add?></td>
	<td><?=anchor(config_item('modulename').'/produk/edit/'.$lk->id,$lk->nama_produk,array('title'=>lang('produk_detail')))?></td>
	<td><?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdelwish'))?></td>
</tr>
<? }}?>
<script language="javascript">
$(function(){
	$('.butdelwish').click(function(){
		if(confirm("<?=lang('sure_dell_wish')?>")){
			return true;
		}
		return false;
	});
});
</script>
