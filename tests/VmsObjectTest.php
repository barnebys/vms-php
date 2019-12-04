<?php
declare(strict_types=1);

namespace Vms;

use Vms\Vms;
use Vms\Images;
use Vms\Valuation;

class VmsObjectTest extends Tests\TestCase
{
    public function testArrayAccessorsSemantics()
    {
        $s = new VmsObject();
        $s['foo'] = 'a';
        $this->assertSame($s['foo'], 'a');
        $this->assertTrue(isset($s['foo']));
        unset($s['foo']);
        $this->assertFalse(isset($s['foo']));
    }

    public function testNormalAccessorsSemantics()
    {
        $s = new VmsObject();
        $s->foo = 'a';
        $this->assertSame($s->foo, 'a');
        $this->assertTrue(isset($s->foo));
        unset($s->foo);
        $this->assertFalse(isset($s->foo));
    }

    public function testArrayAccessorsMatchNormalAccessors()
    {
        $s = new VmsObject();
        $s->foo = 'a';
        $this->assertSame($s['foo'], 'a');

        $s['bar'] = 'b';
        $this->assertSame($s->bar, 'b');
    }

    public function testCount()
    {
        $s = new VmsObject();
        $this->assertSame(0, count($s));

        $s['key1'] = 'value1';
        $this->assertSame(1, count($s));

        $s['key2'] = 'value2';
        $this->assertSame(2, count($s));

        unset($s['key1']);

        $this->assertSame(1, count($s));
    }

    public function testKeys()
    {
        $s = new VmsObject();
        $s->foo = 'bar';
        $this->assertSame($s->keys(), ['foo']);
    }

    public function testValues()
    {
        $s = new VmsObject();
        $s->foo = 'bar';
        $this->assertSame($s->values(), ['bar']);
    }

    public function testToArray()
    {
        $s = new VmsObject();
        $s->foo = 'a';

        $converted = $s->__toArray();

        $this->assertIsArray($converted);
        $this->assertArrayHasKey('foo', $converted);
        $this->assertEquals('a', $converted['foo']);
    }

    public function testRecursiveToArray()
    {
        $s = new VmsObject();
        $z = new VmsObject();

        $s->child = $z;
        $z->foo = 'a';

        $converted = $s->__toArray(true);

        $this->assertIsArray($converted);
        $this->assertArrayHasKey('child', $converted);
        $this->assertIsArray($converted['child']);
        $this->assertArrayHasKey('foo', $converted['child']);
        $this->assertEquals('a', $converted['child']['foo']);
    }

    public function testNonexistentProperty()
    {
        $s = new VmsObject();
        $this->assertNull($s->nonexistent);
    }

    public function testPropertyDoesNotExists()
    {
        $s = new VmsObject();
        $this->assertNull($s['nonexistent']);
    }

    public function testJsonEncode()
    {
        $s = new VmsObject();
        $s->foo = 'a';

        $this->assertEquals('{"foo":"a"}', json_encode($s));
    }

    public function testToString()
    {
        $s = new VmsObject();
        $s->foo = 'a';

        $string = $s->__toString();
        $expected = <<<EOS
Vms\VmsObject JSON: {
    "foo": "a"
}
EOS;
        $this->assertEquals($expected, $string);
    }

    public function testSetPermanentAttribute()
    {
        $this->expectException(\InvalidArgumentException::class);

        $s = new VmsObject();
        $s->id = 'abc_123';
    }

    public function testSetEmptyStringValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $s = new VmsObject();
        $s->foo = '';
    }
}
