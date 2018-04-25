<?php

namespace Attributes\Test;

use Attributes\Attr;
use Attributes\Types\GenericAttribute;
use Attributes\Types\StringAttribute;

class ServiceLocatorTest extends BaseTestCase
{
    protected $data = [];

    public function setUp()
    {
        $this->data = [];
    }

    public function testParseArgs()
    {
        $attr = new class extends Attr
 {
     public static function parseArgs($numArgs, array &$storage = null, string $path = null, $return = null)
     {
         return parent::parseArgs($numArgs, $storage, $path, $return);
     }
 };

        $result = $attr->parseArgs(1, $this->data, null, null);
        assertCount(3, $result);

        assertSame($this->data, $result[0]);

        // test is a reference
        $this->data['a'] = 'apples';
        assertSame($this->data, $result[0]);

        // should have the same path as the name of this method
        $this->assertSame('testParseArgs', $result[1]);

        // should return the calling object instance
        $this->assertSame($this, $result[2]);
    }

    public function testGeneric()
    {
        assertInstanceOf(GenericAttribute::class, Attr::generic($this->data));
    }

    public function testString()
    {
        assertInstanceOf(StringAttribute::class, Attr::string($this->data));
    }

    public function testNotInObjectContextException()
    {
        $this->expectException(\RuntimeException::class);
        $stackTrace = [
            [
                'file'     => '/home/stefano/Code/attributes/vendor/composer/ClassLoader.php',
                'line'     => 322,
                'function' => 'Composer\\Autoload\\includeFile',
                'args'     => [
                        0 => '/home/stefano/Code/attributes/vendor/composer/../../src/Attr.php',
                    ],
            ],
        ];
        Attr::getCallingTrace($stackTrace);
    }
}
