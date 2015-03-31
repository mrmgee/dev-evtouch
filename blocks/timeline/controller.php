<?php  defined('C5_EXECUTE') or die("Access Denied.");

class TimelineBlockController extends BlockController {
	
	protected $btName = 'Timeline';
	protected $btDescription = 'Block for timeline items';
	protected $btTable = 'btDCTimeline';
	
	protected $btInterfaceWidth = "700";
	protected $btInterfaceHeight = "450";
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;
	
	public function getSearchableContent() {
		$content = array();
		$content[] = date('Y-m-d H-i-s', $this->field_1_date_value);
		$content[] = date('Y-m-d H-i-s', $this->field_2_date_value);
		$content[] = $this->field_3_textbox_text;
		$content[] = $this->field_4_textarea_text;
		$content[] = $this->field_5_textbox_text;
		$content[] = $this->field_6_textbox_text;
		$content[] = $this->field_8_textbox_text;
		$content[] = $this->field_10_textbox_text;
		return implode(' - ', $content);
	}

	public function view() {
//		$this->set('field_9_image', (empty($this->field_9_image_fID) ? null : $this->get_image_object($this->field_9_image_fID, 400, 450, true)));
//Crops image to 400w x 450h using imageHelper
		$this->set('field_9_image', (empty($this->field_9_image_fID) ? null : $this->get_image_object($this->field_9_image_fID, 0, 0, false)));
	}

	public function add() {
		//Set default values for new blocks
		$this->set('field_1_date_value', date('Y-m-d'));
		$this->set('field_2_date_value', date('Y-m-d'));
	}

	public function edit() {
		$this->set('field_9_image', (empty($this->field_9_image_fID) ? null : File::getByID($this->field_9_image_fID)));
	}

	public function save($args) {
		$args['field_1_date_value'] = empty($args['field_1_date_value']) ? null : Loader::helper('form/date_time')->translate('field_1_date_value', $args);
		$args['field_2_date_value'] = empty($args['field_2_date_value']) ? null : Loader::helper('form/date_time')->translate('field_2_date_value', $args);
		$args['field_9_image_fID'] = empty($args['field_9_image_fID']) ? 0 : $args['field_9_image_fID'];
		parent::save($args);
	}

	//Helper function for image fields
	private function get_image_object($fID, $width = 0, $height = 0, $crop = false) {
		if (empty($fID)) {
			$image = null;
		} else if (empty($width) && empty($height)) {
			//Show image at full size (do not generate a thumbnail)
			$file = File::getByID($fID);
			$image = new stdClass;
			$image->src = $file->getRelativePath();
			$image->width = $file->getAttribute('width');
			$image->height = $file->getAttribute('height');
		} else {
			//Generate a thumbnail
			$width = empty($width) ? 9999 : $width;
			$height = empty($height) ? 9999 : $height;
			$file = File::getByID($fID);
			$ih = Loader::helper('image');
			$image = $ih->getThumbnail($file, $width, $height, $crop);
		}
	
		return $image;
	}
	


}
