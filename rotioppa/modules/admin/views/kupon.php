<?
$arr_search = array('1'=>lang('email'),'2'=>lang('nama'));
$vl=isset($val)?$val:false;
$ky=isset($key)?$key:false;
$arr_jenis_kupon = lang('jenis_kupon_array');
$arr_status_kupon = lang('status_kupon_array');
?>
<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_kupon')?></span>
</div>
<br class="clr" />
<form method="post" action="">
<?=lang('add_kupon')?> <input type="text" name="val" value="<?=$vl?>" />
<input type="submit" name="_CARI" value="<?=lang('search')?>" />
</form>
<p>
<?=anchor(config_item('modulename').'/'.$this->router->class.'/input',loadImg('icon/add.png',array("style"=>"position:relative;top:5px"),false,config_item('modulename'),true),array('title'=>lang('input_kupon')))?>
<?=lang('input_kupon')?>
</p>

<table class="adminlist" cellspacing="1">
<thead>
<tr>
	<th class="no">#</th>
	<th><?=lang('kode_kupon')?></th>
	<th><?=lang('jenis_kupon')?></th>
	<th><?=lang('nilai_kupon')?></th>
	<th><?=lang('tgl_awal')?></th>
	<th><?=lang('tgl_akhir')?></th>
	<th><?=lang('status_kupon')?></th>	
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($kupon){$i=$startnumber;foreach($kupon as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->kode_kupon?></td>
	<td><?=$arr_jenis_kupon[$lk->jenis_kupon]?></td>
	<td><?=currency($lk->nilai_kupon)?></td>	
	<td><?=format_date_ina($lk->tgl_awal,'-',' ')?></td>
	<td><?=format_date_ina($lk->tgl_akhir,'-',' ')?></td>
	<td><?=$arr_status_kupon[$lk->status_kupon]?></td>	
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/detail/'.$lk->id_kupon,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id_kupon,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	</td>
</tr>
<? }}else{?><tr><td colspan="6"><?=lang('no_data')?></td></tr><? }?>
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
		if(confirm("<?=lang('sure_dell_kupon')?>")){
			return true;
		}
		return false;
	});
});
</script>