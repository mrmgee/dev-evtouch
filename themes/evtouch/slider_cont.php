<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
<head>
<?php   Loader::element('header_required');
global $c;
global $u;
Loader::model('file_list');
Loader::model('file_set');
$imgHelper = Loader::helper('image');
$parent = Page::getByID($c->getCollectionParentID());
$parentName = $parent->getCollectionHandle();
$pageName = $c->getCollectionHandle();
$pageTitle = $c->getCollectionName();
$fsName = $parentName.'_bkg';
$fs = FileSet::getByName($fsName);
$fileList = new FileList();
$fileList->filterBySet($fs);
$fileList->filterByType(FileType::T_IMAGE); 
$files = $fileList->get(100,0); //limit it to 100 pictures

$size = sizeof($files);
$random = rand(0, $size - 1);
$theFile = $files[$random];
$theFilePath = $theFile->getRecentVersion()->getRelativePath();

if ($u -> isLoggedIn ()) {  // Check login
	if ($c->isEditMode()) {  // if YES Login and YES Edit
		$isEdit = 1;
	}
	else {   // if YES Login and NO Edit
		$isEdit = 1;
	}
} else { // if NO Login
	$isEdit = 0;
}

if ($isEdit == 0) {  // IF logged-in don't output JS
?>

<?php } // END if ($isEdit == 0) ?>

<!-- Site Head Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />

<!-- LOAD COLORBOX OVERLAY -->
<script type="text/javascript" src="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/js/jquery.colorbox-min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/css/theme1/colorbox.css" />

</head>
<body id="<?php echo $pageName ?>">
<!--start main container -->
<div id="main-container" >
	<div id="/<?php echo $parentName ?>" class="nHome <?php echo $parentName ?>"><div></div></div>
	<div class="clear"></div>

	<div id="main-content-container-edit" class="grid_24">
		<div id="main-content-inner">

<?php	//Edit mode show Main area
if ($isEdit == 1) {  // If in edit mode, show all blocks

//	$introArea = new Area('Intro');
//	echo '<div style="background-color:#CCC"><h3>Intro slide content</h3>';
//	$introArea->display($c);
//	echo '</div>';



//	$a = new Area('Main');
//	echo '<h3>Main Details</h3>';
//	$a->display($c);
	
	echo '<div class="mainInfoCont">'.PHP_EOL;
	echo '<h3>Please click numbers on image to reveal information.</h3>'.PHP_EOL;
	echo '<div class="sliderLeft">'.PHP_EOL;
	$ml = new Area('MainLeft');
	$ml->display($c);
	echo '</div><!-- END sliderLeft -->'.PHP_EOL;

	echo '<div class="sliderRight">'.PHP_EOL;
	$mr = new Area('MainRight');
	$mr->display($c);
	echo '</div><!-- END sliderRight -->'.PHP_EOL;
	echo '<div class="clear"></div>'.PHP_EOL;
	
//	echo '<div class="aBottom">'.PHP_EOL;
	$b = new Area('Bottom');
	$b->display($c);
//	echo '</div><!-- END aBottom -->'.PHP_EOL;
	
	echo '</div><!-- END mainInfoCont -->'.PHP_EOL;
	
	
	
	$o = new Area('Overlay');
	echo '<h3>Modal info</h3>';
	$o->display($c);
	



	echo '<h3>Intro slide content</h3>'.PHP_EOL;
	echo '<div class="sliderLeft">'.PHP_EOL;
	$l = new Area('Left');
	$l->display($c);
	echo '</div><!-- END sliderLeft -->'.PHP_EOL;

	echo '<div class="sliderRight">'.PHP_EOL;
	$r = new Area('Right');
	$r->display($c);
	echo '</div><!-- END sliderRight -->'.PHP_EOL;
	echo '<div class="clear"></div><!-- END Intro -->'.PHP_EOL;

} else {	//NOT edit show mormal

$page = Page::getCurrentPage();
$pageID = $page->getCollectionID();
$pageCont = Page::getByID($pageID, $version = 'RECENT');
$introArea = new Area('Intro');
$a = new Area('Main');
$o = new Area('Overlay');
$blocks = $a->getAreaBlocksArray($pageCont);
$introBl =  $introArea->getAreaBlocksArray($pageCont);
$overlayBl =  $o->getAreaBlocksArray($pageCont);

//All blocks in page
$i = 1;
foreach ($blocks as $bl) {
		echo '<div id="cont'.$i.'">'.PHP_EOL;
		$bl->display();
		echo '</div><!-- END cont'.$i.'-->'.PHP_EOL;
		$i++;
	}




?>

			<div class="clear"></div>
<?php } //END if (isEdit == 1) ?>
		</div><!-- END main-content-inner -->
	</div><!-- END main-content-container -->

<!-- FOOTER START main-bkg -->
<div id="main-bkg" class="<?php echo $fsName ?>" style="background:url(<?php echo $theFilePath ?>) 0 0 no-repeat;">
	<div id="main-bkg-outer">
		<div id="main-bkg-inner" class="fullScreen"></div>
	</div>
</div><!-- END main-bkg -->



<?php
	if ($isEdit == 1) {
	}
Loader::element('footer_required');
?>
<?php  $this->inc('elements/analytics.php'); ?>
</body>
</html>