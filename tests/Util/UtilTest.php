<?php

namespace Vms;

class UtilTest extends Tests\TestCase
{
    public function testIsList()
    {
        $list = [9, 'vms', []];
        $this->assertTrue(Util\Util::isList($list));

        $notlist = [9, 'vms', [], 'foo' => 'baz'];
        $this->assertFalse(Util\Util::isList($notlist));
    }

    public function testThatPHPHasValueSemanticsForArrays()
    {
        $original = ['php-arrays' => 'value-semantics'];
        $derived = $original;
        $derived['php-arrays'] = 'reference-semantics';

        $this->assertSame('value-semantics', $original['php-arrays']);
    }

    public function testConvertVmsObjectToArrayIncludesId()
    {
        $valuation = Util\Util::convertToVmsObject(
            [
                'id' => 'val_123'
            ],
            "valuation"
        );

        $this->assertTrue(array_key_exists("id", $valuation->__toArray(true)));
    }
}
