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
namespace OAuth\OAuth1\Token;
defined ( '_JEXEC' ) or die ( 'Restricted access' );

use OAuth\Common\Token\TokenInterface as BaseTokenInterface;

/**
 * OAuth1 specific token interface
 */
interface TokenInterface extends BaseTokenInterface
{
    /**
     * @return string
     */
    public function getAccessTokenSecret();

    /**
     * @param string $accessTokenSecret
     */
    public function setAccessTokenSecret($accessTokenSecret);

    /**
     * @return string
     */
    public function getRequestTokenSecret();

    /**
     * @param string $requestTokenSecret
     */
    public function setRequestTokenSecret($requestTokenSecret);

    /**
     * @return string
     */
    public function getRequestToken();

    /**
     * @param string $requestToken
     */
    public function setRequestToken($requestToken);
}
