<?php

namespace LiveStream\Resources;

use LiveStream\Resources\Resource;
use LiveStream\Exceptions\InValidResourceException;
use LiveStream\Interfaces\Resource as ResourceInterface;

class Event extends Resource implements ResourceInterface
{
    /**
     * Class Constructor.
     *
     * @param string  $fullName
     * @param boolean $init
     */
    public function __construct(string $fullName, bool $init = true)
    {
        parent::__construct($init);
        if ($init)
            $this->data->fullName  = $fullName;
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
    public function getTags()
    {
        return $this->data->tags ?? '';
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call(string $name, array $arguments)
    {
        switch ($name) {
            case 'getDraft':
                return $this->isDraft();
            case 'setDraft':
                return $this->setIsDraft($arguments[0]);
            default:
                return parent::__call($name, $arguments);
        }
    }

    /**
     * Resource Interface Method: Get Resource as JSON String.
     *
     * @return string
     */
    public function getResourceBody(): string
    {
        $body = ['fullName' => $this->data->fullName];

        $this->set_fields($body, [
            'shortName'                 => $this->data->shortName ?? null,
            'startTime'                 => $this->data->startTime ?? null,
            'endTime'                   => $this->data->endTime ?? null,
            'draft'                     => $this->data->draft ?? null,
            'description'               => $this->data->description ?? null,
            'tags'                      => ($this->data->tags ?? null) ? rtrim($this->data->tags, ',') : null,
            'isPublic'                  => $this->data->isPublic ?? null,
            'isSearchable'              => $this->data->isSearchable ?? null,
            'viewerCountVisible'        => $this->data->viewerCountVisible ?? null,
            'postCommentsEnabled'       => $this->data->postCommentsEnabled ?? null,
            'liveChatEnabled'           => $this->data->liveChatEnabled ?? null,
            'isEmbeddable'              => $this->data->isEmbeddable ?? null,
            'isPasswordProtected'       => $this->data->isPasswordProtected ?? null,
            'password'                  => $this->data->password ?? null,
            'isWhiteLabeled'            => $this->data->isWhiteLabeled ?? null,
            'embedRestriction'          => $this->data->embedRestriction ?? null,
            'embedRestrictionWhitelist' => $this->data->embedRestrictionWhitelist ?? null,
            'embedRestrictionBlacklist' => $this->data->embedRestrictionBlacklist ?? null,
        ]);

        return json_encode($body);
    }

    /**
     * Undocumented function
     *
     * @param  array $array
     * @param  array $map
     * @return void
     */
    private function set_fields(array &$array, array $map): void
    {
        foreach ($map as $key => $value) {
            if ($value)
                $array[$key] = $value;
        }
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getContentType(): string
    {
        return 'application/json';
    }

    /**
     * Validates the Event Resource.
     * 
     * @param bool $exists Whether resource is exists (being updated) or not.
     * 
     * @return void
     */
    public function validate(bool $exists = false): void
    {
        if (!$this->data->fullName ?? null) throw new InValidResourceException('Event', 'fullName');

        if (($this->data->isPasswordProtected ?? false) && (!$this->data->password ?? null)) {
            throw new InValidResourceException('Event', 'password (password must be present for a password protected event)');
        }

        if ($exists) {                   
            if (!$this->data->id ?? null) {
                throw new InValidResourceException('Event', 'id (Event ID must be present while updating an event.)');
            }
        }
    }
}
