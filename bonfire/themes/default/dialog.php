<?php echo theme_view('parts/_header'); ?>

<div data-role="dialog">
	<div data-role="header">
		<h1><?php echo isset($page_title) ? $page_title : $this->settings_lib->item('site.title'); ?></h1>
	</div>

	<div data-role="content">
		<h1><?php echo $dialog_message; ?></h1>
		<?php echo isset($content) ? $content : Template::yield(); ?>
	</div>
</div>
</body>
</html>