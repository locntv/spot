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

	//var img_venue = '<?php echo base_url(); ?>assets/images/venue/';
	function listing_item( id, data ) {
		
		var img_venue = '<?php echo base_url(); ?>assets/images/venue/';
		var img_icon = '<?php echo site_url() ?>home/pie_icon/32/32/' + data.id;
		if (data.places_image) {
			var name = data.places_image;
			img_venue += name.replace(".","_160x160.");
		}
		var is_checkin = data.is_checkin;
		var gender = <?php echo $current_user->gender; ?>;
		if(gender ==1){
			gender = "girl(s)";
		} else {
			gender = "guy(s)";
		}
		
		if(is_checkin == 1){
			html =  '<li style="padding: 5px;" data-role="fieldcontain" class="spot-selected" id="place_' + data.id + '">';
		} else {
			html =  '<li style="padding: 5px;" data-role="fieldcontain" id="place_' + data.id + '">';
		}
		html += '<table width="100%" cellpadding="0" cellspacing="0">';
		html += '<tr><td width="5%"><img src="' + img_venue + '" style="width: 80px;" /></td>';
		html += '<td width="90%" style="text-align: left;">';
		html += '<div style="padding:0 5px 0 10px;"><h2><span>' + id + '.</span> ' + data.places_name + '</h2>';
		html += '<p>' + data.places_address + '</p>';
		html += '<p>' + data.places_type + '</p>';
		html += '<p>' + data.people['1'] + '&nbsp; guy(s)& ' +data.people['0'] +' girl(s) &nbsp;&nbsp;&nbsp;&nbsp;' + data.distance+'&nbsp;mile(s)</p></div>';
		html += '</td><td width="5%" style="text-align: center;">';
		html += '<img src="' + img_icon + '" /></td></tr></table>';
		html += '</li>';
		return html;
	}

	function checkin(place_id) {
		$.ajax({
			'dataType': 'json',
			'type'    : 'POST',
			'url'     : 'home/checkin',
			'data'    : { lat: MYMAP.curLat, lng: MYMAP.curLng, place_id: place_id },
			'success' : function(data) {
				if (data.code == 1) {
					$( "#popup_spot_name" ).html(data.place_name);
					$( "#popup_place_id" ).val(place_id);
					$( "#popupDialog" ).popup( "open" );
				} else if (data.code == 2) {
					document.location.href = 'home/people/' + place_id;
				} else {
					$("#popupNoticeDialog").popup("open");
					//document.location.href = 'home';
				}
			}
		});
	}
//-->
</script>

<div class="container">
	<ul id="listing" data-role="listview" data-inset="false"></ul>
</div>

<div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
	<div data-role="header" data-theme="a" class="ui-corner-top">
		<h1>Check in</h1>
	</div>
	<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
		<h3 class="ui-title" id="popup_spot_name" style="text-align: center;"></h3>
		<form action="<?php echo site_url() ?>home/process_checkin" data-ajax="false" method="post">
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<input type="radio" name="checkin-status" id="checkin-status-1" value="1" checked="checked" />
				<label for="checkin-status-1"><img alt="red" src="<?php echo Template::theme_url('images/spot_circle_1.png'); ?>" width="20%"/><span style="vertical-align: 75%;padding-left: 10px;">Wingman</span></label>

				<input type="radio" name="checkin-status" id="checkin-status-2" value="2" />
				<label for="checkin-status-2"><img alt="yellow" src="<?php echo Template::theme_url('images/spot_circle_2.png'); ?>" width="20%"/><span style="vertical-align: 75%;padding-left: 10px;">Convince me</span></label>

				<input type="radio" name="checkin-status" id="checkin-status-3" value="3" />
				<label for="checkin-status-3"><img alt="green" src="<?php echo Template::theme_url('images/spot_circle_3.png'); ?>" width="20%"/> <span style="vertical-align: 75%;padding-left: 5px;">Ready to mingle</span> </label>
			</fieldset>
		</div>
		<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
		<input type="hidden" value="" id="popup_place_id" name="place_id">
		<input type="submit" value="Check-in" data-inline="true" data-theme="b">
		<!--a href="#" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Check-in</a-->
		</form>
	</div>
</div>

<div data-role="popup" id="popupNoticeDialog" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
	<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content" style="text-align: center;">
		<h1 class="ui-title" id="popup_notice">Sorry too far away</h1><br/><br/>
		<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
	</div>
</div>
