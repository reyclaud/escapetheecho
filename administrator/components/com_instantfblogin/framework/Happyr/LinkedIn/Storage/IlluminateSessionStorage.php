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
use Illuminate\Support\Facades\Session;

/**
 * Class SessionStorage.
 *
 * Store data in the session.
 *
 * @author Andreas Creten
 */
class IlluminateSessionStorage extends BaseDataStorage
{
    /**
     * {@inheritDoc}
     */
    public function set($key, $value)
    {
        if (!in_array($key, self::$validKeys)) {
            throw new LinkedInApiException(sprintf('Unsupported key ("%s") passed to set.', $key));
        }

        $name = $this->constructSessionVariableName($key);

        return Session::put($name, $value);
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

        return Session::get($name);
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

        return Session::forget($name);
    }
}
