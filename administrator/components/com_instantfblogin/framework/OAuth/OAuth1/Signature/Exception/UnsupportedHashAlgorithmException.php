<?php
// namespace administrator\components\com_instantfblogin\framework;
/**
 *
 * @package INSTANTFBLOGIN::CONFIG::administrator::components::com_instantfblogin
 * @subpackage framework
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
namespace OAuth\OAuth1\Signature\Exception;
defined ( '_JEXEC' ) or die ( 'Restricted access' );

use OAuth\Common\Exception\Exception;

/**
 * Thrown when an unsupported hash mechanism is requested in signature class.
 */
class UnsupportedHashAlgorithmException extends Exception
{
}
