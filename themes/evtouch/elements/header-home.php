<?php   defined('C5_EXECUTE') or die("Access Denied.");
global $c;
$pageTitle = $c->getCollectionName();
$pageName = $c->getCollectionHandle();
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
$(document).ready(function() { 
  
//	$("body").css("display", "none");
 
//    $("body").fadeIn(200);
 
    $(".nav li").click(function(event){
        event.preventDefault();
        linkLocation = $(this).attr('id');
//        $("body").fadeOut(1000, redirectPage);
        $("#footer").fadeOut(1000);
        $("#main-content-container").fadeOut(1000, redirectPage);
    });
         
    function redirectPage() {
        window.location = linkLocation;
    }
    
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
		?>
	</div>
	
	<div class="clear"></div>