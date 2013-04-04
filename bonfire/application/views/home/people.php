<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>
<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		MYMAP.getPeopleByLocation('#listing', '<?php echo site_url() ?>places/people_ajax');
		MYMAP.getCurrentPos();
		place_id = <?php echo $place_id ?>;
		checkin(place_id);
	});
	
	function checkin(place_id) {
		
		$.ajax({
			'dataType': 'json',
			'type'    : 'POST',
			'url'     : "<?php echo base_url('home/checkin')?>",
			'data'    : { lat: MYMAP.curLat, lng: MYMAP.curLng, place_id: place_id },
			'success' : function(data) {
				alert(data.code);
				if (data.code == 1) { // Not checkin and in range allowed
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
	<ul data-role="listview" data-inset="true" data-inset="false">
		<?php foreach ( $result as $item ) : ?>
		<?php 
			if ( !empty( $item['image'] ) && file_exists(ASSET_PATH . 'images/user/' . $item['image'] )) {
				$image_thumb = str_replace(".", "_128x128.", $item['image']);
			} else {
				$image_thumb = 'happyface.png';
			}
		?>
		<li data-role="fieldcontain">
			<table><tr>
				<td width="30%"><img src="<?php echo base_url() ?>assets/images/user/<?php echo $image_thumb; ?>" style="width: 128px;"/></td>
				<td width="60%" style="text-align: center;">
					<img src="<?php echo Template::theme_url('images/spot_circle_'.$item['checkin_status']); ?>.png" style="width: 50px;"/>
					<h3><?php echo $item['last_name'] ?></h3>
				</td>
			</tr></table>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
	<div data-role="header" data-theme="a" class="ui-corner-top">
		<h1>Check in</h1>
	</div>
	<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
		<h3 class="ui-title" id="popup_spot_name" style="text-align: center;"></h3>
		<form action="home/process_checkin" data-ajax="false" method="post">
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
		<a href="home/spot" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
	</div>
</div>