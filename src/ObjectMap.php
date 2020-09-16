<?php

namespace Nfra\Status;

trait ObjectMap
{

    public static function select(array &$input = null, array $selector, $default=null) : self
    {
        foreach ($input as $cur) {
            if ( ! $cur instanceof self)
                throw new \InvalidArgumentException("property is required to be of type");
            foreach ($selector as $propName => $val) {
                if ( ! $cur->$propName === $val)
                    continue 2;
            }
            return $cur;
        }
        if ($default === null) {
            $instance = new self();
            foreach ($selector as $propName => $val)
                $instance->$propName = $val;
            $input[] = $instance;
            return $instance;
        }
        if ($default instanceof \Exception)
            throw $default;
        return $default;

    }

}