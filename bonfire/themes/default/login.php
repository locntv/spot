<?php echo theme_view('parts/_header'); ?>

<div data-role="page" class="container body"> <!-- Start of Main Container -->
	<div data-role="header">
		<a href="#" data-icon="home">refresh</a>
		<h1><?php echo isset($page_title) ? $page_title : $this->settings_lib->item('site.title'); ?></h1>
	</div>
	<div data-role="content">
	<?php
		echo Template::message();
		echo isset($content) ? $content : Template::yield();
	?>
	</div>
<?php echo theme_view('parts/_footer'); ?>
