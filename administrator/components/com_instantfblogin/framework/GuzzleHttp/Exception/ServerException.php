<?php
namespace GuzzleHttp\Exception;
/**
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage GuzzleHttp
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
/**
 * Exception when a server error is encountered (5xx codes)
 */
class ServerException extends BadResponseException {}
