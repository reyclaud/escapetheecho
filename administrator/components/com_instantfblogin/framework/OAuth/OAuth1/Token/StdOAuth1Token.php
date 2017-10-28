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

use OAuth\Common\Token\AbstractToken;

/**
 * Standard OAuth1 token implementation.
 * Implements OAuth\OAuth1\Token\TokenInterface in case of any OAuth1 specific features.
 */
class StdOAuth1Token extends AbstractToken implements TokenInterface
{
    /**
     * @var string
     */
    protected $requestToken;

    /**
     * @var string
     */
    protected $requestTokenSecret;

    /**
     * @var string
     */
    protected $accessTokenSecret;

    /**
     * @param string $requestToken
     */
    public function setRequestToken($requestToken)
    {
        $this->requestToken = $requestToken;
    }

    /**
     * @return string
     */
    public function getRequestToken()
    {
        return $this->requestToken;
    }

    /**
     * @param string $requestTokenSecret
     */
    public function setRequestTokenSecret($requestTokenSecret)
    {
        $this->requestTokenSecret = $requestTokenSecret;
    }

    /**
     * @return string
     */
    public function getRequestTokenSecret()
    {
        return $this->requestTokenSecret;
    }

    /**
     * @param string $accessTokenSecret
     */
    public function setAccessTokenSecret($accessTokenSecret)
    {
        $this->accessTokenSecret = $accessTokenSecret;
    }

    /**
     * @return string
     */
    public function getAccessTokenSecret()
    {
        return $this->accessTokenSecret;
    }
}
