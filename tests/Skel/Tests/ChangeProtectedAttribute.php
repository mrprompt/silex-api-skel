<?php
namespace Skel\Tests;

use ReflectionProperty;

/**
 * Reusable component to allow changing private/protected attributes
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
trait ChangeProtectedAttribute
{
    /**
     * Configures the attribute with the given value
     *
     * @param object $object
     * @param string $name
     * @param mixed $value
     */
    public function modifyAttribute($object, $name, $value)
    {
        $attribute = new ReflectionProperty($object, $name);

        $attribute->setAccessible(true);
        $attribute->setValue($object, $value);
    }
}
