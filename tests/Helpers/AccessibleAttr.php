<?php

namespace Attributes\Test\Helpers;

use Attributes\Attr;

class AccessibleAttr extends Attr
{
    public static function parseArgs(array &$storage, string $path = null, $return)
    {
        return parent::parseArgs($storage, $path, $return);
    }
}
