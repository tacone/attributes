<?php

namespace Attributes\Helpers;

class Access
{
    public static function getProxy($object)
    {
        $class = get_class($object);
        $accessorClass = 'attr' . md5($class);

        if (!class_exists($accessorClass)) {
            eval('class ' . $accessorClass . ' extends ' . $class . ' {
                   public static function &___getPropertyReference($object, $property) {             
                      return $object->$property;
                   }
                }');
        }
        return $accessorClass;
    }

    public static function &getPropertyReference($object, $property)
    {
        if (isset($object->$property)) {
            return $object->$property;
        }
        $accessorClass = static::getProxy($object);

        return $accessorClass::___getPropertyReference($object, $property);
    }
}
