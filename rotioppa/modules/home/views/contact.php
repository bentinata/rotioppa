<style type="text/css">
      html, body, #map-canvas { height: 300px; margin: 0; padding: 0;}
</style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLLISDJO92x95SJr0v6KSkFs6cKTy0X4I">
    </script>
    <script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: { lat:-6.8989759, lng:107.6208657},
          zoom: 20
        };

        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
        var marker = new google.maps.Marker({
         position: { lat:-6.8989759, lng:107.6208657},
         map: map
        });
      }

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    
<div style="min-height:400px" class="content-text">
<div class="judula">
	KONTAK
</div>
<div class="garis">
</div>
<div class="box-content">
	<div id="kontak">
	<div id="address">
		<div class="takon">
			<h5>Kontak Kami</h5>
			<ul>
				
				<li>Jl. Petogogan I No. 42 Kebayoran Baru - Jakarta Selatan</li>
				<li>Order : (021) 725 6856</li>
				<li>Outlet : (021) 7279 7576</li>
				<br/>
				<br/>
				
		<div id="map-canvas" style="border:1px solid #000;"></div>
			</ul>
		  </div>
	</div>
	<br/>
	<br/>
</div>
</div>
</div>

