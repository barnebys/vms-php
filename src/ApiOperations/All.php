<?php
declare(strict_types=1);
namespace Vms\ApiOperations;

use Vms\Collection;

trait All
{
    public static function all(array $params = [], array $opts = []): Collection
    {
        $url = static::classUri();
        $response = static::_staticRequest('get', $url, $params, $opts);

        $collection = new Collection(static::OBJECT_NAME, $response->getBody());
        $collection->setLastResponse($response);

        return $collection;
    }
}
