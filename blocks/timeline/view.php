<?php  defined('C5_EXECUTE') or die("Access Denied.");
global $c;
global $u;
$parent = Page::getByID($c->getCollectionParentID());
$pageName = $parent->getCollectionHandle();
/* $thisPageName = $c->getCollectionHandle(); */

if (!empty($field_1_date_value)) $field_1_date_value = date('Y-m-d H-i-s', strtotime($field_1_date_value));
if (!empty($field_2_date_value)) $field_2_date_value = date('Y-m-d H-i-s', strtotime($field_2_date_value));
if (!empty($field_3_textbox_text)) $field_3_textbox_text = htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET);
if (!empty($field_4_textarea_text)) $field_4_textarea_text = nl2br(htmlentities($field_4_textarea_text, ENT_QUOTES, APP_CHARSET));

if (!empty($field_7_select_value)){
	if ($field_7_select_value == 1) $catIcon="i_time1_history.png";	//History
	if ($field_7_select_value == 2) $catIcon="i_time2_say.png";	//What People say about EV
	if ($field_7_select_value == 3) $catIcon="i_time3_subject.png";	//Subject Areas
	if ($field_7_select_value == 5) $catIcon="i_time5_gen.png";	//General Purpose
	if ($field_7_select_value == 4) $catIcon="";	//Quick Facts no icon
}

//Add credit and caption to description text
if (!empty($field_5_textbox_text)) $field_5_textbox_text = '<h5 class=\"credit\">'.htmlentities($field_5_textbox_text, ENT_QUOTES, APP_CHARSET).'<\/h5>';	//Image credit
if (!empty($field_6_textbox_text)) $field_6_textbox_text = '<h5 class=\"caption\">'.htmlentities($field_6_textbox_text, ENT_QUOTES, APP_CHARSET).'<\/h5>';	//Image caption

if (!empty($field_8_textbox_text)){
	$field_8_textbox_text = htmlentities($field_8_textbox_text, ENT_QUOTES, APP_CHARSET);
	
}

$field_4_textarea_clean = str_replace(array("\r", "\n"), '', $field_4_textarea_text);
//$field_description = $field_4_textarea_text.$field_6_textbox_text.$field_5_textbox_text;
$field_description = $field_4_textarea_clean.$field_6_textbox_text.$field_5_textbox_text;


if (!empty($field_9_image)) $field_9_image = $field_9_image->src;	//Returns img01.png original name and full path

	if ($field_7_select_value == 1) $SelImportance=72;	//History	100=33.33 | 90=30
	if ($field_7_select_value == 2) $SelImportance=72;	//What People say about EV
	if ($field_7_select_value == 3) $SelImportance=72;	//Subject Areas	70=23.33 | 72=24px font | 80=26.66
	if ($field_7_select_value == 5) $SelImportance=72;	//General Purpose
	if ($field_7_select_value == 4){
		$SelImportance=54;
	//	$field_3_textbox_text='<span class="'.$pageName.'C">'.$field_3_textbox_text.'</span>';	//Quick Facts	54=18px font	| 60=20px font
	}
//	echo $field_1_date_value
//	echo $field_9_image

//if ($c->isEditMode()) {
if ($u -> isLoggedIn ()) {
//	echo '<table>';
	echo '<div style="margin:0 0 20px 0; border-top:1px solid #000">';
	if (!empty($field_9_image)){
		echo '<img src="'.$field_9_image.'" width="100px" style="float:left; margin:0 10px 0 0;" />';
	}
	echo '<p>'.substr($field_1_date_value, 0, 4).'</p>';	//Return only 4-digit year (1972-01-01 00-00-00)
	echo '<h2>'.$field_3_textbox_text.'</h2>';
	echo '<div class="clear"></div></div>';
} else {
	if ($field_7_select_value != 4){	//DON'T output strand (category) Quick Facts/milestones
?>
tg_events_data_arr.push(
{
"id":"<?php echo $bID?>",
"title": "<?php echo $field_3_textbox_text ?>",
"description":"<?php echo $field_description ?>",
"startdate": "<?php echo $field_1_date_value ?>",
"high_threshold":50,
"importance":"72",
"date_display":"ye",
"modal_type":"full",
"image":"<?php echo $field_9_image ?>",
"icon":"<?php echo $catIcon ?>"
}
);
<?php
	}	//END if (field_7_select_value != 4)
	
	if (!empty($field_10_textbox_text)) {	//Check if Students Served is populated
	$startYear = substr($field_1_date_value, 0, 4); //first 4 chars = 1972 (1972-01-01 12:00:00)
?>

stat_data_arr.push({year:<?php echo '"stat-'.$startYear.'"' ?>, stat:"<?php echo $field_10_textbox_text ?>"});
/* JS COMMENT
{
"id":"<?php echo $bID?>stat",
"title": "<?php echo $field_10_textbox_text ?>",
"description":"",
"startdate": "<?php echo $field_1_date_value ?>",
"enddate": "<?php echo $field_2_date_value ?>",
"high_threshold":40,
"importance":"60",
"date_display":"mo",
"icon":"none"
},
*/

<?php
	}	//END if (!empty($field_10_textbox_text))
/*
if ($c->isEditMode()) {
	echo '</table>';
*/	
}	//END if (c->isEditMode())
?>