<p><?php echo $dialog['content']?></p>
<?php if ( isset( $dialog['goto'] ) ) : ?>
	<a href="<?php echo site_url() . $dialog['goto']['url'] ?>" data-role="button" data-ajax="false" data-theme="b"><?php echo $dialog['goto']['name'] ?></a>
<?php endif ?>
<?php if ( isset( $dialog['callback'] ) ) : ?>
	<a href="<?php echo site_url() . $dialog['callback']['url']; ?>" data-role="button" data-ajax="false" data-theme="c"><?php echo $dialog['callback']['name'] ?></a>
<?php endif ?>