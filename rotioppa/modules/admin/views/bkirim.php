<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_biaya')?></span>
</div>
<br class="clr" />

<table class="adminlist" cellspacing="1" style="width:600px">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('prop')?></th>
	<th><?=lang('kota')?></th>
	<th><?=lang('layanan')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_biaya){$i=$startnumber;foreach($list_biaya as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->provinsi?></td>
	<td><?=$lk->kota?></td>
	<td style="padding:0;">
		<? if($lk->biaya){?>
		<table style="margin:0;">
		<? foreach($lk->biaya as $_biaya){?>
		<tr>
			<td style="vertical-align:top;"><?=$_biaya['perusahaan']?></td>
			<td style="background-color:#efefef;">
			<ul style="margin:0;padding:0;">
				<? foreach($_biaya['layanan'] as $_layanan){?>
				<li style="list-style:none"><?=$_layanan['nama_layanan']?> ( Rp <?=$_layanan['biaya']?> )</li>
				<? }?>
			</ul>
			</td>
		</tr> <? }?>
		</table> <? }?>
	</td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	</td>
</tr>
<? }}?>
</tbody>
<tfoot>
<tr><td colspan="5">
	<div class="pagination">
	<?=lang('page')?> <?=$paging->LimitBox('page','class="paging"',$thislink)?> <?=lang('from')?> <?=$paging->total_page?>
	</div>
</td></tr>
</tfoot>
</table>

<? /*
<table class="adminlist" cellspacing="1" style="width:600px">
<thead>
<tr>
	<th class="no"><?=lang('no')?></th>
	<th><?=lang('prop')?></th>
	<th><?=lang('kota')?></th>
	<th><?=lang('biaya')?></th>
	<th>Biaya Elexmedia</th>
	<th><?=lang('lama_kirim')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_biaya){$i=$startnumber;foreach($list_biaya as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->provinsi?></td>
	<td><?=$lk->kota?></td>
	<td>Rp. <?=currency($lk->regular)?></td>
	<td>Rp. <?=currency(($lk->regular+config_item('bkirim_elexmedia')))?></td>
	<td><?=$lk->lama_kirim!=''?$lk->lama_kirim:'...';echo' '.lang('day')?></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
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
*/?>

<script language="javascript">
$(function(){
	$('.butdel-').click(function(){
		if(confirm("<?=lang('sure_dell_biaya')?>")){
			return true;
		}
		return false;
	});
});
</script>