<?php

namespace Entity;

/**
 * Base Entity
 *
 * @abstract
 *
 * @author Pomian Ghe. Aurelian
 */
abstract class BaseEntity
{
    /**
     * Set record values from array.
     *
     * @param array $array
     */
    public function setFromArray($array)
    {
        foreach ($array as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Convert record to array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }
}
