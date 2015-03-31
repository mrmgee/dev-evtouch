<?php  defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
Loader::element('editor_config');
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2>Title</h2>
	<?php  echo $form->text('field_1_textbox_text', $field_1_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Poster image</h2>
	<?php  echo $al->image('field_2_image_fID', 'field_2_image_fID', 'Choose Image', $field_2_image); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Credit</h2>
	<?php  echo $form->text('field_3_textbox_text', $field_3_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Caption</h2>
	<?php  echo $form->text('field_4_textbox_text', $field_4_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Video file</h2>
	<?php  echo $al->file('field_5_image_fID', 'field_5_image_fID', 'Choose Video', $field_5_image); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Width</h2>
	<?php  echo $form->text('vid_width', $vid_width, array('style' => 'width: 50%;')); ?>
</div>
<div class="ccm-block-field-group">
	<h2>Height</h2>
	<?php  echo $form->text('vid_height', $vid_height, array('style' => 'width: 50%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Content (optional)</h2>
	<?php  Loader::element('editor_controls'); ?>
	<textarea id="field_6_wysiwyg_content" name="field_6_wysiwyg_content" class="ccm-advanced-editor"><?php  echo $field_6_wysiwyg_content; ?></textarea>
</div>


