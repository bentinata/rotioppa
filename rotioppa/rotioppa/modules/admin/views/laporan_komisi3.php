<? if($list_iklan){$i=$startnumber;
	foreach($list_iklan as $lk){
		$i++;
	?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->nama_panggilan?><br />
	<span class="note"><?=anchor(config_item('modulename').'/'.$this->router->class.'/listkomisiaff/'.$lk->id_aff,$lk->email)?></span>
	</td>
	<td><?=currency($lk->min_transfer)?></td>
	<td><?=currency($lk->komisi)?></td>
	<td style="text-align:center;">
	<? #=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<? #=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	<? if($lk->selisih>0){?><input type="checkbox" name="check_kom" value="<?=$lk->id?>" /><? }?>
	</td>
</tr>
<? }}?>

<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_biaya')?>")){
			return true;
		}
		return false;
	});
});
</script>