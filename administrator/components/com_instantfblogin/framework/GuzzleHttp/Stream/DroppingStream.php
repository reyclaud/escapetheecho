<?php
namespace GuzzleHttp\Stream;
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
 * Stream decorator that begins dropping data once the size of the underlying
 * stream becomes too full.
 */
class DroppingStream implements StreamInterface
{
    use StreamDecoratorTrait;

    private $maxLength;

    /**
     * @param StreamInterface $stream    Underlying stream to decorate.
     * @param int             $maxLength Maximum size before dropping data.
     */
    public function __construct(StreamInterface $stream, $maxLength)
    {
        $this->stream = $stream;
        $this->maxLength = $maxLength;
    }

    public function write($string)
    {
        $diff = $this->maxLength - $this->stream->getSize();

        // Begin returning false when the underlying stream is too large.
        if ($diff <= 0) {
            return false;
        }

        // Write the stream or a subset of the stream if needed.
        if (strlen($string) < $diff) {
            return $this->stream->write($string);
        }

        $this->stream->write(substr($string, 0, $diff));

        return false;
    }
}
