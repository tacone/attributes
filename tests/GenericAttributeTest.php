<?php

namespace Attributes\Test;

use Attributes\Attr;

class GenericAttributeTest extends BaseTestCase
{
    protected $data = [];
    public $publicData = [];

    public function setUp()
    {
        $this->data = [];
        $this->publicData = [];
    }

    public function testGetterWithImplicitProtectedTarget()
    {
        // test default property name on a protected member
        $attribute = Attr::generic();
        $object = $attribute->handle(['hello1']);

        assertSame('hello1', $this->data[__FUNCTION__]);
        assertSame($this, $object);
    }

    public function testGetterWithtImplicitPublicTarget()
    {
        // test default property name on a protected member
        Attr::$defaultTargetPropertyName = 'publicData';
        $attribute = Attr::generic();
        $object = $attribute->handle(['hello2']);
        Attr::$defaultTargetPropertyName = 'data'; //important


        assertSame('hello2', $this->publicData[__FUNCTION__]);
        assertSame($this, $object);
    }

    public function testGetter()
    {
        // test passing target explicitely
        $attribute = Attr::generic($this->data);
        $object = $attribute->handle(['hello3']);

        assertSame('hello3', $this->data[__FUNCTION__]);
        assertSame($this, $object);
    }

    public function fakeAttributeMethod($value = null)
    {
        $attribute = Attr::generic();
        return $attribute->handle();
    }

    public function testAutoArguments()
    {
        assertNull($this->fakeAttributeMethod());

        $object = $this->fakeAttributeMethod('hello4');
        assertSame('hello4', $this->fakeAttributeMethod());

        assertSame('hello4', $this->data['fakeAttributeMethod']);
        assertSame($this, $object);
    }

    public function testSetter()
    {
        $attribute = Attr::generic($this->data);
        $value = $attribute->handle([]);

        assertNull($value);

        $attribute->handle(['hello3']);
        assertSame('hello3', $attribute->handle());
        assertSame('hello3', $this->data[__FUNCTION__]);
    }
}
