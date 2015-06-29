<div class="header">
	<?=loadImgThem('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span>Ubah Password</span>
</div>

<br class="clr" />

<fieldset>
<legend>Edit</legend>
<? if(isset($msg)){?><div class="<?=isset($ok)?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>

<?=form_open(current_url())?>

<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th>Username</th>
	<td><input type="text" disabled="disabled" value="<?=$this->login_lib->pos_get_data('username')?>"></td>
</tr>
<tr>
	<th>Password Lama</th>
	<td><input type="password" name="oldpass" /></td>
</tr>
<tr>
	<th>Password Baru</th>
	<td><input type="password" name="newpass" /></td>
</tr>
<tr>
	<th>Password Confirmasi</th>
	<td><input type="password" name="confpass" /></td>
</tr>
<tr>
<tr>
	<th></th><td>
	<?=form_input(array('type'=>'submit','name'=>'_CHANGE_PASS','value'=>'Save','class'=>'bt'));?>
	</td>
</tr>
</tbody>
</table>
<?=form_close()?>
</fieldset>

<script language="javascript">
$(function(){
	$('.bt').click(function(){
		o=$("input[name='oldpass']").val();
		n=$("input[name='newpass']").val();
		c=$("input[name='confpass']").val();
		if(o!='' && n!='' && c!='') return true;
		alert('<?=lang('data_must_fill')?>');
		return false;
	});
});
</script>