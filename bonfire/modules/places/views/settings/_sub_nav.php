<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/places') ?>" id="list"><?php echo lang('places_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Places.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/places/create') ?>" id="create_new"><?php echo lang('places_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>