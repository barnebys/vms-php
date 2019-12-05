<?php
declare(strict_types=1);
namespace Vms;

use GuzzleHttp\Psr7\Response;

class VmsObject implements \ArrayAccess, \Countable, \JsonSerializable
{
    protected $_values = [];
    protected $_lastResponse;

    public function __construct(?string $id = null)
    {
        if (null !== $id) {
            $this->_values['id'] = $id;
        }
    }

    public function updateAttributes(array $values): void
    {
        foreach ($values as $k => $v) {
            $objectName = is_string($k) ? $k : null;
            $this->_values[$k] = Util\Util::convertToVmsObject($v, $objectName);
        }
    }

    public static function constructFrom(array $values): VmsObject
    {
        $obj = new static(isset($values['id']) ? $values['id'] : null);
        $obj->refreshFrom($values);

        return $obj;
    }

    public function refreshFrom($values): void
    {
        if ($values instanceof VmsObject) {
            $values = $values->__toArray(true);
        }
        if (is_array($values)) {
            $this->updateAttributes($values);
        } else {
            $this->_values['data'] = $values;
        }
    }

    public function getValue(): string
    {
        if (isset($this->_values['data'])) {
            return $this->_values['data'];
        } else {
            return '';
        }
    }

    /**
     * Get last response.
     *
     * @return mixed
     */
    public function getLastResponse()
    {
        return $this->_lastResponse;
    }

    /**
     * Set last response.
     */
    public function setLastResponse(Response $response): void
    {
        $this->_lastResponse = $response;
    }

    public static function getPermanentAttributes(): Util\Set
    {
        static $permanentAttributes = null;

        if (null === $permanentAttributes) {
            $permanentAttributes = new Util\Set([
                'id',
            ]);
        }

        return $permanentAttributes;
    }

    public function offsetSet($k, $v): void
    {
        $this->$k = $v;
    }

    public function offsetExists($k): bool
    {
        return array_key_exists($k, $this->_values);
    }

    public function offsetUnset($k): void
    {
        unset($this->$k);
    }

    public function offsetGet($k)
    {
        return array_key_exists($k, $this->_values) ? $this->_values[$k] : null;
    }

    public function count(): int
    {
        if ($this instanceof \IteratorAggregate) {
            return iterator_count($this);
        } else {
            return count($this->_values);
        }
    }

    public function keys(): array
    {
        return array_keys($this->_values);
    }

    public function values(): array
    {
        return array_values($this->_values);
    }

    public function jsonSerialize(): array
    {
        return $this->__toArray(true);
    }

    public function __get($k)
    {
        if (isset($this->_values[$k])) {
            return $this->_values[$k];
        }
    }

    public function __set(string $k, $v): void
    {
        if (static::getPermanentAttributes()->includes($k)) {
            throw new \InvalidArgumentException("Cannot set $k on this object. HINT: you can't set: " . join(', ', static::getPermanentAttributes()->toArray()));
        }

        if ('' === $v) {
            throw new \InvalidArgumentException('You cannot set \'' . $k . '\'to an empty string. ' . 'We interpret empty strings as NULL in requests. ' . 'You may set obj->' . $k . ' = NULL to delete the property');
        }

        $this->_values[$k] = Util\Util::convertToVmsObject($v);
    }

    public function __isset(string $k): bool
    {
        return isset($this->_values[$k]);
    }

    public function __unset(string $k): void
    {
        unset($this->_values[$k]);
    }

    public function __toString(): string
    {
        $class = get_class($this);

        return $class . ' JSON: ' . $this->__toJSON();
    }

    public function __toJSON(): string
    {
        return json_encode($this->__toArray(true), JSON_PRETTY_PRINT);
    }

    public function __toArray(bool $recursive = false): array
    {
        if ($recursive) {
            return Util\Util::convertVmsObjectToArray($this->_values);
        } else {
            return $this->_values;
        }
    }
}
