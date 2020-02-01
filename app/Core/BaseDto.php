<?php


namespace App\Core;


use ArrayAccess;
use JsonSerializable;
use App\Core\Contracts\Arrayable;

abstract class BaseDto implements JsonSerializable, ArrayAccess, Arrayable
{
    protected array $attributes = [];

    protected array $allowed = [];

    public function __construct(array $properties = [])
    {
        $this->allowed = array_flip($this->allowed);

        foreach ($properties as $property => $value) {
            if($this->allowed[$property]) {
                $this->attributes[$property] = $value;
            }
        }
    }

    public function __get($name)
    {
        return $this->attributes[$name];
    }

    public function __set($name, $value)
    {
        if($this->allowed[$name]) {
            $this->attributes[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public function validate(): array
    {
        return [];
    }

    public function validationMessages(): array
    {
        return [];
    }

    public function jsonSerialize()
    {
        return $this->attributes;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
