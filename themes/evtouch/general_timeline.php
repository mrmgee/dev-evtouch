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
		$a = new Area('Main');
		$a->display($c);
	}
	else {   // if YES Login and NO Edit show table
	//	echo '<h2>NO EDIT</h2>';	//Testing
?>
	<div class="clear"></div>

	<div id="main-content-container" class="paEdit">
		<div id="main-content-inner">
			<!-- <table> -->
			<?php  
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

	$a = new Area('Main');
	//Add extra blank entry (last year +1) to padd right side of timeline
	$page = Page::getCurrentPage();
	$pageID = $page->getCollectionID();
	$pageCont = Page::getByID($pageID, $version = 'RECENT');
	$blocks = $a->getAreaBlocksArray($pageCont);
	$blCount = count($blocks);

	$tm = 1;
	$yearTotal = 0;
	$medianYear = 0;
	$yrBlCt = 1;
	$firstYear = 0;
	$lastYear = 0;
	
	foreach ($blocks as $bYr) {
			$btc = $bYr->getInstance();	//get the block's controller
			$TmDate = $btc->field_1_date_value;	//retrieves Start Date field from the timeline block
			$TmDateYr = (substr($TmDate, 0, 4)+1);

		if ($yrBlCt == 1){
				$firstYear = $TmDateYr;
			} else if ($yrBlCt == $blCount){
				$lastYear = $TmDateYr;
			}
			$medianYear = round(($firstYear+$lastYear)/2); //Calculate median year for focus
			$yrBlCt++;
	}
//echo '<div>'.$yrBlCt.'/'.$blCount.'<br>firstYear:'.$firstYear.' lastYear:'.$lastYear.' /2='.$medianYear.'</div>'.PHP_EOL;
?>

<!-- Site Head Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />



<!-- Timeline Stylesheets -->
<link rel="stylesheet" href="<?php echo DIR_REL?>/themes/evtouch/css/aristo/jquery-ui-1.8.5.custom.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo DIR_REL?>/themes/evtouch/js/timeglider/Timeglider.css" type="text/css" media="screen">

</head>
<body>
<!--start main container -->
<div id="main-container" >
	<div id="/<?php echo $parentName ?>" class="nHome <?php echo $parentName ?>"><div></div></div>
	<div class="clear"></div>

	<div id="main-content-container" class="grid_24">
		<div id="main-content-inner">
		
		<!-- Instructions overlay -->
		<div class="tg-modal full_modal" id="intro_modal" style="z-index:9; top:20px; left:20px; width:1745px; height:906px;">
			<div class="full_modal_scrim"></div>
			<div class="full_modal_panel <?php echo $parentName ?>">
				<div id="closeIntro" class="close-button full_modal_close">x</div>
				<h4 class="slArrL"></h4>
				<h3>Slide the timeline<br>left and right to<br>view the history</h3>
				<h4 class="slArrR"></h4>
				<div class="clear"></div>
			</div>
		</div>

<div id="placement"></div>
<table class="timeline-table" id="mylife" focus_date="<?php echo $medianYear ?>" title="Environmental Volunteers History" initial_zoom="36" description="A breif history of Environmental Volunteers">

    <tr>
    <th class="tg-startdate">start date</th>
	<th class="tg-enddate">end date</th>
    <th class="tg-title">title</th>
    <th class="tg-description">description</th>
	<th class="tg-icon">icon</th>
	<th class="tg-date_limit">date limit</th> <!-- blank-day,month,day,year ye-only year -->
	<th class="tg-importance">importance</th>  <!-- determines how large item displays -->
	<th class="tg-link">link</th>
	<th class="tg-image">image</th>
	<th class="tg-modal_type">modal</th>
    </tr>

<?php
//TR row above pads viewprort so first item doesn't spring back so abruptly
	$a->display($c); //Output content blocks
	
	foreach ($blocks as $b) {
			$btc = $b->getInstance();	//get the block's controller
			$TmDate = $btc->field_1_date_value;	//retrieves Start Date field from the timeline block
			$TmDateYr = (substr($TmDate, 0, 4)+1);
		
//echo '<div>no'.$tm.'/'.$blCount.' yearTotal now '.$yearTotal.'<br>TmDate is '.$TmDate.'<br>TmDateYr is '.$TmDateYr.'<br><br>yearTotal/tm is '.$yearTotal/$tm.'</div><br><br>'.PHP_EOL;	
		$tm++;
		$yearTotal = $yearTotal + $TmDateYr;
		
	}
?>

</table>
<!-- END timeline table -->

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
<script src="<?php echo DIR_REL?>/themes/evtouch/js/underscore-min.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/backbone-min.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/jquery.global.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/jquery.tmpl.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/ba-debug.min.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/ba-tinyPubSub.js" type="text/javascript"></script>
	
<!-- TIMEGLIDER -->
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider/TG_Date.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider/TG_Org.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider/TG_Timeline.js" type="text/javascript"></script> 
<!-- <script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider/TG_TimelineView.js" type="text/javascript"></script> -->
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider/TG_GenTimelineView.js" type="text/javascript"></script>
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider/TG_Mediator.js" type="text/javascript"></script> 
<script src="<?php echo DIR_REL?>/themes/evtouch/js/timeglider/gen.timeline.widget.js" type="text/javascript"></script>

<script type="text/javascript">
	var appCat = "<?php echo $parentName ?>";


	$(document).ready(function() {
		var tld = "timeline";
		
		var tg = $("#placement").timeline({
				"min_zoom":18, 
				"max_zoom":55, //55
				
				"show_centerline":true,
				
				"show_footer":true,  //hides timeglider black toolbar
				// data source is the id of the table!
				"display_zoom_level":true,	//Hides zoom level number in zoom tool bar
				"data_source":"#mylife"	//Orig table
		});
		
		$(".nHome").click(function(event){
			event.preventDefault();
			linkLocation = $(this).attr('id');
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