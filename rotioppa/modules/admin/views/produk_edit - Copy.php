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
	
	$idkat = $produk->id_kategori;
	$idsub = $produk->id_subkat;
	$idsub2 = $produk->id_subkat2;
	$idkatalog = $produk->id_katalog;
	$idvendor = $produk->vendor;
	$idvcode = $produk->vcode;
	$nproduk = $produk->nama_produk;
	$berat = $produk->berat;
	$summary = $produk->summary;
	$desc = $produk->deskripsi;
	$tag = $produk->tag;
	$mkey = $produk->meta_key;
	$mdesc = $produk->meta_desc;
	$ha = $produk->harga_awal;
	$hb = $produk->harga_baru;
	$hv = $produk->harga_vendor;
	if($produk->for_affiliate!='')	$for_aff = $produk->for_affiliate;
	$kom_aff = $produk->komisi;
	$ketdiskon = $produk->ket_diskon;
	$hadiskon = $produk->harga_awal_diskon;
	$hbdiskon = $produk->harga_baru_diskon;

	$data_gambar = $produk->gambar; #print_r($data_gambar);
	$data_attr = $produk->atribut;
	$rel_diskon = $produk->rel_diskon;
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
	<th><?=lang('k_produk')?></th>
	<td>
	<span id="idkat"><?=(isset($input))?$idkat:format_kode($idkat)?></span>
	<span id="idsubkat"><?=(isset($input))?$idsub:format_kode($idsub,3)?></span>
	<span id="idproduk"><?=$id?></span>
	</td>
</tr>
<tr>
	<th><?=lang('vendor')?></th>
	<td><?=$vendor?form_dropdown('vendor',$vendor):''?>
	</td>
</tr>
<tr>
	<th><?=lang('vcode')?></th>
	<td><select name="vcode"><option> - </option></select>
		<span id="load_vcode"></span>
		<input type="text" name="q" id="query" />
	</td>
</tr>
<tr>
	<th><?=lang('n_produk')?></th>
	<td>
	<input type="text" name="produk" class="produk" value="<?=htmlspecialchars($nproduk)?>" />
	</td>
</tr>
<tr>
	<th><?=lang('kat')?></th>
	<td><?=form_dropdown('kat',$kategori)?></td>
</tr>
<tr>
	<th><?=lang('subkat')?></th>
	<td><select name="subkat"><option> - </option></select>
		<span id="load_subkat"></span>
	</td>
</tr>
<tr style="display:none;">
	<th><?=lang('subkat2')?></th>
	<td><select name="subkat2"><option> - </option></select>
		<span id="load_subkat2"></span>
	</td>
</tr>
<tr>
	<th><?=lang('katalog')?></th>
	<td><?=form_dropdown('katalog',$katalog)?></td>
</tr>
<tr>
	<th><?=lang('berat')?></th>
	<td><input type="text" name="berat" value="<?=currency($berat)?>" class="digit" /> gr.
	<input type="hidden" name="hid_berat" class="fixdigit" />
	</td>
</tr>
<tr>
	<th><?=lang('summary')?></th>
	<td><textarea name="summary" class="summary"><?=$summary?></textarea></td>
</tr>
<tr>
	<th><?=lang('desc')?></th>
	<td><textarea name="desc" class="desc"><?=$desc?></textarea></td>
</tr>
<tr>
	<th><?=lang('tag')?></th>
	<td><textarea name="tag"><?=$tag?></textarea><br />
	<span class="note">*<?=lang('space_with_comma')?></span></td>
</tr>
<tr>
	<th><?=lang('meta_key')?></th>
	<td><?=form_textarea('meta_key',$mkey,'style="height:50px"')?></td>
</tr>
<tr>
	<th><?=lang('meta_desc')?></th>
	<td><?=form_textarea('meta_desc',$mdesc,'style="height:50px"')?></td>
</tr>
<tr>
	<th><?=lang('harga_vendor')?></th>
	<td>
	Rp. <input type="text" class="digit" name="vals_harga_vendor" value="<?=currency($hv)?>" /> 
	<input type="hidden" name="hid_harga_vendor" class="fixdigit" value="<?=$hv?>" />
	<span class="note">*<?=lang('must_int')?></span>
	</td>
</tr>
<tr>
	<th><?=lang(config_item('names_harga_awal'))?></th>
	<td>
	Rp. <input type="text" class="digit" name="vals_harga_awal" value="<?=currency($ha)?>" /> 
	<input type="hidden" name="hid_harga_awal" class="fixdigit" value="<?=$ha?>" />
	<span class="note">*<?=lang('must_int')?></span>
	</td>
</tr>
<tr>
	<th><?=lang(config_item('names_harga_baru'))?></th>
	<td>
	Rp. <input type="text" class="digit" name="vals_harga_baru" value="<?=currency($hb)?>" /> 
	<input type="hidden" name="hid_harga_baru" class="fixdigit" value="<?=$hb?>" />
	<span class="note">*<?=lang('must_int')?></span>
	</td>
</tr>
<tr>
	<th><?=lang('aff')?></th>
	<td><?=form_dropdown('for_aff',$arr_for_aff,$for_aff)?></td>
</tr>
<tr>
	<th><?=lang('aff_kom')?></th>
	<td>
		Rp. <input type="text" class="digit" name="aff_kom" value="<?=currency($kom_aff)?>" /> 
		<input type="hidden" name="hid_aff_kom" class="fixdigit" value="<?=$kom_aff?>" />
	</td>
</tr>
</tbody>
</table>
</fieldset>
<br />

<? $jml_gambar_looping=0;
// looping gambar default
if(isset($data_gambar['def'])){
foreach($data_gambar['def'] as $id_gbr=>$dtgambar){ $jml_gambar_looping++;
	$gambar=unserialize($dtgambar['gbr']); #print_r($gambar);
?>
<?=form_hidden('id_img['.$id_gbr.']',$id_gbr)?>
<fieldset>
<legend><input type="checkbox" name="dell_group_img[<?=$id_gbr?>]" value="<?=$id_gbr?>" title="<?=lang('check_for_del_img_group')?>" /><?=lang('gambar')?></legend>
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('img_def')?></th>
	<td><input class="def_img" type="checkbox" checked="checked" name="def_img[<?=$id_gbr?>]"> <?=lang('make_this_image_default')?></td>
</tr>
<tr>
	<th><?=lang('gambar')?></th>
	<td>
	<ul class="file"><li>
	<?=lang('big_pic')?><br />
	
	<? for($im=1;$im<=5;$im++){?>
		<?=loadImg('icon/break.png',array('class'=>'break'),false,config_item('modulename'),true)?>
		<input type="file" name="big[<?=$id_gbr?>][<?=$im?>]" value="" />
		<? if(!isset($input) && isset($gambar['big'][$im])){?>
		<span class="bubbleInfo">
			<?=loadImg('icon/zoom.png',array('class'=>'picu'),false,config_item('modulename'),true)?>
			<span class="boxpop"><?=loadImgProduk($id.'/'.$id_gbr.'/'.$gambar['big'][$im])?></span>
		</span>
		<input type="checkbox" name="delimg_big[<?=$id_gbr?>][<?=$im?>]" value="<?=$gambar['big'][$im]?>" title="<?=lang('check_for_del_img')?>" />
		<input type="hidden" name="oldbig[<?=$id_gbr?>][<?=$im?>]" value="<?=$gambar['big'][$im]?>" />
		<? }?>
		<? if($im==1){?><span class="note">*<?=lang('main_pic')?></span><? }?>
		<br />
	<? }?>
	
	</li><li>
	<?=lang('small_pic')?><br />
	
	<? for($im2=1;$im2<=5;$im2++){?>
		<?=loadImg('icon/break.png',array('class'=>'break'),false,config_item('modulename'),true)?>
		<input type="file" name="thumb[<?=$id_gbr?>][<?=$im2?>]" value="" />
		<? if(!isset($input) && isset($gambar['thumb'][$im2])){?>
		<span class="bubbleInfo">
			<?=loadImg('icon/zoom.png',array('class'=>'picu'),false,config_item('modulename'),true)?>
			<span class="boxpop"><?=loadImgProduk($id.'/'.$id_gbr.'/'.$gambar['thumb'][$im2])?></span>
		</span>
		<input type="checkbox" name="delimg_thumb[<?=$id_gbr?>][<?=$im2?>]" value="<?=$gambar['thumb'][$im2]?>" title="<?=lang('check_for_del_img')?>" />
		<input type="hidden" name="oldthumb[<?=$id_gbr?>][<?=$im2?>]" value="<?=$gambar['thumb'][$im2]?>" />
		<? }?>
		<br />
	<? }?>
	
	</li></ul><br class="clr" /><br />
	<?=lang('intro_pic')?><br />

	<?=loadImg('icon/break.png',array('class'=>'break'),false,config_item('modulename'),true)?>
	<input type="file" name="intro[<?=$id_gbr?>][1]" value="" />
	<? 
	// *note: field intro ini harus di kasih format array karena looping nya akan bersatu dengan yg lainnya, jika akan di input ke table, format nya di rubah ke format single oleh script
	if(!isset($input) && isset($gambar['intro'])){?>
	<span class="bubbleInfo">
		<?=loadImg('icon/zoom.png',array('class'=>'picu'),false,config_item('modulename'),true)?>
		<span class="boxpop"><?=loadImgProduk($id.'/'.$id_gbr.'/'.$gambar['intro'])?></span>
	</span>
	<input type="checkbox" name="delimg_intro[<?=$id_gbr?>][1]" value="<?=$gambar['intro']?>" title="<?=lang('check_for_del_img')?>" />
	<input type="hidden" name="oldintro[<?=$id_gbr?>]" value="<?=$gambar['intro']?>" />
	<? }
	// *note: format oldintro disini tetap pada format single data (tdk pakai array) karena hanya ada 1 gambar, format single ini yg akan jd format ke db
	?>
	<br />
	</td>
</tr>
<?
$id_first_attr=$def_stock=$checked_first_stock=$checked_stock_khusus='';
if($dtgambar['jenis_stock']=='1'){
	$id_first_attr = array_shift(array_keys($dtgambar['attr'])); #var_dump($id_first_attr);
	$first_attr = array_shift($dtgambar['attr']); #var_dump($first_attr);
	$def_stock = $first_attr['stock'];
	$checked_first_stock='checked="checked"';
// jika stock khusus
}else{ $checked_stock_khusus='checked="checked"';}
?>
<tr>
	<th><?=lang('attr_stock')?><input <?=$checked_first_stock?> class="radio_stock" type="radio" name="jenis_stock[<?=$id_gbr?>]" value="1"></th>
	<td>
		<?=form_hidden("old_jenis_stock[$id_gbr]",$dtgambar['jenis_stock'])?>
		<input type="text" name="stock_umum[<?=$id_gbr?>]" value="<?=$def_stock?>" /> *<?=lang('stock')?> (<?=lang('if_change_to_attr_khusus')?>)
		<? if($id_first_attr!=''){?>
		<input type="hidden" name="idattr_umum[<?=$id_gbr?>]" value="<?=$id_first_attr?>" />
		<? }?>
	</td>
</tr>
<tr>
	<th><?=lang('attr_khusus')?><input <?=$checked_stock_khusus?> class="radio_stock" type="radio" name="jenis_stock[<?=$id_gbr?>]" value="2"></th>
	<td>
		<table id="list-input" class="stock_khusus">
		<thead><tr>
			<th><?=lang('ukuran')?></th>
			<th><?=lang('stock')?></th>
		</tr></thead>
		<tbody id="body_attr_khusus">
		<? $ii=0;foreach($dtgambar['attr'] as $id_attr=>$v_attr){$ii++;?>
		<tr>
			<td><input type="text" name="ukuran[<?=$id_gbr?>][<?=$ii?>]" value="<?=$v_attr['ukuran']?>" />
			<input type="hidden" name="idattr[<?=$id_gbr?>][<?=$ii?>]" value="<?=$id_attr?>" />
			</td>
			<td><input type="text" name="stock[<?=$id_gbr?>][<?=$ii?>]" value="<?=$v_attr['stock']?>" /></td>
		</tr>
		<? }?>
		<? for($ii=$ii;$ii<10;$ii++){?>
		<tr>
			<td><input type="text" name="ukuran_new[<?=$id_gbr?>][<?=$ii?>]" value="" /></td>
			<td><input type="text" name="stock_new[<?=$id_gbr?>][<?=$ii?>]" value="" /></td>
		</tr>
		<? }?>
		</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>
</fieldset>
<? }} // end looping gambar default?>

<?
// looping gambar other
if(isset($data_gambar['other'])){ #print_r($data_gambar['other']);
foreach($data_gambar['other'] as $o_id_gbr=>$o_dtgambar){ $jml_gambar_looping++;
	$o_gambar=unserialize($o_dtgambar['gbr']);
?>
<?=form_hidden('id_img['.$o_id_gbr.']',$o_id_gbr)?>
<fieldset>
<legend><input type="checkbox" name="dell_group_img[<?=$o_id_gbr?>]" value="<?=$o_id_gbr?>" title="<?=lang('check_for_del_img_group')?>" /><?=lang('gambar')?></legend>
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('img_def')?></th>
	<td><input class="def_img" type="checkbox" name="def_img[<?=$o_id_gbr?>]"> <?=lang('make_this_image_default')?></td>
</tr>
<tr>
	<th><?=lang('gambar')?></th>
	<td>
	<ul class="file"><li>
	<?=lang('big_pic')?><br />
	
	<? for($im=1;$im<=5;$im++){?>
		<?=loadImg('icon/break.png',array('class'=>'break'),false,config_item('modulename'),true)?>
		<input type="file" name="big[<?=$o_id_gbr?>][<?=$im?>]" value="" />
		<? if(!isset($input) && isset($o_gambar['big'][$im])){?>
		<span class="bubbleInfo">
			<?=loadImg('icon/zoom.png',array('class'=>'picu'),false,config_item('modulename'),true)?>
			<span class="boxpop"><?=loadImgProduk($id.'/'.$o_id_gbr.'/'.$o_gambar['big'][$im])?></span>
		</span>
		<input type="checkbox" name="delimg_big[<?=$o_id_gbr?>][<?=$im?>]" value="<?=$o_gambar['big'][$im]?>" title="<?=lang('check_for_del_img')?>" />
		<input type="hidden" name="oldbig[<?=$o_id_gbr?>][<?=$im?>]" value="<?=$o_gambar['big'][$im]?>" />
		<? }?>
		<? if($im==1){?><span class="note">*<?=lang('main_pic')?></span><? }?>
		<br />
	<? }?>
	
	</li><li>
	<?=lang('small_pic')?><br />
	
	<? for($im2=1;$im2<=5;$im2++){?>
		<?=loadImg('icon/break.png',array('class'=>'break'),false,config_item('modulename'),true)?>
		<input type="file" name="thumb[<?=$o_id_gbr?>][<?=$im2?>]" value="" />
		<? if(!isset($input) && isset($o_gambar['thumb'][$im2])){?>
		<span class="bubbleInfo">
			<?=loadImg('icon/zoom.png',array('class'=>'picu'),false,config_item('modulename'),true)?>
			<span class="boxpop"><?=loadImgProduk($id.'/'.$o_id_gbr.'/'.$o_gambar['thumb'][$im2])?></span>
		</span>
		<input type="checkbox" name="delimg_thumb[<?=$o_id_gbr?>][<?=$im2?>]" value="<?=$o_gambar['thumb'][$im2]?>" title="<?=lang('check_for_del_img')?>" />
		<input type="hidden" name="oldthumb[<?=$o_id_gbr?>][<?=$im2?>]" value="<?=$o_gambar['thumb'][$im2]?>" />
		<? }?>
		<br />
	<? }?>
	
	</li></ul><br class="clr" /><br />
	<?=lang('intro_pic')?><br />

	<?=loadImg('icon/break.png',array('class'=>'break'),false,config_item('modulename'),true)?>
	<input type="file" name="intro[<?=$o_id_gbr?>][1]" value="" />
	<? if(!isset($input) && isset($o_gambar['intro'])){?>
	<span class="bubbleInfo">
		<?=loadImg('icon/zoom.png',array('class'=>'picu'),false,config_item('modulename'),true)?>
		<span class="boxpop"><?=loadImgProduk($id.'/'.$o_id_gbr.'/'.$o_gambar['intro'])?></span>
	</span>
	<input type="checkbox" name="delimg_intro[<?=$o_id_gbr?>][1]" value="<?=$o_gambar['intro']?>" title="<?=lang('check_for_del_img')?>" />
	<input type="hidden" name="oldintro[<?=$o_id_gbr?>]" value="<?=$o_gambar['intro']?>" />
	<? }?>
	<br />
	</td>
</tr>
<?
$o_id_first_attr=$o_def_stock=$o_checked_first_stock=$o_checked_stock_khusus='';
if($o_dtgambar['jenis_stock']=='1'){
	$o_id_first_attr = array_shift(array_keys($o_dtgambar['attr'])); #var_dump($id_first_attr);
	$o_first_attr = array_shift($o_dtgambar['attr']); #var_dump($first_attr);
	$o_def_stock = $o_first_attr['stock'];
	$o_checked_first_stock='checked="checked"';
// jika stock khusus
}else{ $o_checked_stock_khusus='checked="checked"';}
?>
<tr>
	<th><?=lang('attr_stock')?><input <?=$o_checked_first_stock?> class="radio_stock" type="radio" name="jenis_stock[<?=$o_id_gbr?>]" value="1"></th>
	<td>
		<?=form_hidden("old_jenis_stock[$o_id_gbr]",$o_dtgambar['jenis_stock'])?>
		<input type="text" name="stock_umum[<?=$o_id_gbr?>]" value="<?=$o_def_stock?>" /> *<?=lang('stock')?> (jika mengganti stock ke attribut_khusus maka history stock akan dihapus!)
		<? if($o_id_first_attr!=''){ ?>
		<input type="hidden" name="idattr_umum[<?=$o_id_gbr?>]" value="<?=$o_id_first_attr?>" />
		<? }?>
	</td>
</tr>
<tr>
	<th><?=lang('attr_khusus')?><input <?=$o_checked_stock_khusus?> class="radio_stock" type="radio" name="jenis_stock[<?=$o_id_gbr?>]" value="2"></th>
	<td>
		<table id="list-input" class="stock_khusus">
		<thead><tr>
			<th><?=lang('ukuran')?></th>
			<th><?=lang('stock')?></th>
		</tr></thead>
		<tbody id="body_attr_khusus">
		<? $ii=0;foreach($o_dtgambar['attr'] as $o_id_attr=>$o_v_attr){$ii++;?>
		<tr>
			<td><input type="text" name="ukuran[<?=$o_id_gbr?>][<?=$ii?>]" value="<?=$o_v_attr['ukuran']?>" />
			<input type="hidden" name="idattr[<?=$o_id_gbr?>][<?=$ii?>]" value="<?=$o_id_attr?>" />
			</td>
			<td><input type="text" name="stock[<?=$o_id_gbr?>][<?=$ii?>]" value="<?=$o_v_attr['stock']?>" /></td>
		</tr>
		<? }?>
		<? for($ii=$ii;$ii<10;$ii++){?>
		<tr>
			<td><input type="text" name="ukuran_new[<?=$o_id_gbr?>][<?=$ii?>]" value="" /></td>
			<td><input type="text" name="stock_new[<?=$o_id_gbr?>][<?=$ii?>]" value="" /></td>
		</tr>
		<? }?>
		</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>
</fieldset>
<? }} // end looping gambar other?>

<div id="body_gbr"></div>
<input type="hidden" id="jml_gbr" value="<?=$jml_gambar_looping?>">
<input type="hidden" id="jml_gbr_old" value="<?=$jml_gambar_looping?>">

<div style="display:none">
	<a class="add_gbr" href="#" title="<?=lang('add_gbr')?>">
	<?=loadImg('icon/add.png',array('class'=>'add'),false,config_item('modulename'),true)?> tambah gambar
	</a>
	<a class="dell_gbr" href="#" title="<?=lang('dell_gbr')?>">
	<?=loadImg('icon/delete.png',array('class'=>'dell'),false,config_item('modulename'),true)?> hapus gambar
	</a>
</div>
<br />
<br />

<fieldset>
<legend><?=lang('attr_plus')?></legend>
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('attr_plus')?></th>
	<td>
		<table id="list-input">
		<thead><tr>
			<th><?=lang('attr')?></th>
			<th><?=lang('isi_attr')?></th>
		</tr></thead>
		<tbody id="body_attr_umum">
		<? $ii=0;if($data_attr){foreach($data_attr as $id_attr=>$v_attr){$ii++;?>
		<tr>
			<td><input type="text" name="attr[<?=$id_attr?>]" value="<?=$v_attr['key']?>" /></td>
			<td><input type="text" name="isi_attr[<?=$id_attr?>]" value="<?=$v_attr['val']?>" /></td>
		</tr>
		<? }}?>
		<? for($ii2=$ii;$ii2<5;$ii2++){?>
		<tr>
			<td><input type="text" name="new_attr[<?=$ii2?>]" value="" /></td>
			<td><input type="text" name="new_isi_attr[<?=$ii2?>]" value="" /></td>
		</tr>
		<? }?>
		</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>
</fieldset>
<br />

<fieldset class="diskon" style="display:none;">
<legend><?=lang('in_diskon')?></legend>
<table class="admintable" cellspacing="1">
<tbody>
<tr>
	<th><?=lang('ket_diskon')?></th>
	<td><textarea name="ket_diskon" class="ket_diskon"><?=$ketdiskon?></textarea></td>
</tr>
<tr>
	<th><?=lang('harga_awal')?></th>
	<td>Rp. <input type="text" class="digit" name="harga_awal_diskon" value="<?=currency($hadiskon)?>" /><input value="<?=$hadiskon?>" type="hidden" name="hid_harga_awal_diskon" class="fixdigit" />
	<span class="note">*<?=lang('must_int')?></span></td>
</tr>
<tr>
	<th><?=lang('harga_baru')?></th>
	<td>Rp. <input type="text" class="digit" name="harga_baru_diskon" value="<?=currency($hbdiskon)?>" /><input value="<?=$hbdiskon?>" type="hidden" name="hid_harga_baru_diskon" class="fixdigit" />
	<span class="note">*<?=lang('must_int')?></span></td>
</tr>
</tbody>
</table>
</fieldset>
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

$("select[name='vendor']'").val($('option:first', $("select[name='vendor']")).val());
$("select[name='kat']'").val($('option:first', $("select[name='kat']")).val());

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
