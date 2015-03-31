<?php 
	defined('C5_EXECUTE') or die("Access Denied.");
	$content = $controller->getContent();
	echo '<div class="contSpanFull">';
	print $content;
	echo '</div>';
?>