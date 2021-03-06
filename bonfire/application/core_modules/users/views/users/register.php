<script type="text/javascript">

$(document).ready(function(){
	ver = iOSversion();
	//alert(ver[0]);
	if(ver != null &&  ver[0] < 6){
		$(".check-os").append("This OS does not support to upload image");
	}
})
function iOSversion() {
	  if (/iP(hone|od|ad)/.test(navigator.platform)) {
	    // supports iOS 2.0 and later: <http://bit.ly/TJjs1V>
	    var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
	    return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
	  }
	  return null;
	}
</script>
<section id="register">
	<div class="page-header">
		<h1><?php echo lang('us_login'); ?></h1>
	</div>

<?php if (auth_errors() || validation_errors()) : ?>
		<div class="row-fluid">
			<div class="span12">
				<div class="alert alert-error fade in">
						<a data-dismiss="alert" class="close">&times;</a>
					<?php echo auth_errors() . validation_errors(); ?>
				</div>
			</div>
		</div>
<?php endif; ?>
<?php if (isset($image_error)) : ?>
		<div class="row-fluid">
			<div class="span12">
				<div class="alert alert-error fade in">
						<a data-dismiss="alert" class="close">&times;</a>
					<?php 
						foreach($image_error as $err){
							echo $err;
						}
					?>
				</div>
			</div>
		</div>
<?php endif; ?>

<div class="row-fluid">
	<div class="span12">

<?php echo form_open('register', array('class' => "form-horizontal", 'autocomplete' => 'off','enctype' => 'multipart/form-data')); ?>
<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
	
	<div class="control-group <?php echo iif( form_error('first_name') , 'error'); ?>">
		<label class="control-label required" for="first_name"><?php echo lang('bf_first_name'); ?></label>
		<div class="controls">
		 <input class="span6" type="text" name="first_name" id="first_name"  value="<?php echo set_value('first_name'); ?>"  placeholder="First Name" />
		</div>
	</div>
	
	<div class="control-group <?php echo iif( form_error('last_name') , 'error'); ?>">
		<label class="control-label required" for="last_name"><?php echo lang('bf_last_name'); ?></label>
		<div class="controls">
		 <input class="span6" type="text" name="last_name" id="last_name"  value="<?php echo set_value('last_name'); ?>"  placeholder="Last Name" />
		</div>
	</div>
	
	<div class="control-group <?php echo iif( form_error('email') , 'error'); ?>">
		<label class="control-label required" for="email"><?php echo lang('bf_email'); ?></label>
		<div class="controls">
		 <input class="span6" type="text" name="email" id="email"  value="<?php echo set_value('email'); ?>"  placeholder="email" />
		</div>
	</div>

	<br/>

		<div class="control-group <?php echo iif( form_error('password') , 'error'); ?>">
			<label class="control-label required" for="password"><?php echo lang('bf_password'); ?></label>
			<div class="controls">
				<input class="span6" type="password" name="password" id="password" value="" placeholder="password" />
				<p class="help-block"><?php echo lang('us_password_mins'); ?></p>
			</div>
		</div>

		<span class="fileinput-button" data-role="button" data-icon="plus">
		<span>Add Photo</span>
		    <input type="file" data-clear-btn="false" name="image" multiple data-role="none" accept="image/*"/>
		</span>
		<label class="check-os"></label>
		<div class="control-group <?php echo iif( form_error('gender') , 'error'); ?>">
		    <div class="controls">
			    <select name="gender" id="select-native-1">
			    	<option value="">Select Sex</option>
			        <option value="0">Female</option>
			        <option value="1">Male</option>
			    </select>
		    </div>
		</div>
		
		<?php
			// Allow modules to render custom fields
			Events::trigger('render_user_form');
		?>

	<div class="control-group">
		<div class="controls">
			<input class="btn btn-primary" data-theme="b" type="submit" name="submit" id="submit" value="<?php echo lang('us_register'); ?>"  />
		</div>
	</div>

<?php echo form_close(); ?>

<p style="text-align: center">
	<?php echo lang('us_already_registered'); ?> <?php echo anchor('/login', lang('bf_action_login')); ?>
</p>

	</div>
</div>
</section>
