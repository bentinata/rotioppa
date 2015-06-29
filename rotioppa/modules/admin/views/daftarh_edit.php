<?
// for input
if(isset($input) && $input){
	$tt=lang('input_info');
	$id='';
	$content='';
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$tt=lang('edit_harga');
	$id=form_hidden('id',$detail_harga->id);
	$content=$detail_faq->answer;
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_faq')?></span>
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
	<th>Content</th>
	<td><textarea name="content" class="desc" style="width:300px;"><?=$content?></textarea></td>
</tr>
<tr>
<tr>
	<th></th><td>
	<?=$bt?> &nbsp;&nbsp;
	<?=anchor(config_item('modulename').'/'.$this->router->class.'/faq',lang('back'))?>
	</td>
</tr>
</tbody>
</table>
<?=form_close()?>
</fieldset>
<?=loadJs('jquery.funtion.global.js',false,true)?>	
<?=loadJs('tiny_mce/jquery.tinymce.js',false,true)?>
<span id="smalload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script type="text/javascript">
$(function() {
	$('textarea.summary,textarea.desc,textarea.ket_diskon').tinymce({
		// Location of TinyMCE script
		script_url : '<?=loadJs('tiny_mce/tiny_mce.js',false,true,true)?>',
		theme : "advanced",
		plugins : "advimage,advlink,preview,paste,media,imagemanager,imgmanager,inlinepopups",

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
		content_css : "<?=loadCss('general.css',false,false,true)?>" //,<?=base_url('site')?>priv/css/default/temp.css"
	});
});
$(function(){
	$('.bt').click(function(){
		j=$("textarea[name='content']").val();
		if(t!='' && $j!='') return true;
		alert('<?=lang('data_must_fill')?>');
		return false;
	});
});
</script>