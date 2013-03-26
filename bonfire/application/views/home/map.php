<style type="text/css">
	#map_canvas { height: 300px; width: 100%; }
</style>
<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>
<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>
<script type="text/javascript">

	$(document).ready(function() {

		MYMAP.init('#map_canvas', 15);
		//MYMAP.setCurrentMarker(true, address);
		//MYMAP.addDragMarkerEvent(MYMAP.currentMarker, '#places_address', '#places_latitude', '#places_longitude');
	});

</script>

<div class="container">
	<div id="map_canvas"></div>
</div>
