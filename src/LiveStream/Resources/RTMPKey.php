<?php

namespace LiveStream\Resources;

use LiveStream\Resources\Resource;

class RTMPKey extends Resource
{
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
}
