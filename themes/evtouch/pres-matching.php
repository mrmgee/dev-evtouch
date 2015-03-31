<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
<head>
<?php   Loader::element('header_required');
Loader::model('file_list');
Loader::model('file_set');
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
?>
<script type="text/javascript">
	var appCat = "<?php echo $pageName ?>";
</script>

<!-- Site Head Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />

<!-- LOAD COLORBOX OVERLAY -->
<script type="text/javascript" src="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/js/jquery.colorbox-min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/css/theme1/colorbox.css" />

</head>
<body>
<!--start main container -->
<div id="main-container" >
	<div class="nHome <?php echo $pageName ?>"><a href="/<?php echo $pageName ?>"><span>pageName: <?php echo $pageName ?></span></a></div>
	<div class="clear"></div>

<!-- ORIG -->
<!-- Header  <div id="main-container" > -->
<!-- <div class="clear">Presentation</div> -->

	<div id="main-content-container" class="grid_24">
		<div id="main-content-inner">

			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>

		</div><!-- END main-content-inner -->

	</div><!-- END main-content-container -->

	<!-- end full width content area -->

<!-- FOOTER START main-bkg -->
<div id="main-bkg" class="<?php echo $fsName ?>" style="background:url(<?php echo $theFilePath ?>) 0 0 no-repeat;">
	<div id="main-bkg-outer">
		<div id="main-bkg-inner"></div>
	</div>
</div><!-- END main-bkg -->

<?php   Loader::element('footer_required'); ?>

</body>
</html>