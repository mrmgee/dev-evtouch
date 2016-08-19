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
$pageTitle = $c->getCollectionName();
$homeURL = $parent->getCollectionPath();
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

$multiLang = $_SESSION['firstMessage'];	//$multiLang = 0/1: English/Spanish
?>

<script type="text/javascript">
	var appCat = "<?php echo $parentName ?>";
	var pageTitle = "<?php echo $pageTitle ?>";
	
	$(document).ready(function() {
		$(".nHome").click(function(event){
			event.preventDefault();
			linkLocation = '<?php echo $homeURL ?>';
			$("#main-bkg-inner").fadeOut(500);
			$("#main-content-container").fadeOut(500, redirectPage);
		});
			 
		function redirectPage() {
			window.location = linkLocation;
		}
		
		$('.catTxtC').addClass('<?php echo $parentName ?>C');
		
	});
</script>

<!-- Site Head Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />



<!-- LOAD COLORBOX OVERLAY -->
<script type="text/javascript" src="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/js/jquery.colorbox-min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/css/theme1/colorbox.css" />

</head>
<body id="<?php echo $pageName ?>">
<!--start main container -->
<div id="main-container" >
	<div id="/<?php echo $parentName ?>" class="nHome lHome<?php echo $multiLang ?> <?php echo $parentName ?> "><div></div></div>
	<div class="clear"></div>

<!-- ORIG -->
<!-- Header  <div id="main-container" > -->
<!-- <div class="clear">Presentation</div> -->

	<div id="main-content-container" class="grid_24">
		<div id="main-content-inner">


<?php // - - - - - - - - - TEST
$a = new Area('Main');
	$a->display($c);

/*
$blocksAll = $c->getBlocks();
print_r($blocksAll);
*/
//END - - - - - - - - -  TEST ?>

			<script type="text/javascript">
			if (!(typeof easy_slider_slideshow != 'undefined')) {
				var easy_slider_slideshow = new Array();
				var easy_slider_slideshow_ends = new Array();
				var easy_slider_slideshow_configs = new Array();
				var easy_slider_current_template='';
			}
			
			//Add category class color
			$(document).ready(function() {
				$('.slide h2').addClass('<?php echo $parentName ?>C');  // Add category class color to slide h2
				$('.vidOvInfo h2').addClass('<?php echo $parentName ?>');  // Add category class bkg color to vidOvInfo h2
				$('.slide .contQuote').addClass('<?php echo $parentName ?>');  // Add category class bkg color to slide contQuote
				$('.slide .inverseBoxTint').addClass('<?php echo $parentName ?>');  // Add category class bkg color to slide contQuote
				
				// Get .presImgCredit img and add credit div
				$('.presImgCredit').each(function () {
					imgCreditSrc = $(this).children('img').attr('alt');  //Get .presImgCredit img alt text
					var imgCreditCont = '<div class="credit">'+imgCreditSrc+'</div>'
					$(this).append(imgCreditCont);
				});
				
			});

			</script>
			<div id="easysliderslideshow_202" class="easysliderslideshow pres">
				<div class="slides_container">
					<script type="text/javascript">easy_slider_current_template="pres";if (!(typeof easy_slider_slideshow_configs[easy_slider_current_template] != 'undefined')) {easy_slider_slideshow_configs[easy_slider_current_template]=new Array();}easy_slider_slideshow_configs_temp={"slideTimes":new Array()}</script>

<?php
$page = Page::getCurrentPage();
$parent = $page->getCollectionID();
$children = $page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children 

// Loop thru array $children
foreach ($children as $child) {
//	$b->display();
	$childPage = Page::getByID($child);
	$childID = $childPage->getCollectionID();
	$childName = $childPage->getCollectionName();
	
	array_push($pgNameArr, $childName); //Add page name to $pgNameArr array
	
//	$pageType = CollectionType::getByID($childID);
	$pageTypeID = $childPage->getCollectionTypeID();  // Returns ID of page type
	$pageTypeName = $childPage->getCollectionTypeName();
	
	echo '			<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>'.PHP_EOL;
	echo '			<!--SLIDER CHANGE-->'.PHP_EOL;
	echo '			<div class="slide">'.PHP_EOL;
	echo '				<!--START REPLACE-->'.PHP_EOL;
	echo '<!-- <p>parent:'.$parent.'</p> -->'.PHP_EOL;
	
	echo '<!-- <p>childID:'.$childID.' | childName:'.$childName.'</p> -->'.PHP_EOL;
	echo '<!-- <p>pageTypeID:'.$pageTypeID.' | pageTypeName:'.$pageTypeName.'</p> -->'.PHP_EOL;
	
	$pageCont = Page::getByID($childID, $version = 'RECENT');
	$a = new Area('Main');
	$blocks = $a->getAreaBlocksArray($pageCont);
	
	
	if ($pageTypeName == "Presentation Matching") {  // If page type is Presentation Matching add JS code
//echo '<p>pageTypeName: '.$pageTypeName.'</p>'.PHP_EOL;
//echo '<p>Matching code here</p>'.PHP_EOL;
		// Assign 0 to first block then +1 until end of array
		$i = 0;
		$blArr = array();  // Loop number of block named matching
		$matchImgFidArr = array(9,2,5);  // Maching block image fields field_2_image_fID and field_5_image_fID
		$selArr = array();
		$matchImgArr9 = array();  // Maching block item thumb image fields field_9_image_fID
		$matchImgArr2 = array();  // Maching block item image fields field_2_image_fID
		$matchImgArr5 = array();  // Maching block target image fields field_5_image_fID
		$itemName = array();  // Maching block item name
		$itemTarget = array();  // Maching block item target name
		$itemTargetUnq = array(); // Maching block unique item target name 1-to-many
		$trCardNmArr = array();  // Tracking holds card target ref names

		$trItemName = array();  // Tracking Maching block item name
		$trItemTarget = array();  // Tracking Maching block item target name underscores

		// Intro and completion overlay
		$gg = 1;
		foreach ($blocks as $contBl) {
			$blTypeName = $contBl->getBlockTypeHandle();
// echo '<p>block Type name:'.$blTypeName.'</p>'.PHP_EOL;	//Testing
			if ($blTypeName == "content"){  // Display content blocks
				if ($gg == 1){
					echo '<div class="aTop">'.PHP_EOL;
					$contBl->display();
					echo PHP_EOL.'</div>'.PHP_EOL;
				} else if ($gg == 2){
					echo '<div id="cont'.$gg.'" class="inOverlayCont '.$parentName.'">'.PHP_EOL;
					$contBl->display();
					echo '<div class="nextBtnInv"><h4 class="'.$parentName.'C">Next &gt;</h4></div></div><!-- END cont'.$gg.' -->'.PHP_EOL;
					echo PHP_EOL.'<div class="inOverlay ovPres"></div>'.PHP_EOL;
				} else {
					$contBl->display();
				}
				$gg++;
			}
		}
		

		echo PHP_EOL.'<div id="matchMsg">'.PHP_EOL;  // Feedback msg container div
	
		foreach ($blocks as $b) {
			$blTypeName = $b->getBlockTypeHandle();
// echo '<p>block Type name:'.$blTypeName.'</p>'.PHP_EOL;	//Testing
			
			if ($blTypeName == "matching"){  // ONLY get block type matching from Main area
				array_push($blArr, $i);
				$btc = $b->getInstance();
				foreach ($matchImgFidArr as $matchImgNum) {  // Loop thru image fields and add src to array (9,2,5)
					$image_fID = 'field_'.$matchImgNum.'_image_fID';  // field_9_image_fID
					$imgFID = $btc->$image_fID;  // 56 = $btc->field_9_image_fID
					$img = empty($imgFID) ? null : File::getByID($imgFID);
					$imgTagTest = $img->getRelativePath();  // returns img path
					if ($matchImgNum == 9){
						array_push($matchImgArr9, $imgTagTest); // Push image path into array
					}
					if ($matchImgNum == 2){
						array_push($matchImgArr2, $imgTagTest); // Push image path into array
					}
					if ($matchImgNum == 5){
						array_push($matchImgArr5, $imgTagTest); // Push image path into array
					}
				}  // End foreach $matchImgFidArr
				$itemNameContSrc = $btc->field_1_textbox_text;  // Get item name contents
				$itemNameCont = str_replace(" ","_",$itemNameContSrc);  // replace space with underscore
				array_push($itemName, $itemNameCont);

				$itemTargetContSrc = $btc->field_4_textbox_text;  // Get item target contents
				$itemTargetCont = str_replace(" ","_",$itemTargetContSrc);  // replace space with underscore
				array_push($itemTarget, $itemTargetCont);

				echo '<div id="incorrMsg'.($i+1).'" class="presMatchInfo incorrCont">'.$btc->field_7_wysiwyg_content.'<div class="clear"></div></div>'.PHP_EOL;  // outpot incorr msg div
				echo '<div id="corrMsg'.($i+1).'" class="presMatchInfo">'.$btc->field_8_wysiwyg_content.'<div class="clear"></div></div>'.PHP_EOL;  // outpot corr msg div
				$i++;
			}	// END if $blTypeName == "matching
		}  // END foreach ($blocks as $b)
		
		echo '</div><!-- END matchMsg -->'.PHP_EOL;  // END Feedback msg container div
	
		$blNumArr = '[' . implode(',', $blArr) . ']';
		$itemNumArr = '"item' . implode('","item', $blArr) . '"';

		$indexShuffArr = $blArr; // copies
		shuffle($indexShuffArr);  // shuffles values in array	
?>

<!-- Matching Javascript -->
<script type="text/javascript">
	var correctCards=0;
	var cardID=0;
	
	$(init(0));
	
	// setup card and pile arrays
	var numbers = <?php echo $blNumArr ?>;
	var matchNum = numbers.length;

	function init(n) {
		if (n == 1){  // reset counts
			correctCards=0;  // Needs reset on Play Again
			cardID=0;
			$('.ui-draggable').removeClass('correct').removeClass('ui-draggable-disabled').removeClass('ui-state-disabled').css('top', '').css('left', '').appendTo('#cardPile');  // Replace card divs back to cardPile
			$('.ui-draggable').draggable( 'enable' );
			setupDrag();
		}		
		
		$('.inOverlay').hide();
		$('#cont2').hide(); // Hide the completion message		
		
		$('.presMatchInfo h2').addClass('<?php echo $parentName ?>');  // Add category class color to incorr/corr h2
		$('.incorrCont').addClass('<?php echo $parentName ?>');  // Add category class color to incorr div

		setupDrag();
		
		$(".ui-droppable").droppable({
			accept: ".ui-draggable",
			hoverClass: 'hovered',
			drop: handleCardDrop
		});

	}  // END function init()
	
	
	function setupDrag(){
		$(".ui-draggable").draggable({
			containment: '#content',
			stack: '#cardPile div',
			cursor: 'move',
			start: function(){
				$(this).css('z-index','100');
				cardID = $(this).attr("id"); // returns id of drag card = card1
			},
			stop: function(){ $(this).css('z-index','1'); },
			revert: true
		});
	}
	
	
	function handleCardDrop(event,ui){	
		var slotNumber = $(this).attr("ref");
		var cardNumber = ui.draggable.attr("ref");
		var cardIDSub = cardID.substr(4); // removes first 4 chars(card1) returns 1
		var trIndexSrc = ui.draggable.attr("class"); //Tracking grabs index number from item
		var trIndex = trIndexSrc.charAt(13); //Return 1 = 14th char (ui-draggable 1) - index13 starts at 0	
		
		// If the card was dropped to the correct slot, position it directly
		// on top of the slot, and prevent it being dragged again
		if ( slotNumber == cardNumber ){
			ui.draggable.addClass( 'correct' );
			ui.draggable.draggable( 'disable' );
			var droppedOn = $(this);
			ui.draggable.detach().css({top: 0,left: 0}).appendTo(droppedOn);
			ui.draggable.position( { of: $(this), my: 'left top', at: 'left top' } );
			ui.draggable.draggable( 'option', 'revert', false );
			correctCards++;
			var corrID = '#corrMsg'+cardIDSub;
			$.colorbox({inline:true, href:corrID});  // colorbox show div ID slot corr msg
			
			//Tracking
			var trMsg = '<?php echo $pageTitle ?>: '+trItemName[trIndex]+' - '+trTargetName[trIndex]+' : '+trItemTries[trIndex];
			if (piwikTracker) { //Piwik tracking id="card4" | ref="lagoons_high_tide"
					piwikTracker.trackPageView(trMsg); //ref="lagoons_high_tide"
				}
//alert('trMsg: '+trMsg); //Testing    	
		} else {
			ui.draggable.draggable( 'option', 'revert', true );
			var incorrID = '#incorrMsg'+cardIDSub;
			$.colorbox({inline:true, href:incorrID});  // colorbox show div ID slot corr msg

			//Tracking
			var curTries = trItemTries[trIndex];	//current tries in array
			trItemTries.splice(trIndex,1,(curTries+1)); //Tracking at index trIndex add 1 item value tries++ in trItemTries arr
		}
		
		// If all the cards have been placed correctly then display a message
		if ( correctCards == matchNum ){
			$('#cont2').show();		//Show completion text
			$('.inOverlay').show();	//Show completion overlay
		}
	}  // END function handleCardDrop(event,ui)
</script>
<!-- END Matching Javascript -->

<div id="content" class="presMatching">

  <div id="cardPile">
<?php
// randomize items map index to targets
// shuffle($indexShuffArr);  // shuffles values in array
// $itemName = array();  // Maching block item name
	foreach ($indexShuffArr as $num) {
		echo '<div id="card'.($num+1).'" class="ui-draggable '.$num.'" style="background:url('.$matchImgArr9[$num].') 0 0 no-repeat;" ref="'.$itemTarget[$num].'"></div>'.PHP_EOL;
		$numGl = $num;
		
		array_push($trItemName, $itemName[$num]);	//Add item name to tracking array
		array_push($trItemTarget, $itemTarget[$num]);	//Add target name to tracking array
	}

	echo '</div><!-- END cardPile -->'.PHP_EOL;
  	echo '<div id="cardSlots">'.PHP_EOL;
  	
  	$i = 0;
	foreach ($itemTarget as $slot) {
		if ($curSlot != $slot){  // Check if slot equals curSlot is duplicate
			echo '<div id="slot'.($i).'" class="ui-droppable" style="background: url('.$matchImgArr5[$i].') 0 0 no-repeat;" ref="'.$itemTarget[$i].'"></div>'.PHP_EOL;
		}
		$curSlot = $slot;
		$i++;
	}

?>
	</div><!-- END cardSlots -->

	<div class="clear"></div>
</div><!-- END #content -->

<?php
		$trItemNameJsArr = '["' . implode('","', $trItemName) . '"]';	//creates item name javascript array
		$trItemTargetJsArr = '["' . implode('","', $trItemTarget) . '"]';	//creates target name javascript array
?>
	<script type="text/javascript">//Tracking
	var trItemName  = <?php echo $trItemNameJsArr ?>;
	var trTargetName = <?php echo $trItemTargetJsArr ?>;
	var trItemTries = [];
	for (var ita = 0; ita < trItemName.length; ita++) trItemTries[ita] = 1; //array with x items val 1
	</script>		
<?php	
	} // END If page type is Matching
	
	if ($pageTypeName == "Zoom") {   // Output zoom js
	
		$zoomBlCountArr = array(); // zoom block ids
		
		$i = 1;
		foreach ($blocks as $b) {
			$blTypeName = $b->getBlockTypeHandle();
			if ($blTypeName == "zoom_info") {
				$curBl = $b->getBlockID();
	//echo PHP_EOL.'<p>curBl: '.$curBl.'</p>'.PHP_EOL;	//Testing
				array_push($zoomBlCountArr, $curBl); // Push block ID path into array
				$i++;
			}
		}
		$zoomBlCountArrJs = implode(',', $zoomBlCountArr);
		
		$o = new Area('Overlay');
		$overlayBl =  $o->getAreaBlocksArray($pageCont);
		
		$ie = 1;
		foreach ($overlayBl as $overlay) {
	//		echo '<div class="hideCont">'.PHP_EOL;
			echo '<div id="end'.$ie.'" class="inOverlayCont '.$parentName.'">'.PHP_EOL;
			$overlay->display();
			echo '<div class="nextBtnInv"><h4 class="'.$parentName.'C">Next &gt;</h4></div>'.PHP_EOL;
			echo '</div><!-- END end'.$ie.' -->'.PHP_EOL;
	//		echo '</div>'.PHP_EOL;	//end hideCont
			echo PHP_EOL.'<div class="inOverlay ovPres"></div>'.PHP_EOL;
			$ie++;
		}
?>
	<script type="text/javascript">
		var clickCount = 0;
		
		$('.zoomInfoBtn').colorbox({
			inline:true,
			href:function(){
				var number = $(this).attr('id'); // returns item130
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
	
				return numDiv;
			},
			onClosed:function(){
				checkDone();
			}
		});
		
		$('.inOverlay').hide();
		$('#end1').hide();
		
		$('.zoomInfoContHead').addClass('<?php echo $parentName ?>');  // Add category class color to incorr/corr h2
		
		$('.imgCredit img').each(function(){	//Find img in div.imgCredit and disable drag
			$(this).attr('ondragstart', 'return false');	
		});
		
		//Click counting
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
//alert('trMsg: '+trMsg); //Testing	trMsg: : Saltgrass

			if (inClickedArr == -1){ // NOT in clickClicked array
				clickClicked.push(number); // add to clickClicked array
				clickCount++;
			} else {
			}
			
			if (clickCount == clickTot) {  // current click count equals total click number
				clickDone = 1;
			}
		}
		
		function checkDone(){
			if (clickDone == 1) {
//			alert('DONE'+clickCount+' is: '+clickTot);
//				$('#end1').css('display','block');
//				$.colorbox({inline:true, href:'#end1'});	//Switch from colorbox to overlay
				$('#end1').show();	//Show completion info overlay
				$('.inOverlay').show();	//Show completion overlay
			}
		}
		
		function init(n) {
			if (n == 1){  // reset counts
				clickCount = 0;
				clickClicked = [];
				clickDone = 0;
				$('.inOverlay').hide();
				$('#end1').hide();
			}
		}

	</script>
<?php
	}  // END if ($pageTypeName == "Zoom")
	
	
	if ($pageTypeName == "Presentation Content Page") {   // OUtput top, left, right, bottom area blocks

		$t = new Area('Top');
		$topBlocks = $t->getAreaBlocksArray($pageCont);
		if (count($topBlocks) != 0){
			echo '<div class="aTop">'.PHP_EOL;
			foreach ($topBlocks as $topCont) {
				$topCont->display();
			}
			echo '</div><!-- END aTop -->'.PHP_EOL;
		}
		
		$l = new Area('Left');
		$leftBlocks = $l->getAreaBlocksArray($pageCont);
		echo '<div class="aLeft">'.PHP_EOL;
		foreach ($leftBlocks as $leftCont) {
			$leftCont->display();
		}
		echo '</div><!-- END aLeft -->'.PHP_EOL;
		
		
		$r = new Area('Right');
		$rightBlocks = $r->getAreaBlocksArray($pageCont);
		echo '<div class="aRight">'.PHP_EOL;
		foreach ($rightBlocks as $rightCont) {
			$rightCont->display();
		}
		echo '</div><!-- END aRight -->'.PHP_EOL;
	
		$b = new Area('Bottom');
		$bottomBlocks = $b->getAreaBlocksArray($pageCont);
		if (count($bottomBlocks) != 0){
			echo '<div class="aBottom">'.PHP_EOL;
			foreach ($bottomBlocks as $bottomCont) {
				$bottomCont->display();
			}
			echo '</div><!-- END aBottom -->'.PHP_EOL;
		}

	}  // END if (pageTypeName == "Presentation Content Page")
	

// Loop thru standard presentation child pages
// If page type IS NOT Matching, Zoom, Pres 2-col vert output blocks in Main area - for regular pages
//	if (in_array($pageTypeName, array('Presentation Matching', 'Zoom','Presentation Content Page'))) {	
	if (in_array($pageTypeName, array('Presentation Matching','Presentation Content Page'))) {	
	} else {
//echo '<p>Past match and zoom pageTypeName: '.$pageTypeName.'</p>'; //Testing		
		foreach ($blocks as $cont) {
//echo '<p>pageTypeName: '.$pageTypeName.'</p>'.PHP_EOL; //Testing	
			$cont->display();
		}
	}

	echo '				<!--END REPLACE-->'.PHP_EOL;
	echo '			</div>'.PHP_EOL;
}  // END Loop array $children 

$pgNameArrJs = '["' . implode('","', $pgNameArr) . '"]';	//imploded array of page names to pass to javascript
//Testing
/*
echo '<p>pgNameArr<br>';
print_r($pgNameArr);
echo '</p>';
echo '<p>'.$pgNameArrJs.'</p>';

<p>[rest01 Bring Back the Baylands,rest02 A Little Digging Goes A Long Way,rest03 Restoration in Action zoom,rest04 Learning by Doing,rest05 Healthier Habitats,rest06]</p>	

*/
?>
					<script type="text/javascript">easy_slider_slideshow_configs[easy_slider_current_template].push({ "showControls":0, "showPagination":1, "autostart":0, "hoverPause":0, "slideTime":0, "slideTimes":easy_slider_slideshow_configs_temp["slideTimes"]});</script>
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