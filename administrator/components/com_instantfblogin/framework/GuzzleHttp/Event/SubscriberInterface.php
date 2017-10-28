<?php
namespace GuzzleHttp\Event;
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
 * SubscriberInterface provides an array of events to an
 * EventEmitterInterface when it is registered. The emitter then binds the
 * listeners specified by the EventSubscriber.
 *
 * This interface is based on the SubscriberInterface of the Symfony.
 * @link https://github.com/symfony/symfony/tree/master/src/Symfony/Component/EventDispatcher
 */
interface SubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The returned array keys MUST map to an event name. Each array value
     * MUST be an array in which the first element is the name of a function
     * on the EventSubscriber OR an array of arrays in the aforementioned
     * format. The second element in the array is optional, and if specified,
     * designates the event priority.
     *
     * For example, the following are all valid:
     *
     *  - ['eventName' => ['methodName']]
     *  - ['eventName' => ['methodName', $priority]]
     *  - ['eventName' => [['methodName'], ['otherMethod']]
     *  - ['eventName' => [['methodName'], ['otherMethod', $priority]]
     *  - ['eventName' => [['methodName', $priority], ['otherMethod', $priority]]
     *
     * @return array
     */
    public function getEvents();
}