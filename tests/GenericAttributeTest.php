<?php

namespace Attributes\Test;

use Attributes\Attr;
use Attributes\Types\GenericAttribute;
use Attributes\Types\StringAttribute;

class GenericAttributeTest extends BaseTestCase
{
    protected $data = [];

    public function setUp()
    {
        $this->data = [];
    }

    public function testGetter()
    {
        $attribute = Attr::generic($this->data);
        $object = $attribute->handle('hello');

        assertSame('hello', $this->data[__FUNCTION__]);
        assertSame($this, $object);
    }

    public function testSetter()
    {
        $attribute = Attr::generic($this->data);
        $value = $attribute->handle();

        assertNull($value);

        $attribute->handle('hello');
        assertSame('hello', $attribute->handle());
        assertSame('hello', $this->data[__FUNCTION__]);
    }
}
