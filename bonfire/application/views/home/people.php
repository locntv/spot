<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=geometry&language=en">
</script>
<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		MYMAP.getPeopleByLocation('#listing', '<?php echo site_url() ?>home/people_ajax', '<?php echo $spot->spots_place_id ?>', '<?php echo $spot->places_longitude ?>', '<?php echo $spot->places_latitude ?>', <?php echo $spot->is_checkin ?>);
	});

	function listing_item( data ) {
		var img_user = '<?php echo base_url() ?>assets/images/user/';
		var img_icon = '<?php echo Template::theme_url('images/spot_circle_') ?>' + data.checkin_status + '.png';

		if (data.image) {
			var name = data.image;
			img_user += name.replace(".","_128x128.");
		} else {
			img_user += 'happyface.png';
		}
		html =  '<li style="padding: 5px;" data-role="fieldcontain">';
		html += '<table width="100%" cellpadding="0" cellspacing="0">';
		html += '<tr><td width="30%"><img src="' + img_user + '" style="width: 128px;" /></td>';
		html += '<td width="70%" style="text-align: center;">';
		html += '<img src="' + img_icon + '" style="width: 50px;" /></td></tr></table>';
		html += '</li>';
		return html;
	}

//-->
</script>

<div class="container">
	<ul id="listing" data-role="listview" data-inset="true"></ul>
</div>
<div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
	<div data-role="header" data-theme="a" class="ui-corner-top">
		<h1>Check in</h1>
	</div>
	<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
		<h3 class="ui-title" id="popup_spot_name" style="text-align: center;"></h3>
		<form action="process_checkin" data-ajax="false" method="post">
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<input type="radio" name="checkin-status" id="checkin-status-1" value="1" checked="checked" />
				<label for="checkin-status-1"><img alt="red" src="<?php echo Template::theme_url('images/spot_circle_1.png'); ?>" width="20%"/><span style="vertical-align: 75%;padding-left: 10px;">Wingman</span></label>

				<input type="radio" name="checkin-status" id="checkin-status-2" value="2" />
				<label for="checkin-status-2"><img alt="yellow" src="<?php echo Template::theme_url('images/spot_circle_2.png'); ?>" width="20%"/><span style="vertical-align: 75%;padding-left: 10px;">Not Sure</span></label>

				<input type="radio" name="checkin-status" id="checkin-status-3" value="3" />
				<label for="checkin-status-3"><img alt="green" src="<?php echo Template::theme_url('images/spot_circle_3.png'); ?>" width="20%"/> <span style="vertical-align: 75%;padding-left: 5px;">Game On</span> </label>
			</fieldset>
		</div>
		<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
		<input type="hidden" value="" id="popup_place_id" name="place_id">
		<input type="submit" value="Check-in" data-inline="true" data-theme="b">
		<!--a href="#" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Check-in</a-->
		</form>
	</div>
</div>

<div data-role="popup" id="popupNoticeDialog" data-dismissible="false" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
	<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content" style="text-align: center;">
		<h1 class="ui-title" id="popup_notice">Sorry too far away</h1><br/><br/>
		<a href="<?php echo site_url() ?>home" data-role="button" data-inline="true" data-theme="c" data-ajax="false">Cancel</a>
	</div>
</div>