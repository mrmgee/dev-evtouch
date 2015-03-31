<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
<head>
<!-- Slider container page type based on presentation -->
<?php   Loader::element('header_required');
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
$pgNameArr = array();  // Page name array

$page = Page::getCurrentPage();
$parent = $page->getCollectionID();
$children = $page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children 

if ($c->isEditMode()) {
	$isEdit = 1;
}
else {
	$isEdit = 0;
}
?>

<script type="text/javascript">
	var appCat = "<?php echo $parentName ?>";
	var pageTitle = "<?php echo $pageTitle ?>";
	
	$(document).ready(function() {
		$(".nHome").click(function(event){
			event.preventDefault();
			linkLocation = $(this).attr('id');
			$("#main-bkg-inner").fadeOut(500);
			$("#main-content-container").fadeOut(500, redirectPage);
		});
			 
		function redirectPage() {
			window.location = linkLocation;
		}
		
		$('.catTxtC').addClass('<?php echo $parentName ?>C');
		
		$('.slDetBtn').colorbox({
			inline:true,
			onOpen:function(){
				$('.zoomInfoCont').hide(); //Closes any open info boxes
			},
			href:function(){
				var number = $(this).attr('id'); // returns main1
				var numDiv = '#'+number+'Info'; // creates #main1Info			
				return numDiv;
			}
		});
		
		$('.zoomInfoBtn').click(function(){
			$('.zoomInfoCont').hide(); //Closes any open info boxes
			var number = $(this).attr("id"); // returns 1791
			var numDiv = '#item'+number+'Info'; // creates #item1791Info
			$(numDiv).show(); //simple display:block
//			$(numDiv).addClass('zClk');	//Add clicked style
		});

		$('.xClose').click(function(){
			var number = $(this).attr("id"); // returns cl1791
			var numberSub = number.substr(2); // removes first 2 chars(cl1791) returns 1791
			var numDiv = '#item'+numberSub+'Info'; // creates #item1791Info
			$(numDiv).hide();
		}); // END zoomInfoBtn
		
		$('.slIntro').click(function(){
			$('.SlOverlayBkg').hide();
		});
		
		$('.imgCredit img').each(function(){	//Find img in div.imgCredit and disable drag
			$(this).attr('ondragstart', 'return false');	
		});

		$('#aSlider').addClass('<?php echo $parentName ?>');  // Add category color to slider background
		$('.closeCb').addClass('<?php echo $parentName ?>C');  // Add category color to close btn
		$('.slide h2').addClass('<?php echo $parentName ?>C');  // Add category class color to slide h2
		$('#slider .sliderRight ol li').addClass('<?php echo $parentName ?>C'); //Colorize number in ol based on section
		$('#slider .sliderRight ol li').wrapInner('<span> </span>'); //Colorize number in ol based on section
		
	});
</script>

<!-- Site Head Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />



<!-- LOAD COLORBOX OVERLAY -->
<script type="text/javascript" src="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/js/jquery.colorbox-min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/css/theme1/colorbox.css" />

<!-- LOAD SLIDER CODE -->
<script type="text/javascript" src="<?php echo DIR_REL?>/themes/evtouch/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo DIR_REL?>/themes/evtouch/css/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo DIR_REL?>/themes/evtouch/css/ui.theme.css" type="text/css" media="all" />

<script type="text/javascript">

	function refreshSwatch() {
		var slideVal = $( "#aSlider" ).slider( "value" );
		var transRange = 0;
<?php
$numSlides = count($children);  //count elemnts in $children array
echo '		var numSlides = '.$numSlides.';'.PHP_EOL; //6 in test example
echo '		var totSlide = Math.round(100/numSlides); // 100/6=16.66 gives segements within 0-100 range'.PHP_EOL;

for ($ch=1; $ch<=$numSlides; $ch++) {
	echo '// The number is '.$ch.PHP_EOL;

	if ($ch==1){
?>
		var nlval1;
		if (slideVal < (totSlide/2)-numSlides) {
			nlval1 = 100;
		} else if (slideVal >= (totSlide/2)-numSlides && totSlide > slideVal) {
			nlval1 = (100-(slideVal*numSlides));
		} else {
			nlval1 = 0;
		} 
<?php
	} else if ($ch==2){
?>
		var nlval2;	//25-50
		if (slideVal > (totSlide/2)-numSlides && slideVal < totSlide) {
			nlval2 = (100+((slideVal-totSlide)*numSlides));
		} else if (slideVal >= totSlide && slideVal < totSlide*2) {
			nlval2 = (100-((slideVal-totSlide)*numSlides));
		} else {
			nlval2 = 0;
		}
<?php  
	} else if ($ch==3){
?>
		var nlval3;
		if (slideVal > (totSlide*2)-(numSlides*2) && slideVal < totSlide*2) {
			nlval3 = (((slideVal-totSlide)*numSlides)-50);
		} else if (slideVal >= totSlide*2 && slideVal < totSlide*3) {
			nlval3 = (100-((slideVal-totSlide*2)*numSlides));
		} else {
			nlval3 = 0;
		}
<?php  
	} else if ($ch==4){ 
?>
		var nlval4;
		if (slideVal > (totSlide*3)-(numSlides*3) && slideVal < totSlide*3) {
			nlval4 = (((slideVal-(totSlide*2))*numSlides)-50);
		} else if (slideVal >= totSlide*3 && slideVal <= totSlide*4) {
			nlval4 = (100-((slideVal-totSlide*3)*numSlides));
		} else {
			nlval4 = 0;
		}
<?php  
	} else if ($ch==5){ 
?>
		var nlval5;
		if (slideVal > (totSlide*4)-(numSlides*4) && slideVal < totSlide*4) {
			nlval5 = (((slideVal-(totSlide*3))*numSlides)-50);
		} else if (slideVal >= totSlide*4 && slideVal <= totSlide*5) {
			nlval5 = 100;
		} else {
			nlval5 = 0;
		}
<?php  
	} else if ($ch==6){ //Last one has no fade out
?>
		var nlval6;
		if (slideVal > (totSlide*5)-(numSlides) && slideVal < totSlide*6) {
			nlval6 = (((slideVal-(totSlide*4))*numSlides)-50);
		} else if (slideVal >= totSlide*5 && slideVal <= totSlide*6) {
			nlval6 = 100; //No	Fade-Out
		} else {
			nlval6 = 0;
		}
<?php  
	} //END if loop
}//END loop for $ch<=$numSlides
?>

// Loop through each child and output div id
<?php
//$page = Page::getCurrentPage();
//$parent = $page->getCollectionID();
//$children = $page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children 

// Loop thru array $children
$sl = 1;
foreach ($children as $child) {
	$childPage = Page::getByID($child);
	$childID = $childPage->getCollectionID();
	$childName = $childPage->getCollectionName();

	echo '		$( "#'.$childID.'" ).css( "opacity", (nlval'.$sl.'/100) ).css("z-index",(nlval'.$sl.') );'.PHP_EOL;
	echo '		$( "#nlVal'.$sl.'" ).text(nlval'.$sl.');'.PHP_EOL;
	$sl++;
}
?>
		$("#val").text(slideVal);
	} //END refreshSwatch

	$(function() {
		$( "#aSlider" ).slider({
			orientation: "horizontal",
			range: "min",
			min: 0,
			max: 100,
			value: 0,
			slide: refreshSwatch,
			change: refreshSwatch,
		});
	});
</script>
</head>
<body id="slider">
<?php	// Instructions overlay
if ($isEdit == 1) {  // If in edit mode, show all blocks
	echo '<h2>EDIT MODE</h2>';
	$slOver = new Area('SlidesOverlay');
//	echo '<div class="slOverlayCont '.$parentName.'" style="width:80%; z-index:102;">'.PHP_EOL;
	echo '<div style="width:80%; margin:0 0 60px 60px; z-index:102;">'.PHP_EOL;
	$slOver->display($c);
	echo '</div>'.PHP_EOL;
} else {   // If NOT edit mode output slides
	$page = Page::getCurrentPage();
	$pageID = $page->getCollectionID();
	$pageCont = Page::getByID($pageID, $version = 'RECENT');
	$slOver = new Area('SlidesOverlay');
	$slOverlayBl =  $slOver->getAreaBlocksArray($pageCont);

	$slovb = 1;
	foreach ($slOverlayBl as $SlOverlay) {
		echo '<div id="itemover1Info" class="slOverlayCont '.$parentName.'">'.PHP_EOL;
		$SlOverlay->display();
		echo '<div id ="clover1" class="xClose slIntro">close</div>'.PHP_EOL;
		echo '</div><!-- END cont1 -->'.PHP_EOL;
		$slovb++;
	}
		echo '<div class="SlOverlayBkg"></div><!-- END hideCont intro -->'.PHP_EOL;
//} END edit els farther down
?>

<!--start main container -->
<div id="main-container" >
	<div id="/<?php echo $parentName ?>" class="nHome <?php echo $parentName ?>"><div></div></div>
	<div class="clear"></div>

	<div id="main-content-container" class="grid_24">
		<div id="main-content-inner">
			<script type="text/javascript">
			//Add category class color
			$(document).ready(function() {
				$('.slide h2').addClass('<?php echo $parentName ?>C');
				$('.vidOvInfo h2').addClass('<?php echo $parentName ?>');
				$('.slide .contQuote').addClass('<?php echo $parentName ?>');
				$('.slide .inverseBoxTint').addClass('<?php echo $parentName ?>');
			});
			</script>			
			<div id="easysliderslideshow_202" class="easysliderslideshow pres">
				<div class="slides_container">
<?php
$page = Page::getCurrentPage();
$parent = $page->getCollectionID();
$children = $page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children 

// Loop thru array $children
$childNum = 1;
foreach ($children as $child) {
	$childPage = Page::getByID($child);
	$childID = $childPage->getCollectionID();
	$childName = $childPage->getCollectionName();
	
	array_push($pgNameArr, $childName); //Add page name to $pgNameArr array

	$pageTypeID = $childPage->getCollectionTypeID();  // Returns ID of page type
	$pageTypeName = $childPage->getCollectionTypeName();

	echo '			<!--SLIDER CHANGE-->'.PHP_EOL;

	if ($childNum == 1) { //All slides after first are hidden 
	echo '			<div id="'.$childID.'" class="slide" style="z-index:1;">'.PHP_EOL;
	} else {
	echo '			<div id="'.$childID.'" class="slide" style="opacity:0; z-index:0;">'.PHP_EOL;
	}
	
	echo '				<!--START REPLACE-->'.PHP_EOL;
	echo '<!-- <p>parent:'.$parent.'</p> -->'.PHP_EOL;
	
	echo '<!-- <p>childID:'.$childID.' | childName:'.$childName.'</p> -->'.PHP_EOL;
	echo '<!-- <p>pageTypeID:'.$pageTypeID.' | pageTypeName:'.$pageTypeName.'</p> -->'.PHP_EOL;
	
	$pageCont = Page::getByID($childID, $version = 'RECENT');
	$introArea = new Area('Intro');
	$a = new Area('Main');
	$o = new Area('Overlay');
	$introBl = $introArea->getAreaBlocksArray($pageCont);
	$blocks = $a->getAreaBlocksArray($pageCont);
	$overlayBl =  $o->getAreaBlocksArray($pageCont);
	
	$ml = new Area('MainLeft');
	$MainLeftBlocks = $ml->getAreaBlocksArray($pageCont);
	$mr = new Area('MainRight');
	$MainRightBlocks = $mr->getAreaBlocksArray($pageCont);
	
	$l = new Area('Left');
	$leftBlocks = $l->getAreaBlocksArray($pageCont);
	echo '<div class="sliderLeft">'.PHP_EOL;
	foreach ($leftBlocks as $leftCont) {
		$leftCont->display();
	}
	echo '</div><!-- END sliderLeft -->'.PHP_EOL;

	$r = new Area('Right');
	$rightBlocks = $r->getAreaBlocksArray($pageCont);
	echo '<div class="sliderRight">'.PHP_EOL;
	foreach ($rightBlocks as $rightCont) {
		$rightCont->display();
	}
	
	if ((!$MainLeftBlocks) && (!$MainRightBlocks)) { //Don't output Details for last slide
	} else {
		echo '<div id="main'.$childNum.'" class="slDetBtn '.$parentName.'">DETAILS</div>'.PHP_EOL;
	}
	echo '	<div class="clear"></div>'.PHP_EOL;
	echo '</div><!-- END sliderRight -->'.PHP_EOL;
	
	echo '						<div class="hideCont">'.PHP_EOL;
	echo '							<div id="main'.$childNum.'Info" class="mainInfoCont">'.PHP_EOL;
	
	//Main Left and Right blocks in Details
	echo '							<h3>Please click numbers on image to reveal information.</h3>'.PHP_EOL;
	echo '<div class="sliderLeft">'.PHP_EOL;
	foreach ($MainLeftBlocks as $MainLeftCont) {
		$MainLeftCont->display();
	}
	echo '</div><!-- END sliderLeft -->'.PHP_EOL;
	echo '<div class="sliderRight">'.PHP_EOL;
	foreach ($MainRightBlocks as $MainRightCont) {
		$MainRightCont->display();
	}
	echo '</div><!-- END sliderRight -->'.PHP_EOL;
	

	$mb = new Area('Bottom');
	$MainBotBlocks = $mb->getAreaBlocksArray($pageCont);
	foreach ($MainBotBlocks as $MainBotCont) {
		$MainBotCont->display();
	}

	//Overlay blocks in modal details
	$ie = 1;
	foreach ($overlayBl as $overlay) {
		$overlay->display();
		$ie++;
	}
	echo '<div class="clear"></div>'.PHP_EOL;
	
	echo '								<div class="clear"></div>'.PHP_EOL;
	echo '							</div><!-- END main1Info -->'.PHP_EOL;

	echo '				</div><!-- END hideCont -->'.PHP_EOL;
	echo '				<!--END REPLACE-->'.PHP_EOL;
	echo '			<div class="clear"></div></div>'.PHP_EOL;
	
	$childNum++;
}  // END Loop array $children 

$pgNameArrJs = '["' . implode('","', $pgNameArr) . '"]';	//imploded array of page names to pass to javascript
}  // END  else {} NOT edit mode output slides
?>
					<div id="aSlider"></div>
				</div><!-- END slides_container -->
			</div><!-- END easysliderslideshow_140 -->

		</div><!-- END main-content-inner -->

	</div><!-- END main-content-container -->

	<!-- end full width content area -->

<!-- FOOTER START main-bkg -->
<div id="main-bkg" class="<?php echo $fsName ?>" style="background:url(<?php echo $theFilePath ?>) 0 0 no-repeat;">
	<div id="main-bkg-outer">
		<div id="main-bkg-inner"></div>
	</div>
</div><!-- END main-bkg -->
<script type="text/javascript">
	var pgname = <?php echo $pgNameArrJs ?>;	//Page name js array
</script>
<?php   Loader::element('footer_required'); ?>
<?php  $this->inc('elements/analytics.php'); ?>
</body>
</html>