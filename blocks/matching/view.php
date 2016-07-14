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


$zTop = htmlentities($field_14_textbox_text, ENT_QUOTES, APP_CHARSET);
$zLeft = htmlentities($field_15_textbox_text, ENT_QUOTES, APP_CHARSET);

if (!empty($field_16_textbox_text)) {
	$zWidth = htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET);
} else {
	$zWidth = 200;
}
$zWidthCom = 'width:'.$zWidth.'px;';
if (!empty($field_17_textbox_text)) {
	$zHeight = htmlentities($field_4_textbox_text, ENT_QUOTES, APP_CHARSET);
} else {
	$zHeight = 200;
}
$zHeightCom = 'height:'.$zHeight.'px;';


if ($isEdit == 1) {  // If EDIT then show hotspot
	$zoomStyles = 'display:block; style="top:'.$zTop.'px; left:'.$zLeft.'px;'.$zWidthCom.$zHeightCom;
	
} else {
	$zoomStyles = 'position:absolute; top:'.$zTop.'px; left:'.$zLeft.'px;'.$zWidthCom.$zHeightCom;
}
?>

<?php  if (!empty($field_1_textbox_text)): ?>
	<?php  echo htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?>

<?php  if (!empty($field_2_image)): ?>
<!--	<img src="<?php  echo $field_2_image->src; ?>" width="<?php  echo $field_2_image->width; ?>" height="<?php  echo $field_2_image->height; ?>" alt="" /> -->
<?php  endif; ?>
<?php  if (!empty($field_9_image)): ?>
	<img src="<?php  echo $field_9_image->src; ?>" width="<?php  echo $field_9_image->width; ?>" height="<?php  echo $field_9_image->height; ?>" alt="" />
<?php  endif; ?>

<?php  if (!empty($field_3_textbox_text)): ?>
	<?php  echo htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?>

<?php  if (!empty($field_4_textbox_text)): ?>
	<?php  echo htmlentities($field_4_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?>

<?php  if (!empty($field_5_image)): ?>
<!--	<img src="<?php  echo $field_5_image->src; ?>" width="<?php  echo $field_5_image->width; ?>" height="<?php  echo $field_5_image->height; ?>" alt="" /> -->
	<img src="<?php  echo $field_5_image->src; ?>" width="200px" alt="" />
<?php  endif; ?>

<?php  if (!empty($field_6_textbox_text)): ?>
	<?php  echo htmlentities($field_6_textbox_text, ENT_QUOTES, APP_CHARSET); ?>
<?php  endif; ?>

<?php  if (!empty($field_7_wysiwyg_content)): ?>
	<?php  echo $field_7_wysiwyg_content; ?>
<?php  endif; ?>

<?php  if (!empty($field_8_wysiwyg_content)): ?>
	<?php  echo $field_8_wysiwyg_content; ?>
<?php  endif; ?>


