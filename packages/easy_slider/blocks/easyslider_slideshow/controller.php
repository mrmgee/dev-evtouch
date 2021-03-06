<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class EasysliderSlideshowBlockController extends BlockController {

	const pkgHandle = 'easy_slider';
	protected $btTable = 'btEasySliderSlideshow';
	protected $btInterfaceWidth = "500";
	protected $btInterfaceHeight = "390";

	private function getBlockPath(){
		/*$bt = BlockType::getByHandle('easyslider_slideshow');
		 $uh = Loader::helper('concrete/urls');
		 $local = $uh->getBlockTypeAssetsURL($bt);
		 return $local;*/
		return BASE_URL.DIR_REL."/packages/easy_slider/blocks/easyslider_slideshow";
	}
	function __construct($obj = null) {
		parent::__construct($obj);
		$html=Loader::helper('html');
		//Load jQiery 1.5 and reset C5 Jquery after that
		$this->addHeaderItem('<script type="text/javascript">var jqC5 = jQuery.noConflict(true);</script>');
		$this->addHeaderItem($html->javascript($this->getBlockPath().'/libs/jquery.min.js'));
		$this->addHeaderItem('<script type="text/javascript">var jq15s = jQuery.noConflict(true);$=jqC5;jQuery=jqC5</script>');

	}
	
	public function getBlockTypeDescription() {
		return t("Create a Slider of Blocks");
	}

	public function getBlockTypeName() {
		return t("Easy Slider Slideshow");
	}

	/**
	 * Generates html and part of javascript needed for slideshow
	 */
	public function view(){
		global $c;
			
		$this->runSetter();
			
		if($c->isEditMode()){
			//if(!$c->isEditMode()) echo '<div id="b'.$this->bID.'-b" class="easyslider_slide">';
			echo '<script type="text/javascript">';
			if($this->isFinal($this->bID)){
				echo 'easy_slider_slideshow_ends.push(\''.$this->bID.'\');';
			}
			echo 'easy_slider_addBlock(\''.$this->bID.'\');';
			echo ''.
					'if(CCM_EDIT_MODE){'.
						'jQuery(document).ready(function() {'.
							'easy_slider_start();'.
						'});'.
					'}'.
				'';
			echo '</script>';
			//if(!$c->isEditMode()) echo '</div>';
		}else{
			$templateName=$this->getTemplateName();
			$enclosingStart=$GLOBALS['concrete5_easyslider_slideshow_wrapstart'][$GLOBALS['concrete5_easyslider_slideshow_rev'][$this->bID]];
			$enclosingEnd=$GLOBALS['concrete5_easyslider_slideshow_wrapend'][$GLOBALS['concrete5_easyslider_slideshow_rev'][$this->bID]];
			if($GLOBALS['concrete5_easyslider_slideshow'][$GLOBALS['concrete5_easyslider_slideshow_rev'][$this->bID]][0]==$this->bID){//start
				echo '<div id="easysliderslideshow_'.$this->bID.'" class="easysliderslideshow '.$templateName.'"><div class="slides_container">';
				echo '<script type="text/javascript">easy_slider_current_template="'.$templateName.'";if (!(typeof easy_slider_slideshow_configs[easy_slider_current_template] != \'undefined\')) {easy_slider_slideshow_configs[easy_slider_current_template]=new Array();}easy_slider_slideshow_configs_temp={"slideTimes":new Array()}</script>';
				echo '<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push('.$this->slideTime.')</script>';
				echo '<!--SLIDER START-->';
				echo '<div class="slide">';
				echo '<!--START REPLACE-->'.$enclosingStart;
			}else if($GLOBALS['concrete5_easyslider_slideshow'][$GLOBALS['concrete5_easyslider_slideshow_rev'][$this->bID]][count($GLOBALS['concrete5_easyslider_slideshow'][$GLOBALS['concrete5_easyslider_slideshow_rev'][$this->bID]])-1]==$this->bID){//end
				echo $enclosingEnd.'<!--END REPLACE-->';
				echo '</div>';
				echo '<!--SLIDER END-->';
				if($this->isFinal($this->bID)){
					echo '<script type="text/javascript">';
					echo 'easy_slider_slideshow_configs[easy_slider_current_template].push({ "showControls":'.$this->showControls.', "showPagination":'.$this->showPagination.', "autostart":'.$this->autostart.', "hoverPause":'.$this->hoverPause.', "slideTime":'.$this->slideTime.', "slideTimes":easy_slider_slideshow_configs_temp["slideTimes"]});';
					echo '</script>';
				}
				echo '</div></div>';
			}else{//middle
				echo $enclosingEnd.'<!--END REPLACE-->';
				echo '</div>';
				echo '<script type="text/javascript">easy_slider_slideshow_configs_temp["slideTimes"].push('.$this->slideTime.')</script>';
				echo '<!--SLIDER CHANGE-->';
				echo '<div class="slide">';
				echo '<!--START REPLACE-->'.$enclosingStart;
			}
		}
	}
	
	/**
	 * Check if a Block is the end of a slideshow
	 * @param int $bID
	 * @return boolean
	 */
	private function isFinal($bID){
		return Block::getByID($bID)->getInstance()->isLast==1; //TODO:change
	}
	
	/**
	 * Setup some global variables describing slides used to define html and javascript
	 */
	private function runSetter(){
		global $c;
		if(!isset($GLOBALS['concrete5_easyslider_slideshow_run'])){		
			echo "
			<script type=\"text/javascript\">
			if (!(typeof easy_slider_slideshow != 'undefined')) {
				var easy_slider_slideshow = new Array();
				var easy_slider_slideshow_ends = new Array();
				var easy_slider_slideshow_configs = new Array();
				var easy_slider_current_template='';
			}
			</script>
			";	
			$GLOBALS['concrete5_easyslider_slideshow_run']=true;
		}			
		if(!$c->isEditMode()&&!isset($GLOBALS['concrete5_easyslider_slideshow'])){
			$GLOBALS['concrete5_easyslider_slideshow']=array();
			$GLOBALS['concrete5_easyslider_slideshow_rev']=array();
			$GLOBALS['concrete5_easyslider_slideshow_wrapstart']=array();
			$GLOBALS['concrete5_easyslider_slideshow_wrapend']=array();
			$page=Page::getCurrentPage();
			$areas=$this->getCollectionAreas($page->cID);
			foreach($areas as $area){
				$blocks = $page->getBlocks($area['arHandle']);//TODO: check if putting $this->block->a->arHandle in view.php gets better performance
				$slideshow=array();
				foreach($blocks as $block){
					if($block->getBlockTypeHandle()=='easyslider_slideshow'){
						$slideshow[]=$block->bID;
						if($this->isFinal($block->bID)){
							$GLOBALS['concrete5_easyslider_slideshow'][]=$slideshow;
							//$GLOBALS['concrete5_easyslider_slideshow_area'][]=$area['arHandle'];
							$GLOBALS['concrete5_easyslider_slideshow_wrapstart'][]=Block::getByID($block->bID)->getInstance()->wrapperStart;
							$GLOBALS['concrete5_easyslider_slideshow_wrapend'][]=Block::getByID($block->bID)->getInstance()->wrapperEnd;
							//apply reverse start
							foreach($slideshow as $sbID){
								$GLOBALS['concrete5_easyslider_slideshow_rev'][$sbID]=count($GLOBALS['concrete5_easyslider_slideshow'])-1;
							}
							//apply reverse end
							$slideshow=array();
						}
					}
					/*if(count($slideshow)!=0){ //TODO:think about uncommenting
					 $GLOBALS['concrete5_easyslider_slideshow'][]=$slideshow;
						}*/
				}
			}
		}
	}
	
	/**
	 * Returns the name of the template used by a block
	 * @return string|Ambiguous
	 */
	private function getTemplateName(){
		$db = Loader::db();
		$r=$db->query('select bFilename from Blocks where bID = ?',array($this->bID));
		$row = $r->fetchRow();
		$name=$row['bFilename'];
		if(empty($name))
			return 'default';
		return $name;
	}
	
	/**
	 * Returns arHandles of Areas inside a Collection (Page)
	 * @param unknown_type $cID
	 * @return Ambiguous
	 */
	private function getCollectionAreas($cID){
		$db = Loader::db();
		$r=$db->query('select DISTINCT(arHandle) from Areas where cID=?',array($cID));
		$rows = $r->GetAll();
		return $rows;
	}
	
	function save($data) {
		$data['slideTime']=intval($data['slideTime']);
		$data['autostart']=intval($data['autostart']);
		$data['showControls']=intval($data['showControls']);
		$data['showPagination']=intval($data['showPagination']);
		$data['hoverPause']=intval($data['hoverPause']);
		parent::save($data);
	}
}

?>