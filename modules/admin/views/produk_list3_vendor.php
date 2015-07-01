<? if($list_produk){$i=$startnumber;foreach($list_produk as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->vendor?></td>
	<td><?=$lk->vcode?></td>
	<td><?=anchor(config_item('modulename').'/'.$this->router->class.'/index/false/'.$lk->id,$lk->jml_produk)?></td>
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