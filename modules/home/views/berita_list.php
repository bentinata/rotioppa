<? foreach($list as $br){?>
		<li class="box_content">
			<div class="space_blog">
				<div class="blog">
					<div class="box_news">
                    	
						<div class="isi list_artikel">
							<div class="wrap_author"><? $a = "home/berita/".$br->id;?>	
								<div class="jberita"><a href="<?=site_url($a)?>"><?= $br->title ?></a></div>
									<p style="font-size:13px;">by kueibuhasan| <?=
$newDate = date("M d, Y", strtotime($br->date_input)); ?> | kueibuhasan Tips</p>
							</div> 
								<?= $br->summary ?>
								<a href="<?=site_url($a)?>">Read More...</a>
						</div>
					</div>
				</div>		
			</div> 
		</li>
		<? } ?>