	<div data-role="footer" data-position="fixed">
		<?php if ( isset ( $current_user->email ) ) : ?>
		<div data-role="navbar">
			<?php echo navbar_select( 'navbar.footer', uri_string() ); ?>
		</div><!-- /navbar -->
		<?php else : ?>
		<?php endif; ?>
	</div><!-- /footer -->
</div><!-- /page -->
<?php if ( isset( $refresh ) ) : ?>
<script type="text/javascript">
	setInterval(function() {
		location.reload(); //refresh page
	}, 600000); //10 minutes
</script>
<?php endif; ?>
</body>
</html>
