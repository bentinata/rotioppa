<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('bcast')?></span>
</div>
<br class="clr" />
[ <?=anchor(config_item('modulename').'/'.$this->router->class.'/input',lang('make_bcast'))?> ]<br /><br />
<table class="adminlist" cellspacing="1" style="width:100%">
<thead>
<tr>
	<th class="no">#</th>
	<th><?=lang('mail')?></th>
	<th><?=lang('antrian')?></th>
	<th><?=lang('terkirim')?></th>
	<th><?=lang('gagal')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_mail){$i=0;foreach($list_mail as $lm){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td rowspan="2"><?=$i?></td>
	<td colspan="4"><?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lm->id,$lm->subject)?></td>
	<td><b style="color:<? if($lm->proses=='1')echo'#009900';elseif($lm->proses=='2')echo'#FF0000';?>"><?=lang('proses_'.$lm->proses)?></b></td>
</tr>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td style="padding-left:30px;font-style:italic;font-size:10px;line-height:14px;">
	to: 
	<? $to=explode(',',$lm->to);foreach($to as $_to){?>
		[ <?=ucfirst($list_to[$_to])?> ]&nbsp;
	<? }?><br />
	
	Create: 
	<? 
	$create=explode(' ',$lm->date_created);
	echo format_date($create[0],'00-00-0000','-').'	'.$create[1];
	if($lm->proses=='3' && !empty($lm->date_finished)){
		$finish=explode(' ',$lm->date_finished);
		echo ' .: '.format_date($finish[0],'00-00-0000','-').'	'.$finish[1];
	}
	?>
	</td>
	<td><?=$lm->antri?></td>
	<td><?=$lm->success?></td>
	<td><?=$lm->error?></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lm->id,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lm->id,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	<? 
	if($lm->proses=='2')
		echo anchor(config_item('modulename').'/'.$this->router->class.'/proses/'.$lm->id,loadImg('icon/email_go.png','',false,config_item('modulename'),true),array('title'=>lang('proses_now')));
	elseif($lm->proses=='1')
		echo anchor(config_item('modulename').'/'.$this->router->class.'/stop/'.$lm->id,loadImg('icon/email_delete.png','',false,config_item('modulename'),true),array('title'=>lang('stop_now'),'class'=>'butstop'));
	?>
	</td>
</tr>
<? }}?>

</tbody>
<tfoot>
<tr><td colspan="6">
	<div class="pagination">
	<?=lang('bcast')?>
	</div>
</td></tr>
</tfoot>
</table>

<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_mail')?>")){
			return true;
		}
		return false;
	});
	$('.butstop').click(function(){
		if(confirm("<?=lang('sure_stop_mail')?>")){
			return true;
		}
		return false;
	});
	
});
</script>