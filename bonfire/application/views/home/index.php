<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>

<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		MYMAP.getPlacesByLocation('#listing', '<?php echo site_url() ?>places/places_ajax');

		$('#listing').on('click', 'li', function() {
			var place_id = $(this).attr('id');
			checkin(place_id.split("_")[1]);
		});
	});

	var img_venue = '<?php echo base_url(); ?>assets/images/venue/';
	function listing_item( id, data ) {
		if (data.places_image) {
			var name = data.places_image;
			img_venue += name.replace(".","_160x160.");
		}
		html =  '<li id="place_' + data.id + '"><a href="#"><img src="' + img_venue + '" />';
		html += '<h2><span>' + id + '.</span> ' + data.places_name + '</h2>';
		html += '<p>' + data.places_address + '</p>';
		html += '<p>' + data.places_type + '</p>';
		html += '</a></li>';
		return html;
	}

	function checkin(place_id) {
		$.ajax({
			'dataType': 'json',
			'type'    : 'POST',
			'url'     : 'home/checkin',
			'data'    : { lat: MYMAP.curLat, lng: MYMAP.curLng, place_id: place_id },
			'success' : function(data) {
				if (data == 1) {
					$( "#popupDialog" ).popup( "open" );
				} else if (data == 2) {
					document.location.href = 'home/people/' + place_id;
				} else {
					document.location.href = 'home';
				}
			}
		});
	}
//-->
</script>

<div class="container">
	<ul id="listing" data-role="listview" data-inset="true"></ul>
</div>

<div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
	<div data-role="header" data-theme="a" class="ui-corner-top">
		<h1>Delete Page?</h1>
	</div>
	<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
		<h3 class="ui-title">Are you sure you want to delete this page?</h3>
		<p>This action cannot be undone.</p>
		<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
		<a href="#" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Delete</a>
	</div>
</div>
