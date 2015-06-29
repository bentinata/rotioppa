<div id="wrap_wrap_collect">
	<ul>
		<? 
			foreach($list as $dlist){
				
			?>
			<li class="listproduk">
				<div class="wrap_collect">
					<div class="box_news">
						<div class="isi" style="padding:0px">
							<div class="wrap_author">
								<div class="image_collect" align="center">
								<? if($dlist->image){?>
									<a href="#">
									<img src="<?=base_url()?>uploads/produk/<?=$dlist->menuid?>/thumbnail/<?=$dlist->image?>"/>
									</a>
								<? }else{
										echo "<a href='#'>".theme_img('noimage.gif')."</a>";
									}
								?>
								
								</div>
								<h3 align="center"><a href="#"><?=$dlist->menu?></a></h3>
							</div>
						</div>
					</div>
				</div>
			</li>
			<? } ?>
	</ul>
</div>
