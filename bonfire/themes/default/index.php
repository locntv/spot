<?php echo theme_view('parts/_header'); ?>
<div data-role="page" id="mypage"> <!-- Start of Page -->
	<div data-role="header" data-theme="b">
		<?php if ( isset( $is_new ) ) : ?>
			<a href="<?php echo base_url().'home' ?>" data-ajax="false">Cancel</a>
		<?php elseif ( isset( $is_spot ) ) : ?>
			<a href="<?php echo base_url().'home/new_spot' ?>" data-icon="new" data-ajax="false">Add</a>
		<?php else : ?>
			<a href="<?php echo site_url(uri_string()) ?>" data-icon="refresh" data-ajax="false">refresh</a>
		<?php endif; ?>

		<h1><?php echo isset($page_title) ? $page_title : $this->settings_lib->item('site.title'); ?></h1>
		<?php if(isset($current_user->email)) :?>
			<?php if ( isset( $is_new ) ) : ?>
				<a href="#" data-ajax="false" data-role="button" id="new-spot-done">Done</a>
			<?php else : ?>
				<a href="<?php echo base_url()."logout"?>" data-ajax="false" data-icon="arrow-r">Logout</a>
			<?php endif; ?>
		<?php endif;?>
	</div>
	<div data-role="content">
		<?php echo Template::message(); ?>
		<?php echo isset($content) ? $content : Template::yield(); ?>
	</div>

<?php echo theme_view('parts/_footer'); ?>
