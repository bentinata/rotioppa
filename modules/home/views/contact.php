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
    
<div style="min-height:400px;font-family:tahoma;" class="content-text">
<div class="judula"  style="font-family: 'lobster_1.4regular';color:#9d82bf;">
	Kontak
</div>
<div class="garis" style="margin-top:10px;">
</div>
<div class="box-content">
	<div id="kontak" style="width:100%;">
	<div id="address" style="width:80%;">
		<div class="takon" style="width:80%;
    font-family: 'open_sansregular';">
			<h5>Kontak Kami</h5>
			<ul>
				
				<li>Jl. Surapati No.59 Bandung</li>
				<li>Tlp : (022) 82526189</li>
				<li>Agung : 0813 2038 9126</li>
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

