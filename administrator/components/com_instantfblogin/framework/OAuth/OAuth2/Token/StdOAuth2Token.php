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
namespace OAuth\OAuth2\Token;
defined ( '_JEXEC' ) or die ( 'Restricted access' );

use OAuth\Common\Token\AbstractToken;

/**
 * Standard OAuth2 token implementation.
 * Implements OAuth\OAuth2\Token\TokenInterface for any functionality that might not be provided by AbstractToken.
 */
class StdOAuth2Token extends AbstractToken implements TokenInterface
{
}
