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
$pageType = $c->getCollectionTypeHandle();

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
$homeURL = $parent->getCollectionPath();

$multiLang = $_SESSION['firstMessage'];	//$multiLang = 0/1: English/Spanish

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
<script type="text/javascript">
	var appCat = "<?php echo $pageName ?>";
	var clickCount = 0;
	
	$(document).ready(function() {

		$('.imgCredit img').each(function(){	//Find img in div.imgCredit and disable drag
			$(this).attr('ondragstart', 'return false');	
		});

		$('.closeCb').addClass('<?php echo $parentName ?>C');  // Add category color to close btn
		$('.closeCb').click(function() {
			$('.inOverlay').hide();						// Start close btn
			$('.inOverlayCont').hide();
		});
		
		$('.zoomInfoBtn').colorbox({
			inline:true,
			href:function(){
				var number = $(this).attr("id"); // returns item130
				var numDiv = '#item'+number+'Info'; // creates #item130Info
				var numDivCtr = numDiv+' .ctrCont';
				//Tracking
				var trNameSrc = $(this).attr("class"); //returns zoomInfoBtn Cordgrass cboxElement
				trNameSrcFir = trNameSrc.substr(12); // removes first 12 chars(zoomInfoBtn Cordgrass cboxElement) returns Cordgrass cboxElement
				trName = trNameSrcFir.slice(0, -12);// removes last 12 chars(Cordgrass cboxElement) returns Cordgrass
				
				clickCheck(number);
	
				var clickCountTxt = clickCount+'/'+clickTot;
				$(numDivCtr).text(clickCountTxt);
				$('#zoomCounter h4').text(clickCountTxt);
				
				$(this).addClass('zClk');	//Add clicked style
	
				return numDiv;
			},
			onClosed:function(){
				checkDone();
			}
			
		}); // END colorbox

		$('#zoomCounter').prepend($('#cont1'));	//Add cont1 text to zoomCounter
		$('#zoomCounter').addClass('<?php echo $parentName ?>');  // Add category class color to div.zoomCounter
		$('.zoomInfoContHead').addClass('<?php echo $parentName ?>');  // Add category class color to incorr/corr h2
		
		$(".nHome").click(function(event){
			event.preventDefault();
			linkLocation = '<?php echo $homeURL ?>';
			$("#main-bkg-inner").fadeOut(500);
			$("#main-content-container").fadeOut(500, redirectPage);
		});
			 
		function redirectPage() {
			window.location = linkLocation;
		}

	});
</script>
<?php } // END if ($isEdit == 0) ?>

<!-- Site Head Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />

<!-- LOAD COLORBOX OVERLAY -->
<script type="text/javascript" src="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/js/jquery.colorbox-min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/css/theme1/colorbox.css" />

</head>
<body id="<?php echo $pageName ?>" class="<?php echo $pageType ?>">
<!--start main container -->
<div id="main-container" >
	<div id="/<?php echo $parentName ?>" class="nHome lHome<?php echo $multiLang ?> <?php echo $parentName ?> "><div></div></div>
	<div class="clear"></div>

	<div id="main-content-container" class="grid_24">
		<div id="main-content-inner">

<?php	//Edit mode show Main area
if ($isEdit == 1) {  // If in edit mode, show all blocks
	$a = new Area('Main');
	$a->display($c);

	$introArea = new Area('Intro');
	echo '<div style="background-color:#CCC"><h3>Intro overlay</h3>';
	$introArea->display($c);
	echo '</div>';
	
	$o = new Area('Overlay');
	echo '<h3>Completion overlay</h3>';
	$o->display($c);
	
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

// Instructions overlay
echo '<div id="over'.$ii.'" class="inOverlayCont '.$parentName.'">'.PHP_EOL;
$introBl[0]->display();
if (count($introBl) != 1){
	echo '<div class="closeCb">';
	ob_start();
	$introBl[1]->display();
	$html1 = strip_tags(ob_get_clean());
	echo $html1;
	echo '</div>'.PHP_EOL;
} else {
	if ($multiLang == 0){
		echo '<div class="closeCb">Start &gt;</div>';
	} else {
		echo '<div class="closeCb">Comienzo &gt;</div>';
	}
}
echo '</div><!-- END cont'.$ii.' -->'.PHP_EOL;
?>
			<div class="inOverlay ovFull"></div><!-- END hideCont intro -->

			<div class="hideCont">
<?php	//Hidden overlay item info divs to be loaded into colorbox
$i = 1;
foreach ($blocks as $bl) {
	$blTypeName = $bl->getBlockTypeHandle();
	if ($blTypeName == "content"){ // Display content blocks
		echo '<div id="cont'.$i.'" class="zoomCont">'.PHP_EOL;
		$bl->display();
		echo '</div><!-- END cont'.$i.'-->'.PHP_EOL;
		$i++;
	}
}

$ie = 1;
foreach ($overlayBl as $overlay) {
	echo '<div id="end'.$ie.'" class="'.$parentName.'">'.PHP_EOL;
	$overlay->display();
	echo '</div><!-- END cont'.$ie.' -->'.PHP_EOL;
	$ie++;
}

?>
				<!-- <div class="clear"></div>  -->
			</div><!-- END hideCont intro -->
			<div id="zoomCounter"> <h4></h4></div>


<!-- //  START matching screen -->
<!-- REMOVED easy_slider_slideshow javascript -->

						<!--START REPLACE-->
<?php
$zoomBlCountArr = array(); // zoom block ids

$i = 1;
foreach ($blocks as $b) {
	$blTypeName = $b->getBlockTypeHandle();
	if ($blTypeName != "content" && $blTypeName != "easyslider_slideshow"){ // Display image and zoom_info but NOT content or easyslider_slideshow blocks
//echo PHP_EOL.'<p>blTypeName: '.$blTypeName.'</p>'.PHP_EOL;	//Testing
		$b->display();
		if ($blTypeName == "zoom_info") {
			$curBl = $b->getBlockID();
//echo PHP_EOL.'<p>curBl: '.$curBl.'</p>'.PHP_EOL;	//Testing
			array_push($zoomBlCountArr, $curBl); // Push block ID path into array
			$i++;
		}
	}
}
$zoomBlCountArrJs = implode(',', $zoomBlCountArr);
?>
						<script type="text/javascript">
							var clickClicked = [];
							var clickIDs = [<?php echo $zoomBlCountArrJs ?>];
							var clickTot = clickIDs.length;
							var clickDone = 0;
							
							
							function clickCheck(number){
								var inClickedArr = $.inArray(number,clickClicked);
		
								//Tracking
								var trMsg = '<?php echo $pageTitle ?>: '+trName;
								if (piwikTracker) { //Piwik tracking id="card4" | ref="lagoons_high_tide"
										piwikTracker.trackPageView(trMsg); //ref="lagoons_high_tide"
									}
					
								if (inClickedArr == -1){ // NOT in clickClicked array
									clickClicked.push(number); // add to clickClicked array
									clickCount++;
								} else {
		//			alert(number+' YES in array clickClicked');
								}
								
								if (clickCount == clickTot) {  // current click count equals total click number
									clickDone = 1;
								}
							}
							
							function checkDone(){
								if (clickDone == 1) {
									$('#end1').css('display','block');
									$.colorbox({inline:true, href:'#end1'});
								}
							}
							
						</script>
						<!--END REPLACE-->

<!-- REMOVED easy_slider_slideshow javascript -->
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