<?php echo theme_view('parts/_header'); ?>

<div data-role="page"> <!-- Start of Page -->
	<div data-role="header" data-theme="b">
		<a href="<?php echo site_url(uri_string()) ?>" data-icon="refresh" data-ajax="false">refresh</a>
		<h1><?php echo isset($page_title) ? $page_title : $this->settings_lib->item('site.title'); ?></h1>
		<a href="<?php echo base_url()."logout"?>" data-ajax="false" data-icon="arrow-r">Logout</a>
	</div>
	<div>
		<?php echo Template::message(); ?>
		<?php echo isset($content) ? $content : Template::yield(); ?>
	</div>

<?php echo theme_view('parts/_footer'); ?>
