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

$gplusLoginURL = null;
if($app->input->get('crioslogin', 0)) {
	return;
}

// Google Plus Login URL generation - Execute only if GPlus login is enabled
try {
	// Generate GPlus login URL if the user is a guest
	if ($joomlaUserObject->guest) {
		$googleAPI = new InstantfbloginGoogleLogin($gplusClientId, $gplusKey, JUri::base(), true);
		$gplusLoginURL = $googleAPI->init()->getLoginUrl();
		JFactory::getApplication()->set('ifblgp_login_url', $gplusLoginURL);
	}

	// Load avatars if any and if a user is not a guest
	if(!$joomlaUserObject->guest) {
		if($ifblSession->get('socialLoginType') == 'google' && !$joomlaUserObject->guest) {
			$socialPic = modInstantfbloginHelper::getGPlusPicture($joomlaUserObject->id);
		}
	}
} catch ( InstantfbloginException $e ) {
	$fbUserID = null;
	$app->enqueueMessage($e->getMessage(), $e->getErrorLevel());
} catch ( Exception $e ) {
	$fbUserID = null;
	$ifblException = new InstantfbloginException($e->getMessage(), 'error');
	$app->enqueueMessage(JText::sprintf('COM_INSTANTFBLOGIN_ERROR_GPLUS_LOGIN', $e->getMessage ()), 'warning');
}

// Google Plus Login - Execute only after link click to perform Google login, after Google redirects back
if ($joomlaUserObject->guest && ( bool ) $app->input->getString ( 'code', false ) && ( bool ) !$app->input->getString ( 'state', false )) {
	try {
		$googleAPI = new InstantfbloginGoogleLogin($gplusClientId, $gplusKey, JUri::base(), true);
		$googleUserObject = $googleAPI->init()->loginCallback($app->input->getString ( 'code' ));

		// Check if users exists already in the Joomla database using email address as primary key, retrieve user id if exists
		$authType = $params->get('auth_type', 'id');
		$joomlaIdentifier = $authType == 'id' ? $googleUserObject->getUid() : $googleUserObject->getEmailAddress();
		$alreadyCreatedJoomlaUserID = modInstantfbloginHelper::getJoomlaId ( $joomlaIdentifier, $authType );

		// Set login type in session
		$ifblSession->set('socialLoginType', 'google');

		// Get plugin observer instance
		$dispatcher = JDispatcher::getInstance ();
		JPluginHelper::importPlugin ( 'system' );

		if (! $alreadyCreatedJoomlaUserID) {
			$email = $googleUserObject->getEmailAddress();

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
			$dispatcher->trigger ( 'onGoogleNewUser', array (
					$joomlaUserObject,
					$googleUserObject,
					$params
			) );

			// Do instant Joomla login authentication with new user, aggregated data and random generated password only for login purpouse
			$dispatcher->trigger ( 'onGoogleLogin', array (
					$joomlaUserObject,
					$return,
					$params
			) );
		} else {
			// get already populated $joomlaUserObject
			$joomlaUserObject = JFactory::getUser ( $alreadyCreatedJoomlaUserID );
			// Do instant Joomla login authentication with new user, aggregated data and random generated password only for login purpouse
			$dispatcher->trigger ( 'onGoogleLogin', array (
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
		$app->enqueueMessage(JText::sprintf('COM_INSTANTFBLOGIN_ERROR_GPLUS_LOGIN', $e->getMessage ()), 'warning');
	}
}