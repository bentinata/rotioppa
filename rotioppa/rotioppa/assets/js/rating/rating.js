/* USE
------- for view -----
<span style="float:right"><div id="staroff">
<div id="staron" style="width:<?=(16*$banyakBintang)?>px;"></div></div></span>

------- for input -----
	<input type="hidden" name="bintang" id="val_bintang" value="" />
	<ul class="bintang">
		<li id="b1" val="1"></li>
		<li id="b2" val="2"></li>
		<li id="b3" val="3"></li>
		<li id="b4" val="4"></li>
		<li id="b5" val="5"></li>
	</ul>

*/
$(function(){
	$('li','.bintang').mouseover(function(){ 
		// clear all stars
		$('li','.bintang').attr('class','');
		// select hover stars
		j=$(this).attr('val');
		for(u=1;u<=j;u++){
			$('#b'+u).attr('class','select');
		}
	}).mouseout(function(){
		// clear all stars
		$('li','.bintang').attr('class','');
		// get value before and select stars
		b_val = $("#val_bintang").val();
		for(u=1;u<=b_val;u++){
			$('#b'+u).attr('class','select');
		}
	}).click(function(){
		j=$(this).attr('val');
		for(u=1;u<=j;u++){
			$('#b'+u).attr('class','select');
		}
		$("#val_bintang").val(j);
	});
});