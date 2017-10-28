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

// Facebook Login - Execute only on self page reload url after Facebook JS SDK login completed
if ($joomlaUserObject->guest && ( bool ) $app->input->getInt ( 'fblogin', false )) {
	try {
		// Instantiate main Facebook API library class object, pass in Application ID and secret code
		$facebookAPI = new InstantfbloginFacebook ( array (
				'appId' => $appId,
				'secret' => $secret
		) );

		// Check if SSL peer verification is enabled
		if(!$params->get('curl_ssl_verifypeer', true)) {
			InstantfbloginFacebookBase::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
		}

		// Retrieve info about current Facebook user using API to get user integer identifier
		$fbUserID = $facebookAPI->getUser ();
		if(!$fbUserID) {
			// Patch for iOS Chrome login on first attempt when the user is not already logged into Facebook
			if($app->input->getInt('crioslogin', null)) {
				$app->enqueueMessage(JText::_('COM_INSTANTFBLOGIN_CRIOS_LOGIN_COMPLETE'));
				return;
			}
			throw new InstantfbloginException(JText::_('COM_INSTANTFBLOGIN_FBUSERID_NOTFOUND'), 'warning');
		}
		$ifblSession->set('fbUserID', $fbUserID);
		$ifblSession->set('socialLoginType', 'facebook');

		// Retrieve full Facebook user profile informations using Facebook API
		$fbUserProfileArray = $facebookAPI->api ( '/me?fields=id,email,name,first_name,last_name,link,locale,timezone,updated_time,verified,birthday,picture,gender,location' );

		// Check if users exists already in the Joomla database using email address as primary key, retrieve user id if exists
		$authType = $params->get('auth_type', 'id');
		$alreadyCreatedJoomlaUserID = modInstantfbloginHelper::getJoomlaId ( $fbUserProfileArray [$authType], $authType );

		// Get plugin observer instance
		$dispatcher = JDispatcher::getInstance ();
		JPluginHelper::importPlugin ( 'system' );

		if (! $alreadyCreatedJoomlaUserID) {
			$name = @$fbUserProfileArray ['name'];
			$username = strtolower ( $filter->clean ( @$fbUserProfileArray ['name'], 'username' ) );
			// This Facebook account as no username, for example a Facebook page
			if (! $name) {
				$name = $fbUserProfileArray ['email'] ? $fbUserProfileArray ['email'] : $fbUserProfileArray ['id'] . '@facebook.com';
			}
			if (! $username) {
				$username = $fbUserProfileArray ['email'] ? $fbUserProfileArray ['email'] : $fbUserProfileArray ['id'] . '@facebook.com';
			}
			$password = JUserHelper::genRandomPassword ( 5 );
			$email = $fbUserProfileArray ['email'] ? $fbUserProfileArray ['email'] : $fbUserProfileArray ['id'] . '@facebook.com';
				
			// Check if this email address is not banned
			$bannedEmailAddress = $params->get('banned_email_address', null);
			if($bannedEmailAddress) {
				$bannedEmailAddress = explode(PHP_EOL, $bannedEmailAddress);
				if(is_array($bannedEmailAddress) && count($bannedEmailAddress)) {
					foreach ($bannedEmailAddress as $bannedEmail) {
						$validAddress = filter_var($bannedEmail, FILTER_VALIDATE_EMAIL);
						if($validAddress && $email == $bannedEmail) {
							throw new InstantfbloginException(JText::_('COM_INSTANTFBLOGIN_EMAIL_BANNED'), 'warning');
						}
					}
				}
			}

			// Check if only already existing users must be allowed to login through socials
			if($params->get('allow_only_existing_users', 0)) {
				modInstantfbloginHelper::checkExistingUser($email);
			}

			// Trigger to create a new Joomla user aggregating data from Facebook user profile, pre-populate bind $joomlaUserObject
			$dispatcher->trigger ( 'onFacebookNewUser', array (
					$joomlaUserObject,
					$name,
					$username,
					$password,
					$email,
					$fbUserProfileArray,
					$params
			) );
				
			// Do instant Joomla login authentication with new user, aggregated data and random generated password only for login purpouse
			$dispatcher->trigger ( 'onFacebookLogin', array (
					$joomlaUserObject,
					$return,
					$params
			) );
		} else {
			// get already populated $joomlaUserObject
			$joomlaUserObject = JFactory::getUser ( $alreadyCreatedJoomlaUserID );
			// Do instant Joomla login authentication with new user, aggregated data and random generated password only for login purpouse
			$dispatcher->trigger ( 'onFacebookLogin', array (
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
		$app->enqueueMessage(JText::sprintf('COM_INSTANTFBLOGIN_ERROR_FACEBOOK_LOGIN', $e->getMessage ()), 'warning');
	}
}