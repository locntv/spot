	<div data-role="footer">
		<?php if ( isset ( $current_user->email ) ) : ?>
		<div data-role="navbar">
			<?php echo navbar_select( 'navbar.footer', uri_string() ); ?>
		</div><!-- /navbar -->
		<?php else : ?>
			<h4>Spots</h4>
		<?php endif; ?>
	</div><!-- /footer -->

</div><!-- /page -->
</body>
</html>
