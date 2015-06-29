<div style="padding:10px;border:1px solid #e0e0e0;width:350px;height:100px;">
<p id="msg"></p>
<p><label>Subject </label>:<br/>Hkdjfkdjfd dkfjdfkd fdkjfskd fdkfjsdklf dkfjskdf kdjfslkdfj dkfjdksf kdfjdk </p>
<p><labe>To </labe>: <input type="text" name="email"> <input id="sendmail" type="button" name="_SEND" value="Send &raquo;"></p>
</div>

<span id="smalload" class="hide"><?=loadImg('ajax-loader.gif','',false,config_item('modulename'),true)?></span>
<script language="javascript">
$(function(){
$('#sendmail').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=current_url()?>",
			data: '_SEND=ok&email='+$("input[name='email']").val(),
			beforeSend: function(){
				$('#msg').html($('#smalload').html());
			},
			success: function(msg){ //alert(msg);
				$('#msg').html(msg);
			}
		});
});
});
</script>