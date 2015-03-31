<?php  defined('C5_EXECUTE') or die("Access Denied.");
global $c;
global $u;
$curBl = $b->getBlockID();

$parent = Page::getByID($c->getCollectionParentID());
$parentName = $parent->getCollectionHandle();

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

if (!empty($vid_width)) $v_width = $vid_width;
if (!empty($vid_height)) $v_height = $vid_height;

if ($isEdit !=1) {	//Hide js from edit
?>
<!-- colorbox js -->
<script type="text/javascript">
	$('.vidOv').colorbox({
		inline:true,
		href:function(){
		var number = $(this).attr("id"); // returns vidOv437
		var numDiv = "#"+number+"Info"; // creates #vidOv437Info
//alert('numDiv: '+numDiv);	//Testing
		return numDiv;
		}
	});
</script>
<?php } 	//END Hide js from edit ?>



<div id="vidOv<?php echo $curBl ?>" class="vidOv">
	<div class="vidBtn <?php echo $parentName ?>" style="top:<?php echo ($v_height/2) ?>px;left:<?php echo ($v_width/2)+25 ?>px"><div></div></div>
<?php  if (!empty($field_2_image)): ?>
	<img src="<?php  echo $field_2_image->src; ?>" width="<?php  echo $field_2_image->width; ?>" height="<?php  echo $field_2_image->height; ?>" ondragstart='return false' />
<?php  endif; ?>
	<div class="contCaption">
		<h5 class="caption"><?php  if (!empty($field_4_textbox_text)) echo htmlentities($field_4_textbox_text, ENT_QUOTES, APP_CHARSET); ?></h5>
		<h5 class="credit"><?php  if (!empty($field_3_textbox_text)) echo htmlentities($field_3_textbox_text, ENT_QUOTES, APP_CHARSET); ?></h5>
	</div>
</div>



<div class="hideCont">
	<div id="vidOv<?php echo $curBl ?>Info" class="vidOvInfo">
		<h2><?php  if (!empty($field_1_textbox_text)) echo htmlentities($field_1_textbox_text, ENT_QUOTES, APP_CHARSET); ?></h2>
		<div class="vidContLeft">
<?php if($field_5_image->ftype == "FLV"){ ?>

		<script type="text/javascript" src="/concrete/js/swfobject.js"></script>

		<script type="text/javascript">
		var flashvars = {};
		flashvars.flvfile = "<?php  echo $field_5_image->src ?>";
		
		var params = {};
		params.menu = false;
		params.wmode="transparent";
		
		var attributes = {};
		
		swfobject.embedSWF("<?php echo $this->getBlockURL()?>/videoPlayer.swf", "flv_player_<?php echo $curBl ?>", "<?php echo $v_width ?>", "<?php echo $v_height ?>", "9.0.0","expressInstall.swf", flashvars, params, attributes);
		
		</script>
		
		<div class="ccm-flv-player" id="flv_player_<?php echo $curBl ?>">
		<?php echo t("Loading Video... If you're seeing this message you may not have Flash installed.")?>
		</div>

<?php } else if($field_5_image->ftype == "Quicktime"){ ?>
		
		<object CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="<?php echo $v_width ?>" height="<?php echo $v_height ?>" id="movie1" CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">
			<param name="src" value="<?php echo $field_5_image->src ?>">
			<param name="autoplay" value="false">
			<param name="loop" value="false">
			<param name="controller" value="true">
			<embed src="<?php  echo $field_5_image->src ?>" width="<?php echo $v_width ?>" height="<?php echo $v_height ?>" autoplay="true" loop="false" controller="true" EnableJavaScript="true" NAME="movie1" pluginspage="http://www.apple.com/quicktime/"></embed>
		</object>
		
		<!-- <a href="javascript:document.movie1.Play();">Play Movie1</a> -->

<?php }	//END check filetype ?>	
		


		
<?php	//Testing
/*
	echo '<p>field_5_image:<br></p>';
	echo '<p>field_5_image_fID: ';	//Testing
	print_r($field_5_image_fID);	//45
	echo '</p><p>field_5_image: ';
	print_r($field_5_image);	//
*/
/*
(
    [ftype] => FLV
    [fpath] => /Applications/MAMP/htdocs/files/5613/3893/6520/kgo-091311-br-6pm-salt-ponds.flv
    [fname] => kgo-091311-br-6pm-salt-ponds.flv
    [ftitle] => kgo-091311-br-6pm-salt-ponds.flv
    [fp] => /files/5613/3893/6520/kgo-091311-br-6pm-salt-ponds.flv
    [fdown] => http://localhost:8888/index.php/download_file/37/146/
    [src] => /files/5613/3893/6520/kgo-091311-br-6pm-salt-ponds.flv
)
*/

/*

stdClass Object
(
    [name] => 
    [src] => /files/
    [width] => 
    [height] => 
)

*/
	
?>
		</div><!-- END contLeft -->
	<?php   if (!empty($field_6_wysiwyg_content)) { ?>
		<div class="vidContRight">
	<?php echo $field_6_wysiwyg_content; ?>
		</div>
	<?php } //END if field_6_wysiwyg_content NOT empty?>
	<div class="clear"></div>
	</div><!-- END vidOv123Info-->
	
</div><!-- END hideCont -->	