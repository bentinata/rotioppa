<div style="margin-top:10px;margin-bottom:10%;padding-bottom:10%;">
<?if($list){?>
   <?foreach ($list as $dlist) {?>
	<div style="min-height:400px;padding:10px;" class="content-text">
					<div class="judul" style="font-family: 'lobster_1.4regular';color:#9d82bf;">

						<?=$dlist->judul_promo?>
					</div>
					<div class="garis" style="margin-top:10px;"></div>
		            <br />			
		<div class="box-content">
				<div style="display:inline-block;">
					<div class="leftside width-sidebar">
						<div class="jelas" style="font-family: 'open_sansregular';margin:0;">
						<?if($dlist->image){?>
						<img src="<?=base_url()?>uploads/promo/<?=$dlist->image?>" height="300">
						<?}?>
						<?=$dlist->Promo?>
						</div>
					</div>
				</div>
		</div>	
	</div>
	<? } ?>
<?}else{?>

	<div style="min-height:400px;margin-top:10px;" class="content-text" >
		<div class="box-content">
			<div id="kontak">
				<div class="judul" style="font-family: 'lobster_1.4regular';color:#9d82bf;">
						Belum ada promo
					</div>
			</div>
		</div>
	</div>
<?}?>
</div>