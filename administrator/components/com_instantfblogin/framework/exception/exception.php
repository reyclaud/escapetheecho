<?php
// namespace administrator\components\com_instantfblogin\framework\exception;
/**
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage exception
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Instantfblogin Exception object
 *
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage exception
 * @since 1.6.5
 */
class InstantfbloginException extends Exception {
	/**
	 * Error level
	 * @access private
	 * @var string
	 */
	private $errorLevel;
	
	/**
	 * Error level accessor method
	 * @access public
	 * @return string
	 */
	public function getErrorLevel() {
		return $this->errorLevel;
	}
	
	/**
	 * Class constructor
	 * @access public
	 * @return Object&
	 */
	public function __construct($message, $level, $code = null) {
		parent::__construct($message, $code);
	
		// Set error level
		$this->errorLevel = $level;
	}
}