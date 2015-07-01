<?
$status_mail_array=lang('status_mail_array');
$type_email_array = lang('type_mail_array'); 
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('list_fu')?></span>
</div>
<br class="clr" />
[ <?=anchor(config_item('modulename').'/'.$this->router->class.'/input',lang('make_fu'))?> ]<br /><br />
<table class="adminlist" cellspacing="1" style="width:100%">
<thead>
<tr>
	<th class="no">#</th>
	<th><?=lang('subject_mail')?></th>
	<th><?=lang('type_mail')?></th>
	<th><?=lang('status_mail')?></th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<? if($list_mail){$i=0;foreach($list_mail as $lm){$i++;?>
<tr class="<?=($i%2)==1?'row0':'row1'?>">
	<td><?=$i?></td>
	<td><?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lm->id_email,$lm->subject)?><br />(ket: <?=$code_mail_from_config[$lm->code_email]['ket']?>)</td>
	<td><?=$type_email_array[$lm->type_email]?></td>
	<td><?=$status_mail_array[$lm->status_email]?></td>
	<td>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/edit/'.$lm->id_email,loadImg('icon/edit.png','',false,config_item('modulename'),true),array('title'=>lang('edit')))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/delete/'.$lm->id_email,loadImg('icon/delete.png','',false,config_item('modulename'),true),array('title'=>lang('del'),'class'=>'butdel'))?>
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/test/'.$lm->id_email,loadImg('icon/email_go.png','',false,config_item('modulename'),true),array('title'=>lang('test_mail'),'class'=>'testEmail'))?>
	</td>
</tr>
<? }}?>

</tbody>
<tfoot>
<tr><td colspan="5">
	<div class="pagination">
	paging
	</div>
</td></tr>
</tfoot>
</table>

<!-- lib for fancy -->
<?=loadJs('fancybox/jquery.fancybox-1.3.0.pack.js',false,true)?>
<?=loadCss('js/fancybox/jquery.fancybox-1.3.0.css',false,true,false,true)?>


<script language="javascript">
$(function(){
	$('.butdel').click(function(){
		if(confirm("<?=lang('sure_dell_mail')?>")){
			return true;
		}
		return false;
	});
	$('.testEmail').click(function(){alert('comming soon'); return false;});
	$('.testEmail-old').fancybox({
		'titleShow'     : false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	
});
</script>