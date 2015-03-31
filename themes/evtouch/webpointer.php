<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
<head>
<?php   Loader::element('header_required');
Loader::model('file_list');
Loader::model('file_set');
$imgHelper = Loader::helper('image');
$parent = Page::getByID($c->getCollectionParentID());
$parentName = $parent->getCollectionHandle();
$pageName = $c->getCollectionHandle();
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
?>

<script type="text/javascript">
	var appCat = "<?php echo $parentName ?>";
	
	$(document).ready(function() {
		$('.rTxtCol h2').addClass('<?php echo $parentName ?>C');  // Add category class color to slide h2
	
		$(".nHome").click(function(event){
			event.preventDefault();
			linkLocation = $(this).attr('id');
			$("#main-bkg-inner").fadeOut(500);
			$("#main-content-container").fadeOut(500, redirectPage);
		});
			 
		function redirectPage() {
			window.location = linkLocation;
		}
	});
</script>

<!-- Site Head Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />

<!-- LOAD COLORBOX OVERLAY -->
<script type="text/javascript" src="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/js/jquery.colorbox-min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/css/theme1/colorbox.css" />

</head>
<body id="webpointer" class="<?php echo $parentName ?>">
<!--start main container -->
<div id="main-container" >
	<div id="/<?php echo $parentName ?>" class="nHome <?php echo $parentName ?>"><div></div></div>
	<div class="clear"></div>

	<div id="main-content-container" class="grid_16 pres-2col-vert">
		<div id="main-content-inner">
			
			<!-- <div class="aLeft"> -->
			<?php
			$l = new Area('Left');
			$l->display($c);
			?>
			<!-- </div> --><!-- END aLeft -->

			<div class="rTxtCol">
			<!-- <div class="aRight"> -->
			<?php
			$r = new Area('Right');
			$r->display($c);
			?>
			</div><!-- END aRight -->
			
			<?php
//			$a = new Area('Main');
//			$a->display($c);
			?>
			
		</div>
	<div class="clear"></div>
	</div><!-- END main-content-container -->

<!-- FOOTER START main-bkg -->
<div id="main-bkg" class="<?php echo $fsName ?>" style="background:url(<?php echo $theFilePath ?>) 0 0 no-repeat;">
	<div id="main-bkg-outer">
		<div id="main-bkg-inner" class="fullScreen"></div>
	</div>
</div><!-- END main-bkg -->

<?php   Loader::element('footer_required'); ?>
<?php  $this->inc('elements/analytics.php'); ?>
</body>
</html>