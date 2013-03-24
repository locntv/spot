
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
        <div class="control-group <?php echo form_error('places_longitude') ? 'error' : ''; ?>">
            <?php echo form_label('longitude'. lang('bf_form_label_required'), 'places_longitude', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="places_longitude" type="text" name="places_longitude" maxlength="25" value="<?php echo set_value('places_longitude', isset($places['places_longitude']) ? $places['places_longitude'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('places_longitude'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('places_latitude') ? 'error' : ''; ?>">
            <?php echo form_label('Latitude'. lang('bf_form_label_required'), 'places_latitude', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="places_latitude" type="text" name="places_latitude" maxlength="25" value="<?php echo set_value('places_latitude', isset($places['places_latitude']) ? $places['places_latitude'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('places_latitude'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('places_image') ? 'error' : ''; ?>">
            <?php echo form_label('Image'. lang('bf_form_label_required'), 'places_image', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="places_image" type="text" name="places_image" maxlength="255" value="<?php echo set_value('places_image', isset($places['places_image']) ? $places['places_image'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('places_image'); ?></span>
        </div>


        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="Edit Places" />
            or <?php echo anchor(SITE_AREA .'/settings/places', lang('places_cancel'), 'class="btn btn-warning"'); ?>
            

    <?php if ($this->auth->has_permission('Places.Settings.Delete')) : ?>

            or <button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php echo lang('places_delete_confirm'); ?>')">
            <i class="icon-trash icon-white">&nbsp;</i>&nbsp;<?php echo lang('places_delete_record'); ?>
            </button>

    <?php endif; ?>


        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
