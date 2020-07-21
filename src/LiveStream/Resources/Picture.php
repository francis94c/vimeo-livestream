<?php

namespace LiveStream\Resources;

class Picture extends Resource
{
    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->data->url ?? null;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getThumbnailUrl(): ?string
    {
        return $this->data->url ?? null;
    }
}
