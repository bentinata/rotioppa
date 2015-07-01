<? 
$arr_for_aff=array('1'=>lang('yes'),'2'=>lang('no'));
$for_aff='2'; // default affiliate is no

$tt=lang('input_produk');
$bt=form_input(array('type'=>'submit','name'=>'_INPUT_BT','value'=>lang('input'),'class'=>'bt')).form_hidden('_INPUT','true');
$idkat = 'xx';
$idsub = 'yyy';
$idsub2 = 'zzz';
$nproduk = '';
$berat = 1;
$summary = '';
$desc = '';
$tag = '';
$mkey = '';
$mdesc = '';
$ha='';$hb='';$hv='';
$kom_aff = false;
$data_attr = false;
$ketdiskon = '';
$hadiskon = '';
$hbdiskon = '';
$rel_diskon = false;

if(isset($edit) && $edit){
	$tt=lang('edit_produk');
	$bt=form_input(array('type'=>'submit','name'=>'_EDIT_BT','value'=>lang('edit'),'class'=>'bt')).form_hidden('_EDIT','true');
	
	$idkat = $produk->kategoriID;
	$nproduk = $produk->menu;
	$desc = $produk->deskripsi;
	
} 
?>

<!-- mce editor -->
<?=loadJs('jquery.funtion.global.js',false,true)?>	
<?=loadJs('tiny_mce/jquery.tinymce.js',false,true)?>	
<script type="text/javascript">
$(function() {
	$('textarea.summary,textarea.desc,textarea.ket_diskon').tinymce({
		// Location of TinyMCE script
		script_url : '<?=loadJs('tiny_mce/tiny_mce.js',false,true,true)?>',
		theme : "advanced",
		plugins : "advimage,advlink,preview,paste,media,imagemanager,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,media,preview,code",
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
</script>

<!-- hover -->
<?=loadJs('hover/hover.js',false,true)?>
<?=loadCss('js/hover/hover.css',false,true,false,true)?>

<!-- autocomplete -->
<?=loadJs('autocomplete/jquery.autocomplete.js',false,true)?>
<?=loadCss('js/autocomplete/styles.css',false,true,false,true)?>

<div class="header">
	<?=loadImg('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('det_produk')?></span>
</div>
<br class="clr" />

<?=form_open_multipart(current_url(),array('id'=>'submitthisform'))?>
<?=form_hidden('id',$id)?>

<fieldset class="produk_detail">
<legend><?=$tt?></legend>
<? if(isset($ok)){?><div class="<?=$ok?'msg_success':'msg_error'?>"><?=$msg?></div><br class="clear" /><? }?>

<table class="admintable" cellspacing="1">
<tbody>


<tr>
	<th><?=lang('n_produk')?></th>
	<td>
	<input type="text" name="produk" class="produk" value="<?=htmlspecialchars($nproduk)?>" />
	</td>
</tr>
<tr>
	<th><?=lang('kat')?></th>
	<td><?=form_dropdown('kat',array(1=>"Sweet Oppa",2=>"Salty Oppa",3=>"Beverages"))?></td>
</tr>

<tr>
	<th><?=lang('desc')?></th>
	<td><textarea name="desc" class="desc"><?=$desc?></textarea></td>
</tr>

<Tr>
	<th>Input gambar</th>
	<td><input type="file" name="user_file"></td>
</tr>

</tbody>
</table>
</fieldset>


</tbody>
</table>
</fieldset><a href="<?=base_url('admin')?>">Kembali</a>
<br />

<fieldset style="display:none;">
<legend><?=lang('tampil_diskon')?></legend>
<table class="admintable" cellspacing="1">
<tbody id="body_diskon">
<? $oo=0;if($rel_diskon){foreach($rel_diskon as $rel){?>
<tr>
	<th><?=lang('kat')?></th>
	<td><?=form_dropdown("kat_tampil[$rel->id]",$kategori,$rel->id_kategori,'unik="'.$rel->id.'" pref="" class="kat_tampil" id="kat_'.$rel->id.'"')?></td>
</tr>
<tr>
	<th><?=lang('n_produk')?></th>
	<td>
	<select class="nama_produk_tampil" id="tampil_<?=$rel->id?>" name="nama_produk_tampil[<?=$rel->id?>]"><option> - </option></select>
	<span id="load_nama_produk_tampil_<?=$rel->id?>"></span>
	</td>
</tr>
<? $oo++;}}?>

<? for($o=$oo;$o<5;$o++){?>
<tr>
	<th><?=lang('kat')?></th>
	<td><?=form_dropdown("new_kat_tampil[$o]",$kategori,false,'unik="'.$o.'" pref="new_" class="kat_tampil"')?></td>
</tr>
<tr>
	<th><?=lang('n_produk')?></th>
	<td><select class="nama_produk_tampil" id="new_tampil_<?=$o?>" name="new_nama_produk_tampil[<?=$o?>]"><option> - </option></select>
		<span id="new_load_nama_produk_tampil_<?=$o?>"></span></td>
</tr>
<? }?>
</tbody>
</table>
</fieldset>
<br />

<?=$bt?>
</form>


<? // ------------- 
// sample for create new block image 
// disimpan di luar form supaya tdk ter posting
?>
<div id="gbr_sample" class="hide">
<fieldset>
<legend><?=lang('gambar')?></legend>
<input type="hidden" name="new_gbr" class="new_gbr" />
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('img_def')?></th>
	<td><input class="def_img" type="checkbox" id="new_def_img" name="new_def_img"> <?=lang('make_this_image_default')?></td>
</tr>
<tr>
	<th><?=lang('gambar')?></th>
	<td>
	<ul class="file"><li>
	<?=lang('big_pic')?><br />
	
	<? for($im=1;$im<=5;$im++){?>
		<?=loadImg('icon/break.png',array('class'=>'break'),false,config_item('modulename'),true)?>
		<input type="file" class="new_big" name="new_big" im="<?=$im?>" value="" /><br />
	<? }?>
	
	</li><li>
	<?=lang('small_pic')?><br />
	
	<? for($im2=1;$im2<=5;$im2++){?>
		<?=loadImg('icon/break.png',array('class'=>'break'),false,config_item('modulename'),true)?>
		<input type="file" class="new_thumb" name="new_thumb" im2="<?=$im2?>" value="" /><br />
	<? }?>
	
	</li></ul><br class="clr" /><br />
	<?=lang('intro_pic')?><br />
	<?=loadImg('icon/break.png',array('class'=>'break'),false,config_item('modulename'),true)?>
	<input type="file" id="new_intro" name="new_intro" value="" /><br />
	</td>
</tr>
<tr>
	<th><?=lang('attr_stock')?><input class="radio_stock" type="radio" name="new_jenis_stock" value="1" checked="true"></th>
	<td>
		<input type="text" id="new_stock" name="new_stock" i2="1" value="" /> *<?=lang('stock')?>
	</td>
</tr>
<tr>
	<th><?=lang('attr_khusus')?><input class="radio_stock" type="radio" name="new_jenis_stock" value="2"></th>
	<td>
		<table id="list-input" class="stock_khusus">
		<thead><tr>
			<th><?=lang('ukuran')?></th>
			<th><?=lang('stock')?></th>
		</tr></thead>
		<tbody id="body_attr_khusus">
		<? for($ii=1;$ii<=10;$ii++){?>
		<tr>
			<td><input type="text" class="new_ukuran2" name="new_ukuran" i2="<?=$ii?>" value="" /></td>
			<td><input type="text" class="new_stock2" name="new_stock" i2="<?=$ii?>" value="" /></td>
		</tr>
		<? }?>
		</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>
</fieldset>
</div>
<? //---------- end sample ?>


<span id="smalload" class="hide"><?=loadImg('ajax-loader.gif','',false,config_item('modulename'),true)?></span>
<script language="javascript">
$(function(){
$('.add_gbr').click(function(){ 
	var jml_gambar = parseInt($('#jml_gbr').val());
	jml_gambar+=1;
	$('#gbr_sample > fieldset').attr('class','gbr_ke_'+jml_gambar);

	$('#new_def_img','#gbr_sample').attr('name','new_def_img['+jml_gambar+']');
	$('.new_gbr','#gbr_sample').attr('name','new_gbr['+jml_gambar+']').attr('value',jml_gambar);
	$('.new_big','#gbr_sample').each(function(){
		$(this).attr('name','new_big['+jml_gambar+']['+$(this).attr('im')+']');
	});
	$('.new_thumb','#gbr_sample').each(function(){
		$(this).attr('name','new_thumb['+jml_gambar+']['+$(this).attr('im2')+']');
	});
	$('#new_intro','#gbr_sample').attr('name','new_intro['+jml_gambar+'][1]');
	$('.radio_stock','#gbr_sample').attr('name','new_jenis_stock['+jml_gambar+']');
	$('#new_stock','#gbr_sample').attr('name','new_stock['+jml_gambar+']['+$('#new_stock').attr('i2')+']');
	$('.new_stock2','#gbr_sample').each(function(){
		$(this).attr('name','new_stock2['+jml_gambar+']['+$(this).attr('i2')+']');
	});
	$('.new_ukuran2','#gbr_sample').each(function(){
		$(this).attr('name','new_ukuran2['+jml_gambar+']['+$(this).attr('i2')+']');
	});

	$('#body_gbr').append($('#gbr_sample').html());
	$('#jml_gbr').val((jml_gambar));
	$('#gbr_sample > fieldset').removeAttr('class');

	return false;
});
<? if(!isset($data_gambar['def']) && !isset($data_gambar['other']) ){?>
$(".add_gbr").trigger('click');
$('#new_def_img').attr('checked',true);
<? }?>

$('.dell_gbr').click(function(){
	var jml_gbr = parseInt($('#jml_gbr').val());
	var jml_gbr_old = parseInt($('#jml_gbr_old').val());
	if(jml_gbr>jml_gbr_old){
		$('.gbr_ke_'+jml_gbr).remove();
		jml_gbr-=1;
		$('#jml_gbr').val((jml_gbr));
	}
	return false;
});
$("select[name='vendor']").change(function(event,kt){
	if(kt) thisval=kt;
	else thisval = $(this).val();
	if(thisval!='-'){
		$.ajax({
			type: "POST",
			url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionvcode')?>",
			data: "vendor="+thisval,
			beforeSend: function(){
				$("select[name='vcode']").hide();
				$('#load_vcode').html($('#smalload').html());
			},
			success: function(msg){ //alert(msg);
				$('#load_vcode').html('');
				$("select[name='vcode']").html(msg.res).show();
				a2.setOptions({ lookup: msg.val.split(',') });
				
				<? if(isset($idvcode) && $idvcode!=''){?>
				$("select[name='vcode']").val('<?=$idvcode?>');
				<? }?>
			},
			dataType:'json'
		});
	}
});
// auto trigger
<? if(isset($idvendor) && $idvendor!=''){?>
$("select[name='vendor']").val('<?=$idvendor?>').trigger('change',["<?=$idvendor?>"]);
<? }?>

// auto complate codevendor
var a2 = $('#query').autocomplete({
	lookup: '',
	onSelect: function (value, data){ 
		$("select[name='vcode'] option:contains("+value+")").attr("selected", true);
		var ids=$("select[name='vcode'] option:contains("+value+")").val();
		$("select[name='vcode']").trigger('change',[ids]);
	}
});

$("select[name='kat']").change(function(event,kt){
	if(kt) thisval=kt;
	else thisval = $(this).val();
	if(thisval!='-'){
		$('#idkat').html(format_id_code(thisval,2));
		$.ajax({
			type: "POST",
			url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionsubkat')?>",
			data: "kat="+thisval,
			beforeSend: function(){
				$("select[name='subkat']").hide();
				$('#load_subkat').html($('#smalload').html());
			},
			success: function(msg){ //alert(msg);
				$('#load_subkat').html('');
				$("select[name='subkat']").html(msg).show();
				<? if($idsub!='' && $idsub!='yyy'){?>
				$("select[name='subkat']").val('<?=$idsub?>').trigger('change',["<?=$idsub?>"]);
				<? }?>
			}
		});
	}
});
// auto trigger
<? if($idkat!='' && $idkat!='xx'){?>
$("select[name='kat']").val('<?=$idkat?>').trigger('change',["<?=$idkat?>"]);
<? }?>
	
$("select[name='subkat']").change(function(event,skt){
	if(skt) thisval=skt;
	else thisval = $(this).val();
	if(thisval!='-'){
		$('#idsubkat').html(format_id_code(thisval,3));
		$.ajax({
			type: "POST",
			url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/optionsubkat2')?>",
			data: "subkat="+thisval,
			beforeSend: function(){
				$("select[name='subkat2']").hide();
				$('#load_subkat2').html($('#smalload').html());
			},
			success: function(msg){ //alert(msg);
				$('#load_subkat2').html('');
				$("select[name='subkat2']").html(msg).show();
				<? if($idsub2!='' && $idsub2!='zzz'){?> 
				$("select[name='subkat2']").val('<?=$idsub2?>');
				<? }?>
			}
		});
	}
});
// auto trigger
<? if($idsub!='' && $idsub!='yyy'){?>
//$("select[name='subkat']").val('<?=$idsub?>').trigger('change',["<?=$idsub?>"]);
<? }?>

	
$('.kat_tampil').change(function(event,ktt,idp){
	if(ktt) thisval=ktt;
	else thisval = $(this).val();
	var idunik=$(this).attr('unik');
	var pref=$(this).attr('pref');
	if(thisval!='-'){
		$.ajax({
			type: "POST",
			url: "<?=site_url(config_item('modulename').'/'.$this->router->class.'/namaprodukdiskon')?>", 
			data: "kat="+thisval,
			beforeSend: function(){
				$('#'+pref+'tampil_'+idunik).hide();
				$('#'+pref+'load_nama_produk_tampil_'+idunik).html($('#smalload').html());
			},
			success: function(msg){ //alert(msg);
				$('#'+pref+'load_nama_produk_tampil_'+idunik).html('');
				$('#'+pref+'tampil_'+idunik).html(msg).show();
				if(idp)
				$('#tampil_'+idunik).val(idp);
			}
		});
	}
});
// auto trigger
<? if($rel_diskon){foreach($rel_diskon as $rel){?>
$('#kat_<?=$rel->id?>').val('<?=$rel->id_kategori?>').trigger('change',["<?=$rel->id_kategori?>","<?=$rel->id_produk_lain?>"]);
<? }}?>



$('.def_img').live('click',function(){
	$('.def_img').attr('checked',false);
	$(this).attr('checked',true);
});

// clear the image selected
$('.break').click(function(){
	$(this).next("input[type='file']").val('');
});

});
</script>
