<?php  defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
Loader::element('editor_config');
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2>Item title</h2>
	<?php  echo $form->text('field_1_textbox_text', $field_1_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Item image</h2>
	<?php  echo $al->image('field_2_image_fID', 'field_2_image_fID', 'Choose Image', $field_2_image); ?>
</div>
<div class="ccm-block-field-group">
	<h2>Item thumbnail image</h2>
	<?php  echo $al->image('field_9_image_fID', 'field_9_image_fID', 'Choose Image', $field_9_image); ?>
</div>


<div class="ccm-block-field-group">
	<h2>Item image credit</h2>
	<?php  echo $form->text('field_3_textbox_text', $field_3_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Target title</h2>
	<?php  echo $form->text('field_4_textbox_text', $field_4_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Target image</h2>
	<?php  echo $al->image('field_5_image_fID', 'field_5_image_fID', 'Choose Image', $field_5_image); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Target image credit</h2>
	<?php  echo $form->text('field_6_textbox_text', $field_6_textbox_text, array('style' => 'width: 95%;')); ?>
</div>



<div class="ccm-block-field-group">
	<h2>top coord</h2>
	<?php  echo $form->text('field_10_textbox_text', $field_10_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>left coord</h2>
	<?php  echo $form->text('field_11_textbox_text', $field_11_textbox_text, array('style' => 'width: 95%;')); ?>
</div>


<div class="ccm-block-field-group">
	<h2>Incorrect content</h2>
	<?php  Loader::element('editor_controls'); ?>
	<textarea id="field_7_wysiwyg_content" name="field_7_wysiwyg_content" class="ccm-advanced-editor"><?php  echo $field_7_wysiwyg_content; ?></textarea>
</div>

<div class="ccm-block-field-group">
	<h2>Correct content</h2>
	<?php  Loader::element('editor_controls'); ?>
	<textarea id="field_8_wysiwyg_content" name="field_8_wysiwyg_content" class="ccm-advanced-editor"><?php  echo $field_8_wysiwyg_content; ?></textarea>
</div>