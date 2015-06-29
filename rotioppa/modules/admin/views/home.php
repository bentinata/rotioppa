	<div class="header">
	<?=loadImgThem('icon/mainmenu.png','',false,config_item('modulename'),true)?>
	<span><?=lang('main_menu')?></span>
</div>

<div id="box-home">
<div id="cpanel">
	<div style="float: left;">
		<div class="icon">
			<a href="<?=site_url(config_item('modulename').'/produk')?>">
			<?=loadImgThem('icon/big-produk.png','',false,config_item('modulename'),true)?>					
			<span>Produk</span></a>
		</div>
	</div>
	<div style="float: left;">
		<div class="icon">
			<a href="<?=site_url(config_item('modulename').'/produk/input')?>">
			<?=loadImgThem('icon/big-produk-input.png','',false,config_item('modulename'),true)?>					
			<span>Input Produk</span></a>
		</div>
	</div>

	
	
</div>
<br style="clear:both" />
</div>