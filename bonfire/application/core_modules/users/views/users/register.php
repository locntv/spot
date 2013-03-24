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
<?php if (isset($error)) : ?>
		<div class="row-fluid">
			<div class="span12">
				<div class="alert alert-error fade in">
						<a data-dismiss="alert" class="close">&times;</a>
					<?php 
						foreach($error as $err){
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

		<div class="control-group <?php echo iif( form_error('pass_confirm') , 'error'); ?>">
			<label class="control-label required" for="pass_confirm"><?php echo lang('bf_password_confirm'); ?></label>
			<div class="controls">
				<input class="span6" type="password" name="pass_confirm" id="pass_confirm" value="" placeholder="<?php echo lang('bf_password_confirm'); ?>" />
			</div>
		</div>
		
		<div class="control-group <?php echo iif( form_error('gender') , 'error'); ?>">
		    <label for="select-native-1">I am:</label>
		    <div class="controls">
			    <select name="gender" id="select-native-1">
			    	<option value="">Select Sex</option>
			        <option value="0">Female</option>
			        <option value="1">Male</option>
			    </select>
		    </div>
		</div>
		
		<span class="fileinput-button" data-role="button" data-icon="plus">
		    <input type="file" data-clear-btn="false" name="image" multiple data-role="none" accept="image/*"/>
		</span>
		<p class="help-block"><?php echo lang('us_img_help'); ?></p>

		<?php
			// Allow modules to render custom fields
			Events::trigger('render_user_form');
		?>

	<div class="control-group">
		<div class="controls">
			<input class="btn btn-primary" type="submit" name="submit" id="submit" value="<?php echo lang('us_register'); ?>"  />
		</div>
	</div>

<?php echo form_close(); ?>

<p style="text-align: center">
	<?php echo lang('us_already_registered'); ?> <?php echo anchor('/login', lang('bf_action_login')); ?>
</p>

	</div>
</div>
</section>
