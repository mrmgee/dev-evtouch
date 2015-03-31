<?php  defined('C5_EXECUTE') or die("Access Denied.");
global $u;
global $c;
$curBl = $b->getBlockID();

if ($u -> isLoggedIn ()) {
	$isLogin = 1;
} else {
	$isLogin = 0;
}

if ($c->isEditMode()) {
	$isEdit = 1;
} else {
	$isEdit = 0;
}

$zTop = htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET);
$zLeft = htmlentities($field_2_textbox_text, ENT_QUOTES, APP_CHARSET);
if (!empty($field_3_textbox_text)) {
	$zWidth = htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET);

} else {
	$zWidth = 50;
}
$zWidthCom = 'width:'.$zWidth.'px;';
if (!empty($field_4_textbox_text)) {
	$zHeight = htmlentities($field_4_textbox_text, ENT_QUOTES, APP_CHARSET);
} else {
	$zHeight = 50;
}
$zHeightCom = 'height:'.$zHeight.'px;';

if ($isEdit == 1) {  // If EDIT then show hotspot
	$zoomStyles = 'display:block; style="top:'.$zTop.'px; left:'.$zLeft.'px;'.$zWidthCom.$zHeightCom;
	
} else {
	$zoomStyles = 'position:absolute; top:'.$zTop.'px; left:'.$zLeft.'px;'.$zWidthCom.$zHeightCom;
}


// Hotspot position top:field_1  left:field_2

if ($isLogin == 1) {
	echo '<div id="'.$curBl.'" class="zoomInfoBtnEdit" style="'.$zoomStyles.'">';
	echo '<h3>'.$field_6_textbox_text.'</h3>';
} else {
	echo '<div id="'.$curBl.'" class="zoomInfoBtn" style="'.$zoomStyles.'"><h2>'.$field_6_textbox_text.'</h2>';
}
echo '</div>'.PHP_EOL;

if ($isLogin == 1) {
	echo '	<div id="item'.$curBl.'Info" class="zoomInfoCont"><h3>Info '.$curBl.'</h3>'.PHP_EOL;  // EDIT don't hide div
} else {
echo '	<div id="item'.$curBl.'Info" class="zoomInfoCont hideCont">'.PHP_EOL;
}
if (!empty($field_5_wysiwyg_content)) {
	echo $field_5_wysiwyg_content;
}
echo PHP_EOL.'<div id ="cl'.$curBl.'" class="xClose">close</div>'.PHP_EOL;
echo PHP_EOL.'<div class="clear"></div>'.PHP_EOL.'</div><!-- END zoomInfoCont -->'.PHP_EOL;
?>