<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
<head>
<?php   Loader::element('header_required');
global $c;
global $u;

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

Loader::model('file_list');
Loader::model('file_set');
$imgHelper = Loader::helper('image');
$parent = Page::getByID($c->getCollectionParentID());
$parentName = $parent->getCollectionHandle();
$pageName = $c->getCollectionHandle();
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

$multiLang = $_SESSION['firstMessage'];	//$multiLang = 0/1: English/Spanish
/*
if ($isEdit == 2) {  // If in edit mode, show all blocks
	Loader::element('header_required');
	$a = new Area('Main');
	$a->display($c);
	
//	echo '<div style="display:none">'.PHP_EOL;
}
*/

if ($isEdit == 1) {  // IF logged-in but NOT Edit don't output JS
//	$this->inc('elements/header-home.php');
?>
	<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />
</head>
<body>
<div id="main-container" >
	<div class="clear"></div>
<?php 	
	if ($c->isEditMode()) {  // If in edit mode, show all blocks
	//	echo '<h2>YES EDIT</h2>';	//Testing
		echo '<h2>Settings</h2>
		<p>year,zoom (ex. EV History: 1990,36)</p>
		<p>Midpoint year timeline starts on. Zoom level default 36; 30=month, 50=decade.</p>';
		$s = new Area('Settings');
		$s->display($c);
	
		$o = new Area('Overlay');
		$o->display($c);
		
		$statArea = new Area('Stats Label');
		$statArea->display($c);
			
		$a = new Area('Main');
		$a->display($c);
	}
	else {   // if YES Login and NO Edit show table
	//	echo '<h2>NO EDIT</h2>';	//Testing
?>
	<div class="clear"></div>

	<div id="main-content-container" class="paEdit">
		<div id="main-content-inner">
			<?php
			echo 'year,zoom:';
			$s = new Area('Settings');
			$s->display($c);
			
			echo '<h2>Overlay</h2>';
			$o = new Area('Overlay');
			$o->display($c);
			
			echo 'Stats Label';
			$statArea = new Area('Stats Label');
			$statArea->display($c);
			
			echo '<h2>Main</h2>';
			$a = new Area('Main');
			$a->display($c);
			?>
			<!-- </table> -->
		</div>
	
	</div>
</div><!-- END main-container -->

<?php
	}	//END if (c->isEditMode())

} else {	//NOT logged-in show normal
?>

<!-- Site Head Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />



<!-- Timeline Stylesheets -->
<link rel="stylesheet" href="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/css/jquery-ui-1.10.3.custom.css" type="text/css" charset="utf-8">
<link rel="stylesheet" href="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/timeglider/Timeglider.css" type="text/css" charset="utf-8">
<link rel="stylesheet" href="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/timeglider/timeglider.datepicker.css" type="text/css" charset="utf-8">

</head>
<body>
<!--start main container -->
<div id="main-container" >
	<div id="/<?php echo $parentName ?>" class="nHome lHome<?php echo $multiLang ?> <?php echo $parentName ?>"><div></div></div>
	<div class="clear"></div>

	<div id="main-content-container" class="grid_24">
		<div id="main-content-inner">
		
		<!-- Instructions overlay -->
		<div class="tg-modal full_modal" id="intro_modal" style="top:20px; left:20px; width:1745px; height:906px;">
			<div class="full_modal_scrim"></div>
			<div class="full_modal_panel <?php echo $parentName ?>">
				<div id="closeIntro" class="close-button full_modal_close">x</div>
				<h4 class="slArrL"></h4>
<!--				<h3>Slide the timeline<br>left and right to<br>view the history of<br>Environmental Volunteers</h3> -->
<?php			
				$o = new Area('Overlay');
				$o->display($c);
?>
				<h4 class="slArrR"></h4>
				<div class="clear"></div>
			</div>
		</div>

<div id="placement"></div>

<script type="text/javascript">
var tg_events_data_arr = [];
//var stat_data_obj = { year:"YYYY", stat:"1234" };
var stat_data_obj = {};
var stat_data_arr = [];
var matchDivsArr = [];

<?php	
	$a = new Area('Main');
	$a->display($c);

	$s = new Area('Settings');
	$settingsArray = $s->getAreaBlocksArray($c);
	
	if (count($settingsArray) != 0){  // IF array IS NOT empty
		$settingsBl = Block::getByID($settingsArray[0]->bID);
		ob_start();
		$settingsBl->display();
		$settingsBlClean = strip_tags(ob_get_clean());
		$settingsValArr = explode(',', $settingsBlClean);
		if(is_numeric($settingsValArr[0]) && $settingsValArr[0] >= 1000 && $number <= 9999) { //Check 4digit number for year
			$settingsValArr[0] = $settingsValArr[0];
		} else {
			$settingsValArr[0] = 1990;
		}
		if(is_numeric($settingsValArr[1]) && $settingsValArr[1] >= 1 && $number <= 99) {
			$settingsValArr[1] = $settingsValArr[1];
		} else {
			$settingsValArr[1] = 36;
		}
			
		
	} else {
		$settingsValArr = [1990,36];
	}
?>

var tg_data_source = [
{
"id":"js_history",
"title":"Environmental Volunteers History",
"description":"",
"focus_date":"<?php echo $settingsValArr[0] ?>-01-20",	//1990-01-20
"initial_zoom":"<?php echo $settingsValArr[1] ?>",	//36
"display_zoom_level":false,
//"image_lane_height":150,	//300=322 200=222 150=172
"image_lane_height":300,	//300=586h; 200=384h
//"events":[
"events": tg_events_data_arr

<?php /*
	$a = new Area('Main');
	$a->display($c);
*/ ?>

//]	//END "events":[
    }
]; // end of your data source array


//Build an JS array, then push it to constructed container div studentsNum
// if (!empty($field_6_textbox_text)) $field_6_textbox_text = '<h5 class=\"caption\">'.htmlentities($field_6_textbox_text, ENT_QUOTES, APP_CHARSET).'<\/h5>';	//Image caption

var stat_data = { year:"YYYY", stat:"1234" };

var stat_data_source = [
<?php
	$a = new Area('Main');
	$page = Page::getCurrentPage();
	$pageID = $page->getCollectionID();
	$pageCont = Page::getByID($pageID, $version = 'RECENT');
	$blocks = $a->getAreaBlocksArray($pageCont);
	$blCount = count($blocks);

/*
$childLvlhd = new Area('Header');
$childLvl1Area = $childLvlhd->getAreaBlocksArray($childLvl1Page);
$childLvl1Block0 = Block::getByID($childLvl1Area[0]->bID);	//English Header Geese
$childLvl1Block2 = Block::getByID($childLvl1Area[2]->bID);	//Spanish Header Gansos
*/

	$tm = 1;
	foreach ($blocks as $b) {
		$field_10Block = Block::getByID($blocks[0]->bID);	//$field_10_textbox_text
		if (!empty($field_10Block)) {
//			$field_10Block->display();	//Outputs ENTIRE block form view
			echo $blCount.',';
		} else {
			echo $tm.'null,';
		}
		$tm++;
	}
	echo $blCount;
?>
]; //END stat_data_source
</script>


			<div class="clear"></div>
		</div><!-- END main-content-inner -->
	</div><!-- END main-content-container -->

<!-- FOOTER START main-bkg -->
<div id="main-bkg" class="<?php echo $fsName ?>" style="background:url(<?php echo $theFilePath ?>) 0 0 no-repeat;">
	<div id="main-bkg-outer">
		<div id="main-bkg-inner" class="fullScreen"></div>
	</div>
</div><!-- END main-bkg -->

<!-- 3rd party libs -->
<script type="text/javascript" src="/concrete/js/jquery.js"></script>
<script type="text/javascript" src="/concrete/js/jquery.ui.js"></script>

<!-- FRIEND LIBS -->
<!--
<script src="<?php echo DIR_REL?>/themes/evtouch/js/underscore-min.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/backbone-min.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/jquery.global.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/jquery.tmpl.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/ba-debug.min.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/ba-tinyPubSub.js" type="text/javascript"></script>
-->
<!-- <script src="<?php echo DIR_REL?>/themes/evtouch/js/jquery.ui.ipad.js" type="text/javascript"></script> -->


<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/underscore-min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/backbone-min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/json2.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/jquery.tmpl.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/ba-tinyPubSub.js" type="text/javascript" charset="utf-8"></script>
<!-- <script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/jquery.mousewheel.js" type="text/javascript" charset="utf-8"></script> -->
<!-- <script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/jquery.ui.ipad.js" type="text/javascript" charset="utf-8"></script>  -->
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/globalize.js" type="text/javascript" charset="utf-8"></script>	
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/ba-debug.min.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/attrchange.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/js/attrchange_ext.js" type="text/javascript" charset="utf-8"></script>

	
<!-- TIMEGLIDER -->
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/timeglider/TG_Date.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/timeglider/TG_Org.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/timeglider/TG_Timeline.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/timeglider/TG_TimelineView.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/timeglider/TG_Mediator.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/timeglider/timeglider.timeline.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider_version_1.0.2/timeglider/timeglider.datepicker.js" type="text/javascript" charset="utf-8"></script>



<script type="text/javascript">
var appCat = "<?php echo $parentName ?>";

$(document).ready(function() {
//	$(checkForChanges);	//DIDN't work

	var tg1 = $("#placement").timeline({
		 "data_source":tg_data_source,
		 "min_zoom":20,
		 "max_zoom":60,
		 "display_zoom_level":false,
		//         "image_lane_height":300,
		"loaded":function () {		// loaded callback function
//TEST			alert('Test LOAD!');
			delayBuild();
		},
	});

	
//Add stats Loop thru div#stat-1988 add stat string
/*
var stat_data_obj = { year:"YYYY", stat:"1234" };
var stat_data_arr = [];
*/






function delayBuild() {	//Called in TG loaded once divs are build
	$(this).delay(1000).queue(function() {	//Forces to fire after timeline divs build
		loadStatBuild();
	}); //END $(this).delay(1000)
}; //END delayBuild
	
function loadStatBuild() {	//Finds divs and replaces stat text
		$("div[id^='stat']").each(function(){ 	// get divs the BEGIN WITH "stat-" add to array stat_divs_arr
			matchDiv = (this.id);	//stat-1988
			matchDivsArr.push(matchDiv);
	//alert('this-id: '+matchDiv);	//stat-1988

			for( var i = 0; i < stat_data_arr.length; i++ ){
				checkDate = stat_data_arr[i].year;
	//alert(i+'checkDate: '+checkDate+' EQUALS '+matchDiv);	//0checkDate: stat-1972 EQUALS stat-1990	
	//alert(i+'checkDate: '+checkDate);			
				if( checkDate === matchDiv ){
	//alert(i+'checkDate: '+checkDate+' EQUALS '+matchDiv);
					changeText = stat_data_arr[i].stat;
	//				$(this).append(changeText);
					$('#'+matchDiv).html(changeText);
					$('#'+matchDiv).addClass("sky");
	//alert('statDiv.year: '+checkDate+' statDiv.stat:'+changeText);
	//				break;
				}
			
			};
		});	//END $("div[id^='stat']").each
				$(this).dequeue();

	
	
<?php
$statArea = new Area('Stats Label');
$statArray = $statArea->getAreaBlocksArray($c);
$statBl = Block::getByID($statArray[0]->bID);

	if (!empty($statBl)) {	//Check if Stats Label is populated
		ob_start();
		$statBl->display();
		$statTxt = strip_tags(ob_get_clean());
		echo '$("#studentsLabel").html("'.$statTxt.'").addClass("sky");';
	} else {
		echo '<!-- EMPTY Stats Label -->';
	}
?>

}; //END loadStatBuild


//$( ".inner" ).append( "<p>Test</p>" );


/* DIDN'T WOORK
function checkForChanges()
{	//#tg-truck.div
//    if ($('div.timeglider-handle').hasClass('ui-draggable-dragging'))
	var leftValueLast = 0;
	var leftValue = $('div.timeglider-handle').css("left");
	if (leftValue != leftValueLast)
        alert('MOVING!!! - '+leftValue);
    else
        setTimeout(checkForChanges, 500);
}
*/


$('.timeglider-handle').attrchange({	//div.timeglider-handle  (timeglider-ticks noselect ui-draggable)
//	var leftValue = $('div.timeglider-handle').css("left");
    trackValues: true, // set to true so that the event object is updated with old & new values
    callback: function(evnt) {
    	var properties = $(this).attrchange('getProperties');
//TEST alert(properties);	//Object
    
//        if(evnt.attributeName == "left") { // which attribute you want to watch for changes
            if(evnt.newValue != evnt.oldValue) {
//TEST alert('MOVING!!! - '+evnt.newValue);
				loadStatBuild();
//            }
        }
    }
});

/* REFERENCE
Status: connected. Attribute Name: style Prev Value: null New Value: top: 50px
logMessage('Status: ' + properties.status + '. Attribute Name: ' + event.attributeName + ' Prev Value: ' + event.oldValue + ' New Value: ' + event.newValue);


var $logs = $attrchange_logger.prepend('<p>Attribute <b>' + e.attributeName +
          '</b> changed from <b>' + e.oldValue +
          '</b> to <b>' + e.newValue +
          '</b></p>')
*/

	
	
	$(".nHome").click(function(event){
		event.preventDefault();
		linkLocation = '<?php echo $homeURL ?>';
		$("#main-bkg-inner").fadeOut(500);
		$("#main-content-container").fadeOut(500, redirectPage);
	});
		 
	function redirectPage() {
		window.location = linkLocation;
	}
	
	$("#closeIntro").click(function(event){
//alert('close clicked');		
		$("#intro_modal").hide();
	});
	
});

//TEST alert('stat_data_arr: '+stat_data_arr);	
</script>

<?php } // END if ($isLogin == 0)

	if ($isEdit == 1) {
	echo '</div>'.PHP_EOL;  // END else hide
	}
Loader::element('footer_required');
?>
<?php  $this->inc('elements/analytics.php'); ?>
</body>
</html>