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
    public function __construct(string $fullName, bool $init = true)
    {
        if ($init) {
            $this->data = new stdClass();
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
     * Set Full Name.
     *
     * @param  string $fullName
     * @return \LiveStream\Resources\Event
     */
    public function setFullName(string $fullName): Event
    {
        $this->data->fullName = $fullName;
        return $this;
    }

    /**
     * Get Full Name.
     *
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->data->fullName ?? null;
    }

    /**
     * Set Event Start Time.
     *
     * @param  string $strtime
     * @return \LiveStream\Resources\Event
     */
    public function setStartTime(string $strtime): Event
    {
        $this->data->startTime = date('c', strtotime($strtime));
        return $this;
    }

    /**
     * Get Start Time
     *
     * @return string
     */
    public function getStartTime(): ?string
    {
        return $this->data->startTime ?? null;
    }

    /**
     * Set End Time
     *
     * @param  string $strtime
     * @return \LiveStream\Resources\Event
     */
    public function setEndTime(string $strtime): Event
    {
        $this->data->endTime = date('c', strtotime($strtime));
        return $this;
    }

    /**
     * Get End Time.
     *
     * @return string
     */
    public function getEndTime(): ?string
    {
        return $this->data->endTime ?? null;
    }

    /**
     * Set Is Draft.
     *
     * @param boolean $isDraft
     * 
     * @return \LiveStream\Resources\Event
     */
    public function setIsDraft(bool $isDraft = true): Event
    {
        $this->data->draft = $isDraft;
        return $this;
    }

    /**
     * Get Is Draft.
     *
     * @return boolean
     */
    public function isDraft(): bool
    {
        return $this->data->draft ?? true;
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
     * Get Event Short Name.
     *
     * @return string|null
     */
    public function getShortName(): ?string
    {
        return $this->data->shortName ?? null;
    }

    /**
     * Set Event Description
     *
     * @param  string $description
     * @return Event
     */
    public function setDescription(string $description): Event
    {
        $this->data->description = $description;
        return $this;
    }

    /**
     * Get Description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->data->description ?? null;
    }

    /**
     * Add Event Tag
     *
     * @param  string $tag
     * @return \LiveStream\Resources\Event
     */
    public function addTag(string $tag): Event
    {
        if (!isset($this->data->tags)) $this->data->tags = '';

        $this->data->tags .= rtrim($tag, ',') . ',';

        return $this;
    }

    /**
     * Get Tags.
     *
     * @return string
     */
    public function getTags(): string
    {
        return $this->data->tags ?? '';
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
        if ($this->data->endTime ?? null) $body['endTime'] = $this->data->endTime;
        if ($this->data->draft ?? null) $body['draft'] = $this->data->draft;
        if ($this->data->description ?? null) $body['description'] = $this->data->description;
        if ($this->data->tags ?? null) $body['tags'] = rtrim($this->data->tags, ',');

        return http_build_query($body);
    }
}
