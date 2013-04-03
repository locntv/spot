<?php echo theme_view('parts/_header'); ?>

<div data-role="page" class="container body"> <!-- Start of Main Container -->
	<div data-role="header" data-theme="b">
		<a href="<?php echo site_url(uri_string())?>" data-icon="refresh" data-ajax="false">refresh</a>
		<h1><?php echo isset($page_title) ? $page_title : $this->settings_lib->item('site.title'); ?></h1>
	</div>
	<div data-role="content">
	<?php
		echo Template::message();
		echo isset($content) ? $content : Template::yield();
	?>
	</div>
<?php echo theme_view('parts/_footer'); ?>
