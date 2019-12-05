<?php
declare(strict_types=1);
namespace Vms;

use Vms\ApiOperations\Request;

abstract class ApiResource extends VmsObject
{
    use Request;

    protected $_opts;

    public function __construct(?string $id = null, array $opts = [])
    {
        $this->_opts = Util\RequestOptions::parse($opts);

        parent::__construct($id);
    }

    /**
     * @return string the base URL for the given class
     */
    public static function baseUrl(): string
    {
        return Vms::$apiBase;
    }

    /**
     * @return string the endpoint URI for the given class
     */
    public static function classUri(): string
    {
        $base = str_replace('.', '/', static::OBJECT_NAME);

        return "/${base}";
    }

    public function refresh(): VmsObject
    {
        $client = new ApiClient($this->_opts, static::baseUrl());
        $url = $this->instanceUrl();

        $response = $client->request('get', $url);

        $this->setLastResponse($response);

        if (strstr($response->getHeaderLine('content-type'), 'image') ||
            'application/pdf' === $response->getHeaderLine('content-type')) {
            $this->buffer = new Buffer($response->getBody(), $response->getHeaderLine('content-type'));
        }

        $this->refreshFrom($response->getBody());

        return $this;
    }

    public static function resourceUrl(?string $id): string
    {
        if (null === $id) {
            $class = get_called_class();
            $message = 'Could not determine which URL to request: '
                . "$class instance has invalid ID: $id";
            throw new Error\InvalidRequest($message, null);
        }

        $base = static::classUri();
        $extn = urlencode($id);

        return rtrim(implode('/', [$base, $extn]), '/');
    }

    public function instanceUrl(): string
    {
        return static::resourceUrl($this['id']);
    }
}
