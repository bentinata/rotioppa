<? $i=$startnumber;foreach($list_cek as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lk->id,$lk->kode_transaksi)?></td>
	<td><?=$lk->email?></td>
	<td>Rp. <?=currency($lk->total)?></td>
	<td><?=format_date_ina($lk->tgl_cekout,'-',' ')?></td>
	<td><?=lang('cara_bayar_'.$lk->cara_bayar)?></td>
	<td><?=lang('status_bayar_'.$lk->status_bayar)?></td>
	<td><?=lang('status_kirim_'.$lk->status_kirim)?></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdelproduk'))?>
	</td>
</tr>
<? }?>

<script language="javascript">
$(function(){
	$('.butdelproduk').click(function(){ 
		if(confirm("<?=lang('sure_dell_cekout')?>")){
			return true;
		}
		return false;
	});
});
</script>