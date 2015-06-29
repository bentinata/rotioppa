<? if($list_komisi){$i=$startnumber;
	foreach($list_komisi as $lk){$i++;
	?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->tgl_kom?></td>
	<td><?=currency($lk->komisi)?></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/deletekom/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	</td>
</tr>
<? }}?>

<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_kom')?>")){
			return true;
		}
		return false;
	});
});
</script>