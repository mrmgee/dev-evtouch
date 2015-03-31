<?php   
defined('C5_EXECUTE') or die("Access Denied."); 
$nav = Loader::helper('navigation');
global $c;

if ($c->isEditMode()) {
echo '<h3>Edit background images</h3>';
}
?>

<script type="text/javascript">
$(function(){
	$("#powerSliderContainer<?php  echo $bID; ?>").cycle({ 
		fx: '<?php  echo $transitionType ?>',
		next: '#powerSliderNext<?php  echo $bID; ?>',
		prev: '#powerSliderPrev<?php  echo $bID; ?>',
		pager: '#powerSliderPagination<?php  echo $bID; ?>',
		cleartypeNoBg: true,
		timeout: <?php  echo $slideDelay ?>000
	});
});
</script>
<style>

#powerSliderBlock<?php  echo $bID; ?> { position: fixed; top:0; left:0; width: 100%; height: 100%; z-index: -999999; }
#powerSliderContainer<?php  echo $bID; ?> { position: relative; overflow: hidden; width: <?php  echo $powerSlideWidth ?>px; height: <?php  echo $powerSlideHeight ?>px; }
#powerSliderContainer<?php  echo $bID; ?> .powerSlide { height: <?php  echo $powerSlideHeight ?>px; }
</style>
<div class="powerSliderShell" id="powerSliderBlock<?php  echo $bID; ?>">
    <div class="powerSliderContainer" id="powerSliderContainer<?php  echo $bID; ?>">
		<?php  foreach($images as $imgInfo) { 
		$f = File::getByID($imgInfo['fID']);
		$fp = new Permissions($f);
		$page = Page::getByID($imgInfo['pageID']);
		$theLink = $nav->getLinkToCollection($page);
		?>
		<div class="powerSlide">
			<?php  if ($imgInfo['powerSlidePhraseTitle'] !== "" ){ ?>
			<span class="largeText"><?php  echo $imgInfo['powerSlidePhraseTitle']?></span>
			<?php  } 
			if ($imgInfo['powerSlidePhraseDesc'] !== "" ){?>
			<span class="smallText"><?php  echo $imgInfo['powerSlidePhraseDesc']?></span>
			<?php  } ?>
			<img src="<?php  echo $f->getRelativePath()?>">
		</div>
		<?php   } ?>

	</div><!-- .powerSliderContainer -->
    
    <?php  if ( $paginationToggle == "paginationOn" ) { ?>
    <div class="powerSliderPagination" id="powerSliderPagination<?php  echo $bID; ?>" style="position: absolute; width: <?php  echo $powerSlideWidth ?>px; z-index: 99; bottom: <?php  echo $paginationOffsetY ?>px; text-align: <?php  echo $paginationAlignment ?>; ">
    	
    </div>
	<?php  } ?>
    
    <?php  if ( $prevNextArrows == "prevNextOn" ) { ?>
    <div class="powerSliderNext" id="powerSliderNext<?php  echo $bID; ?>" style="position: absolute; z-index: 99; bottom: <?php  echo $nextBtnOffsetY ?>px; right: <?php  echo $nextBtnOffsetX ?>px;"></div>
    <div class="powerSliderPrev" id="powerSliderPrev<?php  echo $bID; ?>" style="position: absolute; z-index: 99; bottom: <?php  echo $prevBtnOffsetY ?>px; left: <?php  echo $prevBtnOffsetX ?>px;"></div>
    <?php  } ?>

</div><!-- #powerSliderShell  -->