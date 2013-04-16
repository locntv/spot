<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>

<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		var is_valid;
		$("#new-spot-done").click(function(e) {
			codeAddress();
		});
	});

	function codeAddress() {
		MYMAP.searchLocation(MYMAP.currentMarker, '#places_address', '#places_latitude', '#places_longitude');
	}
//-->
</script>
<?php if (validation_errors()) : ?>
	<div class="alert alert-block alert-error fade in ">
		<h4 class="alert-heading">Please fix the following errors :</h4>
		<?php echo validation_errors(); ?>
	</div>
<?php endif; ?>

<div class="container">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal" id="new_spot" enctype="multipart/form-data"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('places_name') ? 'error' : ''; ?>">
				<?php echo form_label('Name'. lang('bf_form_label_required'), 'places_name', array('class' => "control-label") ); ?>
				<div class='controls'>
					<input id="places_name" type="text" name="places_name" maxlength="255" value="<?php echo set_value('places_name', isset($places['places_name']) ? $places['places_name'] : ''); ?>"  />
					<span class="help-inline"><?php echo form_error('places_name'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('places_address') ? 'error' : ''; ?>">
				<?php echo form_label('Address'. lang('bf_form_label_required'), 'places_address', array('class' => "control-label") ); ?>
				<div class='controls'>
					<input id="places_address" type="text" name="places_address" maxlength="255" value="<?php echo set_value('places_address', isset($places['places_address']) ? $places['places_address'] : ''); ?>"  />
					<span class="address-help-inline"><?php echo form_error('places_address'); ?></span>
					<input id="check_address" type="hidden" name="check_address" value="" />
				</div>
			</div>

			<div class="control-group <?php echo form_error('places_type') ? 'error' : ''; ?>">
				<label for="places_type" class="select">Type</label>
				<select name="places_type" id="places_type" data-native-menu="false">
					<?php foreach ( $spot_type as $key => $type_name ) : ?>
						<option value="<?php echo $key ?>"><?php echo $type_name ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<input id="places_longitude" type="hidden" name="places_longitude" value="<?php echo set_value('places_longitude', isset($places['places_longitude']) ? $places['places_longitude'] : ''); ?>"  />

			<input id="places_latitude" type="hidden" name="places_latitude" value="<?php echo set_value('places_latitude', isset($places['places_latitude']) ? $places['places_latitude'] : ''); ?>"  />

			<div class="control-group <?php echo form_error('places_image') ? 'error' : ''; ?>">
				<?php echo form_label('Image', 'places_image', array('class' => "control-label") ); ?>
				<div class='controls'>
					<input id="places_image" type="file" name="places_image" />
					<span class="help-inline"><?php echo form_error('places_image'); ?></span>
				</div>
			</div>
		</fieldset>
	<?php echo form_close(); ?>
</div>

