	<br><div class="judul">
		TESTIMONIAL
	</div>
	<div class="garis"></div><br>
<br>
<div id="wrap_wrap_testi">
	<? 
	$a = 0;
	$b = 3;
	$no = 1;
	
	$aa = "";
	$bb  = "";
	$cc = "";
	if($testimoni){foreach($testimoni as $ts){
		if($no == 1 + ($a*$b)){
			$aa = $aa."	
			<li class='box_content'>
			<div class='space_blog'>
				<div class='blog'>
					<div class='box_news'>
							
						<div class='isi list_artikel'>
								<div class='wrap_author'>
									<div class='jberita'><i>".$ts->testimoni."</i></div>
								</div>
									<div class='author_testi'>".$ts->pengirim."</div>
						</div>
						</div>
						</div>
						</div>
					</li>";
		}else if($no == 2 + ($a*$b)){
			$bb = $bb."	<li class='box_content'>
			<div class='space_blog'>
				<div class='blog'>
					<div class='box_news'>
							
						<div class='isi list_artikel'>
								<div class='wrap_author'>
									<div class='jberita'><i>".$ts->testimoni."</i></div>
									</div>
										<div class='author_testi'>".$ts->pengirim."</div>
								</div>
							</div>
							</div>
						</div>
					</li>";
		}else if($no == 3 + ($a*$b)){
			$cc = $cc."	<li class='box_content'>
			<div class='space_blog'>
				<div class='blog'>
					<div class='box_news'>
							
						<div class='isi list_artikel'>
								<div class='wrap_author'>
									<div class='jberita'><i>".$ts->testimoni."</i></div>
									</div>
										<div class='author_testi'>".$ts->pengirim."</div>
								</div>
								</div>
							</div>
						</div>
					</li>";
		}
		if($no % 3 == 0){$a++;}
		$no++;
		}}
		?>
		
	<div class="testi_kiri bar-testi">
    	<ul>
        	<?= $aa ?>
        </ul>
    </div>
    <div class="testi_tengah bar-testi">
    	<ul>
        	<?= $bb ?>
        </ul>
    </div>
    <div class="testi_kanan bar-testi">
    	<ul>
        	<?= $cc ?>
        </ul>
    </div>
</div>