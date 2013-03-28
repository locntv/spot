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
		html =  '<li><a href="#"><img src="#" class="ui-li-icon"/>';
		html += '<h2><span>' + id + '.</span> ' + data.places_name + '</h2>';
		html += '<p>' + data.places_address + '</p>';
		html += '<p>' + data.places_type + '</p>';
		html += '</a></li>';
		return html;
	}
//-->
</script>

<div class="container">

	<ul id="listing" data-role="listview" data-inset="true">
		<li>
			<a href="#">
				<img src="../../_assets/img/album-bb.jpg">
				<h2><span>1.</span> Wine Emporium</h2>
				<p>Mint 801 9th Street, NW Washington</p>
				<p>Beer, Wine & Spirit</p>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="../../_assets/img/album-bb.jpg">
				<h2><span>2.</span> Wine Emporium</h2>
				<p>Mint 801 9th Street, NW Washington</p>
				<p>Beer, Wine & Spirit</p>
			</a>
		</li>
		<li>
			<a href="#">
				<img src="../../_assets/img/album-bb.jpg">
				<h2><span>3.</span> Wine Emporium</h2>
				<p>Mint 801 9th Street, NW Washington</p>
				<p>Beer, Wine & Spirit</p>
			</a>
		</li>
	</ul>



</div>
