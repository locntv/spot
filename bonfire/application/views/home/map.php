<style type="text/css">
	#map_canvas { position:absolute; width:100%; height:90%; }
</style>
<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>
<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>
<script type="text/javascript">

	$(document).ready(function() {

		MYMAP.init('#map_canvas', 15);
		MYMAP.setCurrentMarker(true, '');
	});

</script>

<div data-role="content" id="map_canvas"></div>
