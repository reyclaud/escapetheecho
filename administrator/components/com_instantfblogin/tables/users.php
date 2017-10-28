<?php
// namespace administrator\components\com_instantfblogin\tables;
/**
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage tables
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.model' );

/**
 * Collected Facebook users table
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage tables
 * @since 1.6
 */
class TableUsers extends JTable {
	/**
	 * @var int Primary key
	 */
	var $id = null;
	
	/**
	 * @var string
	 */
	var $j_uid = null;
	
	/**
	 * @var string
	 */
	var $fb_uid = null;
	
	/**
	 * @var string
	 */
	var $email = null;
	
	/**
	 * @var string
	 */
	var $first_name = null;
	
	/**
	 * @var string
	 */
	var $last_name = null;
	
	/**
	 * @var int
	 */
	var $name = null;
	
	/**
	 * @var string
	 */
	var $gender = null;
	
	/**
	 * @var int
	 */
	var $geolocation = null;
	
	/**
	 * @var int
	 */
	var $registered_on = null;
	
	/**
	 * @var string
	 */
	var $last_update = null;
	
	/**
	 * @var string
	 */
	var $verified = null;
	
	/**
	 * @var string
	 */
	var $account_type = null;
	
	/**
	 * @var string
	 */
	var $picture = null;
	
	/**
	 *
	 * @param
	 *        	database A database connector object
	 */
	function __construct(&$db) {
		parent::__construct ( '#__instantfblogin', 'id', $db );
	}
}