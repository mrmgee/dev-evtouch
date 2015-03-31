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

$feedUrl = $_SERVER['DOCUMENT_ROOT'].'/packages/tws_box_grabber/libraries/weather.xml'; //Read from local cached file
$rawFeed = file_get_contents($feedUrl);
$rawFeed = iconv("UTF-8","UTF-8//IGNORE",$rawFeed); //Fixes ISO encoding to allow SimpleXml to parse
$myweather = new SimpleXmlElement($rawFeed);

$weatherTimeFullObj = $myweather->data->r['time'];
$weatherTimeFull = new DateTime($weatherTimeFullObj);
$weatherTime = $weatherTimeFull->format('g:ia'); // g 12 hour without leading zero : i minutes a am/pm

$humidFull = (float)$myweather->data->r->v2; //type casting turns object into float
$humid = number_format($humidFull, 1);  //one decimal point

$rainFallFull = (float)$myweather->data->r->v3; //type casting turns object into float
$rainFall = number_format($rainFallFull, 1);  //one decimal point

$windSpeedFull = (float)$myweather->data->r->v5; //type casting turns object into float
$windSpeed = number_format($windSpeedFull, 1);  //one decimal points

$windDirFull = $myweather->data->r->v6;
$dirsCal = array('N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW', 'N');
$windDir = $dirsCal[round($windDirFull/45)];

$tempFull = (float)$myweather->data->r->v1;
$temp = number_format($tempFull);  //rounds up from decimal
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
				<h5>Mareas</h5>
				<img id="graph1" src="/packages/tws_box_grabber/libraries/thumbnails/9414523_wl_24.png" width="700px" ondragstart="return false">
				
				<h3>Last updated <?php echo $weatherTime ?></h3>
			</div>
			<div class="statCont scRight">
			
			
			<div class="statCont scMoon">
				<h2>Moon Phase</h2>
				<h5>Fase de la Luna</h5>
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
echo moon_phase(date('Y', $timestamp), date('n', $timestamp), date('j', $timestamp));
?>
			</div>

			<div class="statCont scSm wind">
				<h2>Windspeed/Direction</h2>
				<h5>Velocidad/Dirección del Viento</h5>
				<h3><?php echo $windDir ?></h3>
				<h3><?php echo $windSpeed ?><i>/MPH</i></h3>
			</div>
			
			<div class="statCont scSm humidity">
				<h2>Humidity/Rainfall</h2>
				<h5>Humedad/Lluvia</h5>
				<h3><?php echo $humid ?>%</h3>
				<h3><?php echo $rainFall ?><i>in</i></h3>
			</div>
			
			<div class="clear"></div>

			<div class="statCont temp">
				<h2>Temperature</h2>
				<h5>Temperatura</h5>
				<h3><?php echo $temp ?>° F</h3>
			</div>
			<div class="statCont sun">
				<h2>Sunrise/Sunset</h2>
				<h5>Salida/Puesta del sol</h5>
<?php
/* calculate the sunset time for Duck Pond Palo Alto, CA
Latitude: 37.454744  North
Longitude: -122.103832 West
Zenith ~= 90
offset: -8 GMT
*/

$zenith=90+50/60;
$dstChk = date("I");	// check daylight savings 0 or 1
$dst = -(8-$dstChk);		// PST UTC−8:00 or PDT	UTC−7:00
				
$sunRise24 = date_sunrise(time(), SUNFUNCS_RET_STRING, 37.45, -122.10, $zenith, $dst);
$sunSet24 = date_sunset(time(), SUNFUNCS_RET_STRING, 37.45, -122.10, $zenith, $dst);

$sunRiseFull = date("g:i a", strtotime($sunRise24));
$sunRiseNum = substr($sunRiseFull, 0, -3);
$sunRiseAMP = substr($sunRiseFull, -2);

$sunSetFull = date("g:i a", strtotime($sunSet24));
$sunSetNum = substr($sunSetFull, 0, -3);
$sunSetAMP = substr($sunSetFull, -2);			
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