<?php
declare(strict_types=1);
namespace Vms;

/**
 * Class Options.
 *
 * @property string $systemOk
 * @property string $dbOk
 * @property VmsObject $apiGroups
 * @property Collection $categories
 * @property Collection $currencies
 * @property int $totalValuationsCount
 * @property VmsObject $valuationsCountByCategory
 */
class Options extends ApiResource
{
    const OBJECT_NAME = 'Options';

    public static function fetch(array $opts = []): Options
    {
        $instance = new static(null, $opts);

        $url = '/healthCheck';

        $response = static::_staticRequest('get', $url, [], $opts);

        $body = $response->getBody();

        /*
        foreach($body['categories'] as &$name) {
            $name = $name;
        }

        foreach($body['currencies'] as &$name) {
            $name = $name;
        }
        */

        $body['categories'] = $collection = new Collection(Category::OBJECT_NAME, $body['categories']);
        $body['currencies'] = $collection = new Collection(Currency::OBJECT_NAME, $body['currencies']);

        $instance->refreshFrom($body);

        return $instance;
    }
}
