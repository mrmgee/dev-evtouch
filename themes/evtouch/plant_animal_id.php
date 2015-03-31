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

$parent = Page::getByID($c->getCollectionParentID());
$pageName = $parent->getCollectionHandle();

$children = $page->getCollectionChildrenArray($intOneLevel = 1);  // Get first-level children of $page object and put in array $children

/*
<p>childPageName list</p>
Array
(
    [0] => 140
    [1] => 141
    [2] => 143
    [3] => 177
    [4] => 178
    [5] => 179
)

<p>childPageName: mammals-id</p>

<p>childPageName: reptiles-id</p>

<p>childPageName: plants</p>

<p>childPageName: birds-id</p>

<p>childPageName: duck-like</p>

<p>childPageName: geese</p>
*/


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

//echo PHP_EOL.'<p>childPageName list</p>'.PHP_EOL;  // Testing
//print_r($children);  // Testing
foreach ($children as $child) {
	$childPage = Page::getByID($child);
	$childPageName = $childPage->getCollectionHandle();
//	echo PHP_EOL.'<p>childPageName: '.$childPageName.'</p>'.PHP_EOL;  // Testing
}
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

<script type="text/javascript">
$(document).ready(function() {

// find all shapeID (1,2,3 ... ALL)
	var count = $('div[id^="shape"]').length;  // get divs the BEGIN WITH "shape" results in 5: shape1, shape2, shape3, shape15, shape16
//alert('count: '+count);

	var shapeDivs = [];
	$('div[id^="shape"]').each(function(){ shapeDivs.push(this.id); }); // get divs the BEGIN WITH "shape" add to array shapeDivs
//alert('shapeDivs arr: '+shapeDivs);
		//01 shapeDivs arr: shape179,shape192,shape193,shape15
	
	
	for(var i = 0; i < shapeDivs.length; i++){  // Begin loop for number of items in array shapeDivs
		var cbShapeDiv = "#"+shapeDivs[i];
//		var cbSelDiv = cbShapeDiv+" ul li."+shapeDivs[i]+"gr";  // colorbox selector #shape1 ul li.shape1gr
		var cbSelDiv = cbShapeDiv+" ul li";  // colorbox selector #shape1 ul li.shape1gr
		var cbGroup = shapeDivs[i]+"gr";  // colorbox group shape1gr
		var cbThGroup = "";
//alert('cbSelDiv: '+cbSelDiv+' | cbGroup:'+cbGroup);
		//01 cbSelDiv: #shape179 ul li.shape179gr | cbGroup:shape179gr
		//02 cbSelDiv: #shape179 ul li.shape179gr | cbGroup:shape179gr
		//03 cbSelDiv: #shape179 ul li | cbGroup:shape179gr

		var shapeNavTar = "";
//alert('1 shapeNav: '+shapeNav);  // Loops thru and stops at #shape16 div.itemInfoNavCont NOT current div clicked

		$(cbSelDiv).colorbox({
			inline:true,
			rel:cbGroup,
			
			onOpen:function(){  // Add #shape1 div.itemInfoNavCont (thumb nav) to colorbox
				$('.itemInfoNavCont img').removeClass('thSel');  // remove any selected class
			
				var thisClId = $(this).attr("id"); // returns item130
				var numberSub = thisClId.substr(4); // removes first 4 chars(item130) returns 130
				var numberTh = ".itemInfoNavCont #th"+numberSub;  // creates #th130
//alert('ON numberTh: '+numberTh);	//02 ON numberTh: .itemInfoNavCont #th163  -  correct
	
				$(numberTh).addClass('thSel'); // adds class thSel to #th130
			
				var thisCl = $(this).attr("class");  // shape1gr cboxElement
				var numberThSl = thisCl.substr(0, thisCl.length-14); // removes last 14 chars(gr cboxElement) returns shape1
				var shapeNav = "#"+numberThSl+" div.itemInfoNavCont";  // creates #shape1 div.itemInfoNavCont
alert('shapeNav: '+shapeNav);
		//01 shapeNav: #shape163 div.itemInfoNavCont
		//02 shapeNav: #shape163 div.itemInfoNavCont
		//03 shapeNav: #shape138 div.itemInfoNavCont
		
				$(shapeNavTar).append($(shapeNav));  // Append #item130Info with #shape1 div.itemInfoNavCont (thumb nav)
				

				
			},	// END onOpen  results in #item130Info with #shape16 div.itemInfoNavCont
			
			href:function(){
				var number = $(this).attr("id"); // returns item130
				var numDiv = "#"+number+"Info"; // creates #item130Info
				shapeNavTar = numDiv;
				return numDiv;
			},
			
			onLoad:function(){
				$('div.itemInfoNavCont img').colorbox({
					inline:true,
					rel:function(){  // get group shape1gr
						var navParId = $(this).parent().attr("id"); // returns shape1gr
//alert('navParId: '+navParId);
						return navParId;
					},
					
					onLoad:function(){  // Add #shape1 div.itemInfoNavCont (thumb nav) to colorbox
						$('.itemInfoNavCont img').removeClass('thSel');  // remove any selected class
						var numberTh2 = $(this).attr("id"); // returns th130
						
						$(this).addClass('thSel'); // adds class thSel to #th130
						
						var numberThSl2 = numberTh2.substr(2); // removes first 2 chars returns 130
						var numDiv2 = "#item"+numberThSl2+"Info"; // creates #item130Info
						var navParId2 = $(this).parent().attr("id"); // returns shape1gr
						var navContId = "#"+navParId2;
//alert('numDiv2: '+numDiv2 +' | navContId: '+navContId);
						$(numDiv2).append($(navContId));  // Append #item130Info with #shape1 div.itemInfoNavCont (thumb nav)				
					},	// END onOpen  results in #item130Info with #shape16 div.itemInfoNavCont
					
					href:function(){
						var numberTh = $(this).attr("id"); // returns th130
						var numberThSl = numberTh.substr(2); // removes first 2 chars returns 130
//						var cbThGroup = shapeDivs[i]+"gr"
						var numThDiv = "#item"+numberThSl+"Info"; // creates #item130Info
//alert('numThDiv: '+numThDiv);				
						return numThDiv;
					}
					
				}); // END thumb colorbox
			} // END onLoad
			
		}); // END colorbox
		
		

		

		
		
		var imgThArr = [];  // img src array
		var imgThIDArr = [];  // img id array
		findThImgId = shapeDivs[i];
		findThImg = "#"+findThImgId;
		$(findThImg+' img[class^="itemInfoNav"]').each(function(){ imgThArr.push(this.src); }); // get image src with class itemInfoNav
		$(findThImg+' img[class^="itemInfoNav"]').each(function(){ imgThIDArr.push(this.id); }); // get image id with class itemInfoNav
			
		for(var j = 0; j < imgThArr.length; j++){  // Loop thru imgThArr array and add image to div.itemInfoNavCont
			var curImgTh = imgThArr[j]; // current img src
			var curImgIDTh = imgThIDArr[j]; // current img id
			var curImgThSrc = "<img id="+curImgIDTh+" src="+curImgTh+" width='50px' />";
			var shapeItemNav = findThImg+" div.itemInfoNavCont";  // creates #shape1 div.itemInfoNavCont
			var navShapeId = findThImgId+"gr"; // creates shape1gr
//alert('shapeItemNav: '+shapeItemNav);			
			$(shapeItemNav).attr('id', navShapeId); // add id shape1gr to div.itemInfoNavCont
			
			$(shapeItemNav).append(curImgThSrc);
			shapeNav = shapeItemNav;
//	alert('shapeItemNav:'+shapeItemNav+' | imgThArr arr'+i+': '+curImgTh+'');
		} // END imgThArr for loop
		

	} // END shapeDivs for loop
}); // END document.ready
</script>


<!--START main container -->
<div id="main-container">
	<div class="nHome <?php echo $pageName ?>"><a href="/<?php echo $pageName ?>"><span>pageName: <?php echo $pageName ?></span></a></div>
	<div class="clear"></div>

	<div id="main-content-container">
		<div id="main-content-inner">
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
					<div class="slideFirst">
						<!--START REPLACE-->
						<div class="header main <?php echo $pageName ?>">
							<h1>What did I see?</h1><h3>Touch the item you wish to identify.</h3>
						</div>
						<ul class="pagination">
							<li class="pagHide"><a href="#0">1</a></li>
							<li class="<?php echo $pageName ?>"><a href="#1">1 Bird shapes</a></li>
							<li class="pagHide"><a href="#2">3 List of Bird Shape matches</a></li>
							<li class="<?php echo $pageName ?>"><a href="#3">3 Animals</a></li>
							<li class="pagHide"><a href="#4">5 mammals</a></li>
							<li class="pagHide"><a href="#5">6 lizards</a></li>
							<li class="<?php echo $pageName ?>"><a href="#6">7 Plants</a></li>
<!--						<li class="sea"><a href="#7">8 DONE</a></li> -->
						</ul>
						
						<!--END REPLACE-->
					</div>
					<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>
					<!--SLIDER CHANGE-->
					<div class="slide">
						<!--START REPLACE slide2 Birds -->
						<div class="header selCat <?php echo $pageName ?>"><h1>Bird Shape</h1><h3>Touch the closest match of the bird you saw.</h3></div>
						<ul class="birdShapesNav lvl1">

<?php
foreach ($children as $child) {
	$childPage = Page::getByID($child);
	$childPageName = $childPage->getCollectionHandle();
//	echo PHP_EOL.'<p>child: '.$child.' | childPageName: '.$childPageName.'</p>'.PHP_EOL;
	
	// Break up output by page
	
	if ($childPageName == "birds-id"){
	// List child pages for bird shapes
//	echo '<ul id="birdShapesNav">'.PHP_EOL;
		$parentPage = Page::getByID($child);  // Get page by ID $child
	
//		$subChildren = $parentPage->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
		$childrenLvl1 = $parentPage->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
//print_r($childrenLvl1);
		$i = 1;
		foreach ($childrenLvl1 as $childLvl1) {
			$childLvl1Page = Page::getByID($childLvl1);
			$childLvl1PageName = $childLvl1Page->getCollectionName();
//			echo PHP_EOL.'<p>subChild: '.$subChild.' | subChildPageName: '.$subChildPageName.'</p>'.PHP_EOL;
//			echo '<li><a href="#'.$i.'"><div class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></a></li>'.PHP_EOL;
			echo '<li><a href="'.$childLvl1.'"><div class="'.$pageName.'"></div><h4>'.$childLvl1PageName.'</h4></a></li>'.PHP_EOL;
			$i++;
			// if page has childern push to array
		}  // END foreach ($subChildren as $subChild)
//	echo '</ul><!-- END birdShapesNav -->'.PHP_EOL;
	}  // END $childPageName == "birds-id"
}  // END foreach ($children as $child)
?>

						</ul><!-- END birdShapesNav -->
						<div class="footer <?php echo $pageName ?>">
							<a href="#0">Back <?php echo $pageName ?></a>
						</div>
						<!--END REPLACE-->
					</div>
					
					<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>
					<!--SLIDER CHANGE-->
					<div class="slide">
						<!--START REPLACE slide3 Birds / shapes: Duck-like |  -->
						<div class="header selCat <?php echo $pageName ?>"><h1>slide3 Bird Shape</h1><h3>Touch the closest match of the bird you saw.</h3></div>

<?php
// Test item in array for children
foreach ($childrenLvl1 as $childLvl1) {
	$childLvl1Page = Page::getByID($childLvl1);  // Get page by ID $child
	$childrenLvl2 = $childLvl1Page->getCollectionChildrenArray($intOneLevel = 1);  // Get children of $page object and put in array $children
//	if ( $childrenLvl2 != null){

	echo PHP_EOL.'				<div id="sub'.$childLvl1.'" class="hideCont">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)

	if (count($childrenLvl2) != 0){  // IF array IS NOT empty
	echo '					<ul class="birdShapesNav lvl2">'.PHP_EOL;  //Split lvl2 into ul #sub(parentID)
	
		foreach ($childrenLvl2 as $childLvl2) {
//			$childLvl2Page = Page::getByID($childLvl2);
			$childLvl2Page = Page::getByID($childLvl2, $version = 'RECENT');
			$childLvl2Name = $childLvl2Page->getCollectionName();
//			echo '<li><a href="#2"><div class="'.$pageName.'"></div><h4>'.$childLvl2Name.'</h4></a></li>'.PHP_EOL;  // List of bird shape 2nd Level categories
			echo '						<li><a href="#'.$childLvl2.'"><div class="'.$pageName.'"></div><h4>'.$childLvl2Name.'</h4></a></li>'.PHP_EOL;  // List of bird shape 2nd Level categories
		}  // END foreach ($childrenLvl2 as $childLvl2)
		
	echo '					</ul><!-- END birdShapesNav -->'.PHP_EOL;
	
	} else {  // Output lvl1 items
		//foreach ($childrenLvl2 as $childLvl2) {
		foreach ($childrenLvl1 as $childLvl1) {
echo '<p>NO lvl2 childLvl1: '.$childLvl1.'</p>'.PHP_EOL;
			$childLvl1Page = Page::getByID($childLvl1, $version = 'RECENT');
			$a = new Area('Main');
			$blocks = $a->getAreaBlocksArray($childLvl1Page);
		
			//Simply display blocks with wrapper divs
			foreach ($blocks as $b) {
				$b->display();
			}
		}  // END foreach ($childrenLvl1 as $childLvl1)
	}  // END if (count($childrenLvl2) != 0)
	
	echo '				</div><!-- END sub'.$childLvl1.' -->'.PHP_EOL;
	
} // END foreach ($childrenLvl1 as $childLvl1)
?>
						
						<div class="footer <?php echo $pageName ?>">
							<a href="#0">Back <?php echo $pageName ?></a>
						</div>
						<!--END REPLACE-->
					</div>
					
					
					
					<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>
					<!--SLIDER CHANGE-->
					<div class="slide">
						<!--START REPLACE slide4 Birds / Duck-like / Geese | Dabbling Ducks -->

<?php


//echo '<p>blocks</p>'.PHP_EOL;  // Testing
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
	
		//Simply display blocks with wrapper divs
		foreach ($blocks as $b) {
//echo '<p>blocks main</p>'.PHP_EOL;
			$b->display();
		}
	}  // END foreach ($childrenLvl2 as $childLvl2)
} // END foreach ($childrenLvl1 as $childLvl1)

?>

						<div class="footer <?php echo $pageName ?>">
							<a href="#0">Back <?php echo $pageName ?></a>
						</div>
						<!--END REPLACE slide4 Birds / Duck-like / Geese | Dabbling Ducks -->
					</div>
					
					
					

					<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push(0)</script>
					<!--SLIDER START-->
					<div class="slide">
						<!--START REPLACE-->
<!--					<h3>List of Bird Shape matches</h3> -->
						
<!-- <h4>whole table as GROUPED array</h4> -->

<?php
foreach ($children as $child) {
	$childPage = Page::getByID($child);
	$childPageName = $childPage->getCollectionHandle();
//	echo PHP_EOL.'<p>child: '.$child.' | childPageName: '.$childPageName.'</p>'.PHP_EOL;  // Testing
	
	// Break up output by page

	
	if ($childPageName == "mammals-id"){
		$childPageCont = Page::getByID($child, $version = 'RECENT');
		$a = new Area('Main');
		$blocks = $a->getAreaBlocksArray($childPageCont);
		
		//Simply display blocks with wrapper divs
		foreach ($blocks as $b) {
			$b->display();
		}
	}  // END $childPageName == "mammals-id"
	
}  // END foreach ($children as $child)


//echo 'c is: '.$c;
/* 137 Master plant ID page
$pageID = 137;
$page = Page::getByID($pageID, $version = 'RECENT');
$a = new Area('Main');
$blocks = $a->getAreaBlocksArray($page);

//Simply display blocks with wrapper divs
foreach ($blocks as $b) {
	$b->display();
}
*/

//Same as above strip_tags doesn't remove divs
//foreach ($blocks as $i => $block) {
//	$html = strip_tags($block->display());
//	echo $html;
//}

//Strip ALL tags from block only returns text
//foreach ($blocks as $i => $block) {
//      ob_start();
//      $block->display();
//     $html = strip_tags(ob_get_clean());
//      echo '<div class="div-' . $i . ($i ? '">' : ' active">') . $html . '</div>';
//  }

/* 140 Master mammals ID page
$pageIDMammals = 140;
$page = Page::getByID($pageIDMammals, $version = 'RECENT');
$a = new Area('Main');
$blocks = $a->getAreaBlocksArray($page);

//Simply display blocks with wrapper divs
foreach ($blocks as $b) {
	$b->display();
}
*/

/* 141 Master Reptiles ID page
$pageIDReptiles = 141;
$page = Page::getByID($pageIDReptiles, $version = 'RECENT');
$a = new Area('Main');
$blocks = $a->getAreaBlocksArray($page);

//Simply display blocks with wrapper divs
foreach ($blocks as $b) {
	$b->display();
}
*/
?>

						<div class="footer <?php echo $pageName ?>">
							<a href="#1">Back <?php echo $pageName ?></a>
						</div>
						<!--END REPLACE-->
					</div>

					
					<script type="text/javascript">easy_slider_slideshow_configs[easy_slider_current_template].push({ "showControls":0, "showPagination":0, "autostart":0, "hoverPause":0, "slideTime":0, "slideTimes":easy_slider_slideshow_configs_temp["slideTimes"]});</script>
				</div><!-- END slides_container -->
			</div><!-- END easysliderslideshow_140 -->

			
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

</body>
</html>