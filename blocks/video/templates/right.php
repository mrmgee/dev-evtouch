<?php 
	defined('C5_EXECUTE') or die("Access Denied.");
	$content = $controller->getContent();
	echo '<div class="contRight">';
	print $content;
	echo '</div>';
?>