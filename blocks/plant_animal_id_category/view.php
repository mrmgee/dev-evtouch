<?php  defined('C5_EXECUTE') or die("Access Denied.");
global $c;
global $u;
$page = Page::getCurrentPage();
$pageID = $page->getCollectionID();

$parent = Page::getByID($c->getCollectionParentID());
$catName = $parent->getCollectionHandle();

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

	if ($field_1_select_value == 1) $SelAppType="Bird";
	if ($field_1_select_value == 2) $SelAppType="Mammal";
	if ($field_1_select_value == 3) $SelAppType="Reptile";
	if ($field_1_select_value == 4) $SelAppType="Plant";

	echo '<!-- Type '.$SelAppType.' -->'.PHP_EOL;

 if ($isEdit != 1) {		// If page is NOT in EDIT mode, display:none on shape id wrapper div, otherviews disable so it can be edited
	$shapeDivClass = "paIDresPage";
} else {
	$shapeDivClass = "paIDresPageEdit";
	}

	if ($field_2_select_value == 185) $SelAppCategory="Chicken-like Marsh Birds";
	if ($field_2_select_value == 2) $SelAppCategory="Duck-like Birds";
	if ($field_2_select_value == 3) $SelAppCategory="Gull-like Birds";
	if ($field_2_select_value == 4) $SelAppCategory="Hawk-like Birds";
	if ($field_2_select_value == 5) $SelAppCategory="Hummingbirds";
	if ($field_2_select_value == 6) $SelAppCategory="Long-legged Waders Birds";
	if ($field_2_select_value == 7) $SelAppCategory="Owls";
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
	
	if ($field_2_select_value == 209) $SelAppCategory="Shrub";
	if ($field_2_select_value == 210) $SelAppCategory="Herb";
	if ($field_2_select_value == 211) $SelAppCategory="Grass";
	if ($field_2_select_value == 212) $SelAppCategory="Algae";
	if ($field_2_select_value == 213) $SelAppCategory="Sedge";
	if ($field_2_select_value == 214) $SelAppCategory="Parasite";
	if ($field_2_select_value == 215) $SelAppCategory="Succulent";
	if ($field_2_select_value == 216) $SelAppCategory="Tree";
	
	if ($field_3_select_value == 179) $SelAppSubCategory="Geese";
	if ($field_3_select_value == 192) $SelAppSubCategory="Dabbling Ducks";
	if ($field_3_select_value == 193) $SelAppSubCategory="Diving Ducks";
	if ($field_3_select_value == 194) $SelAppSubCategory="Grebes";
	if ($field_3_select_value == 195) $SelAppSubCategory="Pelican";
	
	if ($field_3_select_value == 196) $SelAppSubCategory="Stilts / Avocets / Plovers";
	if ($field_3_select_value == 197) $SelAppSubCategory="Sandpipers / Phalaropes";
	
	if ($field_3_select_value == 198) $SelAppSubCategory="Flycatchers";
	if ($field_3_select_value == 199) $SelAppSubCategory="Crows / Ravens / Jays";
	if ($field_3_select_value == 200) $SelAppSubCategory="Wrens / Bushtits";
	if ($field_3_select_value == 201) $SelAppSubCategory="Medium Thrush-like Families";
	if ($field_3_select_value == 202) $SelAppSubCategory="Warblers";
	if ($field_3_select_value == 203) $SelAppSubCategory="Sparrows / Towhees / Grosbeaks";
	if ($field_3_select_value == 204) $SelAppSubCategory="Blackbirds / Orioles";
	if ($field_3_select_value == 205) $SelAppSubCategory="Finches";

if ($field_2_select_value != 0) { // shape NOT 0 => Close group
	if ($field_3_select_value != 0) {  // Value in group SubCategory
		if ($isEdit != 1) {
		//	echo '<div id="shape'.$field_3_select_value.'" class="'.$shapeDivClass.'">'.PHP_EOL.'<div class="header selCatLvl2"><h3>'.$SelAppSubCategory.'</h3></div>'.PHP_EOL //Old used dropdown select for category
			echo '<div id="shape'.$pageID.'" class="'.$shapeDivClass.'">'.PHP_EOL.'<div class="header selCatLvl2"><h3>'.$SelAppSubCategory.'</h3></div>'.PHP_EOL;
			echo '<ul>'.PHP_EOL;
		} else {
			echo '<div id="shape'.$field_3_select_value.'" class="'.$shapeDivClass.'"><div class="header selCat catEdit"><h3>'.$SelAppSubCategory.'</h3></div></div>';
			
		}  // END if ($isEdit != 1)
			
	} else {
	
		if ($isEdit != 1) {
		//	echo '<div id="shape'.$field_2_select_value.'" class="'.$shapeDivClass.'"><div class="header selCatLvl1"><h3>'.$SelAppCategory.'</h3></div>'.PHP_EOL; //Old used dropdown select for category
			echo '<div id="shape'.$pageID.'" class="'.$shapeDivClass.'"><div class="header selCatLvl1"><h3>'.$SelAppCategory.'</h3></div>'.PHP_EOL;
			echo '<ul>'.PHP_EOL;
		} else {
			echo '<div id="shape'.$field_2_select_value.'" class="'.$shapeDivClass.'"><div class="header selCat catEdit"><h3>'.$SelAppCategory.'</h3></div></div>';
		}  // END if ($isEdit != 1)
		
	}  // END if ($field_3_select_value != 0)


} else {  // $field_2_select_value == 0 group foot close
	if ($isEdit == 1) {
echo '<p>PLZ DELETE - End Group</p>';
	}
}
/*

	if ($isEdit != 1) {
		echo '<div class="clear"></div>'.PHP_EOL.'</ul>'.PHP_EOL.'<div class="hideCont"><div class="itemInfoNavCont"></div></div>'.PHP_EOL.'</div><!-- End Shape Category -->'.PHP_EOL;
	} else {
		echo '<p>End Group - Closed container</p>';
	}
*/
?>