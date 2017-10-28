<?php
// namespace modules\mod_instantfblogin
/**
 * @package INSTANTFBLOGIN::modules
 * @subpackage mod_instantfblogin_posts
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ();

$clearer = null;
$doc = JFactory::getDocument();
if($params->get('module_posts_floating_boxes', 1)) {
	$doc->addStyleDeclaration('div.fb_iframe_widget,div.ifblgplus,iframe.twitter-timeline{float:left;}');
	$doc->addStyleDeclaration('div.fb_iframe_widget{margin-bottom:20px;}');
	$clearer = '<div style="clear:left"></div>';
}
$doc->addStyleDeclaration('div.fb_iframe_widget,div.ifblgplus{overflow:auto;max-width:100%;}');

?>
<div class="ifbl-posts-container" style="clear: both;">
<?php
// Require module template for the Facebook posts widget
if($params->get('module_posts_fb_enabled', 1)) {
	require_once JPATH_ROOT . '/components/com_instantfblogin/helpers/helper.php';
	// Require Facebook SDK if missing loading by login module and social buttons and other modules comments
	InstantfbloginHelper::injectFacebookSDK($doc, true);
	
	require JModuleHelper::getLayoutPath ( 'mod_instantfblogin_posts', $params->get ( 'layout', 'default_facebook' ) );
}

// Require module template for the Google posts widget. Notice that NO SDK are required and loaded, but only a custom script to use G+ API
if($params->get('module_posts_google_enabled', 0)) {
	$doc->addStyleSheet ( JUri::base ( true ) . '/modules/mod_instantfblogin_posts/assets/css/style.css' );
	$doc->addScript ( JUri::root ( true ) . '/modules/mod_instantfblogin_posts/assets/js/jsapp.js' );
	
	$googleWidgetWidth = (int)$params->get('module_posts_google_width', 340);
	$googleWidgetHeight = (int)$params->get('module_posts_google_height', 500);
	$doc->addStyleDeclaration('div.ifblgplus{width:' . $googleWidgetWidth . 'px;height:' . $googleWidgetHeight . 'px;}');
	$doc->addScriptDeclaration('var ifblGooglePostsApiKey="' . $params->get('module_posts_google_apikey', 'AIzaSyCUGl_fXs5TEABpAVLEimbu4yPsgMGxTI8') . '";');
	$doc->addScriptDeclaration('var ifblGooglePostsUser="' . $params->get('module_posts_google_user', '+google') . '";');
	$doc->addScriptDeclaration('var ifblGooglePostsMaxResults=' . (int)$params->get('module_posts_google_maxresults', 10) . ';');
	
	require JModuleHelper::getLayoutPath ( 'mod_instantfblogin_posts', $params->get ( 'layout', 'default_google' ) );
}


// Require module template for the Twitter posts widget
if($params->get('module_posts_twitter_enabled', 1)) {
	// Require Twitter SDK
	$doc->addScriptDeclaration ('window.twttr=function(t,e,r){var n,i=t.getElementsByTagName(e)[0],w=window.twttr||{};return t.getElementById(r)?w:(n=t.createElement(e),n.id=r,n.src="https://platform.twitter.com/widgets.js",i.parentNode.insertBefore(n,i),w._e=[],w.ready=function(t){w._e.push(t)},w)}(document,"script","twitter-wjs");');
	require JModuleHelper::getLayoutPath ( 'mod_instantfblogin_posts', $params->get ( 'layout', 'default_twitter' ) );
}
?>
</div>
<?php
echo $clearer;