<br/>
<div style="max-height:800px">
	<div class="judula">
		ALL CATEGORY
	</div>
	<div class="garis"></div>
	<div class="list-cat">
	<?php
		$i = 0;
		echo '<ul class="colcat">';
		foreach($listkat as $kat){ $i++;
			echo '<li>';
			echo '<h3>'.$kat['kategori'].'</h3>';
			foreach($kat['listsubkat'] as $subkat){
				echo $subkat['subkategori']." (".$subkat['jmlh'].")";
				echo '<br/>';
			}
			echo '</li>';
			if($i>=6){
				echo '</ul><ul class="colcat">';
				$i=0;
			}
		}
		echo '</ul>';
	?>
	</div>
</div>