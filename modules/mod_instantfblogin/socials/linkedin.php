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
if(version_compare(PHP_VERSION, '5.4', '<') || $app->input->get('crioslogin', 0)) {
	$linkedinLoginURL = null;
	return;
}
if (!function_exists('React\Promise\resolve')) {
	require_once JPATH_ADMINISTRATOR . '/components/com_instantfblogin/framework/React/Promise/functions.php';
}

InstantfbloginLoader::register('InstantfbloginHappyrLinkedin', JPATH_ADMINISTRATOR . '/components/com_instantfblogin/framework/Happyr/linkedin.php');
InstantfbloginLoader::registerNamespace('Happyr\LinkedIn', JPATH_ADMINISTRATOR . '/components/com_instantfblogin/framework');
InstantfbloginLoader::registerNamespace('GuzzleHttp', JPATH_ADMINISTRATOR . '/components/com_instantfblogin/framework');
InstantfbloginLoader::registerNamespace('React', JPATH_ADMINISTRATOR . '/components/com_instantfblogin/framework');

$linkedinLoginURL = null;
$linkedIn = new InstantfbloginHappyrLinkedin($linkedinAppid, $linkedinSecret);

try {
	if ($linkedIn->isAuthenticated() && $joomlaUserObject->guest) {
		if($linkedIn->hasError()) {
			throw new InstantfbloginException ( JText::sprintf('COM_INSTANTFBLOGIN_ERROR_LINKEDIN_LOGIN', $linkedIn->getError()), 'warning' );
		}
	    	
	    //we know that the user is authenticated now. Start query the API
	    $linkedinUser = $linkedIn->get('v1/people/~:(firstName,lastName,emailAddress,id,pictureUrl)');
    	
    	// Set login type in session
    	$ifblSession->set('socialLoginType', 'linkedin');
    
    	// Check if users exists already in the Joomla database using email address as primary key, retrieve user id if exists
    	$authType = $params->get('auth_type', 'id');
    	$joomlaIdentifier = 'in' . $linkedinUser['id'];
    	$alreadyCreatedJoomlaUserID = modInstantfbloginHelper::getJoomlaId ( $joomlaIdentifier, $authType );
    	$linkedinUserObject = new stdClass();
    	$linkedinUserObject->firstname = $linkedinUser['firstName'];
    	$linkedinUserObject->lastname = $linkedinUser['lastName'];
    	$linkedinUserObject->email = $linkedinUser['emailAddress'];
    	$linkedinUserObject->pictureurl = $linkedinUser['pictureUrl'];
    	$linkedinUserObject->joomlaIdentifier = $joomlaIdentifier;
    
    	// Get plugin observer instance
    	$dispatcher = JDispatcher::getInstance ();
    	JPluginHelper::importPlugin ( 'system' );
    
    	if (! $alreadyCreatedJoomlaUserID) {
    		$email = $linkedinUserObject->email;
    		 
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
    		$dispatcher->trigger ( 'onLinkedinNewUser', array (
    				$joomlaUserObject,
    				$linkedinUserObject,
    				$params
    		) );
    
    		// Do instant Joomla login authentication with new user, aggregated data and random generated password only for login purpouse
    		$dispatcher->trigger ( 'onLinkedinLogin', array (
    				$joomlaUserObject,
    				$return,
    				$params
    		) );
    	} else {
    		// get already populated $joomlaUserObject
    		$joomlaUserObject = JFactory::getUser ( $alreadyCreatedJoomlaUserID );
    		// Do instant Joomla login authentication with new user, aggregated data and random generated password only for login purpouse
    		$dispatcher->trigger ( 'onLinkedinLogin', array (
    				$joomlaUserObject,
    				$return,
    				$params
    		) );
    	}
	}
} catch ( InstantfbloginException $e ) {
 	$fbUserID = null;
   	$app->enqueueMessage($e->getMessage(), $e->getErrorLevel());
} catch ( Exception $e ) {
   	$fbUserID = null;
   	$ifblException = new InstantfbloginException($e->getMessage(), 'error');
   	$app->enqueueMessage(JText::sprintf('COM_INSTANTFBLOGIN_ERROR_LINKEDIN_LOGIN', $e->getMessage ()), 'warning');
}

//if not authenticated
if(!$linkedIn->isAuthenticated()) {
	$scope = array('r_emailaddress');
	$linkedinLoginURL = $linkedIn->getLoginUrl(array('scope'=>$scope));
	JFactory::getApplication()->set('ifbldn_login_url', $linkedinLoginURL);
}

// Load avatars if any and if a user is not a guest
if(!$joomlaUserObject->guest) {
	if($ifblSession->get('socialLoginType') == 'linkedin' && !$joomlaUserObject->guest) {
		$socialPic = modInstantfbloginHelper::getLinkedinPicture($joomlaUserObject->id);
	}
}