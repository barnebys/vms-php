<?php
declare(strict_types=1);

namespace Vms;

class Collection extends VmsObject implements \IteratorAggregate
{
    const OBJECT_NAME = "list";

    public $data = [];

    public $totalCount = 0;

    protected $_objectName;

    protected $_objectMap = [
        'valuation' => 'valuations'
    ];

    public function __construct(string $objectName, array $data)
    {
        $this->_objectName = $objectName;

        if (isset($this->_objectMap[$objectName])) {
            $this->data = $data[$this->_objectMap[$objectName]];
            $this->totalCount = $data['totalCount'];
        } else {
            $this->data = $data;
            $this->totalCount = count($data);
        }

        $this->_convertDataToObject();
    }

    public function getTotalCount(): int {
        return $this->totalCount;
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    private function _convertDataToObject()
    {
        foreach ($this->data as &$element) {
            $element = Util\Util::convertToVmsObject($element, $this->_objectName);
        }
    }

    public function toArray(): array
    {
        return json_decode(json_encode($this->data), true);
    }

    public function toList(): array
    {
        $array = $this->toArray();

        foreach($array as &$item) {
            if (is_array($item)) {
                $item = current($item);
            }
        }

        return $array;
    }
}
