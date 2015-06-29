$(document).ready(function(){
	$('.bubbleInfo').each(function () {
		var distance = 50;
		var time = 150;
		var hideDelay = 100;
		var hideDelayTimer = 100;
		var beingShown = false;
		var shown = false;
		var picu = $('.picu', this);
		var info = $('.boxpop', this).css('opacity', 0);
				
		$([picu.get(0), info.get(0)])
		.mouseover(function () { 
			if (hideDelayTimer) clearTimeout(hideDelayTimer);
			if (beingShown || shown) {
				return;
			} else {
				var popX = popY = 0;
				var off_set = $(picu.get(0)).offset();
				var wd = $(picu.get(0)).width();
				popY = off_set.top; 
				popX = off_set.left; //alert(popX+","+popY);
				beingShown = true;
				info.css({
					top: -1,
					left: +wd+distance,
					display: 'block'
				}).animate({
					left: '-=' + distance + 'px',
					opacity: 0.9
					}, time, 'swing', function() {
						beingShown = false;
						shown = true;
				});
			}
			return false;
		}).mouseout(function () {
			if (hideDelayTimer) clearTimeout(hideDelayTimer);
			hideDelayTimer = setTimeout(function () {
			hideDelayTimer = null;
			info.animate({
				left: '-=' + distance + 'px',
				opacity: 0
			}, time, 'swing', function () {
				shown = false;
				info.css('display', 'none');
			});
			}, hideDelay);
			return false;
		});
	});

	// toogle slide up and down the sub menu
	$('.submenu').hover(function(){
		the_child = $('.menu_child',this); //alert($('.sub',this).width());
		if(the_child.html()){ 
			the_child.css({'left':$('.sub',this).width()+'px','top':$('.sub',this).position().top+'px'});
			the_child.slideDown();
		}
	},function(){
		the_child.slideUp();
	}); 
});
