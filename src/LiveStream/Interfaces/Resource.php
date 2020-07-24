<?php

namespace LiveStream\Interfaces;

interface Resource
{
    /**
     * Get HTTP Compatible Resource Body.
     *
     * @return string
     */
    public function getResourceBody(): string;

    /**
     * Get HTTP Content Type.
     *
     * @return string
     */
    public function getContentType(): string;

    /**
     * Validate the Resource.
     * 
     * @param bool $exists Whether resource is exists (being updated) or not.
     *
     * @return void
     */
    public function validate(bool $exists = false): void;
}
