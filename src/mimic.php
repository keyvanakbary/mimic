<?php

namespace mimic;

function hydrate($class, array $attributes)
{
    $object = prototype($class);

    $reflection = new \ReflectionClass($object);
    foreach ($attributes as $name => $value) {
        if ($reflection->hasProperty($name)) {
            $property = $reflection->getProperty($name);
            $property->setAccessible(true);
            $property->setValue($object, $value);
        }
    }

    return $object;
}

function prototype($class)
{
    if (!class_exists($class)) {
        throw new \RuntimeException(sprintf('Class "%s" does not exist', $class));
    }

    return unserialize(sprintf('O:%u:"%s":0:{}', strlen($class), $class));
}

function expose($object)
{
    $reflection = new \ReflectionClass($object);

    return array_reduce($reflection->getProperties(),
        function ($values, \ReflectionProperty $property) use ($object) {
            $property->setAccessible(true);
            $values[$property->name] = $property->getValue($object);

            return $values;
        },
        array()
    );
}
