<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
</div><!-- END main container -->

<div class="clear"></div>
	
	<div id="footer">
<?php
	$pageName = $c->getCollectionHandle();
	echo '<h1>'.$pageName.'</h1>';
?>
		<div id="footer-inner">
		</div>
	</div>

<?php   Loader::element('footer_required'); ?>
<!-- Piwik --> 
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://localhost:8888/analytics/piwik/" : "http://localhost:8888/analytics/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://localhost:8888/analytics/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->
</body>
</html>