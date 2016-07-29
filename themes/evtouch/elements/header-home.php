<?php   defined('C5_EXECUTE') or die("Access Denied.");
global $c;
$pageTitle = $c->getCollectionName();
$pageName = $c->getCollectionHandle();
$pagePath = $c->getCollectionPath();

$parent = Page::getByID($c->getCollectionParentID());
$homeURL = $parent->getCollectionPath();

//Check if HOME/EARTH > parent
// or
// HOME/SPN/EARTH > grandparent

//$parent = Page::getByID($c->getCollectionParentID());
$grandParent = Page::getByID($parent->getCollectionParentID());  // Restoration Projects 

$parentName = $parent->getCollectionHandle();
$grandParentName = $grandParent->getCollectionHandle();

//$children = $grandParent->getCollectionChildrenArray($intOneLevel = 1);  // Get first-level children of $page object and put in array $children

?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">

<head>

<?php   Loader::element('header_required'); ?>

<!-- Site Header Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php  echo $this->getStyleSheet('main.css')?>" />
<style>
a { color: #FFF; text-decoration: none; }
h1 { height: 80px; margin: 0 0 40px 0; padding: 10px 0 0 10px; font-size: 80px; }
</style>

<!-- LOAD COLORBOX OVERLAY -->
<script type="text/javascript" src="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/js/jquery.colorbox-min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_REL?>/packages/lightboxed_image/blocks/lightboxed_image/css/theme1/colorbox.css" />

<script type="text/javascript">
var langSel = '<?php echo $pagePath ?>';
$(document).ready(function() { 
  
//	$("body").css("display", "none");
 
//    $("body").fadeIn(200);

    function redirectPage() {
        window.location = linkLocation;
    }

    $(".nav li").click(function(event){
        event.preventDefault();
        linkLocation = $(this).attr('id');
//        $("body").fadeOut(1000, redirectPage);
        $("#footer").fadeOut(1000);
        $("#main-content-container").fadeOut(1000, redirectPage);
    });

    $("#langSelBtn").click(function(event){
    	if (langSel == '/<?php echo $pageName ?>'){
    		langSel = 1;
    		linkLocation = "/spn/<?php echo $pageName ?>/";
    	} else { 
    		langSel = '/<?php echo $pageName ?>';
    		linkLocation = '/<?php echo $pageName ?>';
    	}
    	alert("langSel: " + langSel);
    		$("#footer").fadeOut(1000);
    		$("#main-content-container").fadeOut(1000, redirectPage);
    }); 

/*	
    $("#langSelBtn").click(function(event){
    	if (langSel == 0){
    		langSel = 1;
    		linkLocation = "/spn/<?php echo $pageName ?>/"  // /spn/earth/
    		$("#footer").fadeOut(1000);
    		$("#main-content-container").fadeOut(1000, redirectPage);
    	} else { 
    		langSel = 0;
    	}
    	alert("langSel: " + langSel);
    });
*/    

	$("#ack").colorbox({inline:true,href:"#ackCont"}); // END main colorbox
	$("#ackCont").addClass("<?php echo $pageName ?>");

});
</script>
</head>
<?php
	$pageName = $c->getCollectionHandle();
	echo '<body id="'.$pageName.'">';
?>
<!--start main container -->

<div class="hideCont">
	<div id="ackCont">
		<h2>CREDITS</h2>
		<h3>Developed for Environmental Volunteers</h3>
		<p>Allan Berkowitz – Executive Director</p>
		<p>Brittany Sabol – Education & Training Director</p>
		<h3>Touchscreens developed by White Room Partners</h3>
		<p>Michael Gee – Principal & Lead Developer</p>
		<p>Anna McElheny – Art Director & User Experience</p>
		<div class="wrpLogo">
			whiteroompartners.com
		</div>
		<h3>Exhibition design by Stephanie Scheafer design</h3>
		<p>Stephanie Scheafer – Principal</p>
	</div>
</div>

<div id="main-container" >

	<div id="header">
		<?php  
		$a = new Area('Header Image');
		$a->display($c);
		
		if ($pageName == "earth") {  // if YES Login and YES Edit
		$langLnk = "Spanish";
		}
		else {   // if YES Login and NO Edit
		$langLnk = "English";
		}


		echo PHP_EOL.'<h2>'.$grandParentName.' / '.$parentName.'</h2>'.PHP_EOL; //Display page title Earth
		
		echo PHP_EOL.'<ul>'.PHP_EOL;
		foreach ($children as $child) {
			$childPage = Page::getByID($child);
			$childPageName = $childPage->getCollectionHandle();
			$childPageTitle = $childPage->getCollectionName();
			echo PHP_EOL.'<li>childPageName: '.$childPageName.' - '.$childPageTitle.'</li>'.PHP_EOL;  // Testing
		}
		echo PHP_EOL.'</ul>'.PHP_EOL;
		
		echo PHP_EOL.'<h2>LANG: '.$langLnk.'</h2>'.PHP_EOL; //Display page title Earth
		echo PHP_EOL.'<h2>TITLE: '.$pageTitle.'</h2>'.PHP_EOL; //Display page title Earth
		echo PHP_EOL.'<h2>NAME: '.$pageName.'</h2>'.PHP_EOL; //Display page name earth

		
		?>
	</div>
	
	<div class="clear"></div>