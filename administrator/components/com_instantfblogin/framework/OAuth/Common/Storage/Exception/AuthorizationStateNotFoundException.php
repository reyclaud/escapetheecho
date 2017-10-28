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
namespace OAuth\Common\Storage\Exception;
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * Exception thrown when a state is not found in storage.
 */
class AuthorizationStateNotFoundException extends StorageException
{
}
