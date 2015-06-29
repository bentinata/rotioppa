<?=loadJs('jquery.js',false,true)?>
<?=loadJs('jquery.corner.js',false,true)?>
<?=loadCss('index.css')?>

<style>
body{background:none;}
#box-buletin{background:#ffffff url('<?=loadImg('popupnew-subscribe-topright.png','',true,false,true)?>') right 0 no-repeat;width:630px;min-height:450px;border:4px solid #0D4269;}
#logo-buletin{background:url('<?=loadImg('popup-subscribe-logo.png','',true,false,true)?>') 15px 2px no-repeat;}
#text-buletin{background:url('<?=loadImg('popupnew-subscribe-text.png','',true,false,true)?>') 15px 90px no-repeat;}
#box-form-buletin{background:url('<?=loadImg('popup-subscribe-barang.gif','',true,false,true)?>') 320px 210px no-repeat;height:460px;padding-left:10px;}

#box-fb{width:299px;height:100%;}
#box-anggota{background-color:#0D416A;height:25px;}
#anggota{color:#fff;font-weight:bold;padding-left:15px;line-height:25px;vertical-align:center;}
#link_anggota{color:#eee;font-style:italic;}
#link_anggota:hover{text-decoration:underline;}
</style>

<div id="box-buletin">
<div id="logo-buletin">
	<div id="text-buletin">
	<div id="box-form-buletin">
		
		<div id="box-fb">
		<div style="height:170px;">&nbsp;</div>

		<? if($_SERVER['HTTP_HOST']!='localhost'){?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			</script>			
			<div class="boxq" style="border-width:2px;border-color:#0D416A;background-image: url('<?=loadImg('background.jpg','',true,'aff')?>');padding:0;">
			<?=loadImg('titlefblike.png',array('style'=>'margin:-10px 5px 5px 25px;'),FALSE,FALSE,TRUE)?>
			<div class="fb-like-box" data-href="http://www.facebook.com/Yellaperdanacom" data-width="295" data-height="260" data-show-faces="true" data-stream="false" data-header="false"></div>
			</div>
		<? }else{?>
			<div style="border:1px solid #e6e6e6;width:295;height:280px;">fb not display on localhost</div>
		<? }?>
		</div>
	</div></div><br />
	<div id="box-anggota">
		<p id="anggota"><?=lang('has_a_member')?> <a id="link_anggota" target="_top" href="<?=site_url('login')?>"><?=lang('come_here')?></a></p>
	</div>
</div>
</div>

<span id="smallload" class="hide"><?=loadImg('small-loader.gif')?></span>
<script type="text/javascript">
$(document).ready(function() {
	$("#bt-buletin").click(function(){
		nama=$("input[name='inama']").val();
		mail=$("input[name='imail']").val();
		cpt=$("input[name='icaptcha']").val();
		if(nama!='' && mail!='' && cpt!=''){
			$.ajax({
				type: "POST",
				url: "<?=site_url('home/addsubscribe')?>",
				data: "postajax=true&inama="+nama+"&imail="+mail+"&icaptcha="+cpt,
				beforeSend: function(){
					$('#bulajax').html($('#smallload').html());
				},
				success: function(msg){ //alert(msg);
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
	$('#box-buletin').corner('15px');
});
</script>
