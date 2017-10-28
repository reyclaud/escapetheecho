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
 * Future that provides array-like access.
 */
interface FutureArrayInterface extends
    FutureInterface,
    \ArrayAccess,
    \Countable,
    \IteratorAggregate {};
