<?php echo theme_view('parts/_header'); ?>

<div data-role="dialog">
	<?php if ( isset( $dialog['header'] ) ) : ?>
		<div data-role="header">
			<h1><?php echo isset($page_title) ? $page_title : $this->settings_lib->item('site.title'); ?></h1>
		</div>
	<?php endif ?>

	<div data-role="content">
		<h3><?php echo $dialog_title; ?></h3>
		<?php echo isset($content) ? $content : Template::yield(); ?>
	</div>
</div>
</body>
</html>