<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
<head>
<?php   Loader::element('header_required');
Loader::model('file_list');
Loader::model('file_set');
//$page = Page::getCurrentPage();
$page = Page::getByID(137);  // Master Plant ID page
//$pageID = $page->getCollectionID();
//echo PHP_EOL.'<p>pageID: '.$pageID.'</p>'.PHP_EOL;
$pageCont = Page::getByID(137, $version = 'RECENT');
$pagePath = $c->getCollectionPath();

$parent = Page::getByID($c->getCollectionParentID());
$pageName = $parent->getCollectionHandle();
$pageTitle = $parent->getCollectionName();

$children = $page->getCollectionChildrenArray($intOneLevel = 1);  // Get first-level children of $page object and put in array $children

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

$multiLang = $_SESSION['firstMessage'];	//$multiLang = 0/1: English/Spanish

//Language check $multiLang = 0/1: English/Spanish
$strLen = strlen($pageName); // count sting length earth=5
$pagePathStart = substr($pagePath, 1, $strLen);  // /spn/earth/plant-animal-id --> spn/e

if ($pageName != $pagePathStart){	// IF earth DOES NOT = spn/e
	$multiLang = 1;					// Spanish
} else {
	$multiLang = 0;					// Use English
}

session_start();
$_SESSION['firstMessage'] = $multiLang;

//echo PHP_EOL.'<p>childPageName list</p>'.PHP_EOL;  // Testing
//print_r($children);  // Testing
foreach ($children as $child) {
	$childPage = Page::getByID($child);
	$childPageName = $childPage->getCollectionHandle();
//	echo PHP_EOL.'<p>childPageName: '.$childPageName.'</p>'.PHP_EOL;  // Testing
}

$hd = new Area('Header');
$cat = new Area('Categories');

/*
$page = Page::getCurrentPage();
$pageID = $page->getCollectionID();
$pageCont = Page::getByID($pageID, $version = 'RECENT');
$hd = new Area('Header');
$a = new Area('Main');
$i = new Area('Intro');
$o = new Area('Overlay');
$mBkg = new Area('Background');
*/

$plidHeaderArea = $hd->getAreaBlocksArray($pageCont);
$plidCatArea = $cat->getAreaBlocksArray($pageCont);

if ($c->isEditMode()) {
	$isEdit = 1;
}
else {
	$isEdit = 0;
}
?>
<script type="text/javascript">
	var appCat = "<?php echo $pageName ?>";
	var pageTitle = "<?php echo $pageTitle ?>";
	$(document).ready(function() {
		$('.lvl2 h4').addClass(appCat+'C');  // Add category bkg color class to page header titlebar
		
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
<body id="plant-animal-id">

<!--START main container -->
<div id="main-container">
	<div id="/<?php echo $pageName ?>" class="nHome <?php echo $pageName ?>"><div></div></div>
	<div class="footer">
		<div class="<?php echo $pageName ?>"><h3></h3></div>
		<!-- <a href="#0"></a> -->
	</div>
	<div class="clear"></div>

	<div id="main-content-container">
		<div id="main-content-inner">
<?php	
if ($isEdit == 1) {  // If in edit mode, show all blocks
	echo '<div style="border:1px #fe66ee solid">'.PHP_EOL;
	$hd = new Area('Header');
	$hd->display($c);
	$cat = new Area('Categories');
	$cat->display($c);
	echo '</div>'.PHP_EOL;
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
			<div id="easysliderslideshow_140" class="easysliderslideshow styled">
				<div class="slides_container">
					<script type="text/javascript">easy_slider_current_template="styled";if (!(typeof easy_slider_slideshow_configs[easy_slider_current_template] != 'undefined')) {easy_slider_slideshow_configs[easy_slider_current_template]=new Array();}easy_slider_slideshow_configs_temp={"slideTimes":new Array()}</script>
					<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>
					<!--SLIDER START-->
					<div class="slide">
						<!--START REPLACE-->
<!--					
						<div class="header main <?php echo $pageName ?>">
							<h1>333 What did I see?</h1><h3>Touch the item you wish to identify.</h3>
						</div>
-->						




						<div class="header main <?php echo $pageName ?>">
<?php
if ($multiLang == 0){	//$multiLang = 0; English
	$plidHeader0 = Block::getByID($plidHeaderArea[0]->bID);  //Header What Did I See?
	$plidHeader0->display();
	} else {
	$plidHeader1 = Block::getByID($plidHeaderArea[1]->bID);  //Header ¿Qué vi
	$plidHeader1->display();
	}
?>
						</div>
						<ul id="paMain" class="pagination">
							<li class="pagHide"><h2 id="0"></h2></li>
							<li class="paBirds"><h2 id="1"></h2><h1>
<?php $plidCat0 = Block::getByID($plidCatArea[0]->bID); 				 //Bird
ob_start();
$plidCat0->display();
$html1 = strip_tags(ob_get_clean());
$langTitle = explode(',', $html1);
echo $langTitle[$multiLang];		// 0/1: English/Spanish

//echo $langTitle[0].'-'.$langTitle[1].'_'.$pagePathStart.'='.$pagePath;		//  /spn/earth/plant-animal-id
//blockDisp(); - LAST GOOD
?>
							</h1></li>
							<li class="pagHide"><h2 id="2"></h2>3 List of Bird Shape matches</li>
							<li class="paAnimals"><h2 id="3"></h2><h1>
<?php
$plidCat1 = Block::getByID($plidCatArea[1]->bID); 				 //Animal
ob_start();
$plidCat1->display();
$html2 = strip_tags(ob_get_clean());
$langTitle2 = explode(',', $html2);
echo $langTitle2[$multiLang];		// 0/1: English/Spanish
?>
							</h1></li>
							<li class="pagHide"><h2 id="4"></h2>5 mammals</li>
							<li class="pagHide"><h2 id="5"></h2>6 lizards</li>
							<li class="paPlants"><h2 id="6"></h2><h1>
<?php
$plidCat2 = Block::getByID($plidCatArea[2]->bID); 				 //Plant
ob_start();
$plidCat2->display();
$html3 = strip_tags(ob_get_clean());
$langTitle3 = explode(',', $html3);
echo $langTitle3[$multiLang];		// 0/1: English/Spanish
?>
							</h1></li>
						</ul>						
						<!--END REPLACE-->
					</div>
					
					<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>
					<!--SLIDER CHANGE-->
					<div class="slide">
						<!--START REPLACE slide2 Birds -->

<?php
foreach ($children as $child) {
	$childPage = Page::getByID($child, $version = 'RECENT');
	$childPageName = $childPage->getCollectionHandle();
	
	$hd = new Area('Header');
	$childHeaderArea = $hd->getAreaBlocksArray($childPage);
	$childHeaderBlock0 = Block::getByID($childHeaderArea[0]->bID);	//English Header Geese
	$childHeaderBlock1 = Block::getByID($childHeaderArea[1]->bID);	//Spanish Header Gansos	
	
//echo PHP_EOL.'<p>child: '.$child.' | childPageName: '.$childPageName.'</p>'.PHP_EOL;
/*
1 child: 177 | childPageName: birds-id
3 child: 208 | childPageName: animals-id
	child: 140 | childPageName: mammals-id
	child: 141 | childPageName: reptiles-id
6 child: 143 | childPageName: plants

*/

	// Break up output by page
	
	if ($childPageName == "birds-id"){
		echo PHP_EOL.'				<div id="main1" class="hideCont">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)
//		echo PHP_EOL.'				<div class="header selCat '.$pageName.'"><h1>Bird Shape</h1><h3>Touch the closest match of the bird you saw.</h3></div>'.PHP_EOL;
		echo PHP_EOL.'				<div class="header selCat '.$pageName.'">';


		if (count($childHeaderArea) != 0){  // IF array IS NOT empty
			if ($multiLang == 0){	//$multiLang = 0; English
				$childHeaderBlock0 ->display();
			} else {
				$childHeaderBlock1 ->display();
			}
		} else {
			echo $childPageName;
		}
		echo '</div>'.PHP_EOL;
		echo '							<ul class="birdShapesNav lvl1">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)

	// List child pages for bird shapes
		$parentPage = Page::getByID($child);  // Get page by ID $child
		$childrenLvl1 = $parentPage->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children

		$i = 1;
		foreach ($childrenLvl1 as $childLvl1) {

			$childLvl1Page = Page::getByID($childLvl1, $version = 'RECENT');	// 178 Duck-like Birds
			$childLvl1PageName = $childLvl1Page->getCollectionName();
			$childrenLvl2 = $childLvl1Page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
			
			$childLvlhd = new Area('Header');
			$childLvl1Area = $childLvlhd->getAreaBlocksArray($childLvl1Page);
			$childLvl1Block0 = Block::getByID($childLvl1Area[0]->bID);	//English Header Geese
			$childLvl1Block2 = Block::getByID($childLvl1Area[2]->bID);	//Spanish Header Gansos

			if (count($childrenLvl2) != 0){  // IF array IS NOT empty and HAS children
				echo '<li id="cat'.$childLvl1.'" class="'.$childLvl1PageName.'"><div id="i'.$childLvl1.'" class="'.$pageName.'"></div><h4>';
				
		if (count($childLvl1Area) != 0){  // IF array IS NOT empty
		ob_start();
			if ($multiLang == 0){	//$multiLang = 0; English
				$childLvl1Block0 ->display();
			} else {
				$childLvl1Block2 ->display();
			}
		$html0 = strip_tags(ob_get_clean());
		echo $html0;
			
		} else {
			echo $childLvl1PageName;
		}
				echo '</h4></li>'.PHP_EOL;
				
			} else {  // Output lvl1 items
				echo '<li id="'.$childLvl1.'" class="'.$childLvl1PageName.'"><div id="i'.$childLvl1.'" class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></li>'.PHP_EOL;
			}  // END if (count(childrenLvl2) != 0
			$i++;
			// if page has childern push to array
		}  // END foreach ($subChildren as $subChild)
	echo '							</ul><!-- END birdShapesNav lvl1 -->'.PHP_EOL;
	echo '				</div><!-- END main1 -->'.PHP_EOL;
	}  // END $childPageName == "birds-id"
	
	
	if ($childPageName == "animals-id"){
		echo PHP_EOL.'				<div id="main3" class="hideCont">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)
//		echo PHP_EOL.'				<div class="header selCat '.$pageName.'"><h1>Animal Type</h1><h3>Touch the closest match of the animal you saw.</h3></div>'.PHP_EOL;
		echo PHP_EOL.'				<div class="header selCat '.$pageName.'">';
		if (count($childHeaderArea) != 0){  // IF array IS NOT empty
			if ($multiLang == 0){	//$multiLang = 0; English
				$childHeaderBlock0 ->display();
			} else {
				$childHeaderBlock1 ->display();
			}
		} else {
			echo '<h1>'.$childPageName.'</h1>';
		}
		echo '</div>'.PHP_EOL;
		echo '							<ul class="birdShapesNav lvl1">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)

		$parentPage = Page::getByID($child);  // Get page by ID $child
	
//		$subChildren = $parentPage->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
		$childrenLvl1 = $parentPage->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
//print_r($childrenLvl1);
		$i = 1;
		foreach ($childrenLvl1 as $childLvl1) {
			$childLvl1Page = Page::getByID($childLvl1);
			$childLvl1PageName = $childLvl1Page->getCollectionName();
			
			$childrenLvl2 = $childLvl1Page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
			
			if (count($childrenLvl2) != 0){  // IF array IS NOT empty and HAS children
				echo '<li id="cat'.$childLvl1.'" class="'.$childLvl1PageName.'"><div id="i'.$childLvl1.'" class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></li>'.PHP_EOL;
			} else {  // Output lvl1 items
				echo '<li id="'.$childLvl1.'" class="'.$childLvl1PageName.'"><div id="i'.$childLvl1.'" class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></li>'.PHP_EOL;
			}  // END if (count(childrenLvl2) != 0
			
//			echo PHP_EOL.'<p>subChild: '.$subChild.' | subChildPageName: '.$subChildPageName.'</p>'.PHP_EOL;
//			echo '<li><a href="#'.$i.'"><div class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></a></li>'.PHP_EOL;
//			echo '<li><a href="'.$childLvl1.'"><div class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></a></li>'.PHP_EOL;
			$i++;
			// if page has childern push to array
		}  // END foreach ($subChildren as $subChild)
	echo '							</ul><!-- END birdShapesNav lvl1 -->'.PHP_EOL;
	echo '				</div><!-- END main3 -->'.PHP_EOL;
	}  // END $childPageName == "animals-id"
	
	
	if ($childPageName == "plants"){
		echo PHP_EOL.'				<div id="main6" class="hideCont">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)
//		echo PHP_EOL.'				<div class="header selCat '.$pageName.'"><h1>Plant Shape</h1><h3>Touch the closest match of the plant you saw.</h3></div>'.PHP_EOL;
		echo PHP_EOL.'				<div class="header selCat '.$pageName.'">';
		if (count($childHeaderArea) != 0){  // IF array IS NOT empty
			if ($multiLang == 0){	//$multiLang = 0; English
				$childHeaderBlock0 ->display();
			} else {
				$childHeaderBlock1 ->display();
			}
		} else {
			echo '<h1>'.$childPageName.'</h1>';
		}
//		$plidHeader6 = Block::getByID($plidHeaderArea[6]->bID);
//		$plidHeader6->display();
		
		echo '</div>'.PHP_EOL;
		echo '							<ul class="birdShapesNav lvl1">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)

		$parentPage = Page::getByID($child);  // Get page by ID $child
	
//		$subChildren = $parentPage->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
		$childrenLvl1 = $parentPage->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
//print_r($childrenLvl1);
		$i = 1;
		foreach ($childrenLvl1 as $childLvl1) {
			$childLvl1Page = Page::getByID($childLvl1);
			$childLvl1PageName = $childLvl1Page->getCollectionName();
			
			$childrenLvl2 = $childLvl1Page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
			
			if (count($childrenLvl2) != 0){  // IF array IS NOT empty and HAS children
				echo '<li id="cat'.$childLvl1.'" class="'.$childLvl1PageName.'"><div id="i'.$childLvl1.'" class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></li>'.PHP_EOL;
			} else {  // Output lvl1 items
				echo '<li id="'.$childLvl1.'" class="'.$childLvl1PageName.'"><div id="i'.$childLvl1.'" class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></li>'.PHP_EOL;
			}  // END if (count(childrenLvl2) != 0
			
//			echo PHP_EOL.'<p>subChild: '.$subChild.' | subChildPageName: '.$subChildPageName.'</p>'.PHP_EOL;
//			echo '<li><a href="#'.$i.'"><div class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></a></li>'.PHP_EOL;
//			echo '<li><a href="'.$childLvl1.'"><div class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></a></li>'.PHP_EOL;
			$i++;
			// if page has childern push to array
		}  // END foreach ($subChildren as $subChild)
	echo '							</ul><!-- END birdShapesNav lvl1 -->'.PHP_EOL;
	echo '				</div><!-- END main6 -->'.PHP_EOL;
	}  // END $childPageName == "plants"
	
	
	
	
}  // END foreach ($children as $child)
?>
						</ul><!-- END birdShapesNav -->
<!--						
						<div class="footer <?php echo $pageName ?>">
							<a href="#0"></a>
						</div>
-->						
						<!--END REPLACE-->
					</div>




					<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>
					<!--SLIDER CHANGE-->
					<div class="slide">
						<!--START REPLACE slide3 Birds / shapes: Duck-like |  -->
<?php
//TESTING
//echo PHP_EOL.'<p>loop slide3</p>'.PHP_EOL;
/*
echo '<p>childrenLvl1:<br>'.PHP_EOL;
print_r($childrenLvl1);
echo '</p>'.PHP_EOL;
*/

foreach ($children as $child) {
	$childPage = Page::getByID($child);
	$parentPage = Page::getByID($child);
	$childrenLvl1 = $parentPage->getCollectionChildrenArray($intOneLevel = 1);

// Test item in array for children
	foreach ($childrenLvl1 as $childLvl1) {
		$childLvl1Page = Page::getByID($childLvl1);  // Get page by ID $child
		$childLvl1Name = $childLvl1Page->getCollectionName();
		$childrenLvl2 = $childLvl1Page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
		$chdLvl1parentPage = Page::getByID($childLvl1);  // Get page by ID $child
		$chdLvl1parentPageName = $parentPage->getCollectionHandle();
//TESTING
//echo PHP_EOL.'<p>childLvl1Name:'.$childLvl1Name.'</p>'.PHP_EOL;
	
		if (count($childrenLvl2) != 0){  // IF array IS NOT empty
			echo PHP_EOL.'				<div id="sub'.$childLvl1.'" class="hideCont">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)

		
//  //  //  //  //  //  //  //  //  //  //  //  //  //  //
//LVL2 Language
// $pageName = earth
// $childLvl1Name = Duck-like Birds

/*
$pageCont = Page::getByID(137, $version = 'RECENT');
$hd = new Area('Header');
$plidHeaderArea = $hd->getAreaBlocksArray($pageCont);
$plidHeader0 = Block::getByID($plidHeaderArea[0]->bID);  //Header
$plidHeader0->display();

$childLvl1Area[0] = Duck-like Birds
$childLvl1Area[1] = Touch the closest match of the bird you saw.
$childLvl1Area[2] = Las aves como pato
$childLvl1Area[3] = Toca el valor más cercano del ave que viste.
*/


$childLvl1Cont = Page::getByID($childLvl1, $version = 'RECENT');	//  sub-178 Get shape page (shrub,herb ...) 
$childLvl1Main = new Area('Main');
$childLvl1Area = $childLvl1Main->getAreaBlocksArray($childLvl1Cont);	//Get all blocks in area Main on Duck-like Birds 
$childLvl1Block0 = Block::getByID($childLvl1Area[0]->bID);
$childLvl1Block1 = Block::getByID($childLvl1Area[1]->bID);
$childLvl1Block2 = Block::getByID($childLvl1Area[2]->bID);	//Spanish title
$childLvl1Block3 = Block::getByID($childLvl1Area[3]->bID);	//Spanish desc text

				echo PHP_EOL.'				<div class="header selCat '.$pageName.'"><h1>';
				if (count($childLvl1Area) != 0){  // IF array IS NOT empty
					ob_start();
					if ($multiLang == 0){	//$multiLang = 0; English
						$childLvl1Block0 ->display();
					} else {
						$childLvl1Block2 ->display();
					}
					$html0 = strip_tags(ob_get_clean());
					echo $html0;
				} else {
					echo $childLvl1Name;
				}
				echo '</h1><h3>';
				if (count($childLvl1Area) != 0){  // IF array IS NOT empty
					ob_start();
					if ($multiLang == 0){	//$multiLang = 0; English
						$childLvl1Block1 ->display();
					} else {
						$childLvl1Block3 ->display();
					}
					$html1 = strip_tags(ob_get_clean());
					echo $html1;
				} else {
					if ($chdLvl1parentPageName == "birds-id"){
						$matchWord = "bird";
					} else {
						$matchWord = "plant";
					}
					echo 'TEST Touch the closest match of the '.$matchWord.' you saw.';
				}

				echo '</h3></div>'.PHP_EOL;
	
			echo '					<ul class="birdShapesNav lvl2">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)
		
			foreach ($childrenLvl2 as $childLvl2) {
				$childLvl2Page = Page::getByID($childLvl2, $version = 'RECENT');
				$childLvl2Name = $childLvl2Page->getCollectionName();
				$strDesc = $childLvl2Page->getCollectionDescription();  // Gets page meta description field text
				$hd = new Area('Header');
				$headerArea = $hd->getAreaBlocksArray($childLvl2Page);
				
				$headerBlock0 = Block::getByID($headerArea[0]->bID);	//English Header Geese
				$headerBlock1 = Block::getByID($headerArea[1]->bID);	//Spanish Header Gansos
				$headerBlock2 = Block::getByID($headerArea[2]->bID);	//English description
				$headerBlock3 = Block::getByID($headerArea[3]->bID);	//Spanish description
				
				echo '						<li id="#'.$childLvl2.'" class="'.$childLvl2Name.'"><div id="i'.$childLvl2.'" class="'.$pageName.'"></div><h4>';
				if (!empty($headerBlock0)){	//English 1st item in array
					ob_start();
					if ($multiLang == 0){	//$multiLang = 0; English
						$headerBlock0 ->display();
					} else {
						$headerBlock1 ->display();
					}
					$html0 = strip_tags(ob_get_clean());
					echo $html0;
				} else {
					echo $childLvl2Name;
				}
				echo '</h4><h5>';
				if (!empty($headerBlock2)){	//English 1st item in array
					ob_start();
					if ($multiLang == 0){	//$multiLang = 0; English
						$headerBlock2 ->display();
					} else {
						$headerBlock3 ->display();
					}
					$html1 = strip_tags(ob_get_clean());
					echo $html1;
				} else {
					echo $strDesc;
				}
				echo '</h5></li>'.PHP_EOL;  // List of bird shape 2nd Level categories




/* ORIG
			foreach ($childrenLvl2 as $childLvl2) {
				$childLvl2Page = Page::getByID($childLvl2, $version = 'RECENT');
				$childLvl2Name = $childLvl2Page->getCollectionName();
				$strDesc = $childLvl2Page->getCollectionDescription();  // Gets page meta description field text
				
				echo '						<li id="#'.$childLvl2.'" class="'.$childLvl2Name.'"><div id="i'.$childLvl2.'" class="'.$pageName.'"></div><h4>'.$childLvl2Name.'</h4><h5>'.$strDesc.'</h5></li>'.PHP_EOL;  // List of bird shape 2nd Level categories
*/


			}  // END foreach ($childrenLvl2 as $childLvl2)
			
		echo '					</ul><!-- END birdShapesNav -->'.PHP_EOL;
		echo '					</div><!-- END sub'.$childLvl1.' -->'.PHP_EOL;
		
		} // END if (count(childrenLvl2) != 0)
	} // END foreach $childrenLvl1 as childLvl1)
		
/*		NOT NEEDED if NO sub category go to 4th slide #3 and ajax load
		else {  // Output lvl1 items
			//foreach ($childrenLvl2 as $childLvl2) {
			foreach ($childrenLvl1 as $childLvl1) {
//echo '<p>NO lvl2 childLvl1: '.$childLvl1.'</p>'.PHP_EOL;
				$childLvl1Page = Page::getByID($childLvl1, $version = 'RECENT');
				$a = new Area('Main');
				$blocks = $a->getAreaBlocksArray($childLvl1Page);
			
				
			}  // END foreach ($childrenLvl1 as $childLvl1)
		}  // END if (count($childrenLvl2) != 0)
		
//		echo '				</div><!-- END subXX'.$childLvl1.' -->'.PHP_EOL;
		
	} // END foreach $childrenLvl1 as childLvl1)
*/
} // END foreach (children as child)	

?>
<!--					
						<div class="footer <?php echo $pageName ?>">
							<a href="#1"></a>
						</div>
-->						
						<!--END REPLACE-->
					</div>
					
					
					
					<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>
					<!--SLIDER CHANGE-->
					<div class="slide">
						<!--START REPLACE slide4 Birds / Duck-like / Geese | Dabbling Ducks -->
						<div id="loadCont">ajax</div>
<?php

echo '<p>pagePath: '.$pagePath.'</p>'.PHP_EOL;  // Testing  pagePath: /spn/earth/plant-animal-id

foreach ($childrenLvl1 as $childLvl1) {
// TESTING
//$pageID = $childLvl1->getCollectionID();
//echo '<p>pageID: '.$childLvl1.'</p>'.PHP_EOL;  // <p>pageID: 178</p>  connect page ID with div id="shape$i" for link and category output

	$childLvl1Page = Page::getByID($childLvl1);  // Get page by ID $child
	$childrenLvl2 = $childLvl1Page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
	foreach ($childrenLvl2 as $childLvl2) {
		$childLvl2Page = Page::getByID($childLvl2, $version = 'RECENT');
		$a = new Area('Main');
		$blocks = $a->getAreaBlocksArray($childLvl2Page);

// DO NOT output blocks, load URL via AJAX
/*
		//Simply display blocks with wrapper divs
		foreach ($blocks as $b) {
//echo '<p>blocks main</p>'.PHP_EOL;
			$b->display();
		}
*/

	}  // END foreach ($childrenLvl2 as $childLvl2)
} // END foreach ($childrenLvl1 as $childLvl1)

?>
<!--
						<div class="footer <?php echo $pageName ?>">
							<a href="#1"></a>
						</div>
-->						
						<!--END REPLACE slide4 Birds / Duck-like / Geese | Dabbling Ducks -->
					</div>
					


					
					<script type="text/javascript">easy_slider_slideshow_configs[easy_slider_current_template].push({ "showControls":0, "showPagination":0, "autostart":0, "hoverPause":0, "slideTime":0, "slideTimes":easy_slider_slideshow_configs_temp["slideTimes"]});</script>
				</div><!-- END slides_container -->
			</div><!-- END easysliderslideshow_140 -->


<?php			
}  // END  else {} NOT edit mode output slides
?>
			
		</div><!-- END main-content-inner -->
	</div><!-- END main-content-container -->
</div><!-- END main container -->

<!-- FOOTER START main-bkg -->
<div id="main-bkg" class="sea_bkg" style="background:url(<?php echo $theFilePath ?>) 0 0 no-repeat;">
	<div id="main-bkg-outer">
		<div id="main-bkg-inner" class="fullScreen"></div>
	</div>
</div><!-- END main-bkg -->
<?php   Loader::element('footer_required'); ?>
<?php  $this->inc('elements/analytics.php'); ?>
</body>
</html>