<?php
declare(strict_types=1);

namespace Vms\ApiOperations;

use Vms\Category;
use Vms\Collection;
use Vms\Currency;

trait Create
{
    public static function create(array $params = [], array $opts = [])
    {
        $params = self::normalizeParams($params);
        $uri = static::classUri();
        $response = static::_staticRequest('post', $uri, ['json' => $params], $opts);

        $json = $response->getBody();

        $instance = new static($json['id']);
        $instance->refreshFrom($params);

        return $instance;
    }

    public static function normalizeParams(array $params): array
    {
        if (isset($params['category']) && $params['category'] instanceof Category) {
            $params['category'] = $params['category']->getValue();
        }

        if (isset($params['currency']) && $params['currency'] instanceof Currency) {
            $params['currency'] = $params['currency']->getValue();
        }

        if (isset($params['images']) && $params['images'] instanceof Collection) {
            $params['images'] = $params['images']->toList();
        }

        return $params;
    }
}
