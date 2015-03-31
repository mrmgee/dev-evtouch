<?php  defined('C5_EXECUTE') or die("Access Denied.");

class PlantAnimalIdCategoryBlockController extends BlockController {
	
	protected $btName = 'Plant/Animal ID Category';
	protected $btDescription = 'Category separator Block for Plant/Animal ID app';
	protected $btTable = 'btDCPlantAnimalIdCategory';
	
	protected $btInterfaceWidth = "700";
	protected $btInterfaceHeight = "450";
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;
	
	public function getSearchableContent() {
		return $this->field_2_textarea_text;
	}








}
