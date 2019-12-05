<?php
declare(strict_types=1);

namespace Vms;

use Vms\Error;

/**
 * Class Images
 *
 * @property string $id
 * @property Buffer $buffer
 *
 * @package Vms
 */

class Images extends ApiResource
{
    const OBJECT_NAME = "image";
    const OBJECT_NAME_COLLECTION = "images";

    use ApiOperations\Fetch;

    // todo add buffer stream to boject
    public static function create(array $paths, array $opts = [])
    {
        foreach ($paths as $path) {
            if (!file_exists($path)) {
                throw new Error\InvalidRequest("File $path not found", $opts);
            }
        }
        
        $uri = static::classUri();
        $response = static::_upload($uri, $paths, $opts);

        $data = [];

        foreach ($response->getBody() as $id) {
            $data[] = ["id" => $id];
        }

        $collection = new Collection(static::OBJECT_NAME, $data);
        $collection->setLastResponse($response);

        return $collection;
    }

    public static function fetchZip(string $id, array $opts = []): Buffer
    {
        $url = implode("/", [static::classUri(), "all", $id]);

        $response = static::_staticRequest('get', $url, [], $opts);

        return new Buffer($response->getBody(), $response->getHeaderLine("content-type"));
    }

    public function setDefault($valuationId)
    {
        $url = implode("/", [static::classUri(), "setDefault", $valuationId, $this->id]);

        $response = static::_staticRequest('patch', $url);
    }
}
