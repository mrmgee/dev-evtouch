<?php    
defined('C5_EXECUTE') or die("Access Denied.");
$includeAssetLibrary = true;
$assetLibraryPassThru = array(
	'type' => 'image'
);
$al = Loader::helper('concrete/asset_library');

$co = new Config();
$pkg = Package::getByHandle("lightboxed_image");
$co->setPackageObject($pkg);
$lightbox_theme = $co->get('lightbox_theme');

$display_caption = '';
$altText = '';
$disableLightbox = '';

$maxWidth = $co->get('last_max_page_width');
$maxHeight = $co->get('last_max_page_height');
$maxWidthLarge = $co->get('last_max_lightbox_width');
$maxHeightLarge =  $co->get('last_max_lightbox_height');

include_once('edit.php');

?>
