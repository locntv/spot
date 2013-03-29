<div data-role="dialog" id="sure" data-title="Are you sure?">
	<div data-role="content">
		<h3 class="sure-1">Noted</h3>
		<p class="sure-2">Hello World</p>
		<a href="#" class="sure-do" data-role="button" data-theme="b" data-rel="back">Yes</a>
		<a href="#" data-role="button" data-theme="c" data-rel="back">No</a>
	</div>
</div>
<?php //echo anchor( '/', $this->settings_lib->item('site.title'), 'class="brand"' ); ?>
<a id="lnkDialog" href="<?php echo site_url() ?>dialog/index" data-rel="dialog" data-transition="pop">fdasfas</a>
<script type="text/javascript">
	//alert('fds');
	$("#lnkDialog").click();
//$("#dialog").dialog();
	//$(document).ready(function() {
		//$.mobile.changePage($("#sure"), null, true, true);
	//});
		/*$(function () {
			$("div[data-role='page']").on("pageshow", function (event, ui) {
				if (getValue() == null) {
					// show the dialog
					$.mobile.changePage("#sure");
				}
			});
		});*/
</script>

<div class="container">
	<div class="ui-grid-view">
		<div class="ui-block-one"><div class="ui-bar ui-bar-e">Block A</div></div>
		<div class="ui-block-two"><div class="ui-bar ui-bar-e">Block B</div></div>
	</div><!-- /grid-a -->
	<ul data-role="listview" data-inset="true">
		<li><a href="#">
			<img src="../../_assets/img/apple.png">
			<h2>iOS 6.1</h2>
			<p>Apple released iOS 6.1</p>
			<p class="ui-li-aside">iOS</p>
		</a></li>
		<li><a href="#">
			<img src="../../_assets/img/blackberry_10.png">
			<h2>BlackBerry 10</h2>
			<p>BlackBerry launched the Z10 and Q10 with the new BB10 OS</p>
			<p class="ui-li-aside">BlackBerry</p>
		</a></li>
		<li><a href="#">
			<img src="../../_assets/img/lumia_800.png">
			<h2>WP 7.8</h2>
			<p>Nokia rolls out WP 7.8 to Lumia 800</p>
			<p class="ui-li-aside">Windows Phone</p>
		</a></li>
		<li><a href="#">
			<img src="../../_assets/img/galaxy_express.png">
			<h2>Galaxy</h2>
			<p>New Samsung Galaxy Express</p>
			<p class="ui-li-aside">Samsung</p>
		</a></li>
		<li><a href="#">
			<img src="../../_assets/img/nexus_7.png">
			<h2>Nexus 7</h2>
			<p>Rumours about new full HD Nexus 7</p>
			<p class="ui-li-aside">Android</p>
		</a></li>
		<li><a href="#">
			<img src="../../_assets/img/firefox_os.png">
			<h2>Firefox OS</h2>
			<p>ZTE to launch Firefox OS smartphone at MWC</p>
			<p class="ui-li-aside">Firefox</p>
		</a></li>
		<li><a href="#">
			<img src="../../_assets/img/tizen.png">
			<h2>Tizen</h2>
			<p>First Samsung phones with Tizen can be expected in 2013</p>
			<p class="ui-li-aside">Tizen</p>
		</a></li>
		<li><a href="#">
			<h2>Symbian</h2>
			<p>Nokia confirms the end of Symbian</p>
			<p class="ui-li-aside">Symbian</p>
		</a></li>
	</ul>
</div>
