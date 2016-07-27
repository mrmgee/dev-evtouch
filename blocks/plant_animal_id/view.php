<?php  defined('C5_EXECUTE') or die("Access Denied.");
global $c;
global $u;
$imgHelper = Loader::helper('image');

$page = Page::getCurrentPage();
$pageID = $page->getCollectionID();


$parent = Page::getByID($c->getCollectionParentID());
$catName = $parent->getCollectionHandle();

$pagePath = $c->getCollectionPath();

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

//$pageID = 137;
$page = Page::getByID($pageID, $version = 'RECENT');
$a = new Area('Main');
//$b = Block::getByID($bID, $page, $a);
//$b = $block->getBlockID();
$curBl = $b->getBlockID();


if(!function_exists('createAltThumb')){
	//Creates thumbs from main images
	function createAltThumb($thFID) {
		$imgHelperTh = Loader::helper('image');
//echo '<p>thFID:'.$thFID.'</p>'; //thFID:229
		//	$thFIDStr = print_r($thFID);
		//	$imgFID = $passStr.'_fID';
//echo '<p>imgFID:'.$imgFID.'</p>';	//imgFID:$field_8_image_fID
			$imgAlt = File::getByID($thFID);
			$width = 160;
			$height = 200;
			$crop = true;
			$imgTag = $imgHelperTh->getThumbnail($imgAlt, $width, $height, $crop);
			echo '<img id="tu'.$thFID.'" src="' . $imgTag->src . '" width="' . $width . '" height="' . $imgTag->height . '" ondragstart="return false" />'.PHP_EOL;
	}
}

if ($isEdit == 1 && (empty($field_5_image))) { // If EDIT and NO image, output item info otherwise it would be invisible
echo '<li id="item'.$curBl.'"><h4 class="needCont">'.htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET).'</h4>'.PHP_EOL;
}

if (!empty($field_5_image)): // If NO image, don't output item info

	if ($pageIDEdit != 1) {
//		echo '<li id="item'.$curBl.'" class="shape'.$field_3_select_value.'gr">'.PHP_EOL;	//Depends on drop down select
		echo '<li id="item'.$curBl.'" class="shape'.$pageID.'gr">'.PHP_EOL;	//Used page Chicken-like = 185
		
//		echo '<li id="item'.$curBl.'" class="shape'.$curBl.'gr">'.PHP_EOL;	// shape##gr needs to be parent shipe number not block number
//		echo '<li id="item'.$curBl.'" class="shape'.$pageID.'gr">'.PHP_EOL;
		// adds class for colorbox group
	} elseif ($isEdit != 1) {
		echo '<li id="item'.$curBl.'">'.PHP_EOL;
	}
	echo '<div class="itemInfoBtn"><div></div></div>'.PHP_EOL;
	echo '<div id="'.htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET).'" class="itemInfoNm">';
	
	if (empty($field_7_image)) {  // IF no thumbnail image, resize/crop main image
		$imgFID = $field_5_image_fID;
		$crop = true;
	} else {
		$imgFID = $field_7_image_fID;
		$crop = false;
	}
		$img = empty($imgFID) ? null : File::getByID($imgFID);
		$width = 160;
		$height = 200;
	//	$crop = true;
		$imgTag = $imgHelper->getThumbnail($img, $width, $height, $crop);
		echo '<img id="th'.$curBl.'" class="itemInfoNav" title="'.htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET).'" src="' . $imgTag->src . '" width="' . $width . '" height="' . $imgTag->height . '" ondragstart="return false" />';
//		echo '<br>img: '.$imgFID;
//	endif;
	echo '</div>';

if (!empty($field_1_textbox_text)):
	echo '<h4>'.htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET).'</h4>'.PHP_EOL;
endif;

	//if ($c->isEditMode()) {  //If current page 137 is in Edit mode
//	if ($pageID != 137 || 140  || 141) {  //ONLY If page 137 only show title DONT show full record
	if ($pageIDEdit != 1) {  //IF page IS NOT edit page type DONT show full record
	
		if ($field_3_select_value == 1) $SelAppCategory="Chicken-like Marsh";
		if ($field_3_select_value == 2) $SelAppCategory="Duck-like";
		if ($field_3_select_value == 3) $SelAppCategory="Gull-like";
		if ($field_3_select_value == 4) $SelAppCategory="Hawk-like";
		if ($field_3_select_value == 5) $SelAppCategory="Hummingbirds";
		if ($field_3_select_value == 6) $SelAppCategory="Long-legged Waders";
		if ($field_3_select_value == 7) $SelAppCategory="Owls";
		if ($field_3_select_value == 8) $SelAppCategory="Perching";
		if ($field_3_select_value == 9) $SelAppCategory="Pigeon-like";
		if ($field_3_select_value == 10) $SelAppCategory="Sandpiper-like";
		if ($field_3_select_value == 11) $SelAppCategory="Swallow-like";
		if ($field_3_select_value == 12) $SelAppCategory="Tree-clinging";
		if ($field_3_select_value == 13) $SelAppCategory="Upland Ground";
		if ($field_3_select_value == 14) $SelAppCategory="Upright-perching Water";

	echo '<div class="hideCont">'.PHP_EOL;  // START hider div

// START itemXXXinfo detail div
	echo '<div id="item'.$curBl.'Info" class="itemInfoCont">'.PHP_EOL;
	echo '<div class="itemInfoContHead '.$catName.'">'.PHP_EOL;
//	
	
	echo '<h4>'.htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET).'</h4>'.PHP_EOL;
		if (!empty($field_2_textbox_text)):
			echo '<h5>'.htmlentities($field_2_textbox_text, ENT_QUOTES, APP_CHARSET).'</h5>'.PHP_EOL;
		endif;
echo $pagePath;
		echo '</div>'.PHP_EOL;
		
	echo '<div id="imgs'.$curBl.'" class="lgImgsCont">'.PHP_EOL;
		if (!empty($field_5_image)):
			echo '<div id="lg'.$field_5_image_fID.'" class="lgImgsItem">'.PHP_EOL;
		//	echo '<img id="lg'.$field_5_image_fID.'" class="primeImg" src="'.$field_5_image->src.'" />';
			echo '<img class="primeImg" src="'.$field_5_image->src.'" ondragstart="return false" />';
			if (!empty($field_5_textbox_text)):
				echo '<div class="clear"></div><h4>'.htmlentities($field_5_textbox_text, ENT_QUOTES, APP_CHARSET).'</h4>'.PHP_EOL;	//credit
			endif;
			if (!empty($field_6_textbox_text)):
				echo '<h3>'.htmlentities($field_6_textbox_text, ENT_QUOTES, APP_CHARSET).'</h3>'.PHP_EOL;	//caption
			endif;
			echo '</div>'.PHP_EOL;
		endif;
		
		
		//Output any alt imgs
		if (!empty($field_8_image)):  //Alt photo 1
			echo '<div id="lg'.$field_8_image_fID.'" class="lgImgsItem hideCont">'.PHP_EOL;
			echo '<img src="'.$field_8_image->src.'" ondragstart="return false" />';
			if (!empty($field_8_textbox_text)):
				echo '<div class="clear"></div><h4>'.htmlentities($field_8_textbox_text, ENT_QUOTES, APP_CHARSET).'</h4>'.PHP_EOL;	//credit
			endif;
			if (!empty($field_9_textbox_text)):
				echo '<h3>'.htmlentities($field_9_textbox_text, ENT_QUOTES, APP_CHARSET).'</h3>'.PHP_EOL;	//caption
			endif;
			echo '</div>'.PHP_EOL;
		endif;
		
		if (!empty($field_10_image)):  //Alt photo 2
			echo '<div id="lg'.$field_10_image_fID.'" class="lgImgsItem hideCont">'.PHP_EOL;
			echo '<img src="'.$field_10_image->src.'" ondragstart="return false" />';
			if (!empty($field_10_textbox_text)):
				echo '<div class="clear"></div><h4>'.htmlentities($field_10_textbox_text, ENT_QUOTES, APP_CHARSET).'</h4>'.PHP_EOL;	//credit
			endif;
			if (!empty($field_11_textbox_text)):
				echo '<h3>'.htmlentities($field_11_textbox_text, ENT_QUOTES, APP_CHARSET).'</h3>'.PHP_EOL;	//caption
			endif;
			echo '</div>'.PHP_EOL;
		endif;

		
		if (!empty($field_12_image)):  //Alt photo 3
			echo '<div id="lg'.$field_12_image_fID.'" class="lgImgsItem hideCont">'.PHP_EOL;
			echo '<img src="'.$field_12_image->src.'" ondragstart="return false" />';
			if (!empty($field_12_textbox_text)):
				echo '<div class="clear"></div><h4>'.htmlentities($field_12_textbox_text, ENT_QUOTES, APP_CHARSET).'</h4>'.PHP_EOL;	//credit
			endif;
			if (!empty($field_13_textbox_text)):
				echo '<h3>'.htmlentities($field_13_textbox_text, ENT_QUOTES, APP_CHARSET).'</h3>'.PHP_EOL;
			endif;
			echo '</div>'.PHP_EOL;
		endif;
		
		
		echo '</div>'.PHP_EOL; // END div#imgs183
		
		
		echo '<div class="itemInfoContRgCol">'.PHP_EOL;
		
//		echo '<h2>'.$SelAppCategory.'</h2>'.PHP_EOL;
		
/*
		echo '<ul>Season';
		if ($mo_jan == 1) {
			echo '<li>Jan</li>';
		}
		if ($mo_feb == 1) {
			echo '<li>Feb</li>';
		}
		if ($mo_mar == 1) {
			echo '<li>Mar</li>';
		}
		if ($mo_apr == 1) {
			echo '<li>Apr</li>';
		}
		if ($mo_may == 1) {
			echo '<li>May</li>';
		}
		if ($mo_jun == 1) {
			echo '<li>Jun</li>';
		}
		if ($mo_jul == 1) {
			echo '<li>Jul</li>';
		}
		if ($mo_aug == 1) {
			echo '<li>Aug</li>';
		}
		if ($mo_sep == 1) {
			echo '<li>Sep</li>';
		}
		if ($mo_oct == 1) {
			echo '<li>Oct</li>';
		}
		if ($mo_nov == 1) {
			echo '<li>Nov</li>';
		}
		if ($mo_dec == 1) {
			echo '<li>Dec</li>';
		}
		echo '</ul>'.PHP_EOL;
*/	
		if (!empty($field_6_wysiwyg_content)):
			echo $field_6_wysiwyg_content;
		endif;
		
		//IF alt images output here
		
		if ((!empty($field_8_image)) || (!empty($field_10_image)) || (!empty($field_12_image))) {
			echo PHP_EOL.'<div id="nav'.$curBl.'" class="altThumbs">'.PHP_EOL;
			echo '<img id="tu'.$field_5_image_fID.'" class="hideCont" src="' . $imgTag->src . '" width="' . $width . '" height="' . $imgTag->height . '" ondragstart="return false" />'.PHP_EOL;
		
		//Check for thumb field_9_image if not create thumb from field_8_image
			if (!empty($field_8_image)){
				if (!empty($field_9_image)){
					echo '<img id="tu'.$field_8_image_fID.'" src="'.$field_9_image->src.'" ondragstart="return false" />';
				} else {
					createAltThumb($field_8_image_fID);
				}
			}
			
		//Check for thumb field_11_image if not create thumb from field_10_image
			if (!empty($field_10_image)){
				if (!empty($field_11_image)){
					echo '<img id="tu'.$field_10_image_fID.'" src="'.$field_11_image->src.' "ondragstart="return false" />';
				} else {
					createAltThumb($field_10_image_fID);
				}
			}
			
		//Check for thumb field_13_image if not create thumb from field_12_image
			if (!empty($field_12_image)){
				if (!empty($field_13_image)){
					echo '<img id="tu'.$field_12_image_fID.'" src="'.$field_13_image->src.'" ondragstart="return false" />';
				} else {
					createAltThumb($field_12_image_fID);
				}
			}
			
			echo PHP_EOL.'</div><!-- END altThumbs -->'.PHP_EOL;
		} // END alt img check
		
		echo '</div><!-- END itemInfoContRgCol -->'.PHP_EOL;
		

//		echo '<div style="position:absolute; bottom:10px;">'.PHP_EOL;  // START itemInfoNav detail div
//		echo '<img class="itemInfoNav" src="'.$field_5_image->src.'" />';
//		echo '</div>'.PHP_EOL;  // END itemInfoNav detail div
		
		echo '</div>'.PHP_EOL;  // END itemXXXinfo detail div
		
		echo '</div><!-- END hideCont -->'.PHP_EOL;  // END hider div
		
	} // END isEditMode
	
	
	if ($pageIDEdit != 1) {
		echo PHP_EOL.'</li><!-- END itemID -->'.PHP_EOL;
	} 

endif; // END image check
?>