<div id="wraper-login">
	<div id="box-top"><div id="br-box-top"></div></div>
	<div id="box-ct">
		<br /><br />
		<br /><br />
		<br /><br />
		<br /><br />
		<br /><br />
		<br /><br />
		
		<div id="main-box" style="background-color:#eee;border-radius:10px;">
			<h3 class="head-login">Login - Administrator</h3>
			
		<center>
		<? if (isset($error_message) AND $error_message!=''){echo '<span class="error_msg">'.$error_message.'</span><br><br>';}?>
		</center>
			<form method="post" id="login_pos">
			<div id="form-login" class="wrap-ct" style="background-color:#eee;">
            

				<ul id="input-login" style="padding:10px">
					<li>
						<label><?=lang('login_user')?></label>
						<input id="user" type="text" name="username" style="text-align:left;" />
					</li>
					<li>
						<label><?=lang('login_password')?></label>
						<input id="pass" type="password" name="password" />
					</li>
					<li>
						<label>&nbsp;</label>
						<input type="hidden" name="do_login" value="1" />
						<input id="do_login" type="button" name="_LOGIN" value="<?=lang('login_button')?>" class="button" style="width:100px;" />
					</li>
				</ul>
			</div>
			</form>
			<div class="clr"></div>
			<br />
		</div>
	</div>
	<div id="box-bt"><div id="br-box-bt"></div></div>
</div>

<script language="javascript">
$(function(){ 
	$('#do_login').click(function(){
		if($('#user').val()!='' && $('#pass').val()!=''){ 
			$('#login_pos').submit();
			return true;
		}
		alert('<?=lang('user_pass_must_fill')?>');
		return false;
	});
});
</script>

<style>
#main-box{margin:0 auto;width:350px;height:250px;background:none;}
	#main-box .head-login{background-color:#939598;padding:20px 10px 10px 10px;color:#FFF; border-top-left-radius:10px;border-top-right-radius:10px;}
#login_pos .button{font-weight: bold;
background-color: #939598;
border: 1px solid #939598;
width: 70px;
color: #fff;}

#form-login{float:left;vertical-align:top;}
#input-login{}	
	#input-login li{margin-bottom:5px;}	
	#input-login .title{font-weight:bold;}
		#input-login li label{display: inline-block;width: 80px;}
		#input-login li input{padding:5px 10px;width: 200px;}
#do_login{width:100px;}

</style>