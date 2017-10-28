<?php
// namespace components\com_instantfblogin\helpers;
/**
 * @package INSTANTFBLOGIN::HELPERS::components::com_instantfblogin
 * @subpackage helpers
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
 
/**
 * Base view for all display core
 * 
 * @package INSTANTFBLOGIN::HELPERS::components::com_instantfblogin
 * @subpackage helpers
 * @since 2.2
 */
class InstantfbloginHelper {
	/**
	 * Load the Facebook SDK using the override/no override method
	 * 
	 * @param object $doc
	 * @param boolean $noOverride
	 * @return void
	 */
	public static function injectFacebookSDK($doc, $noOverride = true) {
		static $injected = array();
		$castedOverride = (int)$noOverride;
		if(isset($injected[$castedOverride])) {
			return;
		}
		
		$noSdkOverrideSkip = null;
		
		// Load always a not overriding FB SDK
		$cParams = JComponentHelper::getParams('com_instantfblogin');
		$locale = JFactory::getLanguage ()->getTag();
		$sdkLangTag = str_replace("-", "_", $locale);
		$sdkVersion = $cParams->get ( 'sdkversion', '2.6' );
		$appId = $cParams->get ( 'appId', null );
		
		if($noOverride) {
			$noSdkOverrideSkip = 'if(d.getElementById(id)){return;}';
		}
							
		$doc->addScriptDeclaration ("(function(d) {
				var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];" .
				$noSdkOverrideSkip .
				"js = d.createElement('script');
				js.id = id;
				js.async = true;
				js.src = '//connect.facebook.net/$sdkLangTag/sdk.js#xfbml=1&version=v$sdkVersion&appId=$appId';
				ref.parentNode.insertBefore(js, ref);
		}(document));");
		
		$injected[$castedOverride] = true;
	}
}