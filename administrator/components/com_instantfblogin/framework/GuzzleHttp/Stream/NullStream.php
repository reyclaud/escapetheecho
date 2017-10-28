<?php
namespace GuzzleHttp\Stream;
use GuzzleHttp\Stream\Exception\CannotAttachException;
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
 * Does not store any data written to it.
 */
class NullStream implements StreamInterface
{
    public function __toString()
    {
        return '';
    }

    public function getContents()
    {
        return '';
    }

    public function close() {}

    public function detach() {}

    public function attach($stream)
    {
        throw new CannotAttachException();
    }

    public function getSize()
    {
        return 0;
    }

    public function isReadable()
    {
        return true;
    }

    public function isWritable()
    {
        return true;
    }

    public function isSeekable()
    {
        return true;
    }

    public function eof()
    {
        return true;
    }

    public function tell()
    {
        return 0;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        return false;
    }

    public function read($length)
    {
        return false;
    }

    public function write($string)
    {
        return strlen($string);
    }

    public function getMetadata($key = null)
    {
        return $key ? null : [];
    }
}
