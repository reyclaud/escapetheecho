<?php
// namespace administrator\components\com_instantfblogin\framework\http;
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
 * HTTP client class.
 *
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage http
 * @since 1.6
 */
class InstantfbloginHttp {
	/**
	 * Number of requests placed
	 * @var    Int 
	 * @since  11.3
	 */
	protected $numRequests;

	/**
	 * @var    JRegistry  Options for the HTTP client.
	 * @since  11.3
	 */
	protected $options;

	/**
	 * @var    InstantfbloginHttpTransport  The HTTP transport object to use in sending HTTP requests.
	 * @since  11.3
	 */
	protected $transport;

	/**
	 * Component params
	 * @var    Object&
	 * @access protected
	 */
	protected $cParams;
	
	/**
	 * Application object
	 * @var    Object&
	 * @access protected
	 */
	protected $app;

	/**
	 * Constructor.
	 *
	 * @param   InstantfbloginHttpTransport  $transport  The HTTP transport object.
	 * @param   $cParams Object& Component configuration
	 *
	 * @since   11.3
	 */
	public function __construct(InstantfbloginHttpTransport $transport = null, &$cParams = null) {
		$this->numRequests = 0;
		$this->cParams = $cParams;
		$this->app = JFactory::getApplication();

		if (is_null($transport) && !class_exists('InstantfbloginHttpTransportSocket')) {
			return false;
		}
		$this->transport = isset($transport) ? $transport : new InstantfbloginHttpTransportSocket($this->options);
	}

	/**
	 * Method to send the OPTIONS command to the server.
	 *
	 * @param   string  $url      Path to the resource.
	 * @param   array   $headers  An array of name-value pairs to include in the header of the request.
	 *
	 * @return  InstantfbloginHttpResponse
	 *
	 * @since   11.3
	 */
	public function options($url, array $headers = null) {
		$this->numRequests++;
		return $this->transport->request('OPTIONS', new JUri($url), null, $headers);
	}

	/**
	 * Method to send the HEAD command to the server.
	 *
	 * @param   string  $url      Path to the resource.
	 * @param   array   $headers  An array of name-value pairs to include in the header of the request.
	 *
	 * @return  InstantfbloginHttpResponse
	 *
	 * @since   11.3
	 */
	public function head($url, array $headers = null) {
		$this->numRequests++;
		return $this->transport->request('HEAD', new JUri($url), null, $headers);
	}

	/**
	 * Method to send the GET command to the server.
	 *
	 * @param   string  $url      Path to the resource.
	 * @param   array   $headers  An array of name-value pairs to include in the header of the request.
	 *
	 * @return  InstantfbloginHttpResponse
	 *
	 * @since   11.3
	 */
	public function get($url, array $headers = null) {
		$this->numRequests++;
		return $this->transport->request('GET', new JUri($url), null, $headers);
	}

	/**
	 * Method to send the POST command to the server.
	 *
	 * @param   string  $url      Path to the resource.
	 * @param   mixed   $data     Either an associative array or a string to be sent with the request.
	 * @param   array   $headers  An array of name-value pairs to include in the header of the request.
	 *
	 * @return  InstantfbloginHttpResponse
	 *
	 * @since   11.3
	 */
	public function post($url, $data, array $headers = null) {
		$this->numRequests++;
		return $this->transport->request('POST', new JUri($url), $data, $headers);
	}

	/**
	 * Method to send the PUT command to the server.
	 *
	 * @param   string  $url      Path to the resource.
	 * @param   mixed   $data     Either an associative array or a string to be sent with the request.
	 * @param   array   $headers  An array of name-value pairs to include in the header of the request.
	 *
	 * @return  InstantfbloginHttpResponse
	 *
	 * @since   11.3
	 */
	public function put($url, $data, array $headers = null) {
		$this->numRequests++;
		return $this->transport->request('PUT', new JUri($url), $data, $headers);
	}

	/**
	 * Method to send the DELETE command to the server.
	 *
	 * @param   string  $url      Path to the resource.
	 * @param   array   $headers  An array of name-value pairs to include in the header of the request.
	 *
	 * @return  InstantfbloginHttpResponse
	 *
	 * @since   11.3
	 */
	public function delete($url, array $headers = null) {
		$this->numRequests++;
		return $this->transport->request('DELETE', new JUri($url), null, $headers);
	}

	/**
	 * Method to send the TRACE command to the server.
	 *
	 * @param   string  $url      Path to the resource.
	 * @param   array   $headers  An array of name-value pairs to include in the header of the request.
	 *
	 * @return  InstantfbloginHttpResponse
	 *
	 * @since   11.3
	 */
	public function trace($url, array $headers = null) {
		$this->numRequests++;
		return $this->transport->request('TRACE', new JUri($url), null, $headers);
	}
}
