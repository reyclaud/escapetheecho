<?php
namespace Happyr\LinkedIn\Storage;
/**
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage Happyr
 * @subpackage LinkedIn
 * @subpackage Storage
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
/**
 * Class DataStorage.
 *
 * We need to store data some where. It might be in a apc cache, filesystem cache, database or in the session.
 * We need it to protect us from CSRF attacks and to reduce the requests to the API.
 *
 * @author Tobias Nyholm
 */
interface DataStorageInterface
{
    /**
     * Stores the given ($key, $value) pair, so that future calls to
     * getPersistentData($key) return $value. This call may be in another request.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value);

    /**
     * Get the data for $key, persisted by BaseFacebook::setPersistentData().
     *
     * @param string $key     The key of the data to retrieve
     * @param mixed  $default The default value to return if $key is not found
     *
     * @return mixed
     */
    public function get($key, $default = false);

    /**
     * Clear the data with $key from the persistent storage.
     *
     * @param string $key
     */
    public function clear($key);

    /**
     * Clear all data from the persistent storage.
     */
    public function clearAll();
}
