<style type="text/css">
	#map_canvas { height: 200px; width: 100%; }
</style>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en">
</script>
<script src="<?php echo Template::theme_url('js/google.map.custom.js'); ?>"></script>
<script type="text/javascript">

	$(document).ready(function() {

		var address = [];
		address['id'] = '#places_address';
		address['lat'] = '#places_latitude';
		address['lng'] = '#places_longitude';

		MYMAP.init('#map_canvas', 15);
		MYMAP.setCurrentMarker(true, address);
		MYMAP.addDragMarkerEvent(MYMAP.currentMarker, '#places_address', '#places_latitude', '#places_longitude');
	});
	function codeAddress() {
		MYMAP.searchLocation(MYMAP.currentMarker, '#places_address', '#places_latitude', '#places_longitude');
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
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal" enctype="multipart/form-data"'); ?>
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
			<?php echo form_label('Image'. lang('bf_form_label_required'), 'places_image', array('class' => "control-label") ); ?>
			<div class='controls'>
				<table width="100%" cellpadding="0" cellspacing="0"><tr>
					<td width="40%">
						<input id="places_image" type="file" name="places_image" />
						<input type="hidden" name="thumb" value="<?php echo $places['places_image'] ?>" />
						<span class="help-inline"><?php echo form_error('places_image'); ?></span>
					</td>
					<td align="left">
						<?php
							if ( !empty( $places['places_image'] ) ):
								$image_thumb = str_replace(".", "_160x160.", $places['places_image']);
						?>
						<div id="preview-thumb" class="image-wrapper">
							<img alt="<?php echo $places['places_image'] ?>" src="<?php echo base_url(); ?>assets/images/<?php echo $folder_name ?>/<?php echo $image_thumb ?>">
						</div>
						<?php endif; ?>
					</td>
				</tr></table>
			</div>
		</div>

		<div class="form-actions">
			<br/>
			<input type="submit" name="save" class="btn btn-primary" value="Edit Places" />
			or <?php echo anchor(SITE_AREA .'/content/places', lang('places_cancel'), 'class="btn btn-warning"'); ?>

			<?php if ($this->auth->has_permission('Places.Content.Delete')) : ?>
				or <button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php echo lang('places_delete_confirm'); ?>')">
					<i class="icon-trash icon-white">&nbsp;</i>&nbsp;<?php echo lang('places_delete_record'); ?>
				</button>
			<?php endif; ?>
		</div>
	</fieldset>
	<?php echo form_close(); ?>


</div>
