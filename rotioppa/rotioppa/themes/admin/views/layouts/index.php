<!DOCTYPE HT>
<html lang="id">
<head>
	<meta charset="UTF-8" />
	<meta name="keywords" content="<?=$keyword?>" />
	<meta name="description" content="<?=$description?>" />
	<title><?=$title?></title>
	
	<?=loadCss('index.css')?>
	<?=$template['metadata']?>

	<?=loadJs('jquery.js',false,true)?>
	<?=isset($customheader)?$customheader:''?>

	<!-- menu script -->
	<?=loadCss('menu/jqueryslidemenu.css')?>
	<!--[if lte IE 7]>
	<style type="text/css">
	html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
	</style>
	<![endif]-->
	<script language="javascript">
	pathImg = '<?=loadImgThem('css/menu/img/','',true,false,false,true)?>';
	</script>
	<?=loadJs('css/menu/jqueryslidemenu.js',false,false,false,true)?>

<body>
	<div id="bg-header">
		<span class="version">rotioppa.com</span>
		<span class="title">Admin Management - Administrator</span>
	</div>
	<div id="bg-center">
		<div id="tab-menu"><?=$template['partials']['menu'];?></div>
		<div id="user"><span><?=$this->login_lib->pos_get_data('username')?> - <?=format_date_ina(date('d m Y'))?></span></div>
		<div id="bg-content"><?=$template['body']?></div>
	</div>
	<div id="bg-footer">
	&copy;2015 rotioppa.com - Management - Administrator<br />
	Halaman admin untuk pengaturan website dan produk - produk rotioppa.com
	</div>
</body>
</html>
 