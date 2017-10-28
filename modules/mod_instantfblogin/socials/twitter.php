<?php
// namespace modules\mod_instantfblogin\socials
/**
 * @package INSTANTFBLOGIN::modules
 * @subpackage mod_instantfblogin
 * @subpackage socials
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ();

$twitterLoginURL = null;
$alwaysNew = $params->get('twitter_token_alwaysnew', 1);

// Twitter Login URL generation - Execute only if Twitter login is enabled and user is not logged in
try {
	// Generate Twitter login URL if the user is a guest
	if (($alwaysNew || !isset($_SESSION ['ifbltw_request_token'])) && $joomlaUserObject->guest && ( bool ) !$app->input->getString ( 'oauth_token', false )) {
		$bas64FunctionNameDecode = 'base'. 64 . '_decode';
		$returnUrlCallback = $bas64FunctionNameDecode ( $return );
		
		$connection = new InstantfbloginTwitterLogin($twitterKey, $twitterSecret);
		
		$uriInstance = JUri::getInstance();
		$domain = rtrim($uriInstance->getScheme() . '://' . $uriInstance->getHost(), '/');
		$request_token = $connection->getRequestToken ( $returnUrlCallback ); // get Request Token
		
		if ($request_token && isset($request_token ['oauth_token'])) {
			$token = $request_token ['oauth_token'];
			$_SESSION ['ifbltw_request_token'] = $token;
			$_SESSION ['ifbltw_request_token_secret'] = $request_token ['oauth_token_secret'];
			
			switch ($connection->http_code) {
				case 200 :
					$twitterLoginURL = $connection->getAuthorizeURL ( $token );
					$_SESSION ['ifbltw_login_url'] = $twitterLoginURL;
					JFactory::getApplication()->set('ifbltw_login_url', $twitterLoginURL);
					break;
			}
		}
	} else {
		$twitterLoginURL = @$_SESSION ['ifbltw_login_url'];
		JFactory::getApplication()->set('ifbltw_login_url', $twitterLoginURL);
	}

	// Load avatars if any and if a user is not a guest
	if(!$joomlaUserObject->guest) {
		if($ifblSession->get('socialLoginType') == 'twitter' && !$joomlaUserObject->guest) {
			$socialPic = modInstantfbloginHelper::getTwitterPicture($joomlaUserObject->id);
		}
	}
} catch ( InstantfbloginException $e ) {
	$fbUserID = null;
	$app->enqueueMessage($e->getMessage(), $e->getErrorLevel());
} catch ( Exception $e ) {
	$fbUserID = null;
	$ifblException = new InstantfbloginException($e->getMessage(), 'error');
	$app->enqueueMessage(JText::sprintf('COM_INSTANTFBLOGIN_ERROR_TWITTER_LOGIN', $e->getMessage ()), 'warning');
}

// Google Plus Login - Execute only after link click to perform Google login, after Google redirects back
if ($joomlaUserObject->guest && ( bool ) $app->input->getString ( 'oauth_token', false ) && ( bool ) $app->input->getString ( 'oauth_verifier', false )) {
	try {
		$connection = new InstantfbloginTwitterLogin($twitterKey, $twitterSecret, $_SESSION['ifbltw_request_token'], $_SESSION['ifbltw_request_token_secret']);
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
		if(isset($access_token['oauth_token'])) {
			$connection = new InstantfbloginTwitterLogin($twitterKey, $twitterSecret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$twitterParams =array();
			$twitterParams['include_entities']='false';
			$twitterUserObject = $connection->get('account/verify_credentials', $twitterParams);
		} else {
			$error = array_keys($access_token);
			throw new InstantfbloginException ( JText::sprintf('COM_INSTANTFBLOGIN_ERROR_TWITTER_LOGIN', array_pop($error)), 'warning' );
		}

		// Set login type in session
		$ifblSession->set('socialLoginType', 'twitter');
		
		// Check if users exists already in the Joomla database using email address as primary key, retrieve user id if exists
		$authType = 'id';
		$joomlaIdentifier = 'tw' . $twitterUserObject->id_str;
		$alreadyCreatedJoomlaUserID = modInstantfbloginHelper::getJoomlaId ( $joomlaIdentifier, $authType );
		$twitterUserObject->email = $joomlaIdentifier . '@twitter.com';
		$twitterUserObject->joomlaIdentifier = $joomlaIdentifier;

		// Get plugin observer instance
		$dispatcher = JDispatcher::getInstance ();
		JPluginHelper::importPlugin ( 'system' );

		if (! $alreadyCreatedJoomlaUserID) {
			// Trigger to create a new Joomla user aggregating data from Facebook user profile, pre-populate bind $joomlaUserObject
			$dispatcher->trigger ( 'onTwitterNewUser', array (
					$joomlaUserObject,
					$twitterUserObject,
					$params
			) );

			// Do instant Joomla login authentication with new user, aggregated data and random generated password only for login purpouse
			$dispatcher->trigger ( 'onTwitterLogin', array (
					$joomlaUserObject,
					$return,
					$params
			) );
		} else {
			// get already populated $joomlaUserObject
			$joomlaUserObject = JFactory::getUser ( $alreadyCreatedJoomlaUserID );
			// Do instant Joomla login authentication with new user, aggregated data and random generated password only for login purpouse
			$dispatcher->trigger ( 'onTwitterLogin', array (
					$joomlaUserObject,
					$return,
					$params
			) );
		}
	} catch ( InstantfbloginException $e ) {
		$fbUserID = null;
		$app->enqueueMessage($e->getMessage(), $e->getErrorLevel());
	} catch ( Exception $e ) {
		$fbUserID = null;
		$ifblException = new InstantfbloginException($e->getMessage(), 'error');
		$app->enqueueMessage(JText::sprintf('COM_INSTANTFBLOGIN_ERROR_TWITTER_LOGIN', $e->getMessage ()), 'warning');
	}
}