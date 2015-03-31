<?php  
defined('C5_EXECUTE') or die("Access Denied.");

global $c;
global $u;

$pageName = $c->getCollectionName();
$pageTitle = $c->getCollectionName();
$pageID = $c->getCollectionID();

$parent = Page::getByID($c->getCollectionParentID());
$parentName = $parent->getCollectionHandle();

$grandParent = Page::getByID($parent->getCollectionParentID());
$grandParentID = $grandParent->getCollectionID();
$grandParentName = $grandParent->getCollectionHandle();

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

if ($isEdit != 1) {  // NOT Logged in as editor
?>
<script type="text/javascript">
$(document).ready(function() {

	$('.header').addClass(appCat);  // Add category bkg color class to page header titlebar
	$('.itemInfoContHead').addClass(appCat);
	$('.itemInfoBtn').addClass(appCat);
	$('.itemInfoContRgCol h3').addClass(appCat+'C');
	$('.itemInfoContRgCol ul li').addClass(appCat+'C');
	$('.itemInfoContRgCol ul li').wrapInner('<span class="li_content" />');

	//Toggle altThumbs thumbs and main img
	var thClickNum = '';
	var thClickArr = [];
	var thClickOrigArr = [];
	
	$('.altThumbs img').click(function(){
		thIDsrc = $(this).attr("id"); 	//returns th229
		thIDsrcSub = thIDsrc.substr(2); // removes first 2 chars(th229) returns 229
		thClickNum = thIDsrcSub; // 229

		if (thClickArr.length < 1){
			itemIdSrc = $(this).parent().attr('id'); // returns tu624 - nav803
			itemIdNum = itemIdSrc.substr(3); // removes first 3 chars(nav803) returns 803
			itemId = '#imgs'+itemIdNum;  // creates #imgs803
	
			thClickArr = $.map($(itemId+ ' .lgImgsItem'), function(n, i){	//Find all elements matching #imgs803 .lgImgsItem
				var mainImgIDSrc = n.id;	//runs 3 times 31-33
				var mainImgIDNum = mainImgIDSrc.substr(2); // removes first 2 chars(lg219) returns 219
				return mainImgIDNum
			});
		}
	
		for(var k in thClickArr){
    		if(thClickArr[k]==thClickNum){ //If clicked num is in array, get index
        		thClickArr.splice(k,1); // remove index of clicked num from array
        		break;
       		 }
		}
		
		showLgId = '#lg'+thClickNum;
		$(showLgId).show();  // show clicked large img
		$(this).hide();  // hide thumb clicked

		for(var g = 0; g < thClickArr.length; g++){  // Loop thru thClickArr array
			hideLgID = '#lg'+thClickArr[g];	//Hide previous large img
			showThID = '#tu'+thClickArr[g];	//Show next thumb
			$(hideLgID).hide();  // hide large img
			$(showThID).show();  // show thumb		
		} // END Loop thClickArr

		thClickArr.push(thIDsrcSub); // add clicked id back to array

	});	//END ('.altThumbs img').click(function

	
// Reset img/alt
	function resetItemLg(){
		for(var r = 0; r < thClickOrigArr.length; r++){  // Loop thru thClickOrigArr array
			lgID = '#lg'+thClickArr[r];
			thID = '#tu'+thClickArr[r];
			if (r == 0){	// first item show large
				$(lgID).show();  // show large img
				$(thID).hide();  // hide thumb
			} else {
				$(lgID).hide();  // hide large img
				$(thID).show();  // show thumb
			}
		} // END Loop thClickOrigArr
		//Clear item alt img click and array
		thClickNum = '';
		thClickArr = [];
	} // END function resetItemLg()


	var cbShapeDiv = $('.paIDresPage').attr("id"); // returns shape192 - Dabbling Ducks
	var cbGroup = cbShapeDiv+"gr";  // colorbox group shape1gr
	var cbThGroup = "";
	var shapeNavTar = "";
	var thSelCl = 'thSel '+appCat;

	$('.paIDresPage ul li').colorbox({
		inline:true,
		onOpen:function(){  // Add #shape1 div.itemInfoNavCont (thumb nav) to colorbox
			resetItemLg();  // Reset large img/alt

			$('.itemInfoNavCont img').removeClass(thSelCl);  // remove any selected class
		
			var thisClId = $(this).attr("id"); // returns item437
			var numberSub = thisClId.substr(4); // removes first 4 chars(item437) returns 437
			var numberTh = ".itemInfoNavCont #th"+numberSub;  // creates #th437

			$(numberTh).addClass(thSelCl); // adds class thSel to #th437
		
			var thisCl = $(this).attr("class");  // shape1gr cboxElement
			var numberThSl = thisCl.substr(0, thisCl.length-14); // removes last 14 chars(gr cboxElement) returns shape1
			var shapeNav = "#"+numberThSl+" div.itemInfoNavCont";  // creates #shape1 div.itemInfoNavCont

			$(shapeNavTar).append($(shapeNav));  // Append #item130Info with #shape1 div.itemInfoNavCont (thumb nav)
			
			//Tracking
			var track = $(this).children('.itemInfoNm').attr("id"); //Get id of child .itemInfoNm of .paIDresPage ul li = Canada Goose
			var trMsg = pageTitle+' ID : '+'<?php echo $pageTitle ?> : '+track;
			trackPass(trMsg); //Pass trMsg to function - trMsg: Sea ID / Tall Wading Birds / Lesser Yellowlegs
			
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
					return navParId;
				},
				
				onLoad:function(){  // Add #shape1 div.itemInfoNavCont (thumb nav) to colorbox
					resetItemLg();  // Reset large img/alt	

					$('.itemInfoNavCont img').removeClass(thSelCl);  // remove any selected class
					var numberTh2 = $(this).attr("id"); // returns th130

					$(this).addClass(thSelCl); // adds class category color to #th130
					
					var numberThSl2 = numberTh2.substr(2); // removes first 2 chars returns 130
					var numDiv2 = "#item"+numberThSl2+"Info"; // creates #item130Info
					var navParId2 = $(this).parent().attr("id"); // returns shape1gr
					var navContId = "#"+navParId2;
					$(numDiv2).append($(navContId));  // Append #item130Info with #shape1 div.itemInfoNavCont (thumb nav)
					
					//Tracking
					var track = $(this).attr("title"); //Get id of child .itemInfoNm of .paIDresPage ul li = Canada Goose
					var trMsg = pageTitle+' ID : '+'<?php echo $pageTitle ?> : '+track;
					trackPass(trMsg); //Pass trMsg to function - trMsg: Sea ID / Tall Wading Birds / Lesser Yellowlegs

				},	// END onOpen  results in #item130Info with #shape16 div.itemInfoNavCont
				
				href:function(){
					var numberTh = $(this).attr("id"); // returns th130
					var numberThSl = numberTh.substr(2); // removes first 2 chars returns 130
					var numThDiv = "#item"+numberThSl+"Info"; // creates #item130Info		
					return numThDiv;
				}
				
			}); // END thumb colorbox
		}, // END onLoad
		
		onClosed:function(){
			resetItemLg();  // Reset large img/alt			
		} // END onClosed

		
	}); // END main colorbox
	
	
//Add thumb imgs to itemInfoNavCont

	var imgThArr = [];  // img src array
	var imgThIDArr = [];  // img id array
	var imgThTitleArr = [];  // img title array
	findThImgId = cbShapeDiv; // shape192
	findThImg = "#"+findThImgId;  // creates #shape192
	$(findThImg+' img[class^="itemInfoNav"]').each(function(){ imgThArr.push(this.src); }); // get image src with class itemInfoNav
	$(findThImg+' img[class^="itemInfoNav"]').each(function(){ imgThIDArr.push(this.id); }); // get image id with class itemInfoNav
	$(findThImg+' img[class^="itemInfoNav"]').each(function(){ imgThTitleArr.push('"'+this.title+'"'); }); // get image ref with class itemInfoNav
	
	for(var j = 0; j < imgThArr.length; j++){  // Loop thru imgThArr array and add image to div.itemInfoNavCont
		var curImgTh = imgThArr[j]; // current img src
		var curImgIDTh = imgThIDArr[j]; // current img id
		var curImgTitleTh = imgThTitleArr[j]; // current img ref
		var curImgThSrc = "<img id="+curImgIDTh+" title="+curImgTitleTh+" src="+curImgTh+" width='50px' ondragstart='return false' />";
		var shapeItemNav = findThImg+" div.itemInfoNavCont";  // creates #shape1 div.itemInfoNavCont
		var navShapeId = findThImgId+"gr"; // creates shape1gr

		$(shapeItemNav).attr('id', navShapeId); // add id shape1gr to div.itemInfoNavCont
		
		$(shapeItemNav).append(curImgThSrc);
		shapeNav = shapeItemNav;
	} // END imgThArr for loop
	
	function trackPass(trMsg){
		if (piwikTracker) { //Piwik tracking id="card4" | ref="lagoons_high_tide"
				piwikTracker.trackPageView(trMsg); //ref="lagoons_high_tide"
		}
	}

}); // END document.ready
</script>


	<div class="paIDloadCont">

<?php
//Output page name as header
	echo '<div id="shape'.$pageID.'" class="paIDresPage">'.PHP_EOL.'<div class="header selCatLvl2"><h3>'.$pageName.'</h3></div>'.PHP_EOL;
	echo '<ul>'.PHP_EOL;

	$a = new Area('Main');
	$a->display($c);
	
	
	//Check if page name is plant color
	if (in_array($pageName, array('Brown Flower','Pink/Purple Flower','Red/Orange Flower','White/Pale Color Flower','Yellow Flower'))) {	
		$shapePageObj = Page::getByPath('/plant-animal-id/plants/habit-shape', $version = 'RECENT');	//Returns ID based on page path
		$shapePageID = $shapePageObj->getCollectionID();	//Returns 241

	//Get blocks from children (SHAPE) of parent (Plants), then check against COLOR ($pageName)
		$childrenLvl1 = $shapePageObj->getCollectionChildrenArray($intOneLevel = 1);	//Returns habit-shape children

		$ic = 1;
		foreach ($childrenLvl1 as $childLvl1) {		//loop thru children pages and output blocks that match color
			$pageCont = Page::getByID($childLvl1, $version = 'RECENT');	//Get shape page (shrub,herb ...) 
			$a = new Area('Main');
			$blocks = $a->getAreaBlocksArray($pageCont);		//Get all blocks in area Main in brown flower page 

			$gk = 1;
			foreach ($blocks as $contBl) {
				$btc = $contBl->getInstance();	//get the block's controller
				$shapeNum = $btc->field_3_select_value;	//retrieves value from the field in plant_animal_id block

				if ($shapeNum == $pageID){	// If block shapeNum (210-Herb) matches $pageID (210-Herb)		
					$contBl->display();	//Simply outputs entire view form block
				}
				
				$gk++;
			}	//END foreach (blocks as contBl)
		
		}	//END foreach(childrenLvl1 as childLvl1)
		$ic++;
	}

// Footer to close shape div
	if ($isEdit != 1) {
		echo '<div class="clear"></div>'.PHP_EOL.'</ul>'.PHP_EOL.'<div class="hideCont"><div class="itemInfoNavCont"></div></div>'.PHP_EOL.'</div><!-- End Shape Category -->'.PHP_EOL;
	} else {
		echo '<p>End Group - Closed container</p>';
	}

?>

	</div><!-- END paIDloadCont -->
	
<?php  
} else {  // YES Logged in display normal
	Loader::element('header_required');
	$this->inc('elements/header-home.php');
?>
<!-- Site Head Content //-->
<link rel="stylesheet" type="text/css" href="<?php echo DIR_REL?>/packages/easy_slider/blocks/easyslider_slideshow/templates/plant_animal_id/view.css" />

	<div class="clear"></div>

	<div id="main-content-container" class="paEdit">
		<div id="main-content-inner">
		
			<?php
			echo '<div id="shape'.$pageID.'" class="paIDresPageEdit"><div class="header selCat catEdit"><h3>'.$pageName.'</h3></div></div>';

			$a = new Area('Main');
			$a->display($c);
			?>
			
		</div>
	
	</div>
</div><!-- END main-container -->
<?php
}  // END if (isEdit != 1)
Loader::element('footer_required');
?>