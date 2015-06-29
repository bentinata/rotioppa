<?
// for input
if(isset($input) && $input){
	$tt=lang('input_info');
	$id='';
	$title=$summary=$desc='';
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_info');
	$id=form_hidden('id',$detail_info->id);
	$title=$detail_info->title;
	$summary=$detail_info->summary;
	$desc=$detail_info->content;
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt'));
}
?>

<!-- mce editor -->
<?
$_base = explode($_SERVER['HTTP_HOST'],base_url());
$_COOKI['_cookie_WEB_BASE'] =ltrim($_base[1],'/').config_item('dir_upload').'/mce';
$_COOKI['_cookie_UPLOADS_PATH'] = str_replace(DIRECTORY_SEPARATOR,'_dir_spr_',realpath(FCPATH).DIRECTORY_SEPARATOR.config_item('dir_upload').DIRECTORY_SEPARATOR.'mce'); 
$_COOKI['_cookie_UPLOADS_URL'] = base_url().config_item('dir_upload').'/mce';
ci()->session->set_userdata($_COOKI);
?>
<?=loadJs('tiny_mce/jquery.tinymce.js',false,true)?>	
<script type="text/javascript">
$(function() {
	$('.the_summary,.the_desc').tinymce({
		// Location of TinyMCE script
		script_url : '<?=loadJs('tiny_mce/tiny_mce.js',false,true,true)?>',
		theme : "advanced",
		plugins : "advimage,advlink,preview,paste,media,imagemanager,imgmanager,inlinepopups",
		relative_urls: false,
		//remove_script_host : 'true',
		//document_base_url : '<?=base_url()?>',  

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,media,preview,code,imgmanager",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css : "<?=link_to_default_temp('css/general.css',config_item('theme_name'),true)?>,<?=link_to_default_temp('css/global.css',config_item('theme_name'),true)?>" //,<?=base_url('site')?>priv/css/default/temp.css"
	});
});
</script>


<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_info')?></span>
</div>
<br class="clr" />

<fieldset>
<legend><?=$tt?></legend>
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<?=form_open(current_url())?>
<?=$id?>
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('title')?></th>
	<td><input type="text" name="title" class="the_title" style="width:700px;" value="<?=$title?>" /></td>
</tr>
<tr>
	<th><?=lang('summary')?></th>
	<td><textarea name="summary" class="the_summary" style="width:700px;height:150px;"><?=$summary?></textarea></td>
</tr>
<tr>
	<th><?=lang('content')?></th>
	<td><textarea name="desc" class="the_desc" style="width:700px;height:400px;"><?=$desc?></textarea></td>
</tr>
<tr>
<tr>
	<th></th><td>
	<?=$bt?> &nbsp;&nbsp;
	<?=anchor(config_item('modulename').'/'.$this->router->class,lang('back'))?>
	</td>
</tr>
</tbody>
</table>
<?=form_close()?>
</fieldset>

<?=loadJs('jquery.funtion.global.js',false,true)?>
<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script language="javascript">
$(function(){
	$('.bt').click(function(){
		inf=$("textarea[name='info']").val();
		if(inf!='') return true;
		alert('<?=lang('data_must_fill')?>');
		return false;
	});
});
</script>