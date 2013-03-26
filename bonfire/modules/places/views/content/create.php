<style type="text/css">
	#map_canvas { height: 200px; width: 100%; }
</style>

<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>

<script type="text/javascript">
	var geocoder;
	var map;
	var marker = new google.maps.Marker( { draggable: true } );
	var pos; // current position

	function initialize() {
		var mapOptions = {
			zoom: 15,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: false,
			scrollwheel: false
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

		geocoder = new google.maps.Geocoder();
		//marker.setMap(map);

		// Try HTML5 geolocation
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				pos = new google.maps.LatLng(position.coords.latitude,
											position.coords.longitude);

				new google.maps.Marker({
					position: pos,
					map: map,
				});

				map.setCenter(pos);
			}, function() {
				handleNoGeolocation(true);
			});
		} else {
			// Browser doesn't support Geolocation
			handleNoGeolocation(false);
		}

	}

	function handleNoGeolocation(errorFlag) {
		if (errorFlag) {
			var content = 'Error: The Geolocation service failed.';
		} else {
			var content = 'Error: Your browser doesn\'t support geolocation.';
		}

		var options = {
			map: map,
			position: new google.maps.LatLng(60, 105),
			content: content
		};

		var infowindow = new google.maps.InfoWindow(options);
		map.setCenter(options.position);
	}

	google.maps.event.addDomListener(window, 'load', initialize);

	function codeAddress() {
		var address = document.getElementById("places_address").value;
		geocoder.geocode ( { 'address': address }, function( results, status )  {
			if ( status == google.maps.GeocoderStatus.OK ) {
				//map.setCenter( results[0].geometry.location );
				marker.setPosition( results[0].geometry.location );
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}

	function setFocusOnSearch() {
		document.getElementById("search").focus();
	}

</script>

<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
<a class="close" data-dismiss="alert">&times;</a>
<h4 class="alert-heading">Please fix the following errors :</h4>
<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($places) ) {
	$places = (array)$places;
}
$id = isset($places['id']) ? $places['id'] : '';
?>
<div class="admin-box">
	<h3>Places</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
	<fieldset>
		<div class="control-group <?php echo form_error('places_name') ? 'error' : ''; ?>">
			<?php echo form_label('Name'. lang('bf_form_label_required'), 'places_name', array('class' => "control-label") ); ?>
			<div class='controls'>
				<input id="places_name" type="text" name="places_name" maxlength="255" value="<?php echo set_value('places_name', isset($places['places_name']) ? $places['places_name'] : ''); ?>"  />
				<span class="help-inline"><?php echo form_error('places_name'); ?></span>
			</div>
		</div>

		<div class="control-group">
			<?php echo form_label('Google Map', 'google_map', array('class' => "control-label") ); ?>
			<div class='controls'>
				<div id="map_canvas"></div>
			</div>
		</div>

		<div class="control-group <?php echo form_error('places_address') ? 'error' : ''; ?>">
			<?php echo form_label('Address'. lang('bf_form_label_required'), 'places_address', array('class' => "control-label") ); ?>
			<div class='controls'>
				<input id="places_address" type="text" name="places_address" maxlength="255" value="<?php echo set_value('places_address', isset($places['places_address']) ? $places['places_address'] : ''); ?>"  />
				<span class="help-inline"><?php echo form_error('places_address'); ?></span>
			</div>
		</div>

		<div class="control-group <?php echo form_error('places_type') ? 'error' : ''; ?>">
			<?php echo form_label('Type'. lang('bf_form_label_required'), 'places_type', array('class' => "control-label") ); ?>
			<div class='controls'>
				<input id="places_type" type="text" name="places_type" maxlength="255" value="<?php echo set_value('places_type', isset($places['places_type']) ? $places['places_type'] : ''); ?>"  />
				<span class="help-inline"><?php echo form_error('places_type'); ?></span>
			</div>

		</div>

		<input id="places_longitude" type="hidden" name="places_longitude" value="<?php echo set_value('places_longitude', isset($places['places_longitude']) ? $places['places_longitude'] : ''); ?>"  />

		<input id="places_latitude" type="hidden" name="places_latitude" value="<?php echo set_value('places_latitude', isset($places['places_latitude']) ? $places['places_latitude'] : ''); ?>"  />

		<div class="control-group <?php echo form_error('places_image') ? 'error' : ''; ?>">
			<?php echo form_label('Image'. lang('bf_form_label_required'), 'places_image', array('class' => "control-label") ); ?>
			<div class='controls'>
				<input id="places_image" type="file" name="places_image" value="<?php echo set_value('places_image', isset($places['places_image']) ? $places['places_image'] : ''); ?>"  />
				<span class="help-inline"><?php echo form_error('places_image'); ?></span>
			</div>
		</div>

		<div class="form-actions">
			<br/>
			<input type="submit" name="save" class="btn btn-primary" value="Create Places" />
			or <?php echo anchor(SITE_AREA .'/content/places', lang('places_cancel'), 'class="btn btn-warning"'); ?>
		</div>
	</fieldset>
	<?php echo form_close(); ?>


</div>
