<?php

namespace LiveStream\Resources;

use stdClass;
use LiveStream\Interfaces\Resource;

class Event implements Resource
{
    /**
     * Resource Payload.
     *
     * @var object
     */
    private $data;

    /**
     * Class Constructor.
     *
     * @param string  $fullName
     * @param boolean $init
     */
    public function __construct(string $fullName, bool $init = false)
    {
        if ($init) {
            $this->data - new stdClass();
            $this->data->fullName  = $fullName;
        }
    }

    /**
     * Factory Method.
     *
     * @param  object $object
     * @return \LiveStream\Resources\Event|null
     */
    public static function fromObject(?object $object): ?Event
    {
        if ($object == null) return null;
        
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

    /**
     * Set Event Start Time.
     *
     * @param string $strtime
     * @return Event
     */
    public function setStartTime(string $strtime): Event
    {
        $this->data->startTime = date('c', strtotime($strtime));
        return $this;
    }

    /**
     * Set Event Short Name.
     *
     * @param string $shortName
     * @return Event
     */
    public function setShortName(string $shortName): Event
    {
        $this->data->shortName = $shortName;
        return $this;
    }

    /**
     * Resource Interface Method: Get Resource as FormURLEncoded String.
     *
     * @return string
     */
    public function getRawBody(): string
    {
        $body = ['fullName' => $this->data->fullName];

        if ($this->data->shortName ?? null) $body['shortName'] = $this->data->shortName;
        if ($this->data->startTime ?? null) $body['startTime'] = $this->data->startTime;

        return http_build_query($body);
    }
}
