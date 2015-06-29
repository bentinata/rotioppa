			<link href='<?=theme_img('sosmed-fb.png')?>' rel='shortcut icon'/>
			
			<div class="rightside width-sidebar">
				<div class="b_box">
					<div class="box">
						
						<div class="form-input">
						<?=form_open('home/addsubscribe',array('id'=>'iform'))?>
						<label class="subsc">Dapatkan info<br/></label>
						<label class="subsc2">Promo & Discount<br/></label>
						<label class="subsc">dengan mengisi form di bawah</label>
						<input class="tinput" type="text" name="imail" placeholder="Email" />
						<input class="tinput" type="text" name="inama" placeholder="Nama" />
								<!--<input class="tinput" type="text" name="inama" placeholder="<?=lang('inama')?>" /><input class="tinput" type="text" name="imail" placeholder="<?=lang('imail')?>" /><?=lang('icode')?>-->
						<a id="bt-buletin" href="javascript:void(0)" class="isubmit"><?=lang('subscribe')?></a>
								<!--input class="isubmit" type="submit" name="_ISUBMIT" value="<?=lang('subscribe')?>" /-->
								<?=form_close()?>
						</div><br clear="all"/>
					</div>
				</div>
			</div>
			
			<div id="box-buletin">
	<!--div id="box-form-buletin">
		<?=form_open('home/addsubscribe',array('id'=>'iform'))?>
		<ul id="form-buletin">
            
		
		</ul>
		<label><span id="bulajax"></span></label>
		<?=form_close()?>
	</div-->
</div>

<span id="smallload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script type="text/javascript">
$(document).ready(function() {
	$("#bt-buletin").click(function(){
		nama=$("input[name='inama']").val();
		mail=$("input[name='imail']").val();
		// alert(mail+'  '+nama);
		if(nama!='' && mail!='' ){
			$.ajax({
				type: "POST",
				url: "<?=site_url('home/addsubscribe')?>",
				data: "postajax=true&inama="+nama+"&imail="+mail,
				beforeSend: function(){
					$('#bulajax').html($('#smallload').html());
				},
				success: function(msg){
					// alert(msg);
					$('#bulajax').html('');
					if(msg.code=='1'){
						alert(msg.msg);
						$('.add_sub').hide();
						parent.$.fancybox.close();
					}else
					alert(msg.msg);
				},
				dataType: 'json'
			});
		}else{
			alert('Lengkapi semua form input!');
		}
		return false;
	});
	$('#box-buletin').corner('10px');
});
</script>
