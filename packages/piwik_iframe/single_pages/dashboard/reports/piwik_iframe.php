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

$pkg = Package::getByHandle('piwik_iframe');
$piwikurl = $pkg->config('piwikurl');
$piwiksiteid = $pkg->config('piwiksiteid');
$pwauthkey = $pkg->config('pwauthkey');
$pwsuperu = $pkg->config('pwsuperu');
?>




<!--Piwik iframe-->
<?php   if (!empty($piwiksiteid) && !empty($piwikurl)) { ?>
<h1><span><?php   echo t('Piwik Analytics')?></span></h1>
<div class="ccm-dashboard-inner">
<!--Piwik Report Area Options for iframe-->
      <div id="pw_iframe-header-1">
   </div>

  <!--Set Default Frame Content, in case none exists-->     
<?php  
if ($piwiksiteid=="")
  $piwiksiteid="1";
else
  $piwiksiteid;
?>

<!--check http-->
<?php  
if(!preg_match('/http[s]?:\/\//', $piwikurl)) $piwikurl = 'http://'.$piwikurl;     
?> 
<!--end of default-->

   
 <!--Actual iframe Code-->    
   <div id="pw_iframe-content">
   
        <?php 
   
 //checks if no Auth Key set, user will be asked to sign in. 
if (empty($pwauthkey))
{
    
  echo'<p><iframe src="'.$piwikurl.'/index.php?module=Login" frameborder="0" marginwidth="0" marginheight="0" width="100%" height="1000px"></iframe></p>';
 
}
else
{
    echo'<p><iframe src="'.$piwikurl.'?module=Widgetize&action=iframe&moduleToWidgetize=Dashboard&actionToWidgetize=index&idSite='.$piwiksiteid.'&period=week&date=yesterday&token_auth='.$pwauthkey.'" frameborder="0" marginwidth="0" marginheight="0" width="100%" height="1000px"></iframe></p>';
   
} 
   
  ?>
   <!--End Actual iframe Code-->   
 
</div>

<?php   } ?>
<!--Piwik iframe Ends-->

<!--Code to make setup wizard pretty and place config at the bottom-->
<?php   if (($piwiksiteid > 0)) echo '</div>' ?>
<?php   if (!empty($piwiksiteid) && empty($piwikurl)) echo '</div>'?>
<!--End of Code to make setup wizard pretty and place config at the bottom-->



<!--Configuration Form 1st step-->
<!--No Permission to Modify-->
 <!--Checked Show No Config Area-->
<?php  if ($pwsuperu=="true")
{
$u = new User(); 
if(!$u->isSuperUser()) { // if not superuser
echo '<b>Contact Super Admin For Changes</b>'; // or leave as blank if you want no message to users
}
else 
{?>
<h1><span><?php   echo t('Piwik Configuration')?></span></h1>
<div class="ccm-dashboard-inner">
<?php 
 }}
 ?>
 <!--End Checked Show No Config Area-->
 
 <!--Not Check Show Config Area-->
<?php   if (empty($pwsuperu)) { ?>
<h1><span><?php   echo t('Piwik Configuration')?></span></h1>
<div class="ccm-dashboard-inner">
<?php  } ?>
<!--End Not Check Show Config Area-->
<!--End No Permission to Modify-->


<!--Welcome-->
<?php   if (empty($piwikurl) && empty($piwiksiteid)) { ?>
<div id="welcome_message">
<center>
<a href="http://piwik.org/"><img style="border: 0px solid ;"
alt="Piwik : Open source Web Analytics"
title="Piwik : Open source Web Analytics"
src="<?php  echo DIR_REL; ?>/packages/piwik_iframe/single_pages/dashboard/reports/piwik_logo.png"></a> <br>
</center>
<?php   echo t('
Welcome to Piwik iframe, the point of this extension is to easily get
your Piwik data in your Concrete5 install. So that you get off to a
flying start, here are some steps to make sure things run smoothly.<br>
<ul>
<li>You need to install Piwik on your server. If you don\'t have it
installed yet, you can download the latest version <a
href="http://piwik.org/latest.zip">here</a>.</li>
<li>You will need to enter you URL to Piwik in the next step. Please
make sure it includes "http://", for example: http://localhost/piwik</li>
<li>If you are tracking this site, you need to install tracking code
on this site. To install tracking code you just need to cut and paste
the <br>
javascript tag given to you during your Piwik install and placed it in
the box located in your Concrete5 Dashboard under System &amp;
Settings&gt;SEO &amp; Statistics&gt;Tracking Codes. The other option is to include
this code in your footer of your theme. You will normally find it in the element folder.</li>
<li>Your Site ID, is the "ID" Number you are given by Piwik for each
website you install tracking. It can be found in your tracking code or
in Website Management in your Piwik install. If you did a fresh Piwik
Install, your site ID is "1".<br>
</li>
<li>You have the option of automatically logging into your Piwik by providing an Auhtkey. You can find it in
the API menu of your Piwik install. If there are multiple users accessing the backend, 
we recommend you create a basic user with just view rights. If you choose, you
can leave the Authkey blank and users will be prompted to login with their Piwik credentials.<br>
</li>
<li>Remember to have the Piwik login screen to work from inside an iframe you
need to add the following to the setting in your config/config.ini.php:</li>
</ul>
<div style="margin-left: 80px;">[General]<br>
enable_framed_pages = 1<br>
</div>
<ul>
<li>You also have the option to lock down the configuration. This was
down to add a finer layer of permission to the extension. By checking
the box "<span style="font-weight: bold;">Only Super User Can Change
Config</span>", only the SuperUser will be able to change the path or
site id. If an Admin accidentaly clicks on the box, don\'t worry. You
can uninstall and reinstall this extension without losing your Piwik
data.</li>
</ul>
Once you have completed the above, you are ready to rock. <br>
<br>
&nbsp;Enjoy using Piwik iframe for Concrete 5<br></p>
</div>')?>
<?php   } ?>
<!--End Welcome-->



<!--Start Welcome Questions-->
<?php   if (empty($piwikurl)) { ?>
<div id="have_account">
  <p style="margin-bottom:0"><b><?php  echo t('Do you already have Piwik Installed?')?> </b></p>
  <ul style="list-style:none;margin:0;padding:0 4px;">
  <li><a href="#" id="have_account_yes"><?php  echo t('Yes, I do.')?></a></li>
  <li><a href="http://piwik.org/latest.zip"><?php  echo t('Nope, but I\'d like to download the latest.')?></a></li>
  </ul>
</div>

<br/>
<?php   } else { ?>
<?php   if (empty($piwiksiteid)) { ?>
<div class="message error"><?php  echo t('Please enter your Site ID. Usually "1" is the default account.')?></div>
<?php   } ?>
<?php   } ?>
<!--End Welcome Questions-->




<!--Configuration Form -->
<!--Start Hide From All Except SuperUser-->
<?php  if ($pwsuperu=="true")
{
$u = new User(); 
if(!$u->isSuperUser()) { // if not superuser
echo '<div id="piwik-settings-form-wrap" style="display:none">';
}
  else
echo '';
 }
 ?>
 <!--End Hide From All Except SuperUser-->
 
 
 
<!--Configuration Form Table-->
<div id="piwik-settings-form-wrap" <?php  if (empty($piwikurl)) echo 'style="display:none"' ?>>


<form method="post" action="<?php   echo $this->action('save_settings')?>" id="piwik-settings-form">
<table style="width: 80%; height: 133px; text-align: center; margin-left: auto; margin-right: auto;" border="1">
<tbody>
<tr>
<td style="vertical-align: center; width: 25%;">
<h4 style="margin:0; padding:0;"><?php  echo t('URL To Piwik') ?><br>
</h4>
<h5 style="margin:0; padding:0; text-align: left; line-height: 1.1;"><?php  echo t('Please ensure your URL starts with "http://" or "https://')?></h5>
</td>
<td style="text-align: center; width: 75%;"><input size="30" name="piwikurl"
value="<?php  echo $piwikurl ?>" type="text"></td>
</tr>
<tr>
<td style="vertical-align: center; width: 25%;">
<h4><?php  echo t('Site ID')?><br>
</h4>
</td>
<td style="text-align: center; width: 75%;"><input size="3" name="piwiksiteid"
value="<?php  echo $piwiksiteid ?>" type="text"></td>
</tr>
<tr>
<td style="vertical-align: center; width:25%;">
<h4 style="margin:0; padding:0;"><?php  echo t('Piwik Authkey')?>*<br>
</h4>
<h5 style="margin:0; padding:0; text-align: left; line-height: 1.1;"><?php  echo t('*If left blank users must login to their own account.')?></h5>
</td>
<td style="text-align: center; width: 75%;"><input size="60" name="pwauthkey"
value="<?php  echo $pwauthkey ?>" type="text">
</td>
</tr>
<!--final config-->
<tr>
<td style="vertical-align: center; width: 25%;;"><h4><?php  echo t('Lock Config')?></h4><br>
</td>
<td style="vertical-align: center; width: 75%;"><div id="piwik-settings-superuser" <?php  if (empty($pwsuperu) && $enable=="0") echo 'style="display:none"' ?>>
<?php  echo t('If checked only SuperUser can modify settings')?>
<input type="checkbox" name="pwsuperu" value="true"<?php  $pwsuperu?> 
<?php  if ($pwsuperu=="true")
 echo 'checked="checked"';
else
 echo '';
 ?>>
</div><br>
</td>
</tr>
<!--end config final-->

</tbody>
</table>
<!--End Configuration Form Table-->

<br/>
<div class="ccm-buttons">

 <!--Only Super User Can Modify Config-->
  <?php 
 if ($pwsuperu=="")
{
$u = new User(); 
if($u->isSuperUser()) { 

$enable = 1;

}
  else
$enable = 0;
 }
 ?>



<a href="javascript:void(0)" id="save_configuration" class="ccm-button-right accept"><span><?php   echo t('Save Configuration')?></span></a>
	
</div>	</div>
 <!--End Only Super User Can Modify Config-->
<!--End Configuration Form-->


<div class="ccm-spacer">&nbsp;</div>
</form>
</div>


</div>

<!--Javascript to make forms works-->
<script type="text/javascript">
$(document).ready(function(){
	$('#save_configuration').click(function(){
		$('#piwik-settings-form').get(0).submit();
	});
	$('#have_account_yes').click(function(){
		$('#have_account').hide();
		$('#piwik-settings-form-wrap').show();
		$('#welcome_message').hide();
		return false;
	});
	
});
</script>
<!--End of the line-->






