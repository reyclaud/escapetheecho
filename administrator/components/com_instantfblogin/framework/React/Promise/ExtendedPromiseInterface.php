<?php
namespace React\Promise;
/**
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage React
 * @subpackage Promise
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
interface ExtendedPromiseInterface extends PromiseInterface
{
    /**
     * @return void
     */
    public function done(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null);

    /**
     * @return ExtendedPromiseInterface
     */
    public function otherwise(callable $onRejected);

    /**
     * @return ExtendedPromiseInterface
     */
    public function always(callable $onFulfilledOrRejected);

    /**
     * @return ExtendedPromiseInterface
     */
    public function progress(callable $onProgress);
}
