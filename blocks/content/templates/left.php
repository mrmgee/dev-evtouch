<?php 
	defined('C5_EXECUTE') or die("Access Denied.");
	$content = $controller->getContent();
	echo '<div class="contLeft">';
	print $content;
	echo '</div>';
?>