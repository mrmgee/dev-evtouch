<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
<head>
<?php   Loader::element('header_required');
Loader::model('file_list');
Loader::model('file_set');
$date = Loader::helper('date');
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

//$feedUrl = 'http://www.weather.gov/xml/current_obs/KPAO.xml'; //Orig
$feedUrl = $_SERVER['DOCUMENT_ROOT'].'/packages/tws_box_grabber/libraries/KPAO.xml'; //Read form local cached file
$rawFeed = file_get_contents($feedUrl);
$myweather = new SimpleXmlElement($rawFeed);
$windDirFull = $myweather->wind_dir;
$windDir = substr($windDirFull, 0, 1); // Get first char of direction North = N
$tempFull = $myweather->temp_f;
$temp = substr($tempFull, 0, -2);
?>
	<script type="text/javascript">
		var appCat = "<?php echo $pageName ?>";
		
		$(document).ready(function() {
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
	<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />
</head>
<body id="stats">

<!--START main container -->
<div id="main-container">
	<div id="/<?php echo $parentName ?>" class="nHome <?php echo $parentName ?>"><div></div></div>

<!--END header -->

	<div class="clear"></div>

	<div id="main-content-container" class="grid_24 stats">
		<div id="main-content-inner" class="stats">
			<div class="header main <?php echo $parentName ?>">
				<h1>Stats for <?php print $date->getLocalDateTime('now', 'F d, Y'); ?></h1>
			</div>
			<div class="statCont scTides">
				<h2>Tides</h2>
				<img id="graph1" src="/packages/tws_box_grabber/libraries/thumbnails/9414523_wl_24.png" width="700px" ondragstart="return false">
			</div>
			<div class="statCont scRight">
			
			
			<div class="statCont scMoon">
				<h2>Moon Phase</h2>
				
<?php

function moon_phase($year, $month, $day){
	$c = $e = $jd = $b = 0;
	if ($month < 3) {
		$year--;
		$month += 12;
	}
	++$month;

	$c = 365.25 * $year;
	$e = 30.6 * $month;
	$jd = $c + $e + $day - 694039.09;	//jd is total days elapsed
	$jd /= 29.5305882;					//divide by the moon cycle
	$b = (int) $jd;						//int(jd) -> b, take integer part of jd
	$jd -= $b;							//subtract integer part to leave fractional part of original jd
	$b = round($jd * 8);				//scale fraction from 0-8 and round

	if ($b >= 8 ){
		$b = 0;//0 and 8 are the same so turn 8 into 0
	}
	$phaseCl = 'moon'.$b;

	switch ($b) {
		case 0:
			$phaseNm = 'New Moon';
			break;
		
		case 1:
			$phaseNm = 'Waxing Crescent Moon';
			break;

		case 2:
			$phaseNm = 'First Quarter Moon';
			break;

		case 3:
			$phaseNm = 'Waxing Gibbous Moon';
			break;

		case 4:
			$phaseNm = 'Full Moon';
			break;

		case 5:
			$phaseNm = 'Waning Gibbous Moon';
			break;

		case 6:
			$phaseNm = 'Third Quarter Moon';
			break;

		case 7:
			$phaseNm = 'Waning Crescent Moon';
			break;
			
		default:
			$phaseNm = 'Error';
	}
	
	$phase = '<h3>'.$phaseNm.'</h3><div id="statMoon" class="'.$phaseCl.'"></div>';
	return $phase;
}  // END function moon_phase

$timestamp = time();
//echo '<p>'.$timestamp.' | currPhase:'.$currPhase.'</p>';	//Testing

echo moon_phase(date('Y', $timestamp), date('n', $timestamp), date('j', $timestamp));
?>
			</div>

			<div class="statCont scSm wind">
				<h2>Windspeed/Direction</h2>
				<h3 class="windDir"><?php echo $windDir ?></h3>
				<h3><?php echo $myweather->wind_mph ?><i>/MPH</i></h3>
			</div>
			
			<div class="clear"></div>
			
	<!--	<div class="statCont scSm temp"> -->
			<div class="statCont temp">
				<h2>Temperature</h2>
				<h3><?php echo $temp ?>° F</h3>
			</div>
			<div class="statCont sun">
				<h2>Sunrise/Sunset</h2>
			<?php
				$todaydate = $date->getLocalDateTime('now', 'd/m');
//echo PHP_EOL.'<p>todaydate:'.$todaydate.'</p>'.PHP_EOL;
				$dst = date("I"); // check daylight savings 0 or 1
								  //	PST	UTC−8:00 or PDT	UTC−7:00


//				http://www.earthtools.org/sun/<latitude>/<longitude>/<day>/<month>/<timezone>/<dst> 0 no / 1 yes
				$sunUrl = 'http://www.earthtools.org/sun/37.48/-122.12/'.$todaydate.'/-8/'.$dst;
//echo PHP_EOL.'<p>sunUrl:'.$sunUrl.'</p>'.PHP_EOL;		
								
				$rawFeed = file_get_contents($sunUrl);
				$mySun = new SimpleXmlElement($rawFeed);
//print_r($mySun);			
				$sunRise24 = $mySun->morning->sunrise;
				$sunSet24 = $mySun->evening->sunset;
				
				$sunRiseFull = date("g:i a", strtotime($sunRise24));
				$sunRiseNum = substr($sunRiseFull, 0, -3);
				$sunRiseAMP = substr($sunRiseFull, -2);
				
				$sunSetFull = date("g:i a", strtotime($sunSet24));
				$sunSetNum = substr($sunSetFull, 0, -3);
				$sunSetAMP = substr($sunSetFull, -2);
				
//echo '<p>sunRise: '.$sunRise.' | sunSet: '.$sunSet.'</p>'.PHP_EOL;

			?>
				<h4 class="sunSet"><?php echo $sunRiseNum.'<i>'.$sunRiseAMP.'</i>' ?></h4>
				<h4><?php echo $sunSetNum.'<i>'.$sunSetAMP.'</i>' ?></h4>
			</div>
		</div><!-- END statCont scRight -->
			<?php  
			$a = new Area('Main');
			$a->display($c);
			?>
			<div class="clear"></div>
<!--		<p>Today is: <?php print $date->getLocalDateTime('now', 'F d, Y'); ?></p> -->
		</div>
	
	</div>
	
	<!-- end full width content area -->
	
</div><!-- END main container -->

<!-- FOOTER START main-bkg -->
<div id="main-bkg" class="sea_bkg" style="background:url(<?php echo $theFilePath ?>) 0 0 no-repeat;">
	<div id="main-bkg-outer">
		<div id="main-bkg-inner" class="fullScreen"></div>
	</div>
</div><!-- END main-content-bkg -->
<?php   Loader::element('footer_required'); ?>
<?php  $this->inc('elements/analytics.php'); ?>
</body>
</html>
