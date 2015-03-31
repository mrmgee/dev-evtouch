<?php  defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
$dt = Loader::helper('form/date_time');
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2>Start Date</h2>
	<?php  echo $dt->date('field_1_date_value', $field_1_date_value); ?>
</div>

<div class="ccm-block-field-group">
	<h2>End Date (optional)</h2>
	<?php  echo $dt->date('field_2_date_value', $field_2_date_value); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Title</h2>
	<?php  echo $form->text('field_3_textbox_text', $field_3_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Description</h2>
	<textarea id="field_4_textarea_text" name="field_4_textarea_text" rows="5" style="width: 95%;"><?php  echo $field_4_textarea_text; ?></textarea>
</div>

<!--
<div class="ccm-block-field-group">
	<h2>icon</h2>
	<?php  // echo $form->text('field_5_textbox_text', $field_5_textbox_text, array('style' => 'width: 95%;')); ?>
</div>
-->
<!--
<div class="ccm-block-field-group">
	<h2>date limit</h2>
	<?php // echo $form->text('field_6_textbox_text', $field_6_textbox_text, array('style' => 'width: 95%;')); ?>
</div>
-->
<div class="ccm-block-field-group">
	<h2>Strand (category)</h2>
	<?php 
	$options = array(
		'0' => '-- Choose one --',
		'1' => 'History',
		'2' => 'What People say about EV',
		'3' => 'Subject Areas',
		'4' => 'Quick Facts',
		'5' => 'General Purpose',
	);
	echo $form->select('field_7_select_value', $options, $field_7_select_value);
	?>
</div>

<div class="ccm-block-field-group">
	<h2>Image</h2>
	<?php  echo $al->image('field_9_image_fID', 'field_9_image_fID', 'Choose Image', $field_9_image); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Image credit</h2>
	<?php  echo $form->text('field_5_textbox_text', $field_5_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Image caption</h2>
	<?php  echo $form->text('field_6_textbox_text', $field_6_textbox_text, array('style' => 'width: 95%;')); ?>
</div>