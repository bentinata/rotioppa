<div style="margin-left:200px"><?=loadImg('peduliIndonesia.jpg',false,FALSE,FALSE,TRUE)?></div><br />

<center>
<div id="slideshow" class="boxq" style="border-width:1px;border-color:#0D416A;padding:0;margin:0;width:600px;">
	<?=loadImg('samudra-slide-1a.jpg',array('class'=>'active'))?>
	<?=loadImg('samudra-slide-2a.jpg')?>
	<?=loadImg('samudra-slide-3a.jpg')?>
</div>
</center>
<br />
<br />
<br />

<p style="font-size:12px;line-height:20px;width:600px;font-family:Verdana, Geneva, sans-serif;text-align:justify;margin-left:200px">
Kami menyadari bahwa Pendidikan Indonesia menjadi faktor utama keberhasilan sebuah bangsa dan kami percaya bahwa kemiskinan dan tindakan kekerasan yang sering terjadi di Indonesia di sebabkan karena kurangnya pendidikan yang diterima oleh masyarakat.<br /><br />
Dan oleh sebab itu kami bertekad untuk membantu memberikan dan meningkatkan taraf pendidikan rakyat Indonesia dengan cara menyisihkan 2,5 % setiap keuntungan yang kami dapatkan dari setiap transaksi pembelian yang terjadi di kueibuhasan.com.<br /><br />
<strong>Bersama kita tingkatkan kesejahteraan bangsa Indonesia melalui Pendidikan :-) .</strong>
</p>

<script type="text/javascript">

/*** 
    Simple jQuery Slideshow Script
    Released by Jon Raasch (jonraasch.com) under FreeBSD license: free to use or modify, not responsible for anything, etc.  Please link out to me if you like it :)
***/

function slideSwitch() {
    var $active = $('#slideshow IMG.active');

    if ( $active.length == 0 ) $active = $('#slideshow IMG:last');

    // use this to pull the images in the order they appear in the markup
    var $next =  $active.next().length ? $active.next()
        : $('#slideshow IMG:first');

    // uncomment the 3 lines below to pull the images in random order
    
    // var $sibs  = $active.siblings();
    // var rndNum = Math.floor(Math.random() * $sibs.length );
    // var $next  = $( $sibs[ rndNum ] );


    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval( "slideSwitch()", 5000 );
});

</script>

<style type="text/css">

/*** set the width and height to match your images **/

#slideshow {
    position:relative;
    height:200px;
}

#slideshow IMG {
    position:absolute;
    top:0;
    left:0;
    z-index:8;
    opacity:0.0;
}

#slideshow IMG.active {
    z-index:10;
    opacity:1.0;
}

#slideshow IMG.last-active {
    z-index:9;
}

</style>
