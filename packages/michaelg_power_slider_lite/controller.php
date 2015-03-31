<?php        
defined('C5_EXECUTE') or die(_("Access Denied."));

class MichaelgPowerSliderLitePackage extends Package {

     protected $pkgHandle = 'michaelg_power_slider_lite';
     protected $appVersionRequired = '5.3.3.1';
     protected $pkgVersion = '1.1.1';

     public function getPackageDescription() {
          return t("Sweet Image Slider with Power Phrases");
     }

     public function getPackageName() {
          return t("Power Slider Lite");
     }


    public function install() {
            $pkg = parent::install();

            // install block
            BlockType::installBlockTypeFromPackage('power_slider_lite', $pkg);
    }   
}
?>
