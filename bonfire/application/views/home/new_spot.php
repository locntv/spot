<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>

<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		//$('#mypage').live('pagecreate', function(e){
			$("#new-spot-done").click(function(e) {
				alert('submit');
			});
		//});
	});
//-->
</script>
<div class="container">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal" enctype="multipart/form-data"'); ?>
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
					<span class="help-inline"><?php echo form_error('places_address'); ?></span>
					<a href="#" style="margin-left: 10px;font-size:14px;" onclick="javascript:codeAddress();">Search</a>
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
				<?php echo form_label('Image', 'places_image', array('class' => "control-label") ); ?>
				<div class='controls'>
					<input id="places_image" type="file" name="places_image" />
					<span class="help-inline"><?php echo form_error('places_image'); ?></span>
				</div>
			</div>
		</fieldset>
	<?php echo form_close(); ?>
</div>

