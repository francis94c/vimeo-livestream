<?php

namespace LiveStream\Resources;

use stdClass;

class Account
{
    /**
     * Account Payload.
     *
     * @var object
     */
    private $data;

    /**
     * Class Constructor.
     *
     * @param boolean $init
     */
    public function __construct(bool $init = true)
    {
        if ($init) $this->data = new stdClass();
    }

    /**
     * Factory Method.
     *
     * @param  object $object
     * @return \LiveStream\Resources\Account
     */
    public static function fromObject(object $object): Account
    {
        $instance = new static(false);
        $instance->data = $object;
        return $instance;
    }

    /**
     * Magic Setter Method
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function __set(string $key, $value): void
    {
        $this->data->$key = $value;
    }

    /**
     * Magic Getter Method
     *
     * @param  string $key
     * @return void
     */
    public function __get(string $key)
    {
        return $this->data->$key ?? null;
    }

    /**
     * Magic Method Isset.
     *
     * @param  string  $key
     * @return boolean
     */
    public function __isset(string $key)
    {
        return isset($this->data->$key);
    }
}
