<?php  defined('C5_EXECUTE') or die("Access Denied.");
global $c;
$page = Page::getCurrentPage();
$pageID = $page->getCollectionID();

$parent = Page::getByID($c->getCollectionParentID());
$catName = $parent->getCollectionHandle();

if ($c->isEditMode()) {
	$isEdit = 1;
}
else {
	$isEdit = 0;
}

$editPageID = array(137,140,141,143);  // IF page is master edit page
if (in_array($pageID, $editPageID)) {
    $pageIDEdit = 1;
//	echo '<p><b>EDIT</b> plant_animal_id_category pageID: '.$pageID.' | pageIDEdit: '.$pageIDEdit.'</p>';
} else {
	$pageIDEdit = 0;
}

	if ($field_1_select_value == 1) $SelAppType="Bird";
	if ($field_1_select_value == 2) $SelAppType="Mammal";
	if ($field_1_select_value == 3) $SelAppType="Reptile";
	if ($field_1_select_value == 4) $SelAppType="Plant";

	echo '<!-- Type '.$SelAppType.' -->'.PHP_EOL;

// if ($isEdit != 1) {		// If page is NOT in EDIT mode, dispaly:none on shape id wrapper div, otherviews disable so it can be edited
if ($pageIDEdit != 1) {		// If page is NOT in EDIT mode, dispaly:none on shape id wrapper div, otherviews disable so it can be edited
	$shapeDivClass = "paIDresPage";
} else {
	$shapeDivClass = "paIDresPageEdit";
	}

	if ($field_2_select_value == 1) $SelAppCategory="Chicken-like Marsh Birds";
	if ($field_2_select_value == 2) $SelAppCategory="Duck-like Birds";
	if ($field_2_select_value == 3) $SelAppCategory="Gull-like Birds";
	if ($field_2_select_value == 4) $SelAppCategory="Hawk-like Birds";
	if ($field_2_select_value == 5) $SelAppCategory="Hummingbirds Birds";
	if ($field_2_select_value == 6) $SelAppCategory="Long-legged Waders Birds";
	if ($field_2_select_value == 7) $SelAppCategory="Owls Birds";
	if ($field_2_select_value == 8) $SelAppCategory="Perching Birds";
	if ($field_2_select_value == 9) $SelAppCategory="Pigeon-like Birds";
	if ($field_2_select_value == 10) $SelAppCategory="Sandpiper-like Birds";
	if ($field_2_select_value == 11) $SelAppCategory="Swallow-like Birds";
	if ($field_2_select_value == 12) $SelAppCategory="Tree-clinging Birds";
	if ($field_2_select_value == 13) $SelAppCategory="Upland Ground Birds";
	if ($field_2_select_value == 14) $SelAppCategory="Upright-perching Water Birds";
	if ($field_2_select_value == 15) $SelAppCategory="Mammals";
	if ($field_2_select_value == 16) $SelAppCategory="Reptiles";
	if ($field_2_select_value == 17) $SelAppCategory="Plants";

if ($field_2_select_value != 0) {
	if ($isEdit != 1) {
		echo '<div id="shape'.$field_2_select_value.'" class="'.$shapeDivClass.'"><div class="header selCat '.$catName.'"><h3>'.$SelAppCategory.'</h3></div>
<ul>'.PHP_EOL;
	} else {
		echo '<div id="shape'.$field_2_select_value.'" class="'.$shapeDivClass.'"><div class="header selCat '.$catName.'"><h3>'.$SelAppCategory.'</h3></div></div>';
	}
} else {  // $field_2_select_value == 0 group foot close
	if ($isEdit != 1) {
		echo '<div class="clear"></div></ul>'.PHP_EOL.'<div class="hideCont"><div class="itemInfoNavCont"></div></div>'.PHP_EOL.'</div><!-- End Shape Category -->'.PHP_EOL;
	} else {
		echo '<p>End Group - Closed container</p>';
	}
}
?>