<?
$type_email_array = lang('type_mail_array'); 
$status_email_array = lang('status_mail_array');
$var_personalisasi='';
$var_personalisasi_sub='';
$var_personalisasi_mce='';
// for input
if(isset($input) && $input){
	$for_email_array = array_keys($code_mail);
	$is_input=true;
	$tt=lang('make_bcast');
	$type='1'; // default type is text
	$id=$status=$subj=$dbmsg=$formail='';
	$bt=form_input(array('type'=>'submit','name'=>'_INPUT','value'=>lang('input'),'class'=>'bt'));
}else{
	$is_input=false;
	$tt=lang('edit_fu');
	$id=form_hidden('id',$detail_mail->id_email);
	$type=$detail_mail->type_email;
	$subj=$detail_mail->subject;
	$dbmsg=$detail_mail->message;
	$status=$detail_mail->status_email;
	$formail=$detail_mail->code_email;
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT','value'=>lang('edit'),'class'=>'bt'));
}
?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('detail_fu')?></span>
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
	<th><?=lang('email_for')?></th>
	<td>
	<? if($is_input){
	if(count($code_mail)>0){?>
		<select name="email_for">
		<?foreach($code_mail as $keycodemail=>$cm){ 
			if(!isset($selected)){ 
				$selected='selected="selected"';
				$hide='';
				$msg_ket=$cm['ket'];
				$keycodemail_forback=$keycodemail;
			}else{
				$selected='';
				$hide='style="display:none;"';
				$msg_ket='';
			}
		?>
			<option <?=$selected?> value="<?=$keycodemail?>" ket="<?=$cm['ket']?>"><?=$cm['interface']?></option>
			<? 
			$var_personalisasi.='<select class="personalisasi personal_main" id="main_'.$keycodemail.'" name="personalisasi" '.$hide.'><option value="">-</option>';
			$var_personalisasi_sub.='<select class="personalisasi personal_sub" id="sub_'.$keycodemail.'" name="personalisasi_sub" '.$hide.'><option value="">-</option>';
			$var_personalisasi_mce.='<select class="personalisasi personal_mce" id="mce_'.$keycodemail.'" name="personalisasi_mce" '.$hide.'><option value="">-</option>';
			foreach($cm['personalisasi'] as $ps){
				$var_personalisasi.='<option value="'.$ps.'">'.$ps.'</option>';
				$var_personalisasi_sub.='<option value="'.$ps.'">'.$ps.'</option>';
				$var_personalisasi_mce.='<option value="'.$ps.'">'.$ps.'</option>';
			}
			$var_personalisasi.='</select>';
			$var_personalisasi_sub.='</select>';
			$var_personalisasi_mce.='</select>';
			?>
		<? }?>
		</select><span id="value_for_back_formail" style="display:none;"><?=$keycodemail_forback?></span><br />
		<span id="msg_ket"><?=$msg_ket?></span>
	<? }}else{?>
		<? echo '<b>'.$for_mail_current['interface'].'</b><br />';
		$var_personalisasi.='<select class="personalisasi personal_main" name="personalisasi"><option value="">-</option>';
		$var_personalisasi_sub.='<select class="personalisasi personal_sub" name="personalisasi_sub"><option value="">-</option>';
		$var_personalisasi_mce.='<select class="personalisasi personal_mce" name="personalisasi_mce"><option value="">-</option>';
		foreach($for_mail_current['personalisasi'] as $ps){
			$var_personalisasi.='<option value="'.$ps.'">'.$ps.'</option>';
			$var_personalisasi_sub.='<option value="'.$ps.'">'.$ps.'</option>';
			$var_personalisasi_mce.='<option value="'.$ps.'">'.$ps.'</option>';
		}
		$var_personalisasi.='</select>';
		$var_personalisasi_sub.='</select>';
		$var_personalisasi_mce.='</select>';
		echo $for_mail_current['ket'];
	}?> 
	</td>
</tr>
<tr>
	<th><?=lang('type_mail')?></th>
	<td><?=form_dropdown('type_email',$type_email_array,$type)?></td>
</tr>
<tr>
	<th><?=lang('subject')?></th>
	<td><?=$var_personalisasi_sub;?> <br /><input id="subjectmail" type="text" name="subject" style="width:400px" value="<?=$subj?>" /></td>
</tr>
<tr>
	<th><?=lang('email')?></th>
	<td>
	<div class="msgarea area_1">
		<?=$var_personalisasi;?> <br />
		<textarea id="mailtext" name="mailtext" style="width:400px;height:400px;" wrap="off"><?=$dbmsg?></textarea>
	</div>
	<div class="msgarea area_2">
		<?=$var_personalisasi_mce;?> <br />
		<textarea id="mailhtml" name="mailhtml" style="width:400px;height:400px"><?=$dbmsg?></textarea>
		<span class="notered">* (shift+enter)</span><span class="note"> untuk baris baru tanpa spasi</span><br />
		<span class="notered">&nbsp;&nbsp;&nbsp;(enter)</span><span class="note"> untuk baris baru dengan spasi</span>
	</div>
	</td>
</tr> 
<tr>
	<th><?=lang('status_mail')?></th>
	<td><?=form_dropdown('status_email',$status_email_array,$status)?></td>
</tr>
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
function insertAtCaret(areaId,text) {
    var txtarea = document.getElementById(areaId);
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 
        "ff" : (document.selection ? "ie" : false ) );
    if (br == "ie") { 
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        strPos = range.text.length;
    }
    else if (br == "ff") strPos = txtarea.selectionStart;

    var front = (txtarea.value).substring(0,strPos);  
    var back = (txtarea.value).substring(strPos,txtarea.value.length); 
    txtarea.value=front+text+back;
    strPos = strPos + text.length;
    if (br == "ie") { 
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        range.moveStart ('character', strPos);
        range.moveEnd ('character', 0);
        range.select();
    }
    else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }
    txtarea.scrollTop = scrollPos;
}


$(function(){
	$('body').append('<span id="id_for_personalisasi"></span>');
	$('.msgarea').hide();
	$('.area_<?=$type?>').show();
	$('textarea','.area_<?=$type?>').attr('name','email');

	$('.bt').click(function(){
		subject=$('#subjectmail').val();
		if(subject!='') return true;
		alert('<?=lang('data_must_fill')?>');
		return false;
	});
	$("select[name='type_email']").change(function(){
		var theId = $(this).val();
		if(theId=='2')
		var theOldVal=$('textarea','.area_1').val();
		else
		var theOldVal=$('textarea','.area_2').val();
		
		$('.msgarea').hide();
		$('textarea','.area_'+theId).val(theOldVal);
		$('textarea','.area_'+theId).attr('name','email');
		$('.area_'+theId).show();
	});
	$("select[name='email_for']").change(function(){
		var mtx=$('#mailtext').val();
		var sbj=$('#subjectmail').val();
		var proses=0;
		if(mtx!='' || sbj!=''){
			if(confirm('<?=lang('sure_to_change_formail')?>')){
				proses=1;
				$('#mailtext').val('');
				$('#subjectmail').val('');
			}else{
				var oldval = $('#value_for_back_formail').html();
				$("select[name='email_for'] option[value='"+oldval+"']").attr('selected', 'selected');
				return false;
	
			}
		}else{
			proses=1;
		}
		if(proses==1){
			var theval=$(this).val();
			$('#value_for_back_formail').html(theval);
			$('.personalisasi').hide();
			$('#main_'+theval).show();
			$('#sub_'+theval).show();
			$('#msg_ket').html($(this).attr('ket'));
		}
	});
	$('.personal_sub').change(function(){
		var theval=$(this).val();
		insertAtCaret('subjectmail',theval);
	});
	$('.personal_main').change(function(){
		var theval=$(this).val();
		insertAtCaret('mailtext',theval);
	});
	$('.personal_mce').change(function(){
		var theval=$(this).val();
		$('#mailhtml').tinymce().execCommand('mceInsertContent',false,theval)
	});
});
</script>

<!-- mce editor -->
<?=loadJs('tiny_mce/jquery.tinymce.js',false,true)?>	
<script type="text/javascript">
$(function() {
	$('#mailhtml').tinymce({
		// Location of TinyMCE script
		script_url : '<?=loadJs('tiny_mce/tiny_mce.js',false,true,true)?>',
		theme_advanced_resize_horizontal : false,
		// General options
		theme : "advanced",
		plugins : "autolink,advhr,advlink,inlinepopups,preview",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,outdent,indent,blockquote,|,undo,redo",
		theme_advanced_buttons2 : "cut,copy,paste,|,link,unlink,anchor,forecolor,|,hr,removeformat,|,code,preview",
		theme_advanced_buttons3 : "formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		//content_css : "<?=loadCss('general.css',false,false,true)?>" //,<?=base_url('site')?>priv/css/default/temp.css"
	});
});
</script>
