<div id="block-sidebar_kanan" class="width-sidebar">
				<div class="box_testi">
					<div class="testimoni" align="left">
						Best Sellers
					</div><div class="garis2"></div>
					<? 
					if(isset($best) && $best){
						foreach($best as $dlist){
						$gbr=unserialize($dlist->gbr); 
						$ha=get_price($dlist->ha_prop,$dlist->hb_prop,$dlist->ha_diskon,$dlist->hb_diskon,'ha');
						$hb=get_price($dlist->ha_prop,$dlist->hb_prop,$dlist->ha_diskon,$dlist->hb_diskon);	
						?>
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
										<h3><a href="<?=site_url('home/detail/index/'.$dlist->id.'/'.en_url_save($dlist->nama_produk))?>"><?=$dlist->nama_produk?></a></h3>
										<h4>
											<span><span class="rp">Rp.<?=currency($ha)?></span><br/>Rp.<?=currency($hb)?></span>
										</h4>
										<!--div class="beli" align="center">
											<span><a href=""><?=theme_img('beli_sekarang.png')?></a></span>
											<span><a href=""><?=theme_img('details.png')?></a></span>
										</div-->
									</div>
								</div>
							</div>
						</div>	
				<? 		}
					}
				?>					
			</div>
			</div>