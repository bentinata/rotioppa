<h3>Sampel data</h3>
<?=$search?>

<script language="javascript">
$(document).ready(function(){
	//load page viewer
	load_page_view('#loadpage');

	$("a[name='_RES']").click(function(){
		var urlpage = '<?=site_url(config_item('modulename').'/custress')?>';
		var objview = '#resultCustID';
		var postdata = 'id='+$(this).attr('title');
		get_page_content(urlpage,objview,postdata);
	});

	$('.detail').click(function(){
		$.fancybox({
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
			'hideOnOverlayClick': false,
			'href':$(this).attr('href'),
			'ajax':{
				type	: "POST",
				data	: "id="+$(this).attr('rel')
			}
		});
		return false;
	});
	
});
</script>
