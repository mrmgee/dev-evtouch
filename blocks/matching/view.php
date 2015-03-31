<?php  defined('C5_EXECUTE') or die("Access Denied.");
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


