<?php
	if ( !empty( $user->image ) ) {
		$image_thumb = str_replace(".", "_128x128.", $user->image);
	}
?>
<div class="container">
	<?php echo form_open('home/me', array('class' => "form-horizontal", 'autocomplete' => 'off','enctype' => 'multipart/form-data')); ?>
		<ul data-role="listview" data-inset="true">
			<li data-role="fieldcontain">
				<div id="preview-thumb" class="image-wrapper" style="text-align: center;">
					<img alt="<?php echo $user->image ?>" src="<?php echo base_url(); ?>assets/images/user/<?php echo $image_thumb ?>">
				</div>
			</li>
			<li data-role="fieldcontain">
				<label for="user_image">Update picture</label>
				<input id="user_image" type="file" name="user_image" />
				<input type="hidden" name="thumb" value="<?php echo $user->image ?>" />
			</li>
			<li data-role="fieldcontain">
				<label for="user-pass">Update password</label>
				<input type="password" data-clear-btn="true" name="user-pass" id="user-pass" value="" autocomplete="off">
			</li>
			<li data-role="fieldcontain">
				<label for="slider2">Slider:</label>
				<input type="range" name="slider2" id="slider2" value="0" min="0" max="100" data-highlight="true">
			</li>
			<li data-role="fieldcontain">

				<input type="submit" name="submit"  value="save" >
			</li>
		</ul>
	<?php echo form_close(); ?>
</div>
