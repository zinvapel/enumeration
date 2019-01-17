<?php

namespace Zinvapel\Enumeration;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

abstract class BaseEnumeration
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string[]
     */
    protected $names = [];

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->validate($value);

        $this->value = $value;
    }

    /**
     * @param mixed $value
     * @return static
     */
    final public static function create($value)
    {
        return new static($value);
    }

    /**
     * @return mixed[]
     */
    final public static function getValuesList()
    {
        try {
            return (new ReflectionClass(get_called_class()))->getConstants();
        } catch (ReflectionException $e) {
            return []; // Never happens
        }
    }

    /**
     * @return string[]
     */
    final public static function getNamesList()
    {
        $values = static::getValuesList();

        return (new static(reset($values)))->names;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    final public static function contains($value)
    {
        return in_array($value, static::getValuesList(), true);
    }

    /**
     * @return mixed
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    final public function getName()
    {
        if (!isset($this->names[$this->getValue()])) {
            throw new InvalidArgumentException(
                sprintf("Name for value '%s' does not exists", $this->getValue())
            );
        }

        return $this->names[$this->getValue()];
    }

    /**
     * @param BaseEnumeration|mixed $value
     * @return bool
     */
    public function eq($value)
    {
        if (!is_object($value)) {
            return ($this->value === $value);
        }

        if (!is_a($value, get_class($this))) {
            return false;
        }
        /* @var BaseEnumeration $value */

        return $this->getValue() === $value->getValue();
    }

    /**
     * @param BaseEnumeration|mixed $value
     * @return bool
     */
    public function neq($value)
    {
        return !$this->eq($value);
    }

    /**
     * @param mixed $value
     * @return void
     * @throws InvalidArgumentException
     */
    private function validate($value)
    {
        if (!static::contains($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    "'%s' is not a valid value for '%s'",
                    $value,
                    get_called_class()
                )
            );
        }
    }
}
