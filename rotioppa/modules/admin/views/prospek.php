<?
$arr_search = array('1'=>lang('email'),'2'=>lang('nama'));
$vl=isset($val)?$val:false;
$ky=isset($key)?$key:false;
?>
<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_pros')?></span>
</div>
<br class="clr" />
<form method="post" action="">
<?=lang('search')?> <?=form_dropdown('key',$arr_search,$ky)?> <input type="text" name="val" value="<?=$vl?>" />
<input type="submit" name="_CARI" value="<?=lang('search')?>" /><br /><br />
</form>
<table class="adminlist" cellspacing="1">
<thead>
<tr>
	<th class="no">#</th>
	<th><?=lang('email')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/1/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/1/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><?=lang('nama')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/2/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/2/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><?=lang('tgl_sign')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/3/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/3/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><?=lang('tgl_valid')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/4/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/4/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($cust){$i=$startnumber;foreach($cust as $lk){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=$lk->email?></td>
	<td><?=$lk->nama?></td>
	<td><?=format_date_ina($lk->tgl_daftar,'-',' ')?></td>
	<td><?=format_date_ina($lk->tgl_valid,'-',' ')?></td>
	<td>
	<? #=anchor(config_item('modulename').'/'.$this->router->class.'/detail/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	</td>
</tr>
<? }}else{?><tr><td colspan="6"><?=lang('no_data')?></td></tr><? }?>
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
		if(confirm("<?=lang('sure_dell_member')?>")){
			return true;
		}
		return false;
	});
});
</script>