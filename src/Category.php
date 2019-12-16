<?php
declare(strict_types=1);
namespace Vms;

/**
 * Class Category.
 *
 * @property string $name
 */
class Category extends VmsObject
{
    const OBJECT_NAME = 'category';

    public static function constructFromLegacy(string $name): ?Category
    {
        $mapping = static::getLegacyMapping();

        if (isset($mapping->{$name})) {
            return self::constructFrom(['name' => $mapping->{$name}]);
        } else {
            throw new \Exception("Invalid legacy category $name");
        }
    }

    public static function getLegacyMapping(): \stdClass
    {
        return json_decode(file_get_contents(__DIR__ . '/../data/category_mapping.json'));
    }
}
