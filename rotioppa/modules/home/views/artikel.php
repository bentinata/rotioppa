	<br><div class="judula">
		Berita & Info
	</div>
	<div class="garis"></div><br>
<div id="kemitraan">
	<ul class="form-kiri2">	
		<li class="box_content">
			<div class="space_blog">
				<div class="blog">
					<div class="box_news" id="artikel">
						<div class="isi">
							<div class="wrap_author"><div align="center"></div>
								<div style="color:#000;font-size:22px; font-weight:bold; font-style:normal;padding:20px 0px 10px 0px;"><?= $artikel->title ?></div>
									<p><span style="color:#000">by</span> kueibuhasan<span style="color:#000">| <?=$newDate = date("M d, Y", strtotime($artikel->date_input)); ?> |</span> kueibuhasan Tips</p>
							</div> 
								<?= $artikel->content ?>
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
<div>
<br>
<br>

