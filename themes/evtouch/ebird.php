<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
<head>
<?php   Loader::element('header_required');
Loader::model('file_list');
Loader::model('file_set');
$imgHelper = Loader::helper('image');
$parent = Page::getByID($c->getCollectionParentID());
$pageName = $parent->getCollectionHandle();
$fsName = $pageName.'_bkg';
$fs = FileSet::getByName($fsName);
$fileList = new FileList();
$fileList->filterBySet($fs);
$fileList->filterByType(FileType::T_IMAGE); 
$files = $fileList->get(100,0); //limit it to 100 pictures

$size = sizeof($files);
$random = rand(0, $size - 1);
$theFile = $files[$random];
$theFilePath = $theFile->getRecentVersion()->getRelativePath();

if ($c->isEditMode()) {
	$isEdit = 1;
}
else {
	$isEdit = 0;
}
?>

<!-- Site Head Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />

</head>
<body>
<!--start main container -->
<div id="main-container-ebird" >
	<div class="nHome <?php echo $pageName ?>"><a href="/<?php echo $pageName ?>"><span>pageName: <?php echo $pageName ?></span></a></div>
	<div class="clear"></div>

	<div id="main-content-container-ebird">
		<div id="main-content-inner" class="ebird">
<!-- width="1760px" height="920px"  1636px x 920px  1150x920  1280 x 1024   http://ruffapp.ornith.cornell.edu/ett/main/bin/main.html?ettLocID=L375214&cID=173  -->
			<iframe src="http://ruffapp.ornith.cornell.edu/ett/main/bin/main.html?ettLocID=L152122" id="ebird" width="1280px" height="1024px" align="left" scrolling="no" frameBorder="0" border="0">
			  your browser does not support iframes!
			</iframe>
<!--			
			<form id="ebird_hidden">
				<input type="text" name="text_field" value="">
			</form>
-->
			<div class="clear"></div>
		</div><!-- END main-content-inner -->
	</div><!-- END main-content-container -->

<!-- FOOTER START main-bkg -->
<div id="main-bkg" class="<?php echo $fsName ?>" style="background:url(<?php echo $theFilePath ?>) 0 0 no-repeat;">
	<div id="main-bkg-outer-ebird">
		<div id="main-bkg-inner" class="fullScreen"></div>
	</div>
</div><!-- END main-bkg -->

<?php
//} else { 
//	echo '<div style="display:none">'.PHP_EOL;
	if ($isEdit == 1) {
	echo '</div>'.PHP_EOL;  // END else hide
	}
Loader::element('footer_required');
?>
<?php  $this->inc('elements/analytics.php'); ?>
</body>
</html>