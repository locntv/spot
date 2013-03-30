<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>

<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		MYMAP.getPlacesByLocation('#listing', '<?php echo site_url() ?>places/places_ajax');
	});

	function listing_item( id, data ) {
		html =  '<li><a href="#"><img src="' + data.places_image + '" width="100%" class="ui-li-icon"/>';
		html += '<h2><span>' + id + '.</span> ' + data.places_name + '</h2>';
		html += '<p>' + data.places_address + '</p>';
		html += '<p>' + data.places_type + '</p>';
		html += '</a></li>';
		return html;
	}
//-->
</script>

<div class="container">
	<ul id="listing" data-role="listview" data-inset="true"></ul>
</div>
