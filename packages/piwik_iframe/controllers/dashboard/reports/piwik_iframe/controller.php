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

class DashboardReportsPiwikIframeController extends Controller {

//This is how items are saved from the iframe
	public function save_settings() {
		$piwiksiteid = $this->post('piwiksiteid');
		$piwikurl  = $this->post('piwikurl');
		$pwauthkey  = $this->post('pwauthkey');
		$pwsuperu  = $this->post('pwsuperu');
		
		$pkg = Package::getByHandle('piwik_iframe');
		$pkg->saveConfig('piwiksiteid', $this->post('piwiksiteid'));
		$pkg->saveConfig('piwikurl', $this->post('piwikurl'));
		$pkg->saveConfig('pwauthkey', $this->post('pwauthkey'));
		$pkg->saveConfig('pwsuperu', $this->post('pwsuperu'));
		$this->set("message", t('Piwik configuration saved.'));

	}


	/* Escape a string to be used as a regular expression pattern
     *
     * Example: escape_string_for_regex('http://www.example.com/s?q=php.net+docs')
     *          returns http:\/\/www\.example\.com\/s\?q=php\.net\+docs
     */
	function regex_escape($str)
	{
		/* All regex special chars (according to arkani at iol dot pt below):
		 * \ ^ . $ | ( ) [ ]
		 * * + ? { } ,
		 */
		$patterns = array(
			'/\//', '/\^/', '/\./', '/\$/', '/\|/',
			'/\(/', '/\)/', '/\[/', '/\]/', '/\*/', '/\+/',
			'/\?/', '/\{/', '/\}/', '/\,/');
        $replace = array(
			'\/', '\^', '\.', '\$', '\|', '\(', '\)',
			'\[', '\]', '\*', '\+', '\?', '\{', '\}', '\,');
       
        return preg_replace($patterns, $replace, $str);
	}
	
	   public function on_start() {
      $html = Loader::helper('html');
      $this->addHeaderItem($html->css('piwik_iframe.css', 'piwik_iframe'));

   }
}