
	<div class="judula">
		<?= $artikel->title?>
	</div>
	<div class="garis"></div>
<div id="kemitraan">
	<ul class="form-kiri2">	
		<li class="box_content">
			<div class="space_blog">
				<div class="blog">
					<div class="box_news">
						<div class="isi">
							<div class="wrap_author">
									<p>by kueibuhasan| <?=
$newDate = date("M d, Y", strtotime($artikel->date_input)); ?> | kueibuhasan Tips</p>
								</div> 
								<div align="center">
									<img src="<?=theme_img('Blog_03.png',false)?>">
								</div>
								
								<?= $artikel->content ?>
							</div>
						</div>
					</div>		
				</div>
			</div>
		</li>
		
	</ul>	
	<ul class="form-kanan2">	
		<li id="sisi">
			<div>
				<ul>
					<li id="block-sidebar_kanan" class="width-sidebar">
						<?=$template['partials']['pg_berita_lain'];?>
					</li>
				</ul>
				<ul>
					<li id="block-sidebar_kanan" class="width-sidebar">
						<?=$template['partials']['pg_kat_produk'];?>
					</li>
				</ul>
			</div>
		</li>
	</ul>
</div>

