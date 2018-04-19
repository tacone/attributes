<?php

namespace Attributes;

use Attributes\Types\GenericAttribute;
use Attributes\Types\StringAttribute;

class Attr
{
    /**
     * @param $storage
     * @param null $path
     * @param null $return
     * @return StringAttribute
     */
    public static function string(&$storage, $path = null, $return = null)
    {
        $arguments = static::parseArgs($storage, $path, $return);

        return StringAttribute::make(...$arguments);
    }

    /**
     * @param $storage
     * @param null $path
     * @param null $return
     * @return GenericAttribute
     */
    public static function generic(&$storage, $path = null, $return = null)
    {
        $arguments = static::parseArgs($storage, $path, $return);

        return GenericAttribute::make(...$arguments);
    }

    /**
     *
     *
     * @param $storage
     * @param $path
     * @param $return
     * @return array
     */
    protected static function parseArgs(array &$storage, string $path = null, $return)
    {

        // lets get the invoking object. It will be returned by the mutator methods to as to
        // achieve a fluent interface

        $callingTrace = null;

        if (is_null($return)) {
            // if a return object is not passed we will assume it it the object that invoked this class
            $callingTrace = self::getCallingTrace();

            $return = $callingTrace['object']; // this may generate an error
        }

        if (is_null($path)) {
            // if the storage key was not specified we will use the calling method name
            // as the default

            $callingTrace = $callingTrace ?: static::getCallingTrace();
            $path = $callingTrace['function'];
        }

        // IMPORTANT: keep the reference!
        return [&$storage, $path, $return];
    }

    public static function getCallingTrace()
    {
        $callingTrace = null;

        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT) as $item) {
            // should not be this class or a subclass
            if ($item['class'] != static::class && $item['class'] != self::class) {
                $callingTrace = $item;
                break;
            }
        }

        if (empty($callingTrace)) {
            throw new \RuntimeException('Could not find instantiator object');
        }

        return $callingTrace;
    }
}
