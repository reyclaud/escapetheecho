<?php
// namespace modules\mod_instantfblogin
/**
 * @package INSTANTFBLOGIN::modules
 * @subpackage mod_instantfblogin_comments
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ();

$doc = JFactory::getDocument();
$widgetHref = $params->get('module_comments_href', null);
$widgetColorScheme = $params->get('module_comments_colorscheme', 'light');
$widgetNumPosts = $params->get('module_comments_numposts', 10);
$widgetOrderBy = $params->get('module_comments_orderby', 'social');
$widgetWidth = $params->get('module_comments_width', '550px');
$widgetPositionment = $params->get('module_comments_positionment', 'absolute');

// Add the moderation meta tag
$cParams = JComponentHelper::getParams('com_instantfblogin');
$fbAppId = $cParams->get('appId', null);
if($fbAppId && !$doc->getMetaData('fb:app_id')) {
	$doc->addCustomTag("<meta property='fb:app_id' content='" . $fbAppId . "' />");
}

// Setup the href for the comments widget
if(!$widgetHref) {
	$widgetHref = JUri::current();
}

// Override the default Facebook IFrame absolute positionment
if($widgetPositionment == 'relative') {
	$doc = JFactory::getDocument();
	$doc->addStyleDeclaration('div.fb-comments.fb_iframe_widget iframe{position:relative;}');
}
$doc->addStyleDeclaration('div.fb-comments.fb_iframe_widget {float:none;clear:both;}');

// Require Facebook SDK if missing loading by login module and social buttons
require_once JPATH_ROOT . '/components/com_instantfblogin/helpers/helper.php';
InstantfbloginHelper::injectFacebookSDK($doc, true);

// Require module templates, both for standard Joomla login form and facebook button addon
require JModuleHelper::getLayoutPath ( 'mod_instantfblogin_comments', $params->get ( 'layout', 'default' ) );