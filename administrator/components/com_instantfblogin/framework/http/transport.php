<?php
// namespace administrator\components\com_instantfblogin\framework\transport;
/**
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage http
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die('Restricted access');

/**
 * HTTP transport class interface.
 *
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage http
 * @since 1.6
 */
interface InstantfbloginHttpTransport {

	/**
	 * Send a request to the server and return a InstantfbloginHttpResponse object with the response.
	 *
	 * @param   string   $method     The HTTP method for sending the request.
	 * @param   JUri     $uri        The URI to the resource to request.
	 * @param   mixed    $data       Either an associative array or a string to be sent with the request.
	 * @param   array    $headers    An array of request headers to send with the request.
	 * @param   integer  $timeout    Read timeout in seconds.
	 * @param   string   $userAgent  The optional user agent string to send with the request.
	 *
	 * @return  InstantfbloginHttpResponse
	 *
	 * @since   11.3
	 */
	public function request($method, JUri $uri, $data = null, array $headers = null, $timeout = null, $userAgent = null);
}
