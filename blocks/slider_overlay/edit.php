<?php  defined('C5_EXECUTE') or die("Access Denied.");
Loader::element('editor_config');
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2>top coord</h2>
	<?php  echo $form->text('field_1_textbox_text', $field_1_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>left coord</h2>
	<?php  echo $form->text('field_2_textbox_text', $field_2_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Info content</h2>
	<h3>Item Number</h3>
	<?php  echo $form->text('field_6_textbox_text', $field_6_textbox_text, array('style' => 'width: 5%;')); ?>
	<?php  Loader::element('editor_controls'); ?>
	<textarea id="field_5_wysiwyg_content" name="field_5_wysiwyg_content" class="ccm-advanced-editor"><?php  echo $field_5_wysiwyg_content; ?></textarea>
</div>


