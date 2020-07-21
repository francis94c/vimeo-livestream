<?php

namespace LiveStream\Resources;

class Account extends Resource
{
    public static function fromObject(object $object): Resource
    {
        $instance = parent::fromObject($object);

        $instance->picture = Picture::fromObject($instance->picture);
        
        return $instance;
    }
}
