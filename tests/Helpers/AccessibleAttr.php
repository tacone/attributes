<?php

namespace Attributes\Test\Helpers;

use Attributes\Attr;

class AccessibleAttr extends Attr
{
    public static function parseArgs($numArgs, array &$storage = null, string $path = null, $return = null)
    {
        return parent::parseArgs($numArgs, $storage, $path, $return);
    }
}
