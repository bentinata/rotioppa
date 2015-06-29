	
		<!-- image slider -->
<? #=loadJs('nivoslider/jquery.nivo.slider.pack.js')?>
<? #=loadCss('js/nivoslider/nivo-slider.css',false,false,false,true)?>
<script type="text/javascript">
$(document).ready(function(){	
	$("#slider").nivoSlider({
		effect:'fold',
		captionOpacity:0,
		animSpeed:100,
		pauseTime:8000
	});

	$("a.showBigC").fancybox({
		'padding'			:5,
		'titleShow'    	:false,
		'transitionIn'		:'elastic',
		'transitionOut'	:'elastic',
		'speedIn'			:500,
		'centerOnScroll'	:true,
		'onComplete': function(){$("#fancybox-outer").css("background","transparent");}
	});

});	
</script>
<div style="min-height:400px" class="content-text">

<div id="slider" class="big-banner">
        	<img src="<?=base_url()?>/themes/simple/img/images/banne.png" alt="Home" class="home" style="margin: 2% 0 0 0%; text-align:center;" />
			
</div>
<div class="box-content">
	<div id="kontak">
	<div id="address">
		<div style="display:inline-block;">
			<div class="judul" style="font-family: 'lobster_1.4regular';color:#9d82bf;">
				Tentang Roti Oppa
			</div>
			<div class="garisi" style="margin-top:10px;"></div>
            <br />			
			<div class="leftside width-sidebar">
			<div class="jelas" style="font-family: 'open_sansregular';">
			
		<?=strtok(file_get_contents("./assets/web/profile.txt"),".");?>.	
						
			</div>
			</div>
		</div>
		<div class="judul" style="font-family: 'lobster_1.4regular';color:#9d82bf;">
				Produk
		</div>
			<div class="garisi" style="margin-top:10px;"></div>
            <br />			
			<div id="ca-container" class="ca-container" >
					<?if($list){?>
        <div id="viewajax2">
    	<div id="wrap_wrap_collect">

	<ul>
		<?foreach($list as $dlist){?>
					<li class="listproduk">
				<div class="wrap_collect">
					<div class="box_news">
						<div class="isi" style="padding:0px">
							<div class="wrap_author">
								<div class="image_collect" align="center">
									<a href="#popup" onClick="popup('<?=$dlist->menu?>','<?=$dlist->image?>','<?=$dlist->deskripsi?>','<?=$dlist->menuid?>')" >
									<img src="<?=base_url()?>uploads/produk/<?=$dlist->menuid?>/thumbnail/<?=$dlist->image?>" alt="28/48/lumpur_cinnamon2.jpg">									</a>
																
								</div>
								<h3 align="center"><a href="#popup"><?=$dlist->menu?></a></h3>
							</div>
						</div>
					</div>
				</div>
			</li>
		<?}?>
			
				</ul>
</div>
    </div>
<?}else{?>
	<br><h3><b>Data tidak di temukan</b></h3>
<?}?>

			</div>
	</div>
		
	<br/>
	<br/>
</div>
</div>
	
</div>

	

<div class="box-title-footer">
	<br><br>
<center>
<div id="container">
	<div class="pagination">
		</div>
	</div>
</center>
			<br>
	
<div id="popup">	
<!-- rating -->
<div class="data-popup">

<a href="#" class="close-button" >X</a>
<p id="menu_prod" style="font-family:lobset1.4_regular;width:100%; border-bottom: 3px dashed; font-size: 24px; font-weight:bold;margin-bottom:30px;text-align:left;">Daftar Kue</p>
			<div class="detailproduk column">
				<div class="column imgpreview">
										<div class="bigfilmstrip column" id="big_32">
						<div class="wrap-img">
															<div class="anim column " id="big_32_1">
								<a href="#" class="showBig">
								<img src="" id="img_prod">
								</a>
								</div>
													</div>
						<!--<p class="noteclick">* Klik untuk memperbesar gambar</p>-->
					</div>				
					<!-- data for stock -->		
					<br class="clear">

				</div>


			<div class="space_blog">
				<div class="form_pendaftaran_mitra">
					<div class="head">
						Deskripsi Produk
					</div>
					<div id="deskripsi_prod" style="text-align:left;font-family:open_sansregular;margin-left:167px;font-size:14px;">
						
					</div>
					
				</div>		
			</div>
	</div>
	<div class="clear"></div>
</div>
</div>
<script>


function popup(menu,img,deskripsi,id){

	$('#menu_prod').html(menu);
	$('#deskripsi_prod').html(deskripsi);
	$('#img_prod').attr('src','<?=base_url()?>uploads/produk/'+id+'/'+img);
	
}

</script>