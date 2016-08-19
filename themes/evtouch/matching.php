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

if ($c->isEditMode()) {
	$isEdit = 1;
}
else {
	$isEdit = 0;
}
?>

<script type="text/javascript">
	var appCat = "<?php echo $parentName ?>";
 
	$(document).ready(function() {
	
	//	$('#main-content-container').fadein(500);
	
		$('.imgCredit img').each(function(){	//Find img in div.imgCredit and disable drag
			$(this).attr('ondragstart', 'return false');	
		});
		
		$('.nHome').click(function(event){
			event.preventDefault();
//			linkLocation = $(this).attr('id');
			linkLocation = '<?php echo $homeURL ?>';
			$("#main-bkg-inner").fadeOut(500);
			$("#main-content-container").fadeOut(500, redirectPage);
		});
			 
		function redirectPage() {
			window.location = linkLocation;
		}
	}); // END document.ready

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

	<div id="main-content-container" class="grid_24">
		<div id="main-content-inner" class="<?php echo $pageName ?>">
<?php //TEST
/*
$blocksAll = $c->getBlocks();
print_r($blocksAll);
*/
//END TEST ?>	
<?php	
if ($isEdit == 1) {  // If in edit mode, show all blocks

	$hd = new Area('Header');
	$hd->display($c);
	
	$i = new Area('Intro');
	$i->display($c);
	
	$o = new Area('Overlay');
	$o->display($c);

	$a = new Area('Main');
	$a->display($c);
	
	$mBkg = new Area('Background');
	$mBkg->display($c);
	
} else {   // If NOT edit mode output slides
?>
		

			<script type="text/javascript">
			if (!(typeof easy_slider_slideshow != 'undefined')) {
				var easy_slider_slideshow = new Array();
				var easy_slider_slideshow_ends = new Array();
				var easy_slider_slideshow_configs = new Array();
				var easy_slider_current_template='';
			}
			</script>
			
			<div id="easysliderslideshow_202" class="easysliderslideshow full_app">
				<div class="slides_container">
					<script type="text/javascript">easy_slider_current_template="full_app";if (!(typeof easy_slider_slideshow_configs[easy_slider_current_template] != 'undefined')) {easy_slider_slideshow_configs[easy_slider_current_template]=new Array();}easy_slider_slideshow_configs_temp={"slideTimes":new Array()}</script>

<?php
$page = Page::getCurrentPage();
$pageID = $page->getCollectionID();
$pageCont = Page::getByID($pageID, $version = 'RECENT');
$hd = new Area('Header');
$a = new Area('Main');
$i = new Area('Intro');
$o = new Area('Overlay');
$mBkg = new Area('Background');

$matchHeaderArea = $hd->getAreaBlocksArray($pageCont);
$blocks = $a->getAreaBlocksArray($pageCont);
$introBl =  $i->getAreaBlocksArray($pageCont);
$overlayBl =  $o->getAreaBlocksArray($pageCont);
$mBkgBl =  $mBkg->getAreaBlocksArray($pageCont);
?>



					<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>
					<!--SLIDER CHANGE-->
					<div class="slide">
						<!--START REPLACE-->
						
<?php	
						foreach ($matchHeaderArea as $matchHeader) {
							echo '							<div class="header selCat '.$parentName.'"><h1>'.PHP_EOL;
							$matchHeader->display();
							echo '</h1></div>'.PHP_EOL;
						}												
?>
						<div class="intro">
<?php
$itc = 1;
foreach ($introBl as $intro) {
	if ($itc == 2) {
		echo '							<div class="clear"></div>'.PHP_EOL;
		echo '							<div class="fullAppCta">'.PHP_EOL;
		$intro->display().PHP_EOL;
	} else if ($itc == 3) {  //Start btn label
		echo '								<div id="1" class="startBtn '.$parentName.'">';
		$intro->display();
		echo '</div>'.PHP_EOL;
		echo '							<div class="clear"></div></div>'.PHP_EOL;
	} else {
		$intro->display();
	}
	$itc++;
}
?>

							<div class="clear"></div>
						</div><!-- END intro -->
						<!--END REPLACE-->
					</div>

<!-- //  START matching screen -->
					<script type="text/javascript">
						easy_slider_slideshow_configs_temp["slideTimes"].push(0)
					//	$.colorbox({inline:true, href:'#cont2'});	// open intro overlay
					//	$('#cont2').hide();
						$('.closeCb').addClass('<?php echo $parentName ?>C');  // Add category color to close btn
						$('#cont2').hide();
					
						$('.closeCb').click(function() {						
							$('.inOverlay').hide();						// Start close btn
							$('.inOverlayCont').hide();
						});
					
					</script>
					<!--SLIDER CHANGE-->
					<div class="slide">
						<!--START REPLACE-->
<?php	// Instructions overlay
$i = 1;
foreach ($overlayBl as $overlay) {
	echo '<div id="cont'.$i.'" class="inOverlayCont '.$parentName.'">'.PHP_EOL;
	$overlay->display();
	echo '</div><!-- END cont'.$i.' -->'.PHP_EOL;
	$i++;
}
?>
						<div class="inOverlay"></div><!-- END hideCont intro -->
<?php
echo '<!-- <p>Matching code here</p> -->'.PHP_EOL;
	// Assign 0 to first block then +1 until end of array
	$i = 0;
	$blArr = array();  // Loop number of block named matching
	$matchImgFidArr = array(9,2,5);  // Maching block image fields field_2_image_fID and field_5_image_fID
	$selArr = array();
	$matchImgArr9 = array();  // Maching block item thumb image fields field_9_image_fID
	$matchImgArr2 = array();  // Maching block item image fields field_2_image_fID
	$matchImgArr5 = array();  // Maching block target image fields field_5_image_fID
	$itemName = array();  // Maching block item name
	$itemCred = array();  // Maching block item image credit
	$itemTarget = array();  // Maching block item target name underscores
	$itemTargetTxt = array();  // Maching block item target name
	$itemTargetUnq = array(); // Maching block unique item target name 1-to-many
	$itemTargetCred = array();  // Maching block item target image credit
	$itemTargetTop = array();  // Maching block item target top coord
	$itemTargetLeft = array();  // Maching block item target left coord
	
	$itemTargetWidth = array();  // Maching block item target width
	$itemTargetHeight = array();  // Maching block item target height
	
	
	$trItemName = array();  // Tracking Maching block item name
	$trItemTarget = array();  // Tracking Maching block item target name underscores

	echo '<div id="matchMsg">'.PHP_EOL;  // Feedback msg container div

$blocks = $a->getAreaBlocksArray($pageCont);


	foreach ($blocks as $b) {
		$blTypeName = $b->getBlockTypeHandle();
//TESTING echo '<p>block Type name:'.$blTypeName.'</p>'.PHP_EOL;
		if ($blTypeName == "content"){ // Display content blocks
			$b->display();
		}
		
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
			$itemNameCont = $btc->field_1_textbox_text;  // Get item name contents
//			$itemNameCont = str_replace(" ","_",$itemNameContSrc);  // replace space with underscore
			array_push($itemName, $itemNameCont);
			
			$itemCredSrc = $btc->field_3_textbox_text;  // Get item image credits contents
			array_push($itemCred, $itemCredSrc);
			
			$itemTargetContSrc = $btc->field_4_textbox_text;  // Get item target contents
			array_push($itemTargetTxt, $itemTargetContSrc);
			
			$itemTargetCont = str_replace(" ","_",$itemTargetContSrc);  // replace space with underscore
			array_push($itemTarget, $itemTargetCont);

			$itemTargetCredSrc = $btc->field_6_textbox_text;  // Get item target image credit contents
			array_push($itemTargetCred, $itemTargetCredSrc);
			
			$itemTargetTopSrc = $btc->field_10_textbox_text;  // Get item target top coord
			array_push($itemTargetTop, $itemTargetTopSrc);
			
			$itemTargetLeftSrc = $btc->field_11_textbox_text;  // Get item target top coord
			array_push($itemTargetLeft, $itemTargetLeftSrc);
			
			
			$itemTargetWidthSrc = $btc->field_12_textbox_text;  // Get item target width
			array_push($itemTargetWidth, $itemTargetWidthSrc);

			$itemTargetHeightSrc = $btc->field_13_textbox_text;  // Get item target height
			array_push($itemTargetHeight, $itemTargetHeightSrc);

//				$itemTarget[$itemNameCont]=$itemTargetCont;  // key => value


			echo '<div id="incorrMsg'.($i+1).'" class="itemInfoCont incorrCont">'.$btc->field_7_wysiwyg_content.'<div class="clear"></div></div>'.PHP_EOL;  // output incorr msg div
			
			echo '<div id="corrMsg'.($i+1).'" class="itemInfoCont">'.PHP_EOL;
			if ($pageName == "birds-matching"){
				echo '<div class="imgCredit '.$pageName.'"><img src="'.$matchImgArr5[$i].'" ondragstart="return false" />'.PHP_EOL;  // birds-matching use TARGET img in corr
				echo '<h3>'.$itemTargetCred[$i].'</h3></div>'.PHP_EOL;
			} else {
				echo '<div class="imgCredit"><img src="'.$matchImgArr2[$i].'" ondragstart="return false" />'.PHP_EOL;  // matching use ITEM img in corr
				//echo '<h3>'.$itemTargetCred[$i].'</h3></div>'.PHP_EOL;	//Target credits
				echo '<h3>'.$itemCred[$i].'</h3></div>'.PHP_EOL;
			}
		
			echo $btc->field_8_wysiwyg_content.PHP_EOL;
			echo '<div class="clear"></div></div>'.PHP_EOL;  // output corr msg div
			$i++;
		}	// END if $blTypeName == "matching
	}  // END foreach ($blocks as $b)
	
	echo '</div><!-- END matchMsg -->'.PHP_EOL;  // END Feedback msg container div

	$blNumArr = '[' . implode(',', $blArr) . ']';

	$indexShuffArr = $blArr; // copies
	shuffle($indexShuffArr);  // shuffles values in array
?>


<!-- Matching Javascript -->
<script type="text/javascript">
var correctCards=0;
var cardID=0;
var clickCount = 0;

$(document).ready(function() {
	$(init(0));
});

// setup card and pile arrays
var numbers = <?php echo $blNumArr ?>;
var matchNum = numbers.length;

function init(n) {
	if (n == 1){  // reset counts
		correctCards=0;  // Needs reset on Play Again
		cardID=0;
		$('.ui-draggable').removeClass('correct').css('top', '').css('left', '').appendTo('#cardPile');  // Replace card divs back to cardPile
	}
	
	$('#successMessage').hide();  // Hide the success message
	$('#successMessage').css({
		left: '580px',
		top: '250px',
		width: 0,
		height: 0
	});
//	$('#matchMsg').hide();  // Hide all feedback msg divs
	$('.itemInfoCont h2').addClass('<?php echo $parentName ?>');  // Add category class color to incorr/corr h2


	$(".ui-draggable").draggable({
		containment: '#content',
		stack: '#cardPile .cardPileCol div',
		cursor: 'move',
		start: function(){
			$(this).css('z-index','100');
			cardID = $(this).attr("id"); // returns id of drag card = card1
		},
		stop: function(){ $(this).css('z-index','1'); },
		revert: true
	});
	
	
	$(".ui-droppable").droppable({
		accept: ".ui-draggable",
		hoverClass: 'hovered',
		drop: handleCardDrop
	});

}  // END function init()

function handleCardDrop(event,ui){
	var slotNumber = $(this).attr("ref");

	var cardNumberArr = [];
	var cardNumber = ui.draggable.attr("ref");	// For mixed put ref in array and check target against it
	var trIndexSrc = ui.draggable.attr("class"); //Tracking grabs index number from item
	var trIndex1 = trIndexSrc.charAt(13); //Return 0 = 14th char (ui-draggable 01) - index13 starts at 0
	var trIndex2 = trIndexSrc.charAt(14); //Return 1 = 15th char (ui-draggable 01) - index13 starts at 0
	var trIndex = parseInt(trIndex1+trIndex2); //Removes leading 0

	cardNumberArr = cardNumber.split("-");

	var cardIDSub = cardID.substr(4); // removes first 4 chars(card1) returns 1
	// If the card was dropped to the correct slot,
	// change the card colour, position it directly
	// on top of the slot, and prevent it being dragged again
	
	var inClickedArr = $.inArray(slotNumber,cardNumberArr);
	
	if (inClickedArr == -1){ // NOT in clickClicked array
		ui.draggable.draggable( 'option', 'revert', true );
		var incorrID = '#incorrMsg'+cardIDSub;
		$.colorbox({inline:true, href:incorrID});  // colorbox show div ID slot corr msg
		
		//Tracking
		var curTries = trItemTries[trIndex];	//current tries in array
		trItemTries.splice(trIndex,1,(curTries+1)); //Tracking at index trIndex add 1 item value tries++ in trItemTries arr
		
	} else {	//Correct success
		ui.draggable.addClass( 'correct' );
		ui.draggable.draggable( 'disable' );
		var droppedOn = $(this);
<?php if ($pageName != "birds-matching"){
	echo '		ui.draggable.detach().css({top: 0,left: 0}).appendTo(droppedOn);'.PHP_EOL;
} else { echo '		ui.draggable.hide();'.PHP_EOL; } ?>
		ui.draggable.draggable( 'option', 'revert', false );
		correctCards++;
		var corrID = '#corrMsg'+cardIDSub;

		$.colorbox({inline:true, href:corrID});  // colorbox show div ID slot corr msg
		//Add cardNumber to correct array
		
		//Tracking
		var trMsg = '<?php echo $pageTitle ?>: '+trItemName[trIndex]+' - '+trTargetName[trIndex]+' : '+trItemTries[trIndex];
		if (piwikTracker) { //Piwik tracking id="card4" | ref="lagoons_high_tide"
            	piwikTracker.trackPageView(trMsg); //ref="lagoons_high_tide"
        	}
	}
	
	// If all the cards have been placed correctly then display a message and reset the cards for another go
	
	if ( correctCards == matchNum ){
		$('#cont2').show();		//Show completion text
		$('.inOverlay').show();	//Show completion overlay
		$('#successMessage').animate({
			left: '380px',
			top: '200px',
			width: '400px',
			height: '100px',
			opacity: 1
		});
	}
}  // END function handleCardDrop(event,ui)
</script>
<!-- END Matching Javascript -->

			<div id="content" class="matching">

				<div id="cardPile" class="<?php echo $pageName ?>">
<?php
// randomize items map index to targets
// shuffle($indexShuffArr);  // shuffles values in array
// $itemName = array();  // Maching block item name
$oddEven = 1;

foreach ($indexShuffArr as $num) {
$number = $num+1;
$trInNum = sprintf("%02d",($oddEven-1));

// to test whether $number is odd you could use the arithmetic operator '%' (modulus) like this
	if( $odd = $oddEven%2 ){  // $odd == 1; the remainder of 25/2
		$itemMarg = 'left';  //    echo 'ODD Number!';
	} else {  // $odd == 0; nothing remains if e.g. $number is 48 instead, as in 48 / 2
		$itemMarg = 'right';  //    echo 'EVEN Number!';
	}

	if( $oddEven == 1 ){  //  split into 2 columns of 7
		echo '<div class="cardPileCol left">'.PHP_EOL;
	}
	if( $oddEven == 8 ){
		echo '<div class="cardPileCol right">'.PHP_EOL;
	}
		
	$img = empty($imgFID) ? null : File::getByID($imgFID);
	echo '<div id="card'.$number.'" class="ui-draggable '.$trInNum.'" style="background:url('.$matchImgArr9[$num].') 0 0 no-repeat;" ref="'.$itemTarget[$num].'"><h3 class="'.$parentName.'">'.$itemName[$num].'</h3></div>'.PHP_EOL;

	$numGl = $num;
		
	if( $oddEven == 7 ){
		echo '<div class="clear"></div></div><!-- END left -->'.PHP_EOL;
	}
	array_push($trItemName, $itemName[$num]);	//Add item name to tracking array
	array_push($trItemTarget, $itemTarget[$num]);	//Add target name to tracking array
	$oddEven++;
}

if ($pageName != "birds-matching"){
	echo '<div class="clear"></div></div><!-- END column -->'.PHP_EOL;

	//Loop to create bkg slots green transparent
	$cardCount = count($indexShuffArr);
	$cc = 1;
	echo '<div class="cardPileBkgCont">'.PHP_EOL;
	while ($cc <= $cardCount) {
		echo '<div class="cardPileBkg '.$parentName.'"></div>'.PHP_EOL;
		$cc++;
	}
	echo '</div>'.PHP_EOL;
}

echo '</div><!-- END cardPile -->'.PHP_EOL;
echo '<div id="cardSlots" class="'.$pageName.'">'.PHP_EOL;

$i = 0;
foreach ($itemTarget as $slot) {
	if ($curSlot != $slot){  // Check if slot equals curSlot is duplicate
		if ($pageName == "birds-matching"){  // Page name IS birds-matching
//			if ( (!empty($itemTargetTop[$i])) && (!empty($itemTargetLeft[$i])) ) {
//				$targetStyles = 'style="top:'.$itemTargetTop[$i].'px;left:'.$itemTargetLeft[$i].'px;"';

//Check if top left empty
//check if width height empty
//if not empty print styles
//else if nothing

			if ( (!empty($itemTargetTop[$i])) && (!empty($itemTargetLeft[$i])) ) {
				$targetTopLeft = 'top:'.$itemTargetTop[$i].'px;left:'.$itemTargetLeft[$i].'px;';
			} else {
				$targetTopLeft = '';
			}
			if ( (!empty($itemTargetWidth[$i])) && (!empty($itemTargetHeight[$i])) ) {
				$targetWidthHeight = 'width:'.$itemTargetWidth[$i].'px;height:'.$itemTargetHeight[$i].'px;';
			} else {
				$targetWidthHeight = '';
			}
			
			if ( (!empty($targetTopLeft)) || (!empty($targetWidthHeight)) ) {
				$targetStyles = 'style="'.$targetTopLeft.$targetWidthHeight.'"';
			} else {
				$targetStyles = '';
			}
				


			
			echo '<div id="slot'.($i).'" class="ui-droppable" '.$targetStyles.' ref="'.$itemTarget[$i].'"><h3 class="tarTitle">'.$itemTargetTxt[$i].'</h3>';
//TESTING
//			echo $i.'top:'.$itemTargetTop[$i].$i.'-left:'.$itemTargetLeft[$i].$i.'-w:'.$itemTargetWidth[$i].$i.'-h:'.$itemTargetHeight[$i];
			
			echo '</div>'.PHP_EOL;
		} else {
			echo '<div id="slot'.($i).'" class="ui-droppable" style="background: url('.$matchImgArr5[$i].') 0 0 no-repeat;" ref="'.$itemTarget[$i].'">'.PHP_EOL;
			echo '<h3 class="tarTitle">'.$itemTarget[$i].'</h3>'.PHP_EOL;
//			echo '<h4 class="imgCredit">'.$itemTargetCred[$i].'</h3></div>'.PHP_EOL;
			echo '</div>'.PHP_EOL;
		} //$pageName == "birds-matching"
	}
	$curSlot = $slot;
	$i++;
}
?>
				</div><!-- END cardSlots -->
<?php  // Check if block type is image and set as bkg
foreach ($blocks as $matchBkg) {
	$blTypeName = $matchBkg->getBlockTypeHandle();
	if ($blTypeName == "image"){ // Display bkg image blocks <div class="zoomBkg">
		$matchBkg->display();
	}
}


//$mBkgBl

foreach ($mBkgBl as $mBkgImg) {
	$mBkgImg->display();
}

?>
				<div class="clear"></div>
			</div><!-- END content -->
<?php
/*
$trItemName = array();  // Tracking Maching block item name
$trItemTarget = array();  // Tracking Maching block item target name underscores
*/

$trItemNameJsArr = '["' . implode('","', $trItemName) . '"]';	//creates item name javascript array
$trItemTargetJsArr = '["' . implode('","', $trItemTarget) . '"]';	//creates target name javascript array

//  END matching screen
echo '				<!--END REPLACE-->'.PHP_EOL;
echo '			</div>'.PHP_EOL;

?>
					<script type="text/javascript">easy_slider_slideshow_configs[easy_slider_current_template].push({ "showControls":0, "showPagination":0, "autostart":0, "hoverPause":0, "slideTime":0, "slideTimes":easy_slider_slideshow_configs_temp["slideTimes"]});</script>
				</div><!-- END slides_container -->
			</div><!-- END easysliderslideshow_140 -->

<?php			
}  // END  else {} NOT edit mode output slides
?>

		</div><!-- END main-content-inner -->
	</div><!-- END main-content-container -->

<!-- FOOTER START main-bkg -->
<div id="main-bkg" class="<?php echo $fsName ?>" style="background:url(<?php echo $theFilePath ?>) 0 0 no-repeat;">
	<div id="main-bkg-outer">
		<div id="main-bkg-inner" class="fullScreen"></div>
	</div>
</div><!-- END main-bkg -->

<?php   Loader::element('footer_required'); ?>
<script type="text/javascript">
//Tracking
var trItemName  = <?php echo $trItemNameJsArr ?>;
var trTargetName = <?php echo $trItemTargetJsArr ?>;
var trItemTries = [];
for (var ita = 0; ita < trItemName.length; ita++) trItemTries[ita] = 1; //array with x items val 1
</script>
<?php  $this->inc('elements/analytics.php'); ?>
</body>
</html>