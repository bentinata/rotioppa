	<br>
	
	
<!-- rating -->
<?=loadJs('rating/rating.js',false,true)?>
<?=loadCss('js/rating/rating.css',false,true,false,true)?>
	<p style="text-align:center; width:100%; border-bottom: 3px dashed; font-size: 24px; font-weight:bold;">Daftar Kue
	</p>

<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><? }?>
<div id="kemitraan">
	<ul class="form-kiri2" style="margin-right:20px">
		<li class="box_content" style="margin-bottom:30px;">
			<div class="detailproduk column">
				<div class="column imgpreview">
					<? // satu set utk gambar default dan tampilkan 
					$def_stock=false;$first_thumb='';$def_idgbr=false;$def_jenis_stock=false;$id_first_attr=0;
					if(isset($detail['gambar']['def']))
					{
					$def_jenis_stock = $detail['gambar']['def']['jenis_stock'];
					// jika stock umum ambil satu saja
					if($def_jenis_stock=='1'){
						$id_first_attr = array_shift(array_keys($detail['gambar']['def']['attr'])); #var_dump($id_first_attr);
						$first_attr = array_shift($detail['gambar']['def']['attr']); #var_dump($first_attr);
						$def_stock = $first_attr['stock'];
					// jika stock khusus looping utk list ukuran
					}else{ 
						unset($ar_ukuran);unset($ar_stock);
						foreach($detail['gambar']['def']['attr'] as $id_attr=>$v_attr){
							if($id_first_attr==0)$id_first_attr=$id_attr;
							$ar_ukuran[$id_attr] = $v_attr['ukuran'];
							$ar_stock[$id_attr] = $v_attr['stock'];
						}
						$def_stock = true; // khusus utk jenis stock 2, defaultnya di buat ada meskipun select option nya kosong, karena systemnya susah
					}
					$def_idgbr = $detail['gambar']['def']['idgbr'];		
					$gbr=unserialize($detail['gambar']['def']['gbr']); #print_r($gbr);echo '<br>-------------<br>';
		
					// -------- gbr default ?>
					<div class="bigfilmstrip column" id="big_<?=$def_idgbr?>">
						<div class="wrap-img">
							<? if(isset($gbr['big'])){
							ksort($gbr['big']);
							foreach($gbr['big'] as $i_gbr=>$gb){?>
								<div class="anim column <?=$i_gbr==1?'':'hide'?>" id="big_<?=$def_idgbr.'_'.$i_gbr?>">
								<a href="<?=loadImgProduk($detail['id'].'/'.$def_idgbr.'/'.$gb,'',true)?>" class="showBig">
									<?=loadImgProduk($detail['id'].'/'.$def_idgbr.'/'.$gb,array('class'=>''))?>
								</a>
								</div>
							<? }}?>
						</div>
						<!--<p class="noteclick">* Klik untuk memperbesar gambar</p>-->
					</div>
	
					<!-- thumbnail -->
					<ul class="columnr filmstrip" id="thumb_<?=$def_idgbr?>">
					<? if(isset($gbr['thumb'])){
						ksort($gbr['thumb']);
						foreach($gbr['thumb'] as $i_th=>$gbrth){
						if($first_thumb=='')$first_thumb=loadImgProduk($detail['id'].'/'.$def_idgbr.'/'.$gbrth,array('lang'=>$i_th)); 
						?>	
						<li><?=loadImgProduk($detail['id'].'/'.$def_idgbr.'/'.$gbrth,array('id_gbr'=>$def_idgbr,'id_urut'=>$i_th))?></li>
					<? }}?>
					</ul>
	
					<!-- data for stock -->
					<span id="data_<?=$def_idgbr?>" class="hide">
						<span class="jenis_stock"><?=$def_jenis_stock?></span>
						<span class="data_stock">
						<? if($def_jenis_stock=='1'){?>
							<input name="stock" type="hidden" value="<?=$def_stock?>" />
							<input name="id_attr" type="hidden" value="<?=$id_first_attr?>" />
						<? 
						// jika stock khusus looping utk list ukuran
						}else{ 
						?>
							<br /><b><?=lang('ukuran')?></b> : <?=form_dropdown('id_attr',$ar_ukuran,false,'class="id_attr"')?><br />
							<?=form_dropdown('select_stock',$ar_stock,false,'class="hide select_stock"')?>
						<? }?>
						</span>
						<span class="idattr_stock"><?=$id_first_attr?></span>
					</span>
					<? }?>	

					<? // loop gambar2 lainnya dan hide 
					if(isset($detail['gambar']['other'])){ 
					foreach($detail['gambar']['other'] as $k_idgbr=>$v_gbr){
						?>
						<!-- big image other -->
						<div class="bigfilmstrip column hide" id="big_<?=$k_idgbr?>">
							<? $gbro=unserialize($v_gbr['gbr']); #print_r($gbro);echo '<br>-------------<br>';
							if(isset($gbro['big'])){
								ksort($gbro['big']);
								foreach($gbro['big'] as $i_gbr=>$gb){
								?>
								<div class="anim column <?=$i_gbr==1?'':'hide'?>" id="big_<?=$k_idgbr.'_'.$i_gbr?>">
								<a href="<?=loadImgProduk($detail['id'].'/'.$k_idgbr.'/'.$gb,'',true)?>" class="showBig">
								<?=loadImgProduk($detail['id'].'/'.$k_idgbr.'/'.$gb,array('class'=>'img300'))?>
								</a>
								</div>
							<? }}?>
						</div>
						
						<!-- thumbnail image -->
						<ul class="columnr filmstrip hide" id="thumb_<?=$k_idgbr?>">
							<? if(isset($gbro['thumb'])){
							ksort($gbro['thumb']);
							foreach($gbro['thumb'] as $i_th=>$gbrth){?>	
							<li><?=loadImgProduk($detail['id'].'/'.$k_idgbr.'/'.$gbrth,array('id_gbr'=>$k_idgbr,'id_urut'=>$i_th))?></li>
						<? }}?>
						</ul>
				
						<!-- data for stock -->
						<span id="data_<?=$k_idgbr?>" class="hide">
							<span class="jenis_stock"><?=$v_gbr['jenis_stock']?></span>
							<span class="data_stock">
							<? if($v_gbr['jenis_stock']=='1'){
								$id_first_attr2 = array_shift(array_keys($v_gbr['attr'])); #var_dump($id_first_attr);
								$first_attr2 = array_shift($v_gbr['attr']); #var_dump($first_attr);
								$def_stock2 = $first_attr2['stock']; ?>
								<input name="stock" type="hidden" value="<?=$def_stock2?>" />
								<input name="id_attr" type="hidden" value="<?=$id_first_attr2?>" />
							<?
							// jika stock khusus looping utk list ukuran
							}else{ 
								$id_first_attr2 = 0;
								unset($ar_ukuran2);unset($ar_stock2);
								foreach($v_gbr['attr'] as $id_attr=>$v_attr){
									if($id_first_attr2==0) $id_first_attr2=$id_attr;
									$ar_ukuran2[$id_attr] = $v_attr['ukuran'];
									$ar_stock2[$id_attr] = $v_attr['stock'];
								} ?>
								<br /><b><?=lang('ukuran')?></b> : <?=form_dropdown('id_attr',$ar_ukuran2,false,'class="id_attr"')?><br />
								<?=form_dropdown('select_stock',$ar_stock2,false,'class="hide select_stock"')?>
							<? }?>
							</span>
							<span class="idattr_stock"><?=$id_first_attr2?></span>
						</span>
					<? }}?>
					<br class="clear" />

				</div>

				<div class="columnr detailpreview">
					<h2 class="title"><?=$detail['nama_produk']?></h2>
				
					
					
					<?
					if($def_jenis_stock=='1'){ // stock umum
						$div_status_stock = '';
					}else{
						$div_status_stock = 'hide';
					}
					?>
					<div class="stock-page <? #=$view_stock?>" id="stock">
					
					</div>
					<div class="clear"></div>
					<br>
					
					<?
						$res_rate = 0;
						if($detail['raterev']->rate!=0){
							//$res_rate=$detail['raterev']->rate/$detail['raterev']->cust;
							//$total_width_star=ceil($def_width_star*$res_rate);
							$res_rate = ($detail['raterev']->rate * 100) / ($detail['raterev']->cust * 5);
						}
						?>
						<br>
						
						<script type="text/javascript">var switchTo5x=true;</script>
						<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
						<script type="text/javascript">stLight.options({publisher: "f6bf78ad-c6f0-42e6-b95a-065a85abb43b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
					<br>
						<div>
					<span class='st_sharethis_large' displayText='ShareThis'></span>
					<span class='st_fblike_large' displayText='Facebook Like'></span>
					<span class='st_facebook_large' displayText='Facebook'></span>
					<span class='st_plusone_large' displayText='Google +1'></span>
					<span class='st_twitter_large' displayText='Tweet'></span>
					<span class='st_linkedin_large' displayText='LinkedIn'></span>
					<span class='st_pinterest_large' displayText='Pinterest'></span>
					<span class='st_email_large' displayText='Email'></span>
			</div>
			
				
			</div>

			<div style="clear:both"></div>
			<div class="space_blog">
				<div class="form_pendaftaran_mitra">
					<div class="head">
						Deskripsi Produk
					</div>
					<div class="form-input">
						<ul>
							<li><b>Deskripsi Produk</b></li>
							<li><p><?=$detail['deskripsi']?></p></li>
							<li><b><?=lang('berat')?></b><p><? $cv=convert_unit($detail['berat']);echo $cv['hasil'].' '.$cv['satuan'];?></p></li>
						</ul>
					</div>
				</div>		
			</div>
			<div class="space_blog" style="margin-top:40px">
		</li>
	</ul>
</div>
<?=loadJs('jquery.funtion.global.js',false,true)?>
<script language="javascript">
$(function(){
	$('#submit').click(function(){
	
			var star = $('input[name=star]:checked', '.stars').attr('class');
			$('.bintang').val() = star;
			alert(star);
			star = (star != undefined)? star : 'You have to choose a rating from 1 to 5';
			
	});
	$('.tabMenu').click(function(){
		var idDiv = $(this).attr('data-id'); //alert(idDiv);
		
		$(this).parents('ul').find('li').removeClass();
		$(this).parent().attr('class','active');
		$('.tab-content',$(this).parents('.tab-box')).hide();
		$('#'+idDiv).slideDown('slow');
	});
	
	$('.img_other').click(function(){
		var idgbr = $(this).attr('idgbr');
		// hide old img and show new img
		$('.bigfilmstrip,.filmstrip').hide();
		$('#big_'+idgbr+',#thumb_'+idgbr).fadeIn();
		$('.bt-filmstrip li').removeAttr('class');
		$(this).parent().attr('class','def');
	
		// change stock
		var parent_data='#data_'+idgbr;
		var jenis_stock=$('.jenis_stock',parent_data).html();
		var data_stock=$('.data_stock',parent_data).html(); //alert(data_stock);
		$('#option_ukuran').html(data_stock);
	
		// proses stock
		if(jenis_stock=='1'){
			$('#option_ukuran').attr('class','hide');
			var stock=parseInt($("input[name='stock']",parent_data).val()); //alert(stock);
			$('#status_stock').show();
			if(stock>0){ //alert(1);
				// status stock 
				$('#value_status_stock_1').show();
				$('#value_status_stock_2').hide();
				// wishlist atau stock
				$('#stock').show();
				$('#wish').hide();
				$('#jml').show();
				$('#get_cart').show();
			}else{ //alert(2);
				$('#value_status_stock_2').show();
				$('#value_status_stock_1').hide();
				$('#stock').hide();
				$('#wish').show();
			}
		}else{
			$('#stock').show();
			$('#status_stock').hide();
			$('#option_ukuran').show();
			stock = parseInt($(".select_stock option[value='"+idattr+"']",parent_data).text());
			if(stock>0){
				$('#jml').show();
				$('#get_cart').show();
				$('#wish').hide();
			}else{ 
				// show wishlist and hide jml
				$('#jml').hide().val('');
				$('#get_cart').hide();
				$('#wish').show();
			}
		}
	
	
		return false;
	});
	$('.filmstrip img').click(function(){
		$('.anim').hide('fast');
		$('#big_'+$(this).attr('id_gbr')+'_'+$(this).attr('id_urut')).show("slow");
	});
	
	$('#jml').keyup(function(e){ 
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
			//display error message
			alert('<?=lang('justnumber')?>');
			$(this).val(clear_format_curency($(this).val()));
			return false;
		}else{
			var ukuran_select = $(".id_attr",'#option_ukuran').val();
			if(ukuran_select)
			{ // jika stock nya berbentuk option selected
				stock = $(".select_stock option[value='"+ukuran_select+"']",'#option_ukuran').text();
			}else{ // jika stock nya biasa
				stock = $("input[name='stock']",'#option_ukuran').val();
			}
			var res = $(this).val(); 
			if(stock=='') stock=0; 
			if(parseInt(res)>parseInt(stock)){
				alert('<?=lang('not_have_stock')?> '+stock);
				$(this).val('');
				return false;
			}else{
				$(this).val(res);
				return true;
			}
		}
	}).val('');
	
	$('#get_cart').click(function(){
		if($('#jml').val()!=''){
			if($('#jml').trigger('keyup')){ 
				if($('#jml').val()!=''){
					goSubmit='1'; 
					if($("input[name='kupon']").val() && $("input[name='kupon']").val()!=''){
						goSubmit='2';
						if($('#is_kupon').val()=='1') goSubmit='1';
					}
					if(goSubmit=='1'){
						$('#post_cart').submit();
						return true;
					}else{
						alert('<?=lang('kupon_must_complete_or_notfill')?>');
					}
				}
			}
		}else
			alert('<?=lang('jml_must_fil')?>');
		return false;
	});
	
	$(".id_attr",'#option_ukuran').live('change',function(){
		var stock = $(".select_stock option[value='"+$(this).val()+"']",'#option_ukuran').text();
		var input_stock = $('#jml').val(); 
		if(stock=='') stock=0; 
		if(input_stock=='') input_stock=0; 
		if(parseInt(input_stock)>parseInt(stock)){
			alert('<?=lang('not_have_stock')?> '+stock);
			$('#jml').val('').hide();
			$('#get_cart').hide();
			$('#wish').show();
			return false;
		}else{
			if(parseInt(stock)>0){
			$('#jml').show();
			$('#get_cart').show();
			$('#wish').hide();
			}else{
			$('#jml').hide().val('');
			$('#get_cart').hide();
			$('#wish').show();
			}
			return true;
		}
	});
	$("input[name='_REVIEW']").click(function(){
		alert('asdasad');
		st=$(".bintang").val();
		rv=$("textarea[name='review']").val();
		cp=$("input[name='captcha']").val();
		if(st!='' && rv!='' && cp!='') return true;
		alert('<?=lang('rate_rev_must_fill')?>');
		return false;
	});
	$("a.showBig").fancybox({
		'titleShow'     : false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'/*,
		'width':500,	// di buat auto
		'height':500*/
	});
	$('#tellfriend').click(function(){
		$.fancybox({
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
			'hideOnOverlayClick': false,
			'href':'<?=site_url(config_item('modulename').'/tellfriend')?>',
			'ajax':{
				type	: "POST",
				data	: "idp=<?=$detail['id']?>&prd=<?=$detail['nama_produk']?>"
			}
		});
		return false;
	});
	$("input[name='_WSUBMIT']").click(function(){
		nm=$("input[name='wnama']").val();
		em=$("input[name='wmail']").val();
		cp=$("input[name='wcaptcha']").val();
		if(nm!='' && em!='' && cp!=''){
			return true;
		}
		alert('<?=lang('data_not_complete')?>');
		return false;
	});

	$('#link_process').click(function(){
		var thelink = $(this);
		var kkupon = $("input[name='kupon']").val();
		var hkupon = '<?=get_price($detail['harga_awal'],$detail['harga_baru'],$detail['harga_awal_diskon'],$detail['harga_baru_diskon'])?>';
		if(kkupon=="") alert('<?=lang('kupon_empty')?>');
		else{
		$.ajax({type: "POST",
			url:'<?=site_url('home/reqajax/use_kupon')?>',
			data: ({kode_kupon:kkupon,harga:hkupon}),
			dataType:'json',
			beforeSend : function(){
				thelink.hide();
				$('#img_backup').show();
				$('#loader_process').show();
			},
			success: function(data){
				thelink.show();
				$('#img_backup').hide();
				$('#loader_process').hide();
				$('#msg_process').html(data.msg);
				if(data.code=='1') $('#is_kupon').val('1');
			}
		});
		}return false;
	});
	$("input[name='kupon']").keypress(function(){
		$('#is_kupon').val('2');
	});
})(jQuery);
</script>
