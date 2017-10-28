<?php
namespace Happyr\LinkedIn\Http;
/**
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage Happyr
 * @subpackage LinkedIn
 * @subpackage Http
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
/**
 * Class RequestInterface.
 *
 * The Request purpose is to send a HTTP request to the API.
 *
 * @author Tobias Nyholm
 */
interface RequestInterface
{
    const USER_AGENT = 'Happyr/0.5';

    /**
     * Makes an HTTP request.
     *
     * @param string $method  HTTP method
     * @param string $url     The URL to make the request to
     * @param array  $options with all the options related to the array.
     *
     * @return string The response text
     *
     * @throws \Happyr\LinkedIn\Exceptions\LinkedInApiException
     */
    public function send($method, $url, array $options);

    /**
     * @return array|null with HTTP headers. The header name is the array key. Returns null of no previous request.
     */
    public function getHeadersFromLastResponse();
}
