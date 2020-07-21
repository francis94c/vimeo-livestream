<?php

namespace LiveStream\Resources;

/**
 * Account Object
 * 
 * @property int $id Account ID.
 */
class Account extends Resource
{
    public static function fromObject(object $object): Resource
    {
        $instance = parent::fromObject($object);

        $instance->picture = Picture::fromObject($instance->picture);

        return $instance;
    }
}
