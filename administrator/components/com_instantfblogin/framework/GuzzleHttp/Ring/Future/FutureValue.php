<?php
namespace GuzzleHttp\Ring\Future;
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
 * Represents a future value that responds to wait() to retrieve the promised
 * value, but can also return promises that are delivered the value when it is
 * available.
 */
class FutureValue implements FutureInterface
{
    use BaseFutureTrait;
}
