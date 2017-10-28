<?php
// namespace modules\mod_instantfblogin
/**
 * @package INSTANTFBLOGIN::modules
 * @subpackage mod_instantfblogin
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.user.helper' );

// Auto loader setup, register framework autoloader prefix
require_once dirname ( __FILE__ ) . '/helper.php';
require_once JPATH_ROOT . '/administrator/components/com_instantfblogin/framework/loader.php';
require_once JPATH_ROOT . '/components/com_instantfblogin/helpers/helper.php';
InstantfbloginLoader::setup ();
InstantfbloginLoader::registerPrefix ( 'Instantfblogin', JPATH_ROOT . '/administrator/components/com_instantfblogin/framework' );

// Load component translations
$jLang = JFactory::getLanguage ();
$jLang->load ( 'com_instantfblogin', JPATH_ROOT . '/components/com_instantfblogin', 'en-GB', true, true );
if ($jLang->getTag () != 'en-GB') {
	$jLang->load ( 'com_instantfblogin', JPATH_SITE, null, true, false );
	$jLang->load ( 'com_instantfblogin', JPATH_ROOT . '/components/com_instantfblogin', null, true, false );
}

// Params override
$params = JComponentHelper::getParams ( 'com_instantfblogin' );

// Session object used only for the Facebook login method
$ifblSession = JFactory::getSession();

// Facebook APP section
$fbLoginActive = $params->get('fblogin_active', null);
$appId = $params->get ( 'appId', null );
$secret = $params->get ( 'secret', null );

// GPlus app section
$gplusLoginActive = $params->get('gpluslogin_active', null);
$gplusClientId = $params->get ( 'gplusClientID', null );
$gplusKey = $params->get ( 'gplusKey', null );

// Twitter app section
$twitterLoginActive = $params->get('twitterlogin_active', null);
$twitterKey = $params->get ( 'twitterKey', null );
$twitterSecret = $params->get ( 'twitterSecret', null );

// Linkedin app section
$linkedinLoginActive = $params->get('linkedinlogin_active', null);
$linkedinAppid = $params->get ( 'linkedinAppid', null );
$linkedinSecret = $params->get ( 'linkedinSecret', null );

// If none of social login is valid set show a notice
if($fbLoginActive) {
	if (!($appId && $secret)) {
		echo JText::_ ( 'COM_INSTANTFBLOGIN_MISSING_FBSETUP_DATA' );
	}
}
if($gplusLoginActive) {
	if (!($gplusClientId && $gplusKey)) {
		echo JText::_ ( 'COM_INSTANTFBLOGIN_MISSING_GPLUSSETUP_DATA' );
	}
}

// Instantiate main application objects
$filter = JFilterInput::getInstance ();
$joomlaUserObject = JFactory::getUser ();
$app = JFactory::getApplication ();
$doc = JFactory::getDocument ();
$router = $app->getRouter ();
$moduleLinks = array();
$layout = 'default';
$rememberVisible = $params->get ( 'remember_me', 0 ) <= 1 ? '' : 'style="display:none;"';
$rememberChecked = $params->get ( 'remember_me', 0 ) % 2 ? 'checked="checked"' : '';

// Detect user status loggedin/loggedout and generate right redirect link after corresponding action
$redirectLinkType = ( bool ) $joomlaUserObject->get ( 'guest', 0 ) ? 'login' : 'logout';
$return = modInstantfbloginHelper::getReturnURL ( $params, $router, $app, $redirectLinkType );

// Include socials connectors
if($fbLoginActive) {
	include_once 'socials/facebook.php';
}
if($gplusLoginActive) {
	include_once 'socials/google.php';
}
if($twitterLoginActive) {
	include_once 'socials/twitter.php';
}

if($linkedinLoginActive) {
	include_once 'socials/linkedin.php';
}

// Add module stylesheet and scripts
if($params->get('use_modal_lightbox', 0)) {
	if($params->get('include_jquery', 1)) {
		JHtml::_('jquery.framework');
	}
	$doc->addStyleSheet ( JUri::base ( true ) . '/components/com_instantfblogin/css/bootstrap-interface.css' );
	$doc->addScript ( JURI::root ( true ) . '/components/com_instantfblogin/js/bootstrap-interface.js' );
	$layout = 'modal';
}

$doc->addStyleSheet ( JUri::base ( true ) . '/modules/mod_instantfblogin/assets/css/style.css' );
$doc->addScript ( JURI::root ( true ) . '/modules/mod_instantfblogin/assets/js/jsapp.js' );

$doc->addScriptDeclaration ( "var ifblAppId = '$appId';" );
// Load the SDK Asynchronously after ifblAppId evaluation
$sdkLoadMode = $params->get('sdkloadmode', 2);

// Setup sdk language
$sdkVersion = $params->get ( 'sdkversion', '2.5' );
$doc->addScriptDeclaration ( "var ifblSdkVersion = 'v$sdkVersion';" );
// Yes overwrite mode
if($sdkLoadMode == 2) {
	InstantfbloginHelper::injectFacebookSDK($doc, false);
} elseif($sdkLoadMode == 1) { // Yes no overwrite
	InstantfbloginHelper::injectFacebookSDK($doc, true);
} else {
	// Don't load FB SDK
}

JHtml::_ ( 'behavior.keepalive' );
JHtml::_ ( 'behavior.modal' );

// Generate and store module links based on integration type
modInstantfbloginHelper::generateLinks($moduleLinks, $params);

// Require module templates, both for standard Joomla login form and facebook button addon
require JModuleHelper::getLayoutPath ( 'mod_instantfblogin', $params->get ( 'layout', $layout ) );