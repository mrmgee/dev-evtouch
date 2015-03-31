<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class LightboxedImagePackage extends Package {

     protected $pkgHandle = 'lightboxed_image';
     protected $appVersionRequired = '5.4.2';
     protected $pkgVersion = '0.9.2';

     public function getPackageDescription() {
          return t("Adds an image with a caption and an optional lightbox effect");
     }

     public function getPackageName() {
          return t("Lightboxed Image");
     }
     
     public function install() {
          $pkg = parent::install();
     
          // install block 
          BlockType::installBlockTypeFromPackage('lightboxed_image', $pkg); 
     }
     
}

?>