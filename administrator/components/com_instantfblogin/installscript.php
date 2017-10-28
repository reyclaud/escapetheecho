<?php
//namespace administrator\components\com_instantfblogin;
/**
 * Application install script
 * @package INSTANTFBLOGIN::INSTALL::administrator::components::com_instantfblogin 
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html    
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/** 
 * Application install script class
 * @package INSTANTFBLOGIN::administrator::components::com_instantfblogin  
 */
class com_instantfbloginInstallerScript {
	/*
	* Find mimimum required joomla version for this extension. It will be read from the version attribute (install tag) in the manifest file
	*/
	private $minimum_joomla_release = '3.0.0';
	
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * preflight runs before anything else and while the extracted files are in the uploaded temp folder.
	 * If preflight returns false, Joomla will abort the update and undo everything already done.
	 */
	function preflight($type, $parent) {
		// Check if the installation is broken
		if($type == 'install' && !file_exists(JPATH_ROOT . '/components/com_instantfblogin')) {
			$database = JFactory::getDBO ();
			$existsTableQuery = "SHOW TABLES LIKE " . $database->quote( $database->getPrefix() . 'instantfblogin');
			if($database->setQuery($existsTableQuery)->loadResult()) {
				$query = "DROP TABLE " . $database->quoteName('#__instantfblogin');
				$database->setQuery($query)->execute();
			}
		}
	}
	
	/*
	 * $parent is the class calling this method.
	 * install runs after the database scripts are executed.
	 * If the extension is new, the install method is run.
	 * If install returns false, Joomla will abort the install and undo everything already done.
	 */
	function install($parent) {
		$database = JFactory::getDBO ();
		echo ('<style type="text/css">div.alert-success, span.step_details {display: none;font-size: 12px;} span.step_details div{margin-top:0 !important;} table.adminform h3{text-align:left;}.installcontainer{width: 720px;}</style>');
		echo ('<link rel="stylesheet" type="text/css" href="' . JURI::root ( true ) . '/administrator/components/com_instantfblogin/css/bootstrap-install.css' . '" />');
		echo ('<script type="text/javascript" src="' . JURI::root ( true ) . '/administrator/components/com_instantfblogin/js/installer.js' .'"></script>' );
		$lang = JFactory::getLanguage ();
		$lang->load ( 'com_instantfblogin' );
		$parentParent = $parent->getParent();
		
		// Component installer
		$componentInstaller = JInstaller::getInstance ();
		$pathToPlugin = $componentInstaller->getPath ( 'source' ) . '/plugins';
		$pathToModule = $componentInstaller->getPath ( 'source' ) . '/modules';
		
		echo ('<div class="installcontainer">');
		$systemPluginInstaller = new JInstaller ();
		if (! $systemPluginInstaller->install ( $pathToPlugin . '/system' )) {
			echo '<p>' . JText::_ ( 'COM_INSTANTFBLOGIN_ERROR_INSTALLING_PLUGINS' ) . '</p>';
			// Install failed, rollback changes
			$parentParent->abort(JText::_('COM_INSTANTFBLOGIN_ERROR_INSTALLING_PLUGINS'));
			return false;
		} else {
			$query = "UPDATE #__extensions" . "\n SET enabled = 1" .
					"\n WHERE type = 'plugin' AND element = " . $database->quote ( 'instantfblogin' ) .
					"\n AND folder = " . $database->quote ( 'system' );
			$database->setQuery ( $query );
			if (! $database->execute ()) {
				echo '<p>' . JText::_ ( 'COM_INSTANTFBLOGIN_ERROR_PUBLISHING_PLUGIN' ) . '</p>';
			}?>
			<div class="progress">
				<div class="bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
					<span class="step_details"><?php echo JText::_('COM_INSTANTFBLOGIN_OK_INSTALLING_SYSTEM_PLUGINS');?></span>
				</div>
			</div>
			<?php 
		}
		
		$contentPluginInstaller = new JInstaller ();
		if (! $systemPluginInstaller->install ( $pathToPlugin . '/content')) {
			echo '<p>' . JText::_ ( 'COM_INSTANTFBLOGIN_ERROR_INSTALLING_SOCIAL_PLUGINS' ) . '</p>';
			// Install failed, rollback changes
			$parentParent->abort(JText::_('COM_INSTANTFBLOGIN_ERROR_INSTALLING_SOCIAL_PLUGINS'));
			return false;
		} else {
			$query = "UPDATE #__extensions" . "\n SET enabled = 1" .
					"\n WHERE type = 'plugin' AND element = " . $database->quote ( 'instantfbloginshare' ) .
					"\n AND folder = " . $database->quote ( 'content' );
			$database->setQuery ( $query );
			if (! $database->execute ()) {
				echo '<p>' . JText::_ ( 'COM_INSTANTFBLOGIN_ERROR_PUBLISHING_SOCIAL_PLUGINS' ) . '</p>';
			}?>
			<div class="progress">
				<div class="bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
					<span class="step_details"><?php echo JText::_('COM_INSTANTFBLOGIN_OK_INSTALLING_SOCIALSHARE_PLUGIN');?></span>
				</div>
			</div>
			<?php 
		}
		
		// New module installer for the main login module
		$moduleInstaller = new JInstaller ();
		if (! $moduleInstaller->install ( $pathToModule . '/login' )) {
			echo '<p>' . JText::_ ( 'COM_INSTANTFBLOGIN_ERROR_INSTALLING_MODULE' ) . '</p>';
			// Install failed, rollback changes
			$parentParent->abort(JText::_('COM_INSTANTFBLOGIN_ERROR_INSTALLING_MODULE'));
			return false;
		} else {
			?>
			<div class="progress">
				<div class="bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
					<span class="step_details"><?php echo JText::_('COM_INSTANTFBLOGIN_OK_INSTALLING_MODULE');?></span>
				</div>
			</div>
			<?php 
		}
		
		// New module installer for the posts module
		$moduleInstaller = new JInstaller ();
		if (! $moduleInstaller->install ( $pathToModule . '/posts' )) {
			echo '<p>' . JText::_ ( 'COM_INSTANTFBLOGIN_ERROR_INSTALLING_POSTS_MODULE' ) . '</p>';
			// Install failed, rollback changes
			$parentParent->abort(JText::_('COM_INSTANTFBLOGIN_ERROR_INSTALLING_POSTS_MODULE'));
			return false;
		} else {
			?>
			<div class="progress">
				<div class="bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
					<span class="step_details"><?php echo JText::_('COM_INSTANTFBLOGIN_OK_INSTALLING_POSTS_MODULE');?></span>
				</div>
			</div>
			<?php 
		}
		
		// New module installer for the comments module
		$moduleInstaller = new JInstaller ();
		if (! $moduleInstaller->install ( $pathToModule . '/comments' )) {
			echo '<p>' . JText::_ ( 'COM_INSTANTFBLOGIN_ERROR_INSTALLING_COMMENTS_MODULE' ) . '</p>';
			// Install failed, rollback changes
			$parentParent->abort(JText::_('COM_INSTANTFBLOGIN_ERROR_INSTALLING_COMMENTS_MODULE'));
			return false;
		} else {
			?>
			<div class="progress">
				<div class="bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
					<span class="step_details"><?php echo JText::_('COM_INSTANTFBLOGIN_OK_INSTALLING_COMMENTS_MODULE');?></span>
				</div>
			</div>
			<?php 
		}
		
		?>
		<div class="progress">
			<div class="bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
				<span class="step_details"><?php echo JText::_('COM_INSTANTFBLOGIN_OK_INSTALLING_COMPONENT');?></span>
		  	</div>
		</div>
		
		<div class="alert alert-success"><?php echo JText::_('COM_INSTANTFBLOGIN_ALL_COMPLETED');?></div>
		<?php 
		echo ('</div>');
		
		return true;
	}
	
	/*
	 * $parent is the class calling this method.
	 * update runs after the database scripts are executed.
	 * If the extension exists, then the update method is run.
	 * If this returns false, Joomla will abort the update and undo everything already done.
	 */
	function update($parent) {
		// Execute always SQL install file to get added updates in that file, disregard DBMS messages and Joomla queue for user
		$parentParent = $parent->getParent();
		$parentManifest = $parentParent->getManifest();
		try {
			// Install/update always without error handlingm case legacy J Error
			JError::setErrorHandling(E_ALL, 'ignore');
			if (isset($parentManifest->install->sql)) {
				$updateResult = $parentParent->parseSQLFiles($parentManifest->install->sql);
				if(!$updateResult) {
					$app = JFactory::getApplication();
					$appReflection = new ReflectionClass(get_class($app));
					$_messageQueue = $appReflection->getProperty('_messageQueue');
					$_messageQueue->setAccessible(true);
					$_messageQueue->setValue($app, array());
				}
			}
		} catch (Exception $e) {
			// Do nothing for user for Joomla 3.x case, case Exception handling
		}
		
		$this->install($parent);
	}
	
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * postflight is run after the extension is registered in the database.
	 */
	function postflight($type, $parent) { 
		// Setup
		$params ['registration_email'] = '';
		$params ['fblogin_active'] = '0';
		$params ['appId'] = '';
		$params ['secret'] = '';
		$params ['gpluslogin_active'] = '0';
		$params ['gplusClientID'] = '';
		$params ['gplusKey'] = '';
		$params ['twitterlogin_active'] = '0';
		$params ['twitterKey'] = '';
		$params ['twitterSecret'] = '';
		$params ['linkedinlogin_active'] = '0';
		$params ['linkedinAppid'] = '';
		$params ['linkedinSecret'] = '';
		
		// Preferences and template
		$params ['login_form_type'] = 'jfb';
		$params ['joomla_template'] = '';
		$params ['use_modal_lightbox'] = '0';
		$params ['show_fbavatar'] = '1';
		$params ['fbavatar_size'] = 'normal';
		$params ['facebook_show_loading'] = '1';
		$params ['template'] = '';
		$params ['use_custom_text'] = '0';
		$params ['custom_text'] = '';
		$params ['gplus_template'] = '';
		$params ['use_custom_gplus_text'] = '0';
		$params ['custom_gplus_text'] = '';
		$params ['twitter_template'] = '';
		$params ['use_custom_twitter_text'] = '0';
		$params ['custom_twitter_text'] = '';
		$params ['linkedin_template'] = '';
		$params ['use_custom_linkedin_text'] = '0';
		$params ['custom_linkedin_text'] = '';
		$params ['forgot_username_link'] = '1';
		$params ['forgot_password_link'] = '1';
		$params ['create_account_link'] = '1';
		$params ['remember_me'] = '0';
		$params ['pretext'] = '';
		$params ['posttext'] = '';
		
		// Advanced
		$params ['login'] = '';
		$params ['logout'] = '';
		$params ['custom_loading_msg'] = '0';
		$params ['loading_msg'] = '';
		$params ['show_greetings_msg'] = '0';
		$params ['greetings_msg'] = '';
		$params ['usefullname'] = 'name';
		$params ['usesecure'] = '0';
		$params ['facebook_logout'] = '0';
		$params ['sdkloadmode'] = '1';
		$params ['sdkversion'] = '2.8';
		$params ['auth_type'] = 'id';
		$params ['curl_ssl_verifypeer'] = '1';
		$params ['match_existing_users'] = '1';
		$params ['allow_only_existing_users'] = '0';
		$params ['new_usertype'] = '';
		$params ['banned_email_address'] = '';
		$params ['moduleclass_sfx'] = '';
		$params ['include_jquery'] = '1';
		$params ['enable_debug'] = '0';
		$params ['3pdintegration'] = '';
		$params ['3pdintegration_links'] = '';
		
		// Social share
		$params ['social_sharer_enabled'] = '0';
		$params ['custom'] = '0';
		$params ['position'] = '2';
		$params ['showInArticles'] = '1';
		$params ['showInCategories'] = '0';
		$params ['showInSections'] = '0';
		$params ['showInFrontPage'] = '0';
		$params ['excludeSections'] = '';
		$params ['excludeCats'] = '';
		$params ['excludeArticles'] = '';
		$params ['includeArticles'] = '';
		$params ['ogimage_detection'] = '0';
		$params ['ogtitle_detection'] = '0';
		$params ['ogdescription_detection'] = '0';
		$params ['ogadditional_tags'] = '0';
		$params ['twitter_card_enable'] = '0';
		$params ['twitter_card_site'] = '';
		$params ['twitter_card_creator'] = '';
		$params ['twitter_card_type'] = 'summary';
		$params ['facebookAutoPosting'] = '0';
		$params ['gplusAutoPosting'] = '0';
		$params ['twitterAutoPosting'] = '0';
		$params ['facebookLikeButton'] = '1';
		$params ['facebookLikeAction'] = 'like';
		$params ['facebookLikeType'] = 'button_count';
		$params ['facebookLikeColor'] = 'light';
		$params ['facebookLikeShowfaces'] = '1';
		$params ['facebookLikeWidth'] = '100';
		$params ['facebookShareMeButton'] = '1';
		$params ['facebookShareMeCounter'] = '0';
		$params ['color_facebookShareMeBadgeText'] = '#FFFFFF';
		$params ['color_facebookShareMeBadge'] = '#3B5998';
		$params ['twitterButton'] = '1';
		$params ['twitterName'] = '';
		$params ['twitterCounter'] = 'horizontal';
		$params ['twitterSize'] = '0';
		$params ['linkedInButton'] = '1';
		$params ['linkedInType'] = 'right';
		$params ['plusButton'] = '1';
		$params ['plusType'] = 'medium';
		$params ['gshareButton'] = '1';
		$params ['shareAnnotation'] = 'bubble';
		$params ['pinterestButton'] = '1';
		
		// Insert all params settings default first time, merge and insert only new one if any on update, keeping current settings
		if ($type == 'install') {  
			$this->setParams ( $params );  
		} elseif ($type == 'update') {
			// Load and merge existing params, this let add new params default and keep existing settings one
			$db = JFactory::getDbo ();
			$query = $db->getQuery(true);
			$query->select('params');
			$query->from('#__extensions');
			$query->where($db->quoteName('name') . '=' . $db->quote('instantfblogin'));
			$db->setQuery($query);
			$existingParamsString = $db->loadResult();
			// store the combined new and existing values back as a JSON string
			$existingParams = json_decode ( $existingParamsString, true );
			
			// Check if upgrading from old 1.6 and force auto-activate FB feature and remove unusued plugin
			if(!array_key_exists('fblogin_active', $existingParams)) {
				$params['fblogin_active'] = '1';

				// Check if plugin exists
				$query = "SELECT extension_id" .
						 "\n FROM #__extensions" .
						 "\n WHERE type = 'plugin' AND element = " . $db->quote('instantfblogin') .
						 "\n AND folder = " . $db->quote('instantfblogin');
				$db->setQuery($query);
				$pluginID = $db->loadResult();
				if($pluginID) {
					// New plugin installer
					$pluginInstaller = new JInstaller ();
					$pluginInstaller->uninstall('plugin', $pluginID);
				}
			}
			
			// Merge params
			$updatedParams = array_merge($params, $existingParams);
			
			$this->setParams($updatedParams);
		}
	}
	
	/*
	 * $parent is the class calling this method
	 * uninstall runs before any other action is taken (file removal or database processing).
	 */
	function uninstall($parent) {
		$database = JFactory::getDBO ();
		$lang = JFactory::getLanguage();
		$lang->load('com_instantfblogin');
			
		// Check if system plugin exists
		$query = "SELECT extension_id" .
				 "\n FROM #__extensions" .
				 "\n WHERE type = 'plugin' AND element = " . $database->quote('instantfblogin') .
				 "\n AND folder = " . $database->quote('system');
		$database->setQuery($query);
		$pluginID = $database->loadResult();
		if(!$pluginID) {
			echo '<p>' . JText::_('COM_INSTANTFBLOGIN_PLUGIN_ALREADY_REMOVED') . '</p>';
		} else {
			// New plugin installer
			$systemPluginInstaller = new JInstaller ();
			if(!$systemPluginInstaller->uninstall('plugin', $pluginID)) {
				echo '<p>' . JText::_('COM_INSTANTFBLOGIN_ERROR_UNINSTALLING_PLUGINS') . '</p>';
			}
		}
		
		// Check if content plugin exists
		$query = "SELECT extension_id" .
				 "\n FROM #__extensions" .
				 "\n WHERE type = 'plugin' AND element = " . $database->quote('instantfbloginshare') .
				 "\n AND folder = " . $database->quote('content');
		$database->setQuery($query);
		$pluginID = $database->loadResult();
		if(!$pluginID) {
			echo '<p>' . JText::_('COM_INSTANTFBLOGIN_PLUGIN_ALREADY_REMOVED') . '</p>';
		} else {
			// New plugin installer
			$systemPluginInstaller = new JInstaller ();
			if(!$systemPluginInstaller->uninstall('plugin', $pluginID)) {
				echo '<p>' . JText::_('COM_INSTANTFBLOGIN_ERROR_UNINSTALLING_PLUGINS') . '</p>';
			}
		}
		
		// Check if the login module exists
		$query = "SELECT extension_id" .
				 "\n FROM #__extensions" .
				 "\n WHERE type = 'module' AND element = " . $database->quote('mod_instantfblogin') .
				 "\n AND client_id = 0";
		$database->setQuery($query);
		$moduleID = $database->loadResult();
		if(!$moduleID) {
			echo '<p>' . JText::_('COM_INSTANTFBLOGIN_MODULE_ALREADY_REMOVED') . '</p>';
		} else {
			// New plugin installer
			$moduleInstaller = new JInstaller ();
			if(!$moduleInstaller->uninstall('module', $moduleID)) {
				echo '<p>' . JText::_('COM_INSTANTFBLOGIN_ERROR_UNINSTALLING_MODULE') . '</p>';
			}
		}
		
		// Check if posts module exists
		$query = "SELECT extension_id" .
				 "\n FROM #__extensions" .
				 "\n WHERE type = 'module' AND element = " . $database->quote('mod_instantfblogin_posts') .
				 "\n AND client_id = 0";
		$database->setQuery($query);
		$moduleID = $database->loadResult();
		if(!$moduleID) {
			echo '<p>' . JText::_('COM_INSTANTFBLOGIN_MODULE_ALREADY_REMOVED') . '</p>';
		} else {
			// New plugin installer
			$moduleInstaller = new JInstaller ();
			if(!$moduleInstaller->uninstall('module', $moduleID)) {
				echo '<p>' . JText::_('COM_INSTANTFBLOGIN_ERROR_UNINSTALLING_MODULE') . '</p>';
			}
		}
		
		// Check if comments module exists
		$query = "SELECT extension_id" .
				 "\n FROM #__extensions" .
				 "\n WHERE type = 'module' AND element = " . $database->quote('mod_instantfblogin_comments') .
				 "\n AND client_id = 0";
		$database->setQuery($query);
		$moduleID = $database->loadResult();
		if(!$moduleID) {
			echo '<p>' . JText::_('COM_INSTANTFBLOGIN_MODULE_ALREADY_REMOVED') . '</p>';
		} else {
			// New plugin installer
			$moduleInstaller = new JInstaller ();
			if(!$moduleInstaller->uninstall('module', $moduleID)) {
				echo '<p>' . JText::_('COM_INSTANTFBLOGIN_ERROR_UNINSTALLING_MODULE') . '</p>';
			}
		}
		
		// Uninstall complete
		return true;
	}
	
	/*
	 * get a variable from the manifest file (actually, from the manifest cache).
	 */
	function getParam($name) {
		$db = JFactory::getDbo ();
		$db->setQuery ( 'SELECT manifest_cache FROM #__extensions WHERE name = "instantfblogin"' );
		$manifest = json_decode ( $db->loadResult (), true );
		return $manifest [$name];
	}
	
	/*
	 * sets parameter values in the component's row of the extension table
	 */
	function setParams($param_array) {
		if (count ( $param_array ) > 0) { 
			$db = JFactory::getDbo (); 
			// store the combined new and existing values back as a JSON string
			$paramsString = json_encode ( $param_array );
			$db->setQuery ( 'UPDATE #__extensions SET params = ' . $db->quote ( $paramsString ) . ' WHERE name = "instantfblogin"' );
			$db->execute ();
		}
	}
}