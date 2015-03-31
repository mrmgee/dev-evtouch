<?php  
	defined('C5_EXECUTE') or die("Access Denied.");	
	
	Loader::block('library_file');
	
	class LightboxedImageBlockController extends BlockController {

		protected $btInterfaceWidth = 300;
		protected $btInterfaceHeight = 450;
		protected $btTable = 'btLightboxedImage';
	
		public function on_page_view() {
		
			$co = new Config();
			$pkg = Package::getByHandle("lightboxed_image");
			$co->setPackageObject($pkg);
	  		
			$bv = new BlockView();
			$bv->setBlockObject($this->getBlockObject());
			$bt = BlockType::getByHandle($this->btHandle);
			$uh = Loader::helper('concrete/urls');
			
			// find and replace performed here to allow for https cases
		  	$this->addHeaderItem(Loader::helper('html')->css(str_replace(BASE_URL,'', $uh->getBlockTypeAssetsURL($bt, 'css/'. $co->get('lightbox_theme').'/colorbox.css' ))));
				  
			$jstrigger = '<script type="text/javascript"> 
			 $(document).ready(function(){
				 $("a[rel=\'lb_image\']").colorbox({returnFocus: false}); 
			 });
			</script>';
				
			$this->addHeaderItem($jstrigger);
			
		
		}


		/** 
		 * Used for localization. If we want to localize the name/description we have to include this
		 */
		public function getBlockTypeDescription() {
			return t("Adds an image with a caption and an optional lightbox effect");
		}
		
		public function getBlockTypeName() {
			return t("Lightboxed Image");
		}		
		
		public function getJavaScriptStrings() {
			return array(
				'image-required' => t('You must select an image.')
			);
		}
	
		function getFileID() {return $this->fID;}
		
		function getFileObject() {
			return File::getByID($this->fID);
		}		
		function getAltText() {return $this->altText;}
		function getExternalLink() {return $this->externalLink;}
		
		public function save($args) {		
			$args['fID'] = ($args['fID'] != '') ? $args['fID'] : 0;
			$args['maxWidth'] = (intval($args['maxWidth']) > 0) ? intval($args['maxWidth']) : 0;
			$args['maxHeight'] = (intval($args['maxHeight']) > 0) ? intval($args['maxHeight']) : 0;
			$args['maxWidthLarge'] = (intval($args['maxWidthLarge']) > 0) ? intval($args['maxWidthLarge']) : 0;
			$args['maxHeightLarge'] = (intval($args['maxHeightLarge']) > 0) ? intval($args['maxHeightLarge']) : 0;
			$args['disableLightbox'] = isset($args['disableLightbox']) ? 1 : 0;
		 		
			$co = new Config();
			$pkg = Package::getByHandle("lightboxed_image");
			$co->setPackageObject($pkg);
			$co->save('lightbox_theme', $args['lightbox_theme']);
			$co->save('last_max_page_width', $args['maxWidth']);
			$co->save('last_max_page_height', $args['maxHeight']);
			$co->save('last_max_lightbox_width', $args['maxWidthLarge']);
			$co->save('last_max_lightbox_height', $args['maxHeightLarge']);
			$co->save('last_theme', $args['lightbox_theme']);
			
			parent::save($args);
		}
		
	 

		function getContentAndGenerate($align = false, $style = false, $id = null) {
			$c = Page::getCurrentPage();
			$bID = $this->bID;
			
			$f = $this->getFileObject();
			$fullPath = $f->getPath();
			$relPath = $f->getRelativePath();			
			$size = @getimagesize($fullPath);
			$ih = Loader::helper('image');
			
			if ($this->maxWidth > 0 || $this->maxHeight > 0) {
				$mw = $this->maxWidth > 0 ? $this->maxWidth : $size[0];
				$mh = $this->maxHeight > 0 ? $this->maxHeight : $size[1];
				
				$widthofcaption = $mw;
				$thumb = $ih->getThumbnail($f, $mw, $mh);
				$sizeStr = ' width="' . $thumb->width . '" height="' . $thumb->height . '"';
				$relPath = $thumb->src;
			} else {
				$sizeStr = $size[3];
				$widthofcaption = $size[0];
			}
			
			
			if ($this->maxWidthLarge > 0 || $this->maxHeightLarge > 0) {
				$mw = $this->maxWidthLarge > 0 ? $this->maxWidthLarge : $size[0];
				$mh = $this->maxHeightLarge > 0 ? $this->maxHeightLarge : $size[1];
				
				$largeimage = $ih->getThumbnail($f, $mw, $mh);
				$largeimagsrc = $largeimage->src;
			} else {
				
				$largeimagsrc = $f->getRelativePath();
			}

			$largeimage = $ih->getThumbnail($f, 1000, 800);
			
			
			// if using html5, replace div with figure
			$img = '<div class="lightboxed-image-block">';
			
			if (!$this->disableLightbox) {
				
				if ($this->display_caption != 'page_only' && $this->altText != '') {
					$img .=	'<a href="'  . $largeimagsrc . '" title="'. $this->altText . '"  rel="lb_image">';
				} else {
					$img .=	'<a href="'  . $largeimagsrc . '"  rel="lb_image">';
				}
			}
			
			$img .= "<img border=\"0\" class=\"lightboxed-image\" alt=\"{$this->altText}\" src=\"{$relPath}\" {$sizeStr} />";
			
			if (!$this->disableLightbox) {
				$img .= '</a>';
			}
			
			if ($this->altText && $this->display_caption != 'lb_only') {
				
				// if using html5, replace the div with figcaption
				$img .= '<div style="width: ' .$widthofcaption . 'px" class="lightboxed-image-caption"><div class="lightboxed-image-caption-content">' . $this->altText . '</div></div>';
			}
			
			$img .= "</div>";
	
			return $img;
		}
		
		public function getSearchableContent() {
			return $this->altText;
		}
		

	}

?>