<?php  defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
Loader::element('editor_config');
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2>Name</h2>
	<?php  echo $form->text('field_1_textbox_text', $field_1_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Scientific Name</h2>
	<?php  echo $form->text('field_2_textbox_text', $field_2_textbox_text, array('style' => 'width: 95%;')); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Characteristic</h2>
	<?php 
	$options = array(
		'0' => '- Flower Color -',
		'236' => 'Brown Flower',
		'237' => 'Pink/Purple Flower',
		'238' => 'Red/Orange Flower',
		'239' => 'White/Pale Flower',
		'240' => 'Yellow Flower',
	);
	echo $form->select('field_3_select_value', $options, $field_3_select_value);
	?>
</div>


<div class="ccm-block-field-group">
	<h2>Season</h2>
	<?php
	echo $form->hidden('mo_jan', 0);
	echo $form->checkbox('mo_jan', 1, $mo_jan);
	echo "<label for='mo_jan'>Jan</label>";
	
	echo $form->hidden('mo_feb', 0);
	echo $form->checkbox('mo_feb', 1, $mo_feb);
	echo "<label for='mo_feb'>Feb</label>";
	
	echo $form->hidden('mo_mar', 0);
	echo $form->checkbox('mo_mar', 1, $mo_mar);
	echo "<label for='mo_mar'>Mar</label>";

	echo $form->hidden('mo_apr', 0);
	echo $form->checkbox('mo_apr', 1, $mo_apr);
	echo "<label for='mo_apr'>Apr</label>";
	
	echo $form->hidden('mo_may', 0);
	echo $form->checkbox('mo_may', 1, $mo_may);
	echo "<label for='mo_may'>May</label>";
	
	echo $form->hidden('mo_jun', 0);
	echo $form->checkbox('mo_jun', 1, $mo_jun);
	echo "<label for='mo_jun'>Jun</label>";
	
	echo $form->hidden('mo_jul', 0);
	echo $form->checkbox('mo_jul', 1, $mo_jul);
	echo "<label for='mo_jul'>Jul</label>";
	
	echo $form->hidden('mo_aug', 0);
	echo $form->checkbox('mo_aug', 1, $mo_aug);
	echo "<label for='mo_aug'>Aug</label>";

	echo $form->hidden('mo_sep', 0);
	echo $form->checkbox('mo_sep', 1, $mo_sep);
	echo "<label for='mo_sep'>Sep</label>";

	echo $form->hidden('mo_oct', 0);
	echo $form->checkbox('mo_oct', 1, $mo_oct);
	echo "<label for='mo_oct'>Oct</label>";

	echo $form->hidden('mo_nov', 0);
	echo $form->checkbox('mo_nov', 1, $mo_nov);
	echo "<label for='mo_nov'>Nov</label>";

	echo $form->hidden('mo_dec', 0);
	echo $form->checkbox('mo_dec', 1, $mo_dec);
	echo "<label for='mo_dec'>Dec</label>";

	?>
</div>

<div class="ccm-block-field-group">
	<h2>Main photo</h2>
	<?php  echo $al->image('field_5_image_fID', 'field_5_image_fID', 'Choose Image', $field_5_image); ?>

	<p>Main photo credit <?php  echo $form->text('field_5_textbox_text', $field_5_textbox_text, array('style' => 'width: 20%;')); ?></p>
	
	<p>Main photo caption <?php  echo $form->text('field_6_textbox_text', $field_6_textbox_text, array('style' => 'width: 20%;')); ?></p>
	
	<h3>Main photo thumbnail</h3>
	<?php  echo $al->image('field_7_image_fID', 'field_7_image_fID', 'Choose Image', $field_7_image); ?>
</div>

<div class="ccm-block-field-group">
	<h2>Info</h2>
	<?php  Loader::element('editor_controls'); ?>
	<textarea id="field_6_wysiwyg_content" name="field_6_wysiwyg_content" class="ccm-advanced-editor"><?php  echo $field_6_wysiwyg_content; ?></textarea>
</div>


<div class="ccm-block-field-group">
	<h2>Alt photo 1</h2>
	<?php  echo $al->image('field_8_image_fID', 'field_8_image_fID', 'Choose Image', $field_8_image); ?>
	<p>Alt photo 1 credit <?php  echo $form->text('field_8_textbox_text', $field_8_textbox_text, array('style' => 'width: 20%;')); ?></p>
	<p>Alt photo 1 caption <?php  echo $form->text('field_9_textbox_text', $field_9_textbox_text, array('style' => 'width: 20%;')); ?></p>
	<h3>Alt photo 1 thumbnail</h3>
	<?php  echo $al->image('field_9_image_fID', 'field_9_image_fID', 'Choose Image', $field_9_image); ?>
</div>



<div class="ccm-block-field-group">
	<h2>Alt photo 2</h2>
	<?php  echo $al->image('field_10_image_fID', 'field_10_image_fID', 'Choose Image', $field_10_image); ?>
	<p>Alt photo 2 credit <?php  echo $form->text('field_10_textbox_text', $field_10_textbox_text, array('style' => 'width: 20%;')); ?></p>
	<p>Alt photo 2 caption <?php  echo $form->text('field_11_textbox_text', $field_11_textbox_text, array('style' => 'width: 20%;')); ?></p>
	<h3>Alt photo 2 thumbnail</h3>
	<?php  echo $al->image('field_11_image_fID', 'field_11_image_fID', 'Choose Image', $field_11_image); ?>
</div>


<div class="ccm-block-field-group">
	<h2>Alt photo 3</h2>
	<?php  echo $al->image('field_12_image_fID', 'field_12_image_fID', 'Choose Image', $field_12_image); ?>
	<p>Alt photo 3 credit <?php  echo $form->text('field_12_textbox_text', $field_12_textbox_text, array('style' => 'width: 20%;')); ?></p>
	<p>Alt photo 3 caption <?php  echo $form->text('field_13_textbox_text', $field_13_textbox_text, array('style' => 'width: 20%;')); ?></p>
	<h3>Alt photo 3 thumbnail</h3>
	<?php  echo $al->image('field_13_image_fID', 'field_13_image_fID', 'Choose Image', $field_13_image); ?>
</div>