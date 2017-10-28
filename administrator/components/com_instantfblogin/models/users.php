<?php
// namespace administrator\components\com_instantfblogin\models;
/**
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage models
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.model' );

/**
 * Users model responsibilities
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage models
 * @since 1.6
 */
interface IInstantfbloginModelUsers {
	/**
	 * Get geolocation translations from DB
	 *
	 * @access public
	 * @return array[] &
	 */
	public function &getGeoTranslations();
}

/**
 * Users model responsibilities
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage models
 * @since 1.6
 */
class InstantfbloginModelUsers extends InstantfbloginModel implements IInstantfbloginModelUsers {
	/**
	 * Restituisce la query string costruita per ottenere il wrapped set richiesto in base
	 * allo userstate, opzionalmente seleziona i campi richiesti
	 * 
	 * @access private
	 * @return string
	 */
	protected function buildListQuery($fields = 'a.*') {
		// WHERE
		$where = array();
		$whereString = null;
				
		//Filtro testo
		if($this->state->get('searchword')) {
			$where[] = "\n (a.email LIKE " .
						$this->_db->quote('%' . $this->state->get('searchword') . '%') .
						"\n OR a.first_name LIKE " . 
						$this->_db->quote('%' . $this->state->get('searchword'). '%') . 
						"\n OR a.last_name LIKE " . 
						$this->_db->quote('%' . $this->state->get('searchword'). '%') .
						"\n OR a.name LIKE " . 
						$this->_db->quote('%' . $this->state->get('searchword'). '%') . ")";
		}
		
		//Filtro periodo
		if($this->state->get('fromPeriod')) {
			// Instance a new date time in the selected timezone
			$fromDate = JDate::getInstance($this->state->get('fromPeriod'), new DateTimeZone($this->joomlaConfig));
			// Get date time UTC
			$where[] = "\n a.registered_on > " . $this->_db->quote($fromDate->toSql());
		}
		
		if($this->state->get('toPeriod')) {
			// Instance a new date time in the selected timezone
			$toDate = JDate::getInstance($this->state->get('toPeriod'), new DateTimeZone($this->joomlaConfig));
			// Add Interval
			$toDate->add(new DateInterval('PT23H59M59S'));
			// Get date time UTC
			$where[] = "\n a.registered_on < " . $this->_db->quote($toDate->toSql());
		}
		
		if($this->state->get('gender')) {
			$where[] = "\n a.gender = " .  $this->_db->quote($this->state->get('gender'));
		}
		
		if($this->state->get('account_type')) {
			$where[] = "\n a.account_type = " .  $this->_db->quote($this->state->get('account_type'));
		}
		
		if($this->state->get('geo')) {
			$where[] = "\n a.geolocation = " .  $this->_db->quote($this->state->get('geo'));
		}
		  
		if (count($where)) {
			$whereString = "\n WHERE " . implode ("\n AND ", $where);
		}
		
		// ORDERBY
		if($this->state->get('order')) {
			$orderString = "\n ORDER BY " . $this->state->get('order') . " ";
		}
		
		//Filtro testo
		if($this->state->get('order_dir')) {
			$orderString .= $this->state->get('order_dir');
		}
		
		
		$query = "SELECT $fields"
				. "\n FROM #__instantfblogin AS a"
				. $whereString 
				. $orderString;
		return $query;
	}

	/**
	 * Main get data method
	 * @access public
	 * @return Object[]
	 */
	public function getData($asArray = false) {
		// Build query
		$query = $this->buildListQuery ();
		$this->_db->setQuery ( $query, $this->getState ( 'limitstart' ), $this->getState ( 'limit' ) );
		try {
			if(!$asArray) {
				$result = $this->_db->loadObjectList ();
			} else {
				$result = $this->_db->loadAssocList ();
			}
			
			if($this->_db->getErrorNum()) {
				throw new InstantfbloginException(JText::_('COM_INSTANTFBLOGIN_ERROR_RECORDS') . $this->_db->getErrorMsg(), 'error');
			}
		} catch (InstantfbloginException $e) {
			$this->app->enqueueMessage($e->getMessage(), $e->getErrorLevel());
			$result = array();
		} catch (Exception $e) {
			$InstantfbloginException = new InstantfbloginException($e->getMessage(), 'error');
			$this->app->enqueueMessage($InstantfbloginException->getMessage(), $InstantfbloginException->getErrorLevel());
			$result = array();
		}
		return $result;
	}
	
	/**
	 * Restituisce le select list usate dalla view per l'interfaccia
	 * @access public
	 * @return array
	 */
	public function getFilters() {
		$lists = array();
		 
		$types[] = JHTML::_('select.option',  '0', '- '. JText::_('COM_INSTANTFBLOGIN_USER_GENDER' ) .' -' ); 
		$types[] = JHTML::_('select.option', 'male', JText::_('COM_INSTANTFBLOGIN_USER_GENDER_MALE' ) );
		$types[] = JHTML::_('select.option', 'female', JText::_('COM_INSTANTFBLOGIN_USER_GENDER_FEMALE' ) );
		 
		$lists['gender'] 	= JHTML::_('select.genericlist', $types, 'gender', 'class="inputbox hidden-phone" size="1" onchange="document.adminForm.task.value=\'users.display\';document.adminForm.submit( );"', 'value', 'text', $this->state->get('gender'));
			
		$accountType[] = JHTML::_('select.option',  '', '- '. JText::_('COM_INSTANTFBLOGIN_ACCOUNT_TYPE' ) .' -' );
		$accountType[] = JHTML::_('select.option', 'user', JText::_('COM_INSTANTFBLOGIN_ACCOUNT_TYPE_FB_USER' ) );
		$accountType[] = JHTML::_('select.option', 'page', JText::_('COM_INSTANTFBLOGIN_ACCOUNT_TYPE_FB_PAGE' ) );
		$accountType[] = JHTML::_('select.option', 'goog', JText::_('COM_INSTANTFBLOGIN_ACCOUNT_TYPE_GOOGLE' ) );
		$accountType[] = JHTML::_('select.option', 'twit', JText::_('COM_INSTANTFBLOGIN_ACCOUNT_TYPE_TWITTER' ) );
		$accountType[] = JHTML::_('select.option', 'lkin', JText::_('COM_INSTANTFBLOGIN_ACCOUNT_TYPE_LINKEDIN' ) );
		
		$lists['account_type'] 	= JHTML::_('select.genericlist', $accountType, 'account_type', 'class="inputbox hidden-phone" size="1" onchange="document.adminForm.task.value=\'users.display\';document.adminForm.submit( );"', 'value', 'text', $this->state->get('account_type'));
			
		// Select every geo nationality available in the database
		$query = "SELECT DISTINCT COALESCE(map.name, fbl.geolocation) AS text," .
				 "\n fbl.geolocation AS value" .
				 "\n FROM " . $this->_db->quotename('#__instantfblogin') . " AS fbl" .
				 "\n LEFT JOIN " . $this->_db->quotename('#__instantfblogin_countries_map') . " AS map" .
				 "\n ON map.iso1_code = SUBSTRING(fbl.geolocation, -2)" .
				 "\n AND (fbl.geolocation REGEXP '_' OR LENGTH(fbl.geolocation) = 2)" .
				 "\n WHERE NOT ISNULL(fbl.geolocation)" .
				 "\n AND fbl.geolocation != ''" .
				 "\n ORDER BY text";
		$distinctGeo = $this->_db->setQuery($query)->loadObjectList();
		
		$defaultChoice = JHTML::_('select.option',  '', '- '. JText::_('COM_INSTANTFBLOGIN_ALL_GEOLOCATION' ) .' -' );
		array_unshift($distinctGeo, $defaultChoice);
			
		$lists['geo'] = JHTML::_('select.genericlist', $distinctGeo, 'geo', 'class="inputbox hidden-phone" size="1" onchange="document.adminForm.task.value=\'users.display\';document.adminForm.submit( );"', 'value', 'text', $this->state->get('geo'));
			
		
		return $lists;
	}
	
	/**
	 * Purge the cache of all messages in a single operation
	 * 
	 * @access public
	 * @param array $cids
	 * @return boolean
	 */
	public function deleteEntities($cids) {
		try {
			// Manage third party integrations
			$additionalNameTable = null;
			$additionalTable = null;
			$onClause = null;

			if($tpdIntegration = $this->componentParams->get('3pdintegration', null)) {
				switch ($tpdIntegration) {
					case 'jomsocial':
							$additionalNameTable = "," . $this->_db->quoteName('3pdusers');
							$additionalTable = "\n LEFT JOIN #__community_users AS 3pdusers";
							$onClause = "\n ON fbusers.j_uid = 3pdusers.userid";
						break;
							
					case 'easysocial':
							$additionalNameTable = "," . $this->_db->quoteName('3pdusers') .
												   "," . $this->_db->quoteName('3pdusers_maps');
							$additionalTable = "\n LEFT JOIN #__social_users AS 3pdusers" .
											   "\n ON fbusers.j_uid = 3pdusers.user_id";
							$onClause = "\n LEFT JOIN #__social_profiles_maps AS 3pdusers_maps" .
										"\n ON fbusers.j_uid = 3pdusers_maps.user_id";
						break;
							
					case 'cbuilder':
							$additionalNameTable = "," . $this->_db->quoteName('3pdusers');
							$additionalTable = "\n LEFT JOIN #__comprofiler AS 3pdusers";
							$onClause = "\n ON fbusers.j_uid = 3pdusers.user_id";
						break;
							
					case 'kunena':
							$additionalNameTable = "," . $this->_db->quoteName('3pdusers');
							$additionalTable = "\n LEFT JOIN #__kunena_users AS 3pdusers";
							$onClause = "\n ON fbusers.j_uid = 3pdusers.userid";
						break;
				}
			}
			
			$query = "DELETE " . 
					 $this->_db->quoteName('fbusers') . "," .
					 $this->_db->quoteName('jusers') .
					 $additionalNameTable .
					 "\n FROM #__instantfblogin AS fbusers" .
					 "\n LEFT JOIN #__users AS jusers" .
					 "\n ON fbusers.j_uid = jusers.id" .
					 $additionalTable .
					 $onClause .
					 "\n WHERE fbusers.id IN (" . implode (',', $cids) .")";
			$this->_db->setQuery($query);
			if(!$this->_db->execute()) {
				throw new InstantfbloginException($this->_db->getErrorMsg(), 'error');
			}
		} catch (InstantfbloginException $e) {
			$this->setError($e);
			return false;
		} catch (Exception $e) {
			$InstantfbloginException = new InstantfbloginException($e->getMessage(), 'error');
			$this->setError($InstantfbloginException);
			return false;
		}
		return true;
	}
	
	/**
	 * Get geolocation translations from DB
	 *
	 * @access public
	 * @return array[] &
	 */
	public function &getGeoTranslations() {
		static $resultTranslations;
	
		if($resultTranslations) {
			return $resultTranslations;
		}
		$query = "SELECT" .
				$this->_db->quoteName('iso1_code') . "," .
				$this->_db->quoteName('name') .
				"\n FROM  #__instantfblogin_countries_map";
		$this->_db->setQuery($query);
	
		try {
			$resultTranslations = $this->_db->loadAssocList('iso1_code');
			if ($this->_db->getErrorNum()) {
				throw new InstantfbloginException(JText::sprintf('COM_INSTANTFBLOGIN_ERROR_RECORDS', $this->_db->getErrorMsg()), 'error');
			}
		} catch (JRealtimeException $e) {
			$this->app->enqueueMessage($e->getMessage(), $e->getErrorLevel());
			$result = array();
		} catch (Exception $e) {
			$ifblException = new InstantfbloginException($e->getMessage(), 'error');
			$this->app->enqueueMessage($ifblException->getMessage(), $ifblException->getErrorLevel());
			$result = array();
		}
	
		return $resultTranslations;
	}
	
	/**
	 * Class constructor
	 *
	 * @access public
	 * @param $config array
	 * @return Object&
	 */
	public function __construct($config = array()) {
		parent::__construct ( $config );
	
		$componentParams = $this->getComponentParams();
		$this->setState('cparams', $componentParams);
		
		$joomlaConfig = JFactory::getConfig ();
		$this->joomlaConfig = $this->user->getParam ( 'timezone', $joomlaConfig->get ( 'offset' ) );
	}
} 