<?php 
defined('C5_EXECUTE') or die("Access Denied.");
echo '<div class="sliderImgCaption">'.PHP_EOL;
echo($controller->getContentAndGenerate());
echo '</div>'.PHP_EOL;
?>