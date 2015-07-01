<!DOCTYPE HTML>
<html lang="id">
<head>

	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="keywords" content="<?=$keyword?>" />
	<meta name="description" content="<?=$description?>" />
	<link href='<?=base_url()?>themes/simple/img/images/logo.png' rel='SHORTCUT ICON'/>
	<title><?=$title?></title>

	<?=loadCss('index.css')?>
	<?=loadCss('style.css')?>
	<!-- <?=loadCss('jquery.jscrollpane.css')?> -->
	<?=loadCss('nav.css')?>
	<?=loadCss('js/socialfeed/css/jquery.socialfeed.css',false,true,false,true)?>
    
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
    <?=loadJs('jquery.js',false,true)?>
    <?=loadJs('socialfeed/bower_components/codebird-js/codebird.js',false,true)?>
    <?=loadJs('socialfeed/bower_components/doT/doT.min.js',false,true)?>
    <?=loadJs('socialfeed/bower_components/moment/min/moment.min.js',false,true)?>
    <?=loadJs('socialfeed/js/jquery.socialfeed.js',false,true)?>
	<!-- lib for fancy -->
	<?=loadJs('fancybox/jquery.fancybox-1.3.0.pack.js',false,true)?>
	<?=loadCss('js/fancybox/jquery.fancybox-1.3.0.css',false,true,false,true)?>	
	<?=loadJs('jquery.corner.js',false,true)?>
  
    
	<script>
			(function($) {
			$.fn.menumaker = function(options) {  
				var cssmenu = $(this), settings = $.extend({
			   		format: "dropdown",
			   		sticky: false
			 		}, options);
			 	return this.each(function() {
			   		$(this).find(".mbutton").on('click', function(){
				 		$(this).toggleClass('menu-opened');
				 		var mainmenu = $(this).next('ul');
				 		if (mainmenu.hasClass('open')) { 
				   			mainmenu.slideToggle().removeClass('open');
				 		}else {
				   			mainmenu.slideToggle().addClass('open');
				   			if (settings.format === "dropdown") {
					 			mainmenu.find('ul').show();
				   			}
				 		}
			   		});
			   		cssmenu.find('li ul').parent().addClass('has-sub');
					multiTg = function() {
				 		cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
				 		cssmenu.find('.submenu-button').on('click', function() {
				   			$(this).toggleClass('submenu-opened');
				   				if ($(this).siblings('ul').hasClass('open')) {
					 				$(this).siblings('ul').removeClass('open').slideToggle();
				   				}else {
					 				$(this).siblings('ul').addClass('open').slideToggle();
				   				}
				 			});
			   			};
			   			if (settings.format === 'multitoggle') multiTg();
			   			else cssmenu.addClass('dropdown');
			   			if (settings.sticky === true) cssmenu.css('position', 'fixed');
						resizeFix = function() {
			  				var mediasize = 700;
				 			if ($( window ).width() > mediasize) {
				  				cssmenu.find('ul').show();
				 			}
				 			if ($(window).width() <= mediasize) {
				   				cssmenu.find('ul').hide().removeClass('open');
				 			}
			   			};
			   			resizeFix();
			  			 return $(window).on('resize', resizeFix);
			 		});
			  };
			  
			  $(document).ready(function(){
				$('.nav-search').hide();
				$('.nav-user').hide();
				
				$('.search-button').click(function(){
					$('.nav-search').slideDown(300);
				});
				
				$('.user-button').click(function(){
					$('.nav-user').slideDown(300);
				});
				
				$(document).mouseup(function (e){
    				var container = $(".nav-user");
						if (!container.is(e.target) // if the target of the click isn't the container...
        				&& container.has(e.target).length === 0) // ... nor a descendant of the container
    				{
       	 				container.slideUp(300);
    				}
				});
				$( window ).resize(function() {
					$(".nav-search").hide();
					$('.nav-user').hide();
					
				});
				$(document).mouseup(function (e){
    				var container = $(".nav-search");
						if (!container.is(e.target) // if the target of the click isn't the container...
        				&& container.has(e.target).length === 0) // ... nor a descendant of the container
    				{
       	 				container.slideUp(300);
    				}
				});
				
				$('#to-top').click(function(){
					$("html, body").animate({ scrollTop: 0 }, "slow");
				});
				$("#cssmenu").menumaker({
					format: "multitoggle"
				});
			});
		})(jQuery);
	</script>
    
 
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow&v1' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Coustard:900' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Rochester' rel='stylesheet' type='text/css' />



	<?=isset($template['metadata'])?$template['metadata']:''?>
	<?=isset($customheader)?$customheader:''?>
</head>



	<header>
		<!--<div class="call_center">
			Call Center : 081320572408
		</div>
		<br>-->
		<div id="jb-toolbar" style="background:url('<?=base_url()?>themes/simple/img/images/header_bg.png') repeat;">
			
			<?=isset($template['partials']['pg_topbar'])?$template['partials']['pg_topbar']:''?>
		</div>
	</header>
<body style="background:url('<?=base_url()?>themes/simple/img/images/pattern.jpg');">

<div id="page" class="main">


	<section class="sidebar">
		
		<? if(isset($template['partials']['pg_block5'])){?>
		<div id="block_testi">
			<div id="block-wrap">
					<div id="intro">
						<? echo $template['partials']['pg_block5'];?>
					</div>
			</div>
		</div>
		<? }?>
	
	</section>
	<section class="konten">
		
		<div id="block-body">
			<? if(isset($template['partials']['pg_banner'])){?>
			<div id="block-banner">
				<? echo $template['partials']['pg_banner'];?>
			</div>
			<? }?>
		</div>
	
		<? if(isset($template['partials']['pg_block4'])){?>
		<div id="block_produk_terbaru">
			<div id="block-wrap">
					<div id="intro">
						<? echo $template['partials']['pg_block4'];?>
					</div>
				
						
				
			</div>
		</div>
		<? }?>
	
		
	
	<div id="block-wrap">
		<div id="block-content" <?=isset($template['partials']['pg_sidebar'])?'class="width-content"':'';?>>
			<?=$template['body']?>
			<? if(isset($template['partials']['pg_block3'])){?>
				<div id="block-wrap">
				<? echo $template['partials']['pg_block3'];?>
				</div>
			<? }?>
		</div>
		
	</div>	
	
	</section>

</div>
	<div class="clearfix">
</div>
	<footer>
		<div class="foot-container">
		<? if(isset($template['partials']['pg_footer'])){echo $template['partials']['pg_footer'];}else{$this->template->load_view_ontheme('footer');}?>	
		</div>
	</footer>
</body>
</html>
