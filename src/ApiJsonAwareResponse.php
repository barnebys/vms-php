<?php
declare(strict_types=1);
namespace Vms;

use GuzzleHttp\Psr7\Response;

class ApiJsonAwareResponse extends Response
{
    /**
     * Cache for performance.
     *
     * @var array
     */
    private $json;

    public function getBody()
    {
        if ($this->json) {
            return $this->json;
        }
        // get parent Body stream

        // if JSON HTTP header detected - then decode
        if (false !== strpos($this->getHeaderLine('Content-Type'), 'application/json')) {
            $body = (string) parent::getBody()->getContents();

            return /*$this->json =*/ \json_decode($body, true);
        }

        return parent::getBody();
    }
}
