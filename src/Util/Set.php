<?php
declare(strict_types=1);

namespace Vms\Util;

use IteratorAggregate;
use ArrayIterator;

class Set implements IteratorAggregate
{
    private $_elts;

    public function __construct($members = [])
    {
        $this->_elts = [];
        foreach ($members as $item) {
            $this->_elts[$item] = true;
        }
    }

    public function includes(string $elt): bool
    {
        return isset($this->_elts[$elt]);
    }

    public function add(string $elt): void
    {
        $this->_elts[$elt] = true;
    }

    public function discard(string $elt): void
    {
        unset($this->_elts[$elt]);
    }

    public function toArray(): array
    {
        return array_keys($this->_elts);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }
}
