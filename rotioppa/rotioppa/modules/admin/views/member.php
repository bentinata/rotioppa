<?
$arr_search = array('1'=>lang('email'),'2'=>lang('nama'));
$vl=isset($val)?$val:false;
$ky=isset($key)?$key:false;
?>
<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_member')?></span>
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
	?>
	</th>
	<th><?=lang('tgl_sign')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/3/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/3/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><?=lang('no_tlp')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/4/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/4/d',
		loadImg('icon/down.png','',false,config_item('modulename'),true))
	?></th>
	<th><?=lang('status_member')
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/5/a',
		loadImg('icon/up.png','',false,config_item('modulename'),true))
	.anchor(config_item('modulename').'/'.$this->router->class.'/'.$this->router->method.'/5/d',
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
	<td><?=$lk->nama_lengkap?></td>
	<td><?=format_date_ina($lk->daftar,'-',' ')?></td>
	<td><?=$lk->no_tlp?></td>
	<td><?=lang('status_member_'.$lk->status)?></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/detail/'.$lk->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lk->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	<?=$lk->status!='1'?'<a href="javascript:void(0)" title="'.lang('aktivasi').'" class="aktivasi" ids="'.$lk->id.'" id="'.$lk->id.'">'.loadImg('icon/email_go.png','',false,config_item('modulename'),true).'</a>':''?>
	<?=$lk->status!='1'?'<a href="javascript:void(0)" title="'.lang('aktivasi_just_mail').'" class="aktivasi_mail" ids="'.$lk->id.'">'.loadImg('icon/email_delete.png','',false,config_item('modulename'),true).'</a>':''?>
	<span id="load_<?=$lk->id?>"></span>
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

<span id="smallload" class="hide"><?=loadImg('ajax-loader.gif','',false,ci()->module)?></span>
<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_member')?>")){
			return true;
		}
		return false;
	});
	$('.aktivasi').click(function(){
		if(confirm("<?=lang('sure_to_aktivate')?>")){
		var ids=$(this).attr('ids');
		$.ajax({
			type: "POST",
			url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/aktivasi')?>",
			data: "id="+ids,
			beforeSend: function(){
				$('#load_'+ids).html($('#smallload').html());
			},
			success: function(msg){ //alert(msg);
				$('#load_'+ids).html(msg);
				$('#'+ids).hide();
			}
		});
		}
		return false;
	});
	$('.aktivasi_mail').click(function(){
		if(confirm("<?=lang('sure_to_aktivate_mail')?>")){
		var ids=$(this).attr('ids');
		$.ajax({
			type: "POST",
			url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/aktivasi_just_mail')?>",
			data: "id="+ids,
			beforeSend: function(){
				$('#load_'+ids).html($('#smallload').html());
			},
			success: function(msg){ //alert(msg);
				$('#load_'+ids).html(msg);
			}
		});
		}
		return false;
	});
});
</script>