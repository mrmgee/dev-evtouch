<?php 
	defined('C5_EXECUTE') or die("Access Denied.");
	$content = $controller->getContent();
	echo '<div class="contQuote">';
	print $content;
	echo '</div>';
?>