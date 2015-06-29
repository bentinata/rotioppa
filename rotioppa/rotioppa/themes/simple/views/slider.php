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
<div id="slider" class="big-banner">
        	<img src="<?=base_url()?>/themes/simple/img/images/banne.png" alt="Home" class="home" style="margin: 2% 0 0 0%; text-align:center;" />
			
		</div>