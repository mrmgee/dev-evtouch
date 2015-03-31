<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!-- Piwik --> 
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "<?php echo BASE_URL.DIR_REL ?>/analytics/piwik/" : "<?php echo BASE_URL.DIR_REL ?>/analytics/piwik/");

document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="<?php echo BASE_URL.DIR_REL ?>/analytics/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->