<?php


namespace apps\enum\classier;


use ReflectionException;

class Utils
{

    /**
     * 当前实例的所有常量
     * @var array
     */
    protected static $constants = [];

    /**
     * 获取常量
     * @param $class
     * @return array
     * @throws ReflectionException
     */
    public static function getConstants($class): array
    {
        $className = is_object($class) ? get_class($class) : (string)$class;

        $className = ltrim($className, '\\');

        if (array_key_exists($className, self::$constants)) {
            return (array)self::$constants[$className];
        }

        return self::$constants[$className] = (new \ReflectionClass($class))->getConstants();
    }
}
