<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">

<head>

<?php   Loader::element('header_required'); ?>

<!-- Site Header Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />
</head>
<body>

<!-- START main-bkg -->
<?php
Loader::model('file_list');
Loader::model('file_set');
$parent = Page::getByID($c->getCollectionParentID());
$pageName = $parent->getCollectionHandle();
$fsName = $pageName.'_bkg';
$fs = FileSet::getByName($fsName);
$fileList = new FileList();
$fileList->filterBySet($fs);
$fileList->filterByType(FileType::T_IMAGE); 
$files = $fileList->get(100,0); //limit it to 100 pictures

$size = sizeof($files);
$random = rand(0, $size - 1);
$theFile = $files[$random];
$theFilePath = $theFile->getRecentVersion()->getRelativePath();

echo '<!--START main container -->
<div id="main-bkg" class="'.$fsName.'" style="background:url(
'.$theFilePath.'

) 0 0 no-repeat;">';
echo '	<div id="main-bkg-outer">';
echo '		<div id="main-bkg-inner">';
echo '		</div>';
echo '	</div>';
echo '</div>';
echo '<!-- END main-content-bkg -->';

echo '<!--START main container -->';
echo '<div id="main-container">';
echo '	<div class="nHome '.$pageName.'"><a href="/'.$pageName.'"><span>pageName: '.$pageName.'</span></a></div>';
?>