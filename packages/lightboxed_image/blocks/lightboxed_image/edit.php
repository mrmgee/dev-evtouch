<?php   
defined('C5_EXECUTE') or die("Access Denied.");
$includeAssetLibrary = true; 
$assetLibraryPassThru = array(
	'type' => 'image'
);
	$al = Loader::helper('concrete/asset_library');

$bf = null;

if ($controller->getFileID() > 0) { 
	$bf = $controller->getFileObject();
}

$co = new Config();
$pkg = Package::getByHandle("lightboxed_image");
$co->setPackageObject($pkg);
$lightbox_theme = $co->get('last_theme');


// set sensible defaults for first use
if ($maxWidth == '' && $maxWidth !== 0) {
	$maxWidth = '240';
}	
	
if ($maxWidthLarge == '' && $maxWidthLarge !== 0) {
	$maxWidthLarge = '960';
}


?>
<div class="ccm-block-field-group">
<h2><?php  echo t('Image')?></h2>
<?php  echo $al->image('ccm-b-image', 'fID', t('Choose Image'), $bf);?>
</div>

<div class="ccm-block-field-group">
<h2><?php  echo t('Caption')?></h2>
<?php  echo  $form->text('altText', $altText, array('style' => 'width: 250px')); ?>
<br />
<strong><?php  echo t('Display caption');?>:</strong>
<?php  echo $form->select('display_caption', array('both'=>t('On page and lightbox'), 'page_only'=>'Only on the page', 'lb_only'=>'Only on the lightbox'), $display_caption); ?>
</div>

<div class="ccm-block-field-group">
<h2><?php  echo t('Maximum Dimensions');?></h2>
<strong><?php  echo t('For on page image')?>:</strong>
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td><?php  echo t('Width')?>&nbsp;</td>
<td><?php  echo  $form->text('maxWidth', intval($maxWidth), array('style' => 'width: 60px', 'maxlength'=>4)); ?></td>
<td>&nbsp;&nbsp;</td>
<td><?php  echo t('Height')?>&nbsp;</td>
<td><?php  echo  $form->text('maxHeight', intval($maxHeight), array('style' => 'width: 60px', 'maxlength'=>4)); ?></td>
</tr>
</table>

<strong><?php  echo t('For lightbox image')?>:</strong>
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td><?php  echo t('Width')?>&nbsp;</td>
<td><?php  echo  $form->text('maxWidthLarge', intval($maxWidthLarge), array('style' => 'width: 60px', 'maxlength'=>4)); ?></td>
<td>&nbsp;&nbsp;</td>
<td><?php  echo t('Height')?>&nbsp;</td>
<td><?php  echo  $form->text('maxHeightLarge', intval($maxHeightLarge), array('style' => 'width: 60px', 'maxlength'=>4)); ?></td>
</tr>
</table>
<?php  echo t('(Values left as 0 or blank indicate no resizing)'); ?>
</div>

<div class="ccm-block-field-group">
<h2><?php  echo t('Lightbox settings');?></h2>
 <strong><?php  echo t('Theme (site wide setting)')?>:</strong>
<?php  echo $form->select('lightbox_theme', array('theme1'=> t('Theme') . ' 1', 'theme2'=>t('Theme') .' 2', 'theme3'=>t('Theme') .' 3','theme4'=>t('Theme') .' 4','theme5'=>t('Theme') .' 5'), $lightbox_theme); ?>
<p><?php  echo t('Note: changing the theme will change it for all lightboxed images across the site'); ?></p>

<?php  echo $form->checkbox('disableLightbox', 1, $disableLightbox); ?>
<?php  echo t('Disable Lightbox')?>

</div>


