<!DOCTYPE HTML>
<html lang="id">
<head>

	<meta charset="UTF-8" />
	<meta name="keywords" content="<?=$keyword?>" />
	<meta name="description" content="<?=$description?>" />
	<title><?=$title?></title>

	<?=loadCss('index.css')?>

	<?=loadJs('jquery.js',false,true)?>
	<?=loadJs('jquery.corner.js',false,true)?>
	<?=isset($customheader)?$customheader:''?>

	<script type="text/javascript">
	$(document).ready(function() {
		// square the box
		$('.boxq').corner("5px");$('.img-slider').corner("5px");
	});
	</script>
</head>

<body>

<div id="sam-wrap">
	<div id="sam-body">
		<div id="sam-content"><div class="sam-ct">
			<!-- content -->
			<?=$template['body']?>
		</div></div>
	</div>

</div>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function() {
	if(!$('#sam-sidebar').html()){
		$('#sam-content').css({width:'100%'});
	}
});
</script>

</body>
</html>
