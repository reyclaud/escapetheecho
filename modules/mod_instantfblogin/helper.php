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
class modInstantfbloginHelper {
	/**
	 * Manage the redirection url routing after a login has been completed
	 *
	 * @param Object $params
	 * @param Object $router
	 * @param Object $app
	 * @param string $redirectLinkType
	 * @return string
	 */
	public static function getReturnURL($params, $router, $app, $redirectLinkType) {
		$url = null;
		$uriInstance = JUri::getInstance();
		$domain = $uriInstance->getScheme() . '://' . $uriInstance->getHost();
		if ($itemid = $params->get ( $redirectLinkType )) {
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true );
			$query->select ( $db->quoteName ( 'link' ) );
			$query->from ( $db->quoteName ( '#__menu' ) );
			$query->where ( $db->quoteName ( 'published' ) . '=1' );
			$query->where ( $db->quoteName ( 'id' ) . '=' . $db->quote ( $itemid ) );
			$db->setQuery ( $query );
			if ($link = $db->loadResult ()) {
				if ($router->getMode () == JROUTER_MODE_SEF) {
					$url = $domain . (JRoute::_ ( 'index.php?Itemid=' . $itemid ));
				} else {
					$url = $link . '&Itemid=' . $itemid;
				}
			}
		}
		if (! $url) {
			// stay on the same page
			$uri = clone JFactory::getURI ();
			$vars = $router->parse ( $uri );
			unset ( $vars ['lang'] );
			if ($router->getMode () == JROUTER_MODE_SEF) {
				if (isset ( $vars ['Itemid'] )) {
					$itemid = $vars ['Itemid'];
					$menu = $app->getMenu ();
					$item = $menu->getItem ( $itemid );
					unset ( $vars ['Itemid'] );
					$url = $domain . (JRoute::_ ( 'index.php?Itemid=' . $itemid ));
				} else {
					$url = $domain . (JRoute::_ ( 'index.php?' . JURI::buildQuery ( $vars ), false ));
				}
			} else {
				$url = 'index.php?' . JURI::buildQuery ( $vars );
			}
		}

		$bas64FunctionNameEncode = 'base'. 64 . '_encode';
		$bas64FunctionNameDecode = 'base'. 64 . '_decode';
		return $bas64FunctionNameEncode ( $url );
	}

	/**
	 * Find if the FB user id is already registered in this Joomla system
	 * and in this case return the Joomla user id assigned
	 *
	 * @param string $userIdentifier
	 *        	It can be facebook app scoped user id or email address
	 * @param string $email        	
	 * @return int
	 */
	public static function getJoomlaId($userIdentifier, $authType = 'id') {
		$db = JFactory::getDbo ();
		// Mapping for auth types
		$mapping = array('id'=>'fb_uid', 'email'=>'email');
		$authType = $mapping[$authType];
		
		$query = "SELECT " . $db->quoteName('j_uid') .
				 "\n FROM #__instantfblogin" . 
				 "\n WHERE" . $db->quoteName($authType) . " = " . $db->quote ( $userIdentifier );
		$db->setQuery ( $query );
		$userExistsID = $db->loadResult ();
		
		return $userExistsID;
	}
	
	/**
	 * Load the Google plus avatar picture from the database
	 *
	 * @param int $userID
	 * @return string
	 */
	public static function getGPlusPicture($userID) {
		$db = JFactory::getDbo ();

		$query = "SELECT " . $db->quoteName('picture') .
				 "\n FROM #__instantfblogin" .
				 "\n WHERE" . $db->quoteName('j_uid') . " = " . (int)$userID .
				 "\n AND " . $db->quoteName('account_type') . " = " . $db->quote('goog');
		$db->setQuery ( $query );
		$userExistsGPlusPicture = $db->loadResult ();

		return $userExistsGPlusPicture;
	}
	
	/**
	 * Load the Google plus avatar picture from the database
	 *
	 * @param int $userID
	 * @return string
	 */
	public static function getTwitterPicture($userID) {
		$db = JFactory::getDbo ();
	
		$query = "SELECT " . $db->quoteName('picture') .
				 "\n FROM #__instantfblogin" .
				 "\n WHERE" . $db->quoteName('j_uid') . " = " . (int)$userID .
				 "\n AND " . $db->quoteName('account_type') . " = " . $db->quote('twit');
				 $db->setQuery ( $query );
		$userExistsTwitterPicture = $db->loadResult ();
	
		return $userExistsTwitterPicture;
	}
	
	/**
	 * Load the Google plus avatar picture from the database
	 *
	 * @param int $userID
	 * @return string
	 */
	public static function getLinkedinPicture($userID) {
		$db = JFactory::getDbo ();
	
		$query = "SELECT " . $db->quoteName('picture') .
				 "\n FROM #__instantfblogin" .
				 "\n WHERE" . $db->quoteName('j_uid') . " = " . (int)$userID .
				 "\n AND " . $db->quoteName('account_type') . " = " . $db->quote('lkin');
		$db->setQuery ( $query );
		$userExistsLinkedinPicture = $db->loadResult ();
	
		return $userExistsLinkedinPicture;
	}
	
	/**
	 * Check if the current social loggin in user is already present in the Joomla database by email matching
	 * @param string $email
	 * @throws InstantfbloginException
	 */
	public static function checkExistingUser($email) {
		$db = JFactory::getDbo();
		$existsEmailAddressQuery = 	"SELECT" . $db->quoteName('id') .
									"\n FROM #__users" .
									"\n WHERE" . $db->quoteName('email') . " = " .  $db->quote($email);
		$existsUser = $db->setQuery($existsEmailAddressQuery)->loadResult();
		
		if(!$existsUser) {
			throw new InstantfbloginException(JText::_('COM_INSTANTFBLOGIN_DISALLOWED_LOGIN_TO_UNREGISTERED_USERS'), 'warning');
		}
		
		return true;
	}
	
	/**
	 * Calculates and store module links based on the type of integration
	 *
	 * @param array& $moduleLinks
	 * @param Object $params
	 * @return array
	 */
	public static function generateLinks(&$moduleLinks, $params) {
		jimport('joomla.filesystem.folder');
		$linksIntegrationType = $params->get ( '3pdintegration_links', null);
		if ($linksIntegrationType == "jomsocial" && file_exists ( JPATH_BASE . '/components/com_community/libraries/core.php' )) { // JomSocial
			$jspath = JPATH_BASE . '/components/com_community';
			include_once ($jspath . '/libraries/core.php');
			$moduleLinks['registerLink'] = CRoute::_ ( 'index.php?option=com_community&view=register' );
			$moduleLinks['profileLink'] = CRoute::_ ( 'index.php?option=com_community&view=profile' );
			$moduleLinks['forgotUsernameLink'] = JRoute::_ ( 'index.php?option=com_users&view=remind', false );
			$moduleLinks['forgotPasswordLink'] = JRoute::_ ( 'index.php?option=com_users&view=reset', false );
		} else if ($linksIntegrationType == 'easysocial' && file_exists ( JPATH_ADMINISTRATOR . '/components/com_easysocial/includes/foundry.php' )) { //Easysocial
			include_once (JPATH_ADMINISTRATOR . '/components/com_easysocial/includes/foundry.php');
			$moduleLinks['registerLink'] = FRoute::registration ();
			$moduleLinks['profileLink'] = FRoute::profile ();
			if (method_exists ( 'FRoute', 'getDefaultItemId' ))
				$Itemid = '&Itemid=' . FRoute::getDefaultItemId ( 'account' );
			else
				$Itemid = '';
			$moduleLinks['forgotUsernameLink'] = JRoute::_ ( 'index.php?option=com_easysocial&view=account&layout=forgetUsername' . $Itemid );
			$moduleLinks['forgotPasswordLink'] = JRoute::_ ( 'index.php?option=com_easysocial&view=account&layout=forgetpassword' . $Itemid );
		} else if ($linksIntegrationType == "cbuilder" && file_exists ( JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.foundation.php' )) { //CB
			$moduleLinks['registerLink'] = JRoute::_ ( "index.php?option=com_comprofiler&task=registers", false );
			$moduleLinks['profileLink'] = JRoute::_ ( "index.php?option=com_comprofiler", false );
			$forgotLink = JRoute::_ ( "index.php?option=com_comprofiler&task=lostPassword" );
			$moduleLinks['forgotUsernameLink'] = $forgotLink;
			$moduleLinks['forgotPasswordLink'] = $forgotLink;
		} else if ($linksIntegrationType == "virtuemart" && file_exists ( JPATH_ADMINISTRATOR . '/components/com_virtuemart/version.php' )) { // Virtuemart
			require_once (JPATH_ADMINISTRATOR . '/components/com_virtuemart/version.php');
			if (class_exists ( 'vmVersion' ) && property_exists ( 'vmVersion', 'RELEASE' )) {
				if (version_compare ( '1.99', vmVersion::$RELEASE )) // -1 if ver1, 1 if 2.0+
					$moduleLinks['registerLink'] = JRoute::_ ( "index.php?option=com_virtuemart&view=user", false );
				else {
					if (file_exists ( JPATH_SITE . '/components/com_virtuemart/virtuemart_parser.php' )) {
						require_once (JPATH_SITE . '/components/com_virtuemart/virtuemart_parser.php');
						global $sess;
						if(is_object($sess)) {
							$moduleLinks['registerLink'] = $sess->url ( SECUREURL . 'index.php?option=com_virtuemart&amp;page=shop.registration' );
						}
					}
				}
			}
			$moduleLinks['profileLink'] = JRoute::_ ( 'index.php?option=com_users&view=profile', false );
			$moduleLinks['forgotUsernameLink'] = JRoute::_ ( 'index.php?option=com_users&view=remind', false );
			$moduleLinks['forgotPasswordLink'] = JRoute::_ ( 'index.php?option=com_users&view=reset', false );
		} else if ($linksIntegrationType == 'kunena' && JFolder::exists ( JPATH_SITE . '/components/com_kunena' )) { // Kunena
			$moduleLinks['registerLink'] = JRoute::_ ( 'index.php?option=com_users&view=registration', false );
			$moduleLinks['profileLink'] = JRoute::_ ( 'index.php?option=com_kunena&view=user', false );
			$moduleLinks['forgotUsernameLink'] = JRoute::_ ( 'index.php?option=com_users&view=remind', false );
			$moduleLinks['forgotPasswordLink'] = JRoute::_ ( 'index.php?option=com_users&view=reset', false );
		} else { // Default Joomla
			$moduleLinks['registerLink'] = JRoute::_ ( 'index.php?option=com_users&view=registration', false );
			$moduleLinks['profileLink'] = JRoute::_ ( 'index.php?option=com_users&view=profile', false );
			$moduleLinks['forgotUsernameLink'] = JRoute::_ ( 'index.php?option=com_users&view=remind', false );
			$moduleLinks['forgotPasswordLink'] = JRoute::_ ( 'index.php?option=com_users&view=reset', false );
		}

		return $moduleLinks;
	}
}