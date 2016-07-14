<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
</div><!-- END main container -->

<div class="clear"></div>
	
	<div id="footer">
<?php
	$pageName = $c->getCollectionHandle();
	echo '<h1>'.$pageName.'</h1>';
?>
		<div id="footer-inner">
		</div>
		<div id="ack">CREDITS</div>
	</div>

<?php   Loader::element('footer_required');
$this->inc('elements/analytics.php'); ?>
</body>
</html>

<?php
//cURL for stats data caching
$date = Loader::helper('date');
include $_SERVER['DOCUMENT_ROOT'].'/packages/tws_box_grabber/libraries/simple_html_dom.php';
require_once($_SERVER['DOCUMENT_ROOT'].'/packages/tws_box_grabber/libraries/url_to_absolute.php');

$todaydate = $date->getLocalDateTime('now', 'd/m');
$dst = date("I"); // check daylight savings 0 or 1	PST	UTC−8:00 or PDT	UTC−7:00

$extSites = array();	//external sites URL array - get form website
$extSites[0] = 'http://tidesandcurrents.noaa.gov/ports/ports.html?id=9414523&mode=allwater';
$extSites[1] = 'http://www.weather.gov/xml/current_obs/KPAO.xml';
//$extSites[2] = 'http://192.168.15.11/?command=DataQuery&uri=dl:Table1&format=xml&mode=most-recent';


$extSitesFile = array();	//external sites file path array - save website to a file
$extSitesFile[0] = $_SERVER['DOCUMENT_ROOT'].'/packages/tws_box_grabber/libraries/tidesSrc.txt';
$extSitesFile[1] = $_SERVER['DOCUMENT_ROOT'].'/packages/tws_box_grabber/libraries/KPAO.xml';
$extSitesFile[2] = $_SERVER['DOCUMENT_ROOT'].'/packages/tws_box_grabber/libraries/weather.xml';

$extSitesImg = array();	//external sites file path array
$extSitesImg[0] = $_SERVER['DOCUMENT_ROOT'].'/packages/tws_box_grabber/libraries/thumbnails/9414523_wl_24.png';

$extSitesCache = array();	//external sites cache interval array
$extSitesCache[0] = 3600; //3600 seconds = 1 hr tide table
$extSitesCache[1] = 3600; //3600 seconds = 1 hr KPAO weather
$extSitesCache[2] = 300; //300 seconds = 5min local weather

$xd = 0;
for ($xd = 0; $xd < count($extSites); $xd++){	//Loop thru URL array and perform curl

	$LastModified = filemtime($extSitesFile[$xd]);  //Check for connection using file path item at index $xd in extSitesFile array
	$now = time();

	if($now - $LastModified >= $extSitesCache[$xd]) {	//Set by extSitesCache[xd]
		$curlSrc = curl_init($extSites[$xd]);	//Check for connection using URL item at index $xd in extSites array
		curl_setopt($curlSrc, CURLOPT_RETURNTRANSFER, true);
	
	//Test if connected	
		if(curl_exec($curlSrc) === false){
		//	echo 'Curl error: ' . curl_error($curlTst);
		} else { //Connection fine get file
		//	echo '<p>Operation completed without any errors</p>'.PHP_EOL;	
			$curl = curl_init();
			curl_setopt ($curl, CURLOPT_URL, $extSites[$xd]);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			curl_setopt($curl, CURLOPT_ENCODING, "UTF-8" );
			curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_REFERER, $extSites[$xd]);
		
			$result = curl_exec ($curl); //Orig
			curl_close ($curl);

			//write contents of $result to file
			$File = $extSitesFile[$xd];
			$fh = fopen($File, 'w') or die("can't open file");
			fwrite($fh, $result);
			fclose($fh);
			
			$url = $extSites[0]; //http://tidesandcurrents.noaa.gov/ports/ports.html?id=9414523&mode=allwater
			$html = file_get_html($File);

			foreach($html->find('img') as $element) {
				$imgPathSrc = url_to_absolute($url, $element->src);
			
				$imageFilename = pathinfo($imgPathSrc, PATHINFO_FILENAME);
				$imageFilExt = pathinfo($imgPathSrc, PATHINFO_EXTENSION);
				$imagename = $imageFilename.'.'.$imageFilExt; //Returned 9414523_wl_24.png WORKS				
				$fullpath = $_SERVER['DOCUMENT_ROOT'].'/packages/tws_box_grabber/libraries/thumbnails/'.$imagename;
			
				$ch = curl_init ($imgPathSrc);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
				$rawdata=curl_exec($ch);
				$rawdata=curl_exec($ch);
				curl_close ($ch);
				if(file_exists($fullpath)){
					unlink($fullpath);
				}
				$fp = fopen($fullpath,'x');
				fwrite($fp, $rawdata);
				fclose($fp);
			}
			

		}	//END if(curl_exec(curlTst) === false)
		curl_close($curlSrc);
		
	} //END if last mod

}	//END for loop thru URL array
?>