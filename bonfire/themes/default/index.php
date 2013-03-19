<?php echo theme_view('parts/_header'); ?>

<div data-role="page"> <!-- Start of Page -->

	<div><?php echo Template::message(); ?></div>
	<div data-role="content">
		<?php echo isset($content) ? $content : Template::yield(); ?>
	</div>

<?php echo theme_view('parts/_footer'); ?>
