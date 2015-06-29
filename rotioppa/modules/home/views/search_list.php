
<? 
foreach($list as $dlist){
	$gbr=unserialize($dlist->gambar);
    $ha=get_price($dlist->ha_prop,$dlist->hb_prop,$dlist->ha_diskon,$dlist->hb_diskon,'ha');
	$hb=get_price($dlist->ha_prop,$dlist->hb_prop,$dlist->ha_diskon,$dlist->hb_diskon);	
	/*?>
<div class="list-produk list-koleksi boxq">
	<? if(isset($gbr['intro'])){?>
	<div class="column intro"><?=loadImgProduk($dlist->id.'/'.$dlist->idgbr.'/'.$gbr['intro'])?></div>
	<? }?>
	<div class="columnr desc">
		<h5 class="link"><a href="<?=site_url('home/detail/index/'.$dlist->id.'/'.en_url_save($dlist->nama_produk))?>"><?=highlight_phrase($dlist->nama_produk,$key,'<span class="tag-search">','</span>')?></a></h5><br />
		<?=highlight_phrase($dlist->summary,$key,'<span class="tag-search">','</span>')?><br />
	<table><tr>
	<td>
		<? if($hb==0){?>
        <span class="rp">Rp. <?=currency($ha)?></span>
        <? }else{?>
		<span class="rpline">Rp. <?=currency($ha)?></span>&nbsp;&nbsp;
		<span class="rp">Rp. <?=currency($hb)?></span>
        <? }?>
	</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>	
		<? //------ rating bintang
		$def_width_star=11; // artinya 11px
		$total_width_star=0;
		if($dlist->rate!=0){
			$res_rate=$dlist->rate/$dlist->cust;
			$total_width_star=ceil($def_width_star*$res_rate);
		}
		?>
		<div id="staroff"><div id="staron" style="width:<?=$total_width_star?>px;"></div></div>
	</td>
	<td>
		<p><?=$dlist->rate?>/<?=$dlist->cust?></p>
	</td>
	</tr></table>
<br class="clear" />
<? /*
<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.kueibuhasan.com/home/detail/index/<?=$dlist->id.'/'.en_url_save($dlist->nama_produk)?>.html&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;font&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
/?>		
		<br /><br />
		<a href="<?=site_url('home/detail/index/'.$dlist->id.'/'.en_url_save($dlist->nama_produk))?>"><?=loadImg('detail.png',array('class'=>'columnr'))?></a>
	</div>
	<div class="clear"></div>
</div> */?>

	<li>
				<div class="wrap_collect">
					<div class="box_news">
						<div class="isi">
							<div class="wrap_author">
								<div class="image_collect" align="center">
								<? if(isset($gbr['intro'])){?>
									<a href="<?=site_url('home/detail/index/'.$dlist->id.'/'.en_url_save($dlist->nama_produk))?>">
									<?=loadImgProduk($dlist->id.'/'.$dlist->idgbr.'/'.$gbr['intro'])?>
									</a>
								<? }?>
								</div>
								<h3 align="center"><a href="<?=site_url('home/detail/index/'.$dlist->id.'/'.en_url_save($dlist->nama_produk))?>"><?=$dlist->nama_produk?></a></h3>
								<h4>
									<span>Rp.<?=currency($ha)?><br/><span class="rp">Rp.<?=currency($hb)?></span></span>
								</h4>
								<div class="beli" align="center">
									<span><a href="<?=site_url('home/detail/index/'.$dlist->id.'/'.en_url_save($dlist->nama_produk))?>"><?=theme_img('beli_sekarang.png')?></a></span>
								</div>								
							</div>
						</div>
					</div>
				</div>
			</li>
<? }?>

	