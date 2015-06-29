	<br><div class="judul">
		CEK STOCK
	</div>
	<div class="garis"></div><br>
<div id="kemitraan">
	<ul class="form-kiri">
		<li class="box_content">
			<div class="space_blog">
				<div>
						<div class="form-input">
							<?=form_open('home/',array('id'=>'iform'))?>
								<table class="tbl">
									<tr>
										<td>Masukkan nama produk</td>
										<td>:</td>
										<td>
											<input class="tinput" type="text" name="inama" />
										</td>
									</tr>
									<tr>
										<td><br><br><br>Hasil Pencarian...</td>
									</tr>
								</table>
								<?=form_close()?>
						</div>
					
				</div>		
			</div>
		</li>
	</ul>	
	<ul class="form-kanan">	
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

