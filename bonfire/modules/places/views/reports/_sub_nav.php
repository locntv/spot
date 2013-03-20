<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/places') ?>" id="list"><?php echo lang('places_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Places.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/places/create') ?>" id="create_new"><?php echo lang('places_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>