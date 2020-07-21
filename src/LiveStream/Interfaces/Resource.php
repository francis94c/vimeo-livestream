<?php

namespace LiveStream\Interfaces;

interface Resource
{
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getRawBody(): string;
    
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getContentType(): string;
}
