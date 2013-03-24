<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php e($this->settings_lib->item('site.title')); ?></title>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
		<meta name="description" content="">
		<meta name="author" content="">


		<?php echo Assets::css('css/spot.css'); ?>
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="<?php echo Template::theme_url('js/jquery.mobile-1.3.0.min.js') ?>"></script>

		<?php echo Assets::css('css/jquery.mobile-1.3.0.min.css'); ?>


		<style type="text/css">
			html { height: 100% }
			body { height: 100%; margin: 0; padding: 0 }
			#map_canvas { height: 100% }
		</style>

		<script type="text/javascript"
			src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=vi">
		</script>
	</head>
<body>
