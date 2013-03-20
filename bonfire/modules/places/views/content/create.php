
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
        <div class="control-group <?php echo form_error('places_longtitude') ? 'error' : ''; ?>">
            <?php echo form_label('Longtitude'. lang('bf_form_label_required'), 'places_longtitude', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="places_longtitude" type="text" name="places_longtitude" maxlength="25" value="<?php echo set_value('places_longtitude', isset($places['places_longtitude']) ? $places['places_longtitude'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('places_longtitude'); ?></span>
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
            <input type="submit" name="save" class="btn btn-primary" value="Create Places" />
            or <?php echo anchor(SITE_AREA .'/content/places', lang('places_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
