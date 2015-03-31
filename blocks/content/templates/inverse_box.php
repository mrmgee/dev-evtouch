<?php 
	defined('C5_EXECUTE') or die("Access Denied.");
	$content = $controller->getContent();
	echo '<div class="inverseBox"><div class="inverseBoxTint"></div>';
	print $content;
	echo '</div>';
?>