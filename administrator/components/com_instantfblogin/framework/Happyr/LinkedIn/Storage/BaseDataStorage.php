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
 * @author Tobias Nyholm
 */
abstract class BaseDataStorage implements DataStorageInterface
{
    public static $validKeys = array('state', 'code', 'access_token', 'user');

    /**
     * {@inheritDoc}
     */
    public function clearAll()
    {
        foreach (self::$validKeys as $key) {
            $this->clear($key);
        }
    }

    /**
     * Generate a session name.
     *
     * @param $key
     *
     * @return string
     */
    protected function constructSessionVariableName($key)
    {
        return 'linkedIn_'.$key;
    }
}
