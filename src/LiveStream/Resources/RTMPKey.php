<?php

namespace LiveStream\Resources;

use stdClass;

class RTMPKey
{
    /**
     * Resource Payload.
     *
     * @var object
     */
    private $data;

    /**
     * Class Constructor
     *
     * @param boolean $init
     */
    public function __construct(bool $init = false)
    {
        if ($init) $this->data - new stdClass();
    }

    /**
     * Factory Method.
     *
     * @param  object $object
     * @return \LiveStream\Resources\RTMPKey|null
     */
    public static function fromObject(?object $object): ?RTMPKey
    {
        if ($object == null) return null;

        $instance = new static(false);
        $instance->data = $object;
        return $instance;
    }

    /**
     * Get RTMP Key ID.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->data->id ?? null;
    }

    /**
     * Get RTMP Key URL.
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->data->rtmpUrl ?? null;
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
