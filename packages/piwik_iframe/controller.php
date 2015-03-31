<?php 
/* Piwik iframe - See Piwik in Concrete5 
 * 
 * NOTICE OF LICENSE
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 * @package     Piwik iframe
 * @copyright   Copyright (C) 2012 Adrian Speyer. (http://www.adrianspeyer.com)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 */


 
defined('C5_EXECUTE') or die(_("Access Denied."));

class PiwikIframePackage extends Package {

   protected $pkgHandle = 'piwik_iframe';
   protected $appVersionRequired = '5.5.1';
   protected $pkgVersion = '0.9.6';

   public function getPackageDescription() {
      return t("Adds the Piwik iFrame for your site into the dashboard.");
   }

   public function getPackageName() {
      return t("Piwik Iframe"); 
   }

 	
	
	   public function install() {
      $pkg = parent::install();
      Loader::model('single_page');
      $sp = SinglePage::add('/dashboard/reports/piwik_iframe', $pkg);
      $sp->update(array('cName' => 'Piwik iframe', 'cDescription'=>'iFrame of Piwik Stats'));
   }
   
  
    public function uninstall() {
		$sp = Page::getByPath('/dashboard/reports/piwik_iframe');
		if ($sp) $sp->delete();

		parent::uninstall();
	}
	
	
	
	
	
	
	

}
?>