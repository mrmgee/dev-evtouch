<?php 
defined('C5_EXECUTE') or die("Access Denied.");

echo '<div class="box-grabber">';

if($title) echo '<h2>'.$title.'</h2>';

$purl = parse_url($url);
  $scheme   = isset($purl['scheme']) ? $purl['scheme'] . '://' : ''; 
  $host     = isset($purl['host']) ? $purl['host'] : ''; 
  $port     = isset($purl['port']) ? ':' . $purl['port'] : ''; 
  $user     = isset($purl['user']) ? $purl['user'] : ''; 
  $pass     = isset($purl['pass']) ? ':' . $purl['pass']  : ''; 
  $pass     = ($user || $pass) ? "$pass@" : '';
  
$baseurl = $scheme.$user.$pass.$host.$port;

Loader::library('phpQuery-onefile', 'tws_box_grabber');
Loader::library('url_to_absolute', 'tws_box_grabber');

global $docs;

echo '<p>url: '.$url.'</p>'.PHP_EOL;

if($docs == null) {
    $docs = array();
}

if(isset($docs[$url])) {
    //reuse the previously retrieved document
    $doc = $docs[$url];
}
else {
    $doc = phpQuery::newDocumentFileHTML($url, "UTF-8");
    $docs[$url] = $doc;    
}

phpQuery::selectDocument($doc);
$data = pq($selector)->clone();
foreach($data['a'] as $a) {
    $ja = pq($a);
//   $href = $ja->attr('href');
    $href = $baseurl;
//    $ja->attr('href', url_to_absolute($baseurl, $href));
    $ja->attr('href', $baseurl);
    $ja->attr('target', '_blank');
}
echo '<hr><p>data below</p>';
echo $data;
echo '<p>baseurl: '.$baseurl.' | href: '.$href.'</p>'.PHP_EOL;
//echo '<p>doc: '.$doc.'</p>';  // entire page

echo '<p><hr><p>mg loop below</p>';
$dataMg = pq($selector)->clone();
$i = 1;
foreach($dataMg as $item) {
	$ja = pq($item);
	$srcPath = $ja->attr('src');
	if ($i == 1) {  // Just output 1st in loop
		echo '<img id="graph'.$i.'" src="'.$baseurl.$srcPath.'">'.PHP_EOL;
	}
	$i++;
}
echo '</div>';
?>