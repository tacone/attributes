<?php

namespace Attributes;

use Attributes\Helpers\Access;
use Attributes\Types\GenericAttribute;
use Attributes\Types\StringAttribute;

class Attr
{
    // TODO: make it protected
    public static $defaultTargetPropertyName = 'data';

    /**
     * @param $storage
     * @param null $path
     * @param null $return
     * @return StringAttribute
     */
    public static function string(&$storage, $path = null, $return = null)
    {
        $arguments = static::parseArgs(func_num_args(), $storage, $path, $return);

        return StringAttribute::make(...$arguments);
    }

    /**
     * @param $storage
     * @param null $path
     * @param null $return
     * @return GenericAttribute
     */
    public static function generic(&$storage = null, $path = null, $return = null)
    {
        $arguments = static::parseArgs(func_num_args(), $storage, $path, $return);

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
    protected static function parseArgs($numArgs, array &$storage = null, string $path = null, $return = null)
    {

        // lets get the invoking object. It will be returned by the mutator methods to as to
        // achieve a fluent interface

        $callingTrace = null;

        if ($numArgs < 3) {
            // if a return object is not passed we will assume it it the object that invoked this class
            $callingTrace = self::getCallingTrace();

            $return = $callingTrace['object']; // this may generate an error
        }

        if ($numArgs < 2) {
            // if the storage key was not specified we will use the calling method name
            // as the default

            $callingTrace = $callingTrace ?: static::getCallingTrace();

            $path = $callingTrace['function'];
        }

        if ($numArgs < 1) {
            $callingTrace = $callingTrace ?: static::getCallingTrace();
            $storage =& Access::getPropertyReference($callingTrace['object'], static::$defaultTargetPropertyName);
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
