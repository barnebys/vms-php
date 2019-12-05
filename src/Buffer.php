<?php
declare(strict_types=1);
namespace Vms;

use GuzzleHttp\Psr7\Stream;

/**
 * Class Buffer.
 */
class Buffer
{
    const OBJECT_NAME = 'buffer';

    private $_stream;

    private $_contentType;

    public function __construct(Stream $stream, string $contentType)
    {
        $this->_stream = $stream;
        $this->_contentType = $contentType;
    }

    public function saveTo(string $path): void
    {
        file_put_contents($path, $this->_stream->getContents());
    }

    public function getStream(): Stream
    {
        return $this->_stream;
    }

    public function getContentType(): string
    {
        return $this->_contentType;
    }

    public function output()
    {
        header('Content-Type: ' . $this->getContentType());
        echo $this->getStream()->getContents();
    }
}
