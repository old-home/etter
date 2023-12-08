<?php

namespace Graywings\Etter;

use ReflectionException;
use ReflectionProperty;

trait Etter
{
    /**
     * @param string $name
     * @return mixed
     * @throws ReflectionException
     */
    public function __get(
        string $name
    ): mixed {
        $reflectionProperty = new ReflectionProperty(self::class, $name);
        $reflectionAttributes = $reflectionProperty->getAttributes(Get::class);
        if ($reflectionProperty->isStatic()) {
            throw new ReflectionException('Property ' . $name . ' is static. Not supported.');
        }
        if (empty($reflectionAttributes)) {
            throw new ReflectionException('Property ' . $name . ' is not attributed by Get class.');
        }
        return $this->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     * @throws ReflectionException
     */
    public function __set(
        string $name,
        mixed $value
    ): void {
        $reflectionProperty = new ReflectionProperty(self::class, $name);
        $reflectionAttributes = $reflectionProperty->getAttributes(Set::class);
        if ($reflectionProperty->isStatic()) {
            throw new ReflectionException('Property ' . $name . ' is static. Not supported.');
        }
        if (empty($reflectionAttributes)) {
            throw new ReflectionException('Property ' . $name . ' is not attributed by Set class.');
        }
        $this->$name = $value;
    }
}
