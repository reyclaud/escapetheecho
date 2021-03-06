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
use Happyr\LinkedIn\Exceptions\LinkedInApiException;

/**
 * Class SessionStorage.
 *
 * Store data in the session.
 *
 * @author Tobias Nyholm
 */
class SessionStorage extends BaseDataStorage
{
    public function __construct()
    {
        //start the session if it not already been started
        if (php_sapi_name() !== 'cli') {
            if (session_id() === '') {
                session_start();
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value)
    {
        if (!in_array($key, self::$validKeys)) {
            throw new LinkedInApiException(sprintf('Unsupported key ("%s") passed to set.', $key));
        }

        $name = $this->constructSessionVariableName($key);
        $_SESSION[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = false)
    {
        if (!in_array($key, self::$validKeys)) {
            return $default;
        }

        $name = $this->constructSessionVariableName($key);

        return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }

    /**
     * {@inheritDoc}
     */
    public function clear($key)
    {
        if (!in_array($key, self::$validKeys)) {
            throw new LinkedInApiException(sprintf('Unsupported key ("%s") passed to clear.', $key));
        }

        $name = $this->constructSessionVariableName($key);
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }
}
