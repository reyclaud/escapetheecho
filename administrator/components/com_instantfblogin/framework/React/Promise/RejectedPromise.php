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
class RejectedPromise implements ExtendedPromiseInterface, CancellablePromiseInterface
{
    private $reason;

    public function __construct($reason = null)
    {
        if ($reason instanceof PromiseInterface) {
            throw new \InvalidArgumentException('You cannot create React\Promise\RejectedPromise with a promise. Use React\Promise\reject($promiseOrValue) instead.');
        }

        $this->reason = $reason;
    }

    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        if (null === $onRejected) {
            return $this;
        }

        try {
            return resolve($onRejected($this->reason));
        } catch (\Exception $exception) {
            return new RejectedPromise($exception);
        }
    }

    public function done(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        if (null === $onRejected) {
            throw UnhandledRejectionException::resolve($this->reason);
        }

        $result = $onRejected($this->reason);

        if ($result instanceof self) {
            throw UnhandledRejectionException::resolve($result->reason);
        }

        if ($result instanceof ExtendedPromiseInterface) {
            $result->done();
        }
    }

    public function otherwise(callable $onRejected)
    {
        if (!_checkTypehint($onRejected, $this->reason)) {
            return $this;
        }

        return $this->then(null, $onRejected);
    }

    public function always(callable $onFulfilledOrRejected)
    {
        return $this->then(null, function ($reason) use ($onFulfilledOrRejected) {
            return resolve($onFulfilledOrRejected())->then(function () use ($reason) {
                return new RejectedPromise($reason);
            });
        });
    }

    public function progress(callable $onProgress)
    {
        return $this;
    }

    public function cancel()
    {
    }
}
