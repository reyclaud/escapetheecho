<?php
/** 
 * Manage login/logout for Facebook connect
 * @package INSTANTFBLOGIN::plugins::system
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.plugin.plugin' );
class plgSystemInstantfblogin extends JPlugin {
	/** 
	 * Application object
	 * 
	 * @access private
	 * @var Object
	 */
	private $app;
	
	/**
	 * Database object
	 *
	 * @access private
	 * @var Object
	 */
	private $db;
	
	/**
	 * @param cParams
	 */
	private function userIntegration($tpdIntegration, $fbUsersTable, $joomlaUserObject) {
		// Manage third party extensions
		require_once JPATH_ADMINISTRATOR . '/components/com_instantfblogin/tables/custom.php';
		switch ($tpdIntegration) {
			case 'jomsocial':
				$tableInstance = new TableCustom('#__community_users', 'id', $this->db);
				$tableInstance->userid = $joomlaUserObject->id;
				$tableInstance->alias = $joomlaUserObject->id . ':' . $joomlaUserObject->username;
				if(!$tableInstance->store()) {
					throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_3PD_USER') . $tableInstance->getError (), 'notice' );
				}
				break;

			case 'easysocial':
				$tableInstance = new TableCustom('#__social_users', 'id', $this->db);
				$tableInstance->user_id = $joomlaUserObject->id;
				$tableInstance->state = 1;
				$tableInstance->type = 'joomla';
				try {
					$tableInstance->store();
				} catch (Exception $e) { }
				$tableInstance = new TableCustom('#__social_profiles_maps', 'id', $this->db);
				$tableInstance->profile_id = 1;
				$tableInstance->user_id = $joomlaUserObject->id;
				$tableInstance->state = 1;
				$tableInstance->created = $fbUsersTable->registered_on;
				try {
					$tableInstance->store();
				} catch (Exception $e) { }
				break;

			case 'cbuilder':
				$tableInstance = new TableCustom('#__comprofiler', 'userid', $this->db);
				$tableInstance->id = $tableInstance->user_id = $joomlaUserObject->id;
				$tableInstance->firstname = $fbUsersTable->first_name;
				$tableInstance->lastname = $fbUsersTable->last_name;
				$tableInstance->approved = 1;
				$tableInstance->confirmed = 1;
				if(!$tableInstance->store()) {
					throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_3PD_USER') . $tableInstance->getError (), 'notice' );
				}
				break;
		}
	}
	
	/**
	 * Send an email to all administrators if enabled in the com_user
	 *
	 * @param unknown $userData
	 * @param unknown $params
	 * @return boolean
	 */
	private function sendAdminNotification ($userData, $params) {
		// Send Notification mail to administrators
		if ($params->get('mail_to_admin') == 1) {
			$config = JFactory::getConfig();
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$jLang = JFactory::getLanguage ();
			$jLang->load ( 'com_users' );
				
			// Compile the notification mail values.
			$data['fromname'] = $config->get('fromname');
			$data['mailfrom'] = $config->get('mailfrom');
			$data['sitename'] = $config->get('sitename');
			$data['siteurl'] = JUri::root();
				
			$emailSubject = JText::sprintf(
					'COM_USERS_EMAIL_ACCOUNT_DETAILS',
					$userData['name'],
					$data['sitename']
			);
	
			$emailBodyAdmin = JText::sprintf(
					'COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY',
					$userData['name'],
					$userData['username'],
					$data['siteurl']
			);
	
			// Get all admin users
			$query->clear()
				  ->select($db->quoteName(array('name', 'email', 'sendEmail')))
				  ->from($db->quoteName('#__users'))
				  ->where($db->quoteName('sendEmail') . ' = ' . 1);
	
			$db->setQuery($query);
	
			try {
				$rows = $db->loadObjectList();
			}
			catch (RuntimeException $e) {
				return false;
			}
	
			// Send mail to all superadministrators id
			foreach ($rows as $row) {
				JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);
			}
		}
		return true;
	}
	
	/**
	 * onFacebookNewUser handler
	 *
	 * @access public
	 * @param Object $joomlaUserObject
	 * @param string $name        	
	 * @param string $username        	
	 * @param string $password        	
	 * @param string $email        	
	 * @param array $fbUserProfileArray
	 * @param Object $cParams        	
	 * @return null
	 */
	public function onFacebookNewUser($joomlaUserObject, $name, $username, $password, $email, $fbUserProfileArray, $cParams) {
		// Execute only on site application
		if (! $this->app->getClientId ()) {
			jimport ( 'joomla.application.component.helper' );
			$config = JComponentHelper::getParams ( 'com_users' );
			// Default to Registered.
			$defaultUserGroup = $cParams->get('new_usertype', $config->get ( 'new_usertype', 2 ));
			// Check if username already exists
			$query = "SELECT " . $this->db->quoteName('id') .
					 "\n FROM #__users" .
					 "\n WHERE " . $this->db->quoteName('username') . " = " . $this->db->quote($username);
			$existingUsername = $this->db->setQuery($query)->loadResult();
			if($existingUsername) {
				$username .= rand(1, 100);
			}
			
			$data = array (
					"name" => $name,
					"username" => $username,
					"groups" => array (
							$defaultUserGroup
					),
					"email" => $email
			);
			
			// Write to database
			if (! $joomlaUserObject->bind ( $data )) {
				throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_JOOMLA_USER') . $joomlaUserObject->getError (), 'warning' );
			}
			if (! $joomlaUserObject->save ()) {
				// Check if existing user and overwrite mode, don't throw exceptions but load that Joomla user object and go on to add a new IFBL record
				if(!$cParams->get('match_existing_users', 0)) {
					throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_JOOMLA_USER') . $joomlaUserObject->getError (), 'warning');
				} else {
					// Try to load data of existing user using the email address as p.key
					$query = "SELECT *" .
							 "\n FROM #__users" .
							 "\n WHERE " . $this->db->quoteName('email') . " = " . $this->db->quote($email);
					$existingData = $this->db->setQuery($query)->loadAssoc();
					$joomlaUserObject->bind($existingData);
				}
			}
			
			// Track auto created users from Facebook connect login into component db table
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_instantfblogin/tables');
			$fbUsersTable = JTable::getInstance('Users', 'Table');
			$fbUsersTable->j_uid = $joomlaUserObject->id;
			$fbUsersTable->fb_uid = $fbUserProfileArray['id'];
			$fbUsersTable->email = $fbUserProfileArray['email'];
			$fbUsersTable->first_name = isset($fbUserProfileArray['first_name']) ? $fbUserProfileArray['first_name'] : $name;
			$fbUsersTable->last_name = isset($fbUserProfileArray['last_name']) ? $fbUserProfileArray['last_name'] : $name;
			$fbUsersTable->name = isset($fbUserProfileArray['name']) ? $fbUserProfileArray['name'] : $name;
			$fbUsersTable->gender = isset($fbUserProfileArray['gender']) ? $fbUserProfileArray['gender'] : null;
			$fbUsersTable->geolocation = isset($fbUserProfileArray['locale']) ? $fbUserProfileArray['locale'] : null;
			$fbUsersTable->registered_on = JDate::getInstance()->toSql();
			$fbUsersTable->last_update = isset($fbUserProfileArray['updated_time']) ? $fbUserProfileArray['updated_time'] : null;
			$fbUsersTable->verified = isset($fbUserProfileArray['verified']) ? $fbUserProfileArray['verified'] : null;
			$fbUsersTable->account_type = isset($fbUserProfileArray['last_name']) ? 'user' : 'page';
			$fbUsersTable->picture = 'https://graph.facebook.com/'.$fbUserProfileArray['id'].'/picture?type=normal';

			if(! $fbUsersTable->store()) {
				throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_FB_USER') . $fbUsersTable->getError (), 'warning' );
			}
			
			// Call 3PD user integration function
			if($tpdIntegration = $cParams->get('3pdintegration', null)) {
				$this->userIntegration ( $tpdIntegration, $fbUsersTable, $joomlaUserObject );
			}
			
			// Notify administrators
			try {
				$this->sendAdminNotification($data, $config);
			} catch(Exception $e) {
				// No errors for email notification during the create user phase
			}
		}
	}
	
	/**
	 * onFacebookLogin handler
	 *
	 * @access public
	 * @param Object $joomlaUserObject
	 * @param string $return
	 * @param Object $cParams        	
	 * @return null
	 */
	public function onFacebookLogin($joomlaUserObject, $return, $cParams) {
		// Execute only on site application
		if (! $this->app->getClientId ()) {
			jimport ( 'joomla.user.helper' );

			$credentials = array ();
			$credentials ['username'] = $joomlaUserObject->username;
			
			// Check if existing user and overwrite mode, save the existing password
			if($cParams->get('match_existing_users', 0)) {
				$query = "SELECT " . $this->db->quoteName('password') .
						 "\n FROM #__users" .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$storedPassword = $this->db->loadResult ();

				// Reset a new user registration case
				$joomlaUserObject->password_clear = false;
			}
			
			// If newly created user, we have a password clear already generated
			if($joomlaUserObject->password_clear) {
				$credentials ['password'] = $joomlaUserObject->password_clear;
			} else {
				// Generate and use a temp random password just to login on the fly
				$password = JUserHelper::genRandomPassword();
				$credentials ['password'] = $password;
				
				// Go on to generate a random password for this on the fly login
				$hashedPassword = JUserHelper::getCryptedPassword($password);
				$query = "UPDATE #__users" .
						 "\n SET " . $this->db->quoteName('password') . " = " . $this->db->quote($hashedPassword) . 
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$this->db->execute ();
			}
			
			$options = array ();
			$options ['remember'] = true;
			$options ['silent'] = true;
			
			$loggedIn = $this->app->login ( $credentials, $options );
			
			// Check if existing user and overwrite mode, restore the original password
			if($cParams->get('match_existing_users', 0)) {
				$query = "UPDATE #__users" .
						 "\n SET " . $this->db->quoteName('password') . " = " . $this->db->quote($storedPassword) .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$this->db->execute ();
			}
			
			if($cParams->get('show_greetings_msg', 0)) {
				$customMessage = $cParams->get('greetings_msg', JText::_('COM_INSTANTFBLOGIN_SUCCESS_LOGIN'));
				$redirectArray = $loggedIn ? array('msg'=>$customMessage, 'status'=>'') : array('msg'=>'COM_INSTANTFBLOGIN_ERROR_' . 'LOGIN', 'status'=>'error');
			} else {
				$redirectArray = $loggedIn ? array('msg'=>'', 'status'=>'') : array('msg'=>'COM_INSTANTFBLOGIN_ERROR_' . 'LOGIN', 'status'=>'error');
			}
			
			$bas64FunctionNameEncode = 'base'. 64 . '_encode';
			$bas64FunctionNameDecode = 'base'. 64 . '_decode';
			$this->app->redirect ( $bas64FunctionNameDecode ( $return ), JText::_($redirectArray['msg']), $redirectArray['status']);
		}
	}
	
	/**
	 * onGoogleNewUser handler
	 *
	 * @access public
	 * @param Object $joomlaUserObject
	 * @param Object $cParams
	 * @return null
	 */
	public function onGoogleNewUser($joomlaUserObject, $googleUserObject, $cParams) {
		// Execute only on site application
		if (! $this->app->getClientId ()) {
			jimport ( 'joomla.application.component.helper' );
			$config = JComponentHelper::getParams ( 'com_users' );
			// Default to Registered.
			$defaultUserGroup = $cParams->get('new_usertype', $config->get ( 'new_usertype', 2 ));
				
			// Retrieve info user data
			$name = $googleUserObject->getFirstname() . ' ' . $googleUserObject->getLastname();
			$username = $googleUserObject->getUsername();
			$email = $googleUserObject->getEmailAddress();
			
			// Check if username already exists
			$query = "SELECT " . $this->db->quoteName('id') .
					 "\n FROM #__users" .
					 "\n WHERE " . $this->db->quoteName('username') . " = " . $this->db->quote($username);
			$existingUsername = $this->db->setQuery($query)->loadResult();
			if($existingUsername) {
				$username .= rand(1, 100);
			}
			
			$data = array (
					"name" => $name,
					"username" => $username,
					"groups" => array (
							$defaultUserGroup
					),
					"email" => $email
			);
				
			// Write to database
			if (! $joomlaUserObject->bind ( $data )) {
				throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_JOOMLA_USER') . $joomlaUserObject->getError (), 'warning' );
			}
			if (! $joomlaUserObject->save ()) {
				// Check if existing user and overwrite mode, don't throw exceptions but load that Joomla user object and go on to add a new IFBL record
				if(!$cParams->get('match_existing_users', 0)) {
					throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_JOOMLA_USER') . $joomlaUserObject->getError (), 'warning');
				} else {
					// Try to load data of existing user using the email address as p.key
					$query = "SELECT *" .
							 "\n FROM #__users" .
							 "\n WHERE " . $this->db->quoteName('email') . " = " . $this->db->quote($email);
					$existingData = $this->db->setQuery($query)->loadAssoc();
					$joomlaUserObject->bind($existingData);
				}
			}
				
			// Track auto created users from Facebook connect login into component db table
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_instantfblogin/tables');
			$fbUsersTable = JTable::getInstance('Users', 'Table');
			$fbUsersTable->j_uid = $joomlaUserObject->id;
			$fbUsersTable->fb_uid = $googleUserObject->getUid();
			$fbUsersTable->email = $googleUserObject->getEmailAddress();
			$fbUsersTable->first_name = $googleUserObject->getFirstname();
			$fbUsersTable->last_name = $googleUserObject->getLastname();
			$fbUsersTable->name = $name;
			$fbUsersTable->gender = $googleUserObject->getGender();
			$fbUsersTable->geolocation = $googleUserObject->getLocale();
			$fbUsersTable->registered_on = JDate::getInstance()->toSql();
			$fbUsersTable->last_update = null;
			$fbUsersTable->verified = null;
			$fbUsersTable->account_type = 'goog';
			$fbUsersTable->picture = $googleUserObject->getPicture();
	
			if(! $fbUsersTable->store()) {
				throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_FB_USER') . $fbUsersTable->getError (), 'warning' );
			}
				
			// Call 3PD user integration function
			if($tpdIntegration = $cParams->get('3pdintegration', null)) {
				$this->userIntegration ( $tpdIntegration, $fbUsersTable, $joomlaUserObject );
			}
			
			// Notify administrators
			try {
				$this->sendAdminNotification($data, $config);
			} catch(Exception $e) {
				// No errors for email notification during the create user phase
			}
		}
	}
	
	/**
	 * onGoogleLogin handler
	 *
	 * @access public
	 * @param Object $joomlaUserObject
	 * @param string $return
	 * @param Object $cParams
	 * @return null
	 */
	public function onGoogleLogin($joomlaUserObject, $return, $cParams) {
		// Execute only on site application
		if (! $this->app->getClientId ()) {
			jimport ( 'joomla.user.helper' );
	
			$credentials = array ();
			$credentials ['username'] = $joomlaUserObject->username;

			// Check if existing user and overwrite mode, save the existing password
			if($cParams->get('match_existing_users', 0)) {
				$query = "SELECT " . $this->db->quoteName('password') .
						 "\n FROM #__users" .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$storedPassword = $this->db->loadResult ();

				// Reset a new user registration case
				$joomlaUserObject->password_clear = false;
			}

			// If newly created user, we have a password clear already generated
			if($joomlaUserObject->password_clear) {
				$credentials ['password'] = $joomlaUserObject->password_clear;
			} else {
				// Generate and use a temp random password just to login on the fly
				$password = JUserHelper::genRandomPassword();
				$credentials ['password'] = $password;
				$hashedPassword = JUserHelper::getCryptedPassword($password);
				$query = "UPDATE #__users" .
						 "\n SET " . $this->db->quoteName('password') . " = " . $this->db->quote($hashedPassword) .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$this->db->execute ();
			}
				
			$options = array ();
			$options ['remember'] = true;
			$options ['silent'] = true;
				
			$loggedIn = $this->app->login ( $credentials, $options );

			// Check if existing user and overwrite mode, restore the original password
			if($cParams->get('match_existing_users', 0)) {
				$query = "UPDATE #__users" .
						"\n SET " . $this->db->quoteName('password') . " = " . $this->db->quote($storedPassword) .
						"\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$this->db->execute ();
			}

			if($cParams->get('show_greetings_msg', 0)) {
				$customMessage = $cParams->get('greetings_msg', JText::_('COM_INSTANTFBLOGIN_SUCCESS_LOGIN'));
				$redirectArray = $loggedIn ? array('msg'=>$customMessage, 'status'=>'') : array('msg'=>'COM_INSTANTFBLOGIN_ERROR_' . 'LOGIN', 'status'=>'error');
			} else {
				$redirectArray = $loggedIn ? array('msg'=>'', 'status'=>'') : array('msg'=>'COM_INSTANTFBLOGIN_ERROR_' . 'LOGIN', 'status'=>'error');
			}
				
			$bas64FunctionNameEncode = 'base'. 64 . '_encode';
			$bas64FunctionNameDecode = 'base'. 64 . '_decode';
			$this->app->redirect ( $bas64FunctionNameDecode ( $return ), JText::_($redirectArray['msg']), $redirectArray['status']);
		}
	}
	
	/**
	 * onTwitterNewUser handler
	 *
	 * @access public
	 * @param Object $joomlaUserObject
	 * @param Object $cParams
	 * @return null
	 */
	public function onTwitterNewUser($joomlaUserObject, $twitterUserObject, $cParams) {
		// Execute only on site application
		if (! $this->app->getClientId ()) {
			jimport ( 'joomla.application.component.helper' );
			$config = JComponentHelper::getParams ( 'com_users' );
			// Default to Registered.
			$defaultUserGroup = $cParams->get('new_usertype', $config->get ( 'new_usertype', 2 ));
	
			// Retrieve info user data
			$name = $twitterUserObject->name;
			$username = $twitterUserObject->screen_name;
			$email = $twitterUserObject->email;
			
			// Check if username already exists
			$query = "SELECT " . $this->db->quoteName('id') .
					 "\n FROM #__users" .
					 "\n WHERE " . $this->db->quoteName('username') . " = " . $this->db->quote($username);
			$existingUsername = $this->db->setQuery($query)->loadResult();
			if($existingUsername) {
				$username .= rand(1, 100);
			}
			
			$data = array (
					"name" => $name,
					"username" => $username,
					"groups" => array (
							$defaultUserGroup
					),
					"email" => $email
			);
	
			// Write to database
			if (! $joomlaUserObject->bind ( $data )) {
				throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_JOOMLA_USER') . $joomlaUserObject->getError (), 'warning' );
			}
			if (! $joomlaUserObject->save ()) {
				// Check if existing user and overwrite mode, don't throw exceptions but load that Joomla user object and go on to add a new IFBL record
				if(!$cParams->get('match_existing_users', 0)) {
					throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_JOOMLA_USER') . $joomlaUserObject->getError (), 'warning');
				} else {
					// Try to load data of existing user using the email address as p.key
					$query = "SELECT *" .
							"\n FROM #__users" .
							"\n WHERE " . $this->db->quoteName('email') . " = " . $this->db->quote($email);
					$existingData = $this->db->setQuery($query)->loadAssoc();
					$joomlaUserObject->bind($existingData);
				}
			}
	
			// Track auto created users from Facebook connect login into component db table
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_instantfblogin/tables');
			$fbUsersTable = JTable::getInstance('Users', 'Table');
			$fbUsersTable->j_uid = $joomlaUserObject->id;
			$fbUsersTable->fb_uid = $twitterUserObject->joomlaIdentifier;
			$fbUsersTable->email = $twitterUserObject->email;
			$fbUsersTable->first_name = $twitterUserObject->name;
			$fbUsersTable->last_name = '-';
			$fbUsersTable->name = $twitterUserObject->screen_name;
			$fbUsersTable->gender = JText::_('COM_INSTANTFBLOGIN_ND');
			$fbUsersTable->geolocation = $twitterUserObject->location;
			$fbUsersTable->registered_on = JDate::getInstance()->toSql();
			$fbUsersTable->last_update = null;
			$fbUsersTable->verified = 1;
			$fbUsersTable->account_type = 'twit';
			$fbUsersTable->picture = $twitterUserObject->profile_image_url_https;
	
			if(! $fbUsersTable->store()) {
				throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_FB_USER') . $fbUsersTable->getError (), 'warning' );
			}
	
			// Call 3PD user integration function
			if($tpdIntegration = $cParams->get('3pdintegration', null)) {
				$this->userIntegration ( $tpdIntegration, $fbUsersTable, $joomlaUserObject );
			}
			
			// Notify administrators
			try {
				$this->sendAdminNotification($data, $config);
			} catch(Exception $e) {
				// No errors for email notification during the create user phase
			}
		}
	}
	
	/**
	 * onTwitterLogin handler
	 *
	 * @access public
	 * @param Object $joomlaUserObject
	 * @param string $return
	 * @param Object $cParams
	 * @return null
	 */
	public function onTwitterLogin($joomlaUserObject, $return, $cParams) {
		// Execute only on site application
		if (! $this->app->getClientId ()) {
			jimport ( 'joomla.user.helper' );
	
			$credentials = array ();
			$credentials ['username'] = $joomlaUserObject->username;
	
			// Check if existing user and overwrite mode, save the existing password
			if($cParams->get('match_existing_users', 0)) {
				$query = "SELECT " . $this->db->quoteName('password') .
						 "\n FROM #__users" .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$storedPassword = $this->db->loadResult ();
	
				// Reset a new user registration case
				$joomlaUserObject->password_clear = false;
			}
	
			// If newly created user, we have a password clear already generated
			if($joomlaUserObject->password_clear) {
				$credentials ['password'] = $joomlaUserObject->password_clear;
			} else {
				// Generate and use a temp random password just to login on the fly
				$password = JUserHelper::genRandomPassword();
				$credentials ['password'] = $password;
				$hashedPassword = JUserHelper::getCryptedPassword($password);
				$query = "UPDATE #__users" .
						 "\n SET " . $this->db->quoteName('password') . " = " . $this->db->quote($hashedPassword) .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$this->db->execute ();
			}
	
			$options = array ();
			$options ['remember'] = true;
			$options ['silent'] = true;
	
			$loggedIn = $this->app->login ( $credentials, $options );
	
			// Check if existing user and overwrite mode, restore the original password
			if($cParams->get('match_existing_users', 0)) {
				$query = "UPDATE #__users" .
						 "\n SET " . $this->db->quoteName('password') . " = " . $this->db->quote($storedPassword) .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$this->db->execute ();
			}
	
			if($cParams->get('show_greetings_msg', 0)) {
				$customMessage = $cParams->get('greetings_msg', JText::_('COM_INSTANTFBLOGIN_SUCCESS_LOGIN'));
				$redirectArray = $loggedIn ? array('msg'=>$customMessage, 'status'=>'') : array('msg'=>'COM_INSTANTFBLOGIN_ERROR_' . 'LOGIN', 'status'=>'error');
			} else {
				$redirectArray = $loggedIn ? array('msg'=>'', 'status'=>'') : array('msg'=>'COM_INSTANTFBLOGIN_ERROR_' . 'LOGIN', 'status'=>'error');
			}
	
			$bas64FunctionNameEncode = 'base'. 64 . '_encode';
			$bas64FunctionNameDecode = 'base'. 64 . '_decode';
			$this->app->redirect ( $bas64FunctionNameDecode ( $return ), JText::_($redirectArray['msg']), $redirectArray['status']);
		}
	}

	/**
	 * onLinkedinNewUser handler
	 *
	 * @access public
	 * @param Object $joomlaUserObject
	 * @param Object $linkedinUserObject
	 * @param Object $cParams
	 * @return null
	 */
	public function onLinkedinNewUser($joomlaUserObject, $linkedinUserObject, $cParams) {
		// Execute only on site application
		if (! $this->app->getClientId ()) {
			jimport ( 'joomla.application.component.helper' );
			$config = JComponentHelper::getParams ( 'com_users' );
			// Default to Registered.
			$defaultUserGroup = $cParams->get('new_usertype', $config->get ( 'new_usertype', 2 ));
	
			// Retrieve info user data
			$name = ucfirst($linkedinUserObject->firstname) . ' ' . ucfirst($linkedinUserObject->lastname);
			$username = 'in_' . $linkedinUserObject->firstname . $linkedinUserObject->lastname;
			$email = $linkedinUserObject->email;

			// Check if username already exists
			$query = "SELECT " . $this->db->quoteName('id') .
					 "\n FROM #__users" .
					 "\n WHERE " . $this->db->quoteName('username') . " = " . $this->db->quote($username);
			$existingUsername = $this->db->setQuery($query)->loadResult();
			if($existingUsername) {
				$username .= rand(1, 100);
			}

			$data = array (
					"name" => $name,
					"username" => $username,
					"groups" => array (
							$defaultUserGroup
					),
					"email" => $email
			);
	
			// Write to database
			if (! $joomlaUserObject->bind ( $data )) {
				throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_JOOMLA_USER') . $joomlaUserObject->getError (), 'warning' );
			}
			if (! $joomlaUserObject->save ()) {
				// Check if existing user and overwrite mode, don't throw exceptions but load that Joomla user object and go on to add a new IFBL record
				if(!$cParams->get('match_existing_users', 0)) {
					throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_JOOMLA_USER') . $joomlaUserObject->getError (), 'warning');
				} else {
					// Try to load data of existing user using the email address as p.key
					$query = "SELECT *" .
							 "\n FROM #__users" .
							 "\n WHERE " . $this->db->quoteName('email') . " = " . $this->db->quote($email);
					$existingData = $this->db->setQuery($query)->loadAssoc();
					$joomlaUserObject->bind($existingData);
				}
			}
	
			// Track auto created users from Facebook connect login into component db table
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_instantfblogin/tables');
			$fbUsersTable = JTable::getInstance('Users', 'Table');
			$fbUsersTable->j_uid = $joomlaUserObject->id;
			$fbUsersTable->fb_uid = $linkedinUserObject->joomlaIdentifier;
			$fbUsersTable->email = $linkedinUserObject->email;
			$fbUsersTable->first_name = $linkedinUserObject->firstname;
			$fbUsersTable->last_name = $linkedinUserObject->lastname;
			$fbUsersTable->name = $name;
			$fbUsersTable->gender = JText::_('COM_INSTANTFBLOGIN_ND');
			$fbUsersTable->geolocation = JText::_('COM_INSTANTFBLOGIN_ND');
			$fbUsersTable->registered_on = JDate::getInstance()->toSql();
			$fbUsersTable->last_update = null;
			$fbUsersTable->verified = 1;
			$fbUsersTable->account_type = 'lkin';
			$fbUsersTable->picture = $linkedinUserObject->pictureurl;
	
			if(! $fbUsersTable->store()) {
				throw new InstantfbloginException ( JText::_('COM_INSTANTFBLOGIN_ERROR_CREATE_FB_USER') . $fbUsersTable->getError (), 'warning' );
			}
	
			// Call 3PD user integration function
			if($tpdIntegration = $cParams->get('3pdintegration', null)) {
				$this->userIntegration ( $tpdIntegration, $fbUsersTable, $joomlaUserObject );
			}
			
			// Notify administrators
			try {
				$this->sendAdminNotification($data, $config);
			} catch(Exception $e) {
				// No errors for email notification during the create user phase
			}
		}
	}
	
	/**
	 * onLinkedinLogin handler
	 *
	 * @access public
	 * @param Object $joomlaUserObject
	 * @param string $return
	 * @param Object $cParams
	 * @return null
	 */
	public function onLinkedinLogin($joomlaUserObject, $return, $cParams) {
		// Execute only on site application
		if (! $this->app->getClientId ()) {
			jimport ( 'joomla.user.helper' );
	
			$credentials = array ();
			$credentials ['username'] = $joomlaUserObject->username;
	
			// Check if existing user and overwrite mode, save the existing password
			if($cParams->get('match_existing_users', 0)) {
				$query = "SELECT " . $this->db->quoteName('password') .
						 "\n FROM #__users" .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$storedPassword = $this->db->loadResult ();
	
				// Reset a new user registration case
				$joomlaUserObject->password_clear = false;
			}
	
			// If newly created user, we have a password clear already generated
			if($joomlaUserObject->password_clear) {
				$credentials ['password'] = $joomlaUserObject->password_clear;
			} else {
				// Generate and use a temp random password just to login on the fly
				$password = JUserHelper::genRandomPassword();
				$credentials ['password'] = $password;
				$hashedPassword = JUserHelper::getCryptedPassword($password);
				$query = "UPDATE #__users" .
						 "\n SET " . $this->db->quoteName('password') . " = " . $this->db->quote($hashedPassword) .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$this->db->execute ();
			}
	
			$options = array ();
			$options ['remember'] = true;
			$options ['silent'] = true;
	
			$loggedIn = $this->app->login ( $credentials, $options );
	
			// Check if existing user and overwrite mode, restore the original password
			if($cParams->get('match_existing_users', 0)) {
				$query = "UPDATE #__users" .
						 "\n SET " . $this->db->quoteName('password') . " = " . $this->db->quote($storedPassword) .
						 "\n WHERE " . $this->db->quoteName('id') . " = " . (int)$joomlaUserObject->id;
				$this->db->setQuery ( $query );
				$this->db->execute ();
			}
	
			if($cParams->get('show_greetings_msg', 0)) {
				$customMessage = $cParams->get('greetings_msg', JText::_('COM_INSTANTFBLOGIN_SUCCESS_LOGIN'));
				$redirectArray = $loggedIn ? array('msg'=>$customMessage, 'status'=>'') : array('msg'=>'COM_INSTANTFBLOGIN_ERROR_' . 'LOGIN', 'status'=>'error');
			} else {
				$redirectArray = $loggedIn ? array('msg'=>'', 'status'=>'') : array('msg'=>'COM_INSTANTFBLOGIN_ERROR_' . 'LOGIN', 'status'=>'error');
			}
	
			$bas64FunctionNameEncode = 'base'. 64 . '_encode';
			$bas64FunctionNameDecode = 'base'. 64 . '_decode';
			$this->app->redirect ( $bas64FunctionNameDecode ( $return ), JText::_($redirectArray['msg']), $redirectArray['status']);
		}
	}
	
	/* Manage the Joomla updater based on the user license
	 *
	 * @access public
	 * @return void
	 */
	public function onInstallerBeforePackageDownload(&$url, &$headers) {
		$uri 	= JUri::getInstance($url);
		$parts 	= explode('/', $uri->getPath());
		$app = JFactory::getApplication();
		if ($uri->getHost() == 'storejextensions.org' && in_array('com_instantfblogin.zip', $parts)) {
			// Init as false unless the license is valid
			$validUpdate = false;
	
			// Manage partial language translations
			$jLang = JFactory::getLanguage();
			$jLang->load('com_instantfblogin', JPATH_BASE . '/components/com_instantfblogin', 'en-GB', true, true);
			if($jLang->getTag() != 'en-GB') {
				$jLang->load('com_instantfblogin', JPATH_BASE, null, true, false);
				$jLang->load('com_instantfblogin', JPATH_BASE . '/components/com_instantfblogin', null, true, false);
			}
	
			// Email license validation API call and &$url building construction override
			$cParams = JComponentHelper::getParams('com_instantfblogin');
			$registrationEmail = $cParams->get('registration_email', null);
	
			// License
			if($registrationEmail) {
				$prodCode = 'instfblogin';
				$cdFuncUsed = 'str_' . 'ro' . 't' . '13';
	
				// Retrieve license informations from the remote REST API
				$apiResponse = null;
				$apiEndpoint = $cdFuncUsed('uggc' . '://' . 'fgberwrkgrafvbaf' . '.bet') . "/option,com_easycommerce/action,licenseCode/email,$registrationEmail/productcode,$prodCode";
				if (function_exists('curl_init')){
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$apiResponse = curl_exec($ch);
					curl_close($ch);
				}
				$objectApiResponse = json_decode($apiResponse);
	
				if(!is_object($objectApiResponse)) {
					// Message user about error retrieving license informations
					$app->enqueueMessage(JText::_('COM_INSTANTFBLOGIN_ERROR_RETRIEVING_LICENSE_INFO'));
				} else {
					if(!$objectApiResponse->success) {
						switch ($objectApiResponse->reason) {
							// Message user about the reason the license is not valid
							case 'nomatchingcode':
								$app->enqueueMessage(JText::_('COM_INSTANTFBLOGIN_LICENSE_NOMATCHING'));
								break;
	
							case 'expired':
								// Message user about license expired on $objectApiResponse->expireon
								$app->enqueueMessage(JText::sprintf('COM_INSTANTFBLOGIN_LICENSE_EXPIRED', $objectApiResponse->expireon));
								break;
						}
							
					}
	
					// Valid license found, builds the URL update link and message user about the license expiration validity
					if($objectApiResponse->success) {
						$url = $cdFuncUsed('uggc' . '://' . 'fgberwrkgrafvbaf' . '.bet' . '/VASOY1306TSPQnfni8963560923pngtf35td1lboq456a.ugzy');
	
						$validUpdate = true;
						$app->enqueueMessage(JText::sprintf('COM_INSTANTFBLOGIN_EXTENSION_UPDATED_SUCCESS', $objectApiResponse->expireon));
					}
				}
			} else {
				// Message user about missing email license code
				$app->enqueueMessage(JText::sprintf('COM_INSTANTFBLOGIN_MISSING_REGISTRATION_EMAIL_ADDRESS', JFilterOutput::ampReplace('index.php?option=com_instantfblogin&task=config.display#_licensepreferences')));
			}
	
			if(!$validUpdate) {
				$app->enqueueMessage(JText::_('COM_INSTANTFBLOGIN_UPDATER_STANDARD_ADVISE'), 'notice');
			}
		}
	}
	
	/**
	 * Class Constructor
	 * 
	 * @access protected
	 * @param object $subject
	 *        	object to observe
	 * @param array $config
	 *        	An array that holds the plugin configuration
	 * @since 1.6
	 */
	public function __construct(& $subject, $config) {
		parent::__construct ( $subject, $config );
		
		// Load component translations
		$jLang = JFactory::getLanguage ();
		$jLang->load ( 'com_instantfblogin', JPATH_ROOT . '/components/com_instantfblogin', 'en-GB', true, true );
		if ($jLang->getTag () != 'en-GB') {
			$jLang->load ( 'com_instantfblogin', JPATH_SITE, null, true, false );
			$jLang->load ( 'com_instantfblogin', JPATH_ROOT . '/components/com_instantfblogin', null, true, false );
		}
		
		$this->app = JFactory::getApplication ();
		$this->db = JFactory::getDBO();
		
		// Manage partial language translations if editing modules jmap in backend
		if(($this->app->input->get('option') == 'com_modules' || $this->app->input->get('option') == 'com_advancedmodules') &&
			$this->app->input->get('view') == 'module' &&
			$this->app->input->get('layout') == 'edit' &&
			$this->app->getClientId ()) {
			$jLang->load ( 'com_instantfblogin', JPATH_ROOT . '/administrator/components/com_instantfblogin', 'en-GB', true, true );
			if ($jLang->getTag () != 'en-GB') {
				$jLang->load ( 'com_instantfblogin', JPATH_SITE, null, true, false );
				$jLang->load ( 'com_instantfblogin', JPATH_SITE . '/administrator/components/com_instantfblogin', null, true, false );
			}
		}
	}
}