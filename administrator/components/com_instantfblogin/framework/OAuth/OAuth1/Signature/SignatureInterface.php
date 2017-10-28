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
namespace OAuth\OAuth1\Signature;
defined ( '_JEXEC' ) or die ( 'Restricted access' );

use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Uri\UriInterface;

interface SignatureInterface
{
    /**
     * @param string $algorithm
     */
    public function setHashingAlgorithm($algorithm);

    /**
     * @param string $token
     */
    public function setTokenSecret($token);

    /**
     * @param UriInterface $uri
     * @param array        $params
     * @param string       $method
     *
     * @return string
     */
    public function getSignature(UriInterface $uri, array $params, $method = 'POST');
}
