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
 * Custom table on the fly for 3PD extensions user store
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage tables
 * @since 1.6
 */
class TableCustom extends JTable {
	/**
	 *
	 * @param
	 *        	database A database connector object
	 */
	public function __construct($table, $key, &$db) {
		parent::__construct ( $table, $key, $db );
	}
}