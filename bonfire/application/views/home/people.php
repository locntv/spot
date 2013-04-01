<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>

<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		MYMAP.getPeopleByLocation('#listing', '<?php echo site_url() ?>places/people_ajax');
	});
//-->
</script>

<div class="container">
	<ul data-role="listview" data-inset="true" data-inset="false">
		<?php foreach ( $result as $item ) : ?>
		<li data-role="fieldcontain">
			<table><tr>
				<td width="30%"><img src="<?php echo base_url() ?>assets/images/user/<?php echo $item['image'] ?>" style="width: 128px;"/></td>
				<td width="60%" style="text-align: center;">
					<img src="<?php echo Template::theme_url('images/spot_circle_'.$item['checkin_status']); ?>.png" style="width: 50px;"/>
					<h3><?php echo $item['last_name'] ?></h3>
				</td>
			</tr></table>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
