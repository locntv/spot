<?php echo theme_view('parts/_header'); ?>

<div data-role="page"> <!-- Start of Page -->
	<div data-role="header">
		<a href="#" data-icon="home">refresh</a>
		<h1><?php echo isset($page_title) ? $page_title : $this->settings_lib->item('site.title'); ?></h1>
		<a href="<?php echo base_url()."logout"?>" data-ajax="false" data-icon="arrow-r">Logout</a>
	</div>
	<div data-role="content">
		<?php echo Template::message(); ?>
		<?php echo isset($content) ? $content : Template::yield(); ?>
	</div>

<?php echo theme_view('parts/_footer'); ?>
