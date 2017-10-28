<?php
// namespace administrator\components\com_instantfblogin\models;
/**
 *
 * @package INSTANTFBLOGIN::CPANEL::administrator::components::com_instantfblogin
 * @subpackage models
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
define ( 'SERVER_REMOTE_URI', 'http://storejextensions.org/dmdocuments/updates/' );
define ( 'UPDATES_FORMAT', '.json' );
jimport ( 'joomla.application.component.model' );

/**
 * Messages model responsibilities contract
 *
 * @package INSTANTFBLOGIN::MESSAGES::administrator::components::com_instantfblogin
 * @subpackage models
 * @since 1.6
 */
interface ICPanelModel {
	/**
	 * Main get data method
	 *
	 * @access public
	 * @return array
	 */
	public function getData();
	
	/**
	 * Get by remote server informations for new updates of this extension
	 *
	 * @access public
	 * @param InstantfbloginHttp $httpClient        	
	 * @return mixed An object json decoded from server if update information retrieved correctly otherwise false
	 */
	public function getUpdates(InstantfbloginHttp $httpClient);
	
	/**
	 * Delete from file system all obsolete exchanged files
	 * 
	 * @access public
	 * @return boolean
	 */
	public function purgeFileCache();
}
/**
 * CPanel model concrete implementation
 *
 * @package INSTANTFBLOGIN::CPANEL::administrator::components::com_instantfblogin
 * @subpackage models
 * @since 1.6
 */
class InstantfbloginModelCpanel extends InstantfbloginModel {
	/**
	 * Counter result set
	 *
	 * @access protected
	 * @return int
	 */
	protected function buildListQueryTotalUsers() {
		$query = "SELECT COUNT(*) FROM #__users AS u" .
				 "\n LEFT JOIN #__instantfblogin AS ifbl ON ifbl.j_uid = u.id";
		
		return $query;
	}
	
	/**
	 * Counter result set
	 *
	 * @access protected
	 * @return int
	 */
	protected function buildListQueryJoomlaUsers() {
		$query = "SELECT COUNT(u.id) FROM #__users AS u" .
				 "\n LEFT JOIN #__instantfblogin AS ifbl ON ifbl.j_uid = u.id" .
				 "\n WHERE ISNULL(ifbl.id)";
	
		return $query;
	}
	
	/**
	 * Counter result set
	 *
	 * @access protected
	 * @return int
	 */
	protected function buildListQueryFacebookUsers() {
		$query = "SELECT COUNT(*) FROM #__instantfblogin AS ifbl" .
				 "\n INNER JOIN #__users AS u ON ifbl.j_uid = u.id" .
				 "\n WHERE " . $this->_db->quoteName('account_type') . " != " . $this->_db->quote('goog') .
				 "\n AND " . $this->_db->quoteName('account_type') . " != " . $this->_db->quote('twit') .
				 "\n AND " . $this->_db->quoteName('account_type') . " != " . $this->_db->quote('lkin');
		
		return $query;
	}
	
	/**
	 * Counter result set
	 *
	 * @access protected
	 * @return int
	 */
	protected function buildListQueryGPlusUsers() {
		$query = "SELECT COUNT(*) FROM #__instantfblogin AS ifbl" .
				 "\n INNER JOIN #__users AS u ON ifbl.j_uid = u.id" .
				 "\n WHERE " . $this->_db->quoteName('account_type') . " = " . $this->_db->quote('goog');
	
		return $query;
	}
	
	/**
	 * Counter result set
	 *
	 * @access protected
	 * @return int
	 */
	protected function buildListQueryTwitterUsers() {
		$query = "SELECT COUNT(*) FROM #__instantfblogin AS ifbl" .
				 "\n INNER JOIN #__users AS u ON ifbl.j_uid = u.id" .
				 "\n WHERE " . $this->_db->quoteName('account_type') . " = " . $this->_db->quote('twit');
	
		return $query;
	}
	
	/**
	 * Counter result set
	 *
	 * @access protected
	 * @return int
	 */
	protected function buildListQueryLinkedinUsers() {
		$query = "SELECT COUNT(*) FROM #__instantfblogin AS ifbl" .
				 "\n INNER JOIN #__users AS u ON ifbl.j_uid = u.id" .
				 "\n WHERE " . $this->_db->quoteName('account_type') . " = " . $this->_db->quote('lkin');
	
		return $query;
	}
	
	/**
	 * Main get data method
	 *
	 * @access public
	 * @return array
	 */
	public function getData() {
		$calculatedStats = array ();
		// Build queries
		try {
			// Total users
			$query = $this->buildListQueryTotalUsers ();
			$this->_db->setQuery ( $query );
			$calculatedStats ['chart_users_canvas'] ['totalusers'] = $this->_db->loadResult ();
			if ($this->_db->getErrorNum ()) {
				throw new InstantfbloginException ( JText::_ ( 'COM_INSTANTFBLOGIN_DBERROR_STATS' ) . $this->_db->getErrorMsg (), 'error' );
			}
			
			// Facebook registered users
			$query = $this->buildListQueryFacebookUsers ();
			$this->_db->setQuery ( $query );
			$facebookUsersCount = $this->_db->loadResult ();
			if ($this->_db->getErrorNum ()) {
				throw new InstantfbloginException ( JText::_ ( 'COM_INSTANTFBLOGIN_DBERROR_STATS' ) . $this->_db->getErrorMsg (), 'error' );
			}
			
			// GPlus registered users
			$query = $this->buildListQueryGPlusUsers ();
			$this->_db->setQuery ( $query );
			$gplusUsersCount = $this->_db->loadResult ();
			if ($this->_db->getErrorNum ()) {
				throw new InstantfbloginException ( JText::_ ( 'COM_INSTANTFBLOGIN_DBERROR_STATS' ) . $this->_db->getErrorMsg (), 'error' );
			}
			
			// Twitter registered users
			$query = $this->buildListQueryTwitterUsers ();
			$this->_db->setQuery ( $query );
			$twitterUsersCount = $this->_db->loadResult ();
			if ($this->_db->getErrorNum ()) {
				throw new InstantfbloginException ( JText::_ ( 'COM_INSTANTFBLOGIN_DBERROR_STATS' ) . $this->_db->getErrorMsg (), 'error' );
			}
			
			// LinkedIn registered users
			$query = $this->buildListQueryLinkedinUsers ();
			$this->_db->setQuery ( $query );
			$linkedinUsersCount = $this->_db->loadResult ();
			if ($this->_db->getErrorNum ()) {
				throw new InstantfbloginException ( JText::_ ( 'COM_INSTANTFBLOGIN_DBERROR_STATS' ) . $this->_db->getErrorMsg (), 'error' );
			}
			
			// Joomla registered users
			$query = $this->buildListQueryJoomlaUsers ();
			$this->_db->setQuery ( $query );
			$joomlaUsersCount = $this->_db->loadResult ();
			if ($this->_db->getErrorNum ()) {
				throw new InstantfbloginException ( JText::_ ( 'COM_INSTANTFBLOGIN_DBERROR_STATS' ) . $this->_db->getErrorMsg (), 'error' );
			}
			
			// Joomla registered users
			$calculatedStats ['chart_users_canvas'] ['joomlausers'] = $joomlaUsersCount;
			
			// Facebook registered users
			$calculatedStats ['chart_users_canvas'] ['facebookusers'] = $facebookUsersCount;
			
			// GPlus registered users
			$calculatedStats ['chart_users_canvas'] ['gplususers'] = $gplusUsersCount;
			
			// Twitter registered users
			$calculatedStats ['chart_users_canvas'] ['twitterusers'] = $twitterUsersCount;
			
			// LinkedIn  registered users
			$calculatedStats ['chart_users_canvas'] ['linkedinusers'] = $linkedinUsersCount;
		} catch ( InstantfbloginException $e ) {
			$this->app->enqueueMessage ( $e->getMessage (), $e->getErrorLevel () );
			$calculatedStats = array ();
		} catch ( Exception $e ) {
			$InstantfbloginException = new InstantfbloginException ( $e->getMessage (), 'error' );
			$this->app->enqueueMessage ( $InstantfbloginException->getMessage (), $InstantfbloginException->getErrorLevel () );
			$calculatedStats = array ();
		}
		
		return $calculatedStats;
	}
	
	/**
	 * Get by remote server informations for new updates of this extension
	 *
	 * @access public
	 * @param InstantfbloginHttp $httpClient        	
	 * @return mixed An object json decoded from server if update information retrieved correctly otherwise false
	 */
	public function getUpdates(InstantfbloginHttp $httpClient) {
		// Updates server remote URI
		$option = $this->getState ( 'option', 'com_instantfblogin' );
		if (! $option) {
			return false;
		}
		$url = SERVER_REMOTE_URI . $option . UPDATES_FORMAT;
		
		// Try to get informations
		try {
			$response = $httpClient->get ( $url )->body;
			if ($response) {
				$decodedUpdateInfos = json_decode ( $response );
			}
			return $decodedUpdateInfos;
		} catch ( InstantfbloginException $e ) {
			return false;
		} catch ( Exception $e ) {
			return false;
		}
	}
	
	/**
	 * Class constructor
	 * 
	 * @access public
	 * @param array $config        	
	 * @return Object&
	 */
	public function __construct($config = array()) {
		// Parent constructor
		parent::__construct ( $config );
	}
}