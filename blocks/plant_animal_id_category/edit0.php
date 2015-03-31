<?php  defined('C5_EXECUTE') or die("Access Denied.");
?>

<style type="text/css" media="screen">
	.ccm-block-field-group h2 { margin-bottom: 5px; }
	.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2>Type</h2>
	<?php 
	$options = array(
		'0' => '--Choose One--',
		'1' => 'Bird',
		'2' => 'Mammal',
		'3' => 'Reptile',
		'4' => 'Plant',
	);
	echo $form->select('field_1_select_value', $options, $field_1_select_value);
	?>
</div>

<div class="ccm-block-field-group">
	<h2>Shape</h2>
	<?php 
	$options = array(
		'0' => 'Close group',
		'1' => 'Chicken-like Marsh',
		'2' => 'Duck-like',
		'3' => 'Gull-like',
		'4' => 'Hawk-like',
		'5' => 'Hummingbirds',
		'6' => 'Long-legged Waders',
		'7' => 'Owls',
		'8' => 'Perching',
		'9' => 'Pigeon-like',
		'10' => 'Sandpiper-like',
		'11' => 'Swallow-like',
		'12' => 'Tree-clinging',
		'13' => 'Upland Ground',
		'14' => 'Upright-perching Water',
		'15' => 'Mammals',
		'16' => 'Reptiles',
		'17' => 'Plants',
	);
	echo $form->select('field_2_select_value', $options, $field_2_select_value);
	?>
</div>