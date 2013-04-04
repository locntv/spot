<script type="text/javascript">
<!--
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
//-->
</script>
<?php
	if ( !empty( $user->image ) && file_exists(ASSET_PATH . 'images/user/' . $user->image )) {
		$image_thumb = str_replace(".", "_128x128.", $user->image);
	} else {
		$image_thumb = 'happyface.png';
	}
?>
<?php if ($error && !empty($error)) : ?>
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
				<label class="check-os"></label>
			</li>
			<li data-role="fieldcontain">
				<label for="user-pass">Update password</label>
				<input type="password" data-clear-btn="true" name="user-pass" id="user-pass" value="" autocomplete="off">
			</li>
			<li data-role="fieldcontain">
				<label for="slider2">Checkin: <?php echo ($checkin->count);?></label>
			</li>
			<li data-role="fieldcontain">
				<input type="submit" name="submit"  value="save" >
			</li>
		</ul>
	<?php echo form_close(); ?>
</div>
