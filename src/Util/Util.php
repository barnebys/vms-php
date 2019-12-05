<?php
declare(strict_types=1);
namespace Vms\Util;

use Vms\VmsObject;

abstract class Util
{
    public static function getClassName(string $name): ?string
    {
        $types = [
            /* Data Objects */
            \Vms\Buffer::OBJECT_NAME => 'Vms\\Buffer',

            /* API Objects */
            \Vms\Valuation::OBJECT_NAME => 'Vms\\Valuation',
            \Vms\Images::OBJECT_NAME => 'Vms\\Images',
            \Vms\Images::OBJECT_NAME_COLLECTION => 'Vms\\Images',

            /* Helper Objects */
            \Vms\Category::OBJECT_NAME => 'Vms\\Category',
            \Vms\Currency::OBJECT_NAME => 'Vms\\Currency',
            \Vms\Dimensions::OBJECT_NAME => 'Vms\\Dimensions',
            \Vms\Insurance::OBJECT_NAME => 'Vms\\Insurance',
            \Vms\ValueRange::OBJECT_NAME => 'Vms\\ValueRange',
        ];

        if (isset($types[$name])) {
            return $types[$name];
        }

        return null;
    }

    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }
        if ($array === []) {
            return true;
        }
        if (array_keys($array) !== range(0, count($array) - 1)) {
            return false;
        }

        return true;
    }

    public static function convertVmsObjectToArray($values)
    {
        $results = [];
        foreach ($values as $k => $v) {
            if ('_' == $k[0]) {
                continue;
            }
            if ($v instanceof VmsObject) {
                $results[$k] = $v->__toArray(true);
            } elseif (is_array($v)) {
                $results[$k] = self::convertVmsObjectToArray($v);
            } else {
                $results[$k] = $v;
            }
        }

        return $results;
    }

    public static function convertToVmsObject($values, ?string $objectName = null)
    {
        if (!is_null($objectName) && ($class = static::getClassName($objectName))) {
            $object = new $class(isset($values['id']) ? $values['id'] : null);
            $object->refreshFrom($values);

            return $object;
        } elseif (self::isList($values)) {
            return VmsObject::constructFrom($values);
        } elseif (is_array($values)) {
            return VmsObject::constructFrom($values);
        } else {
            return $values;
        }
    }
}
