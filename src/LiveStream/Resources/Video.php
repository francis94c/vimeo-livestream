<?php

namespace LiveStream\Resources;

/**
 * Video Object
 * 
 * @property int $id The integer representation of the unique identifier for this video post.
 * @property bool $draft This indicates whether or not the post is published.
 * @property int $views The number of times this video post was viewed.
 * @property object $likes An object containing a single property, total, which indicates the number of accounts who like this video post.
 * @property object $comments An object containing a single property, total, which indicates the number of accounts who have commented on this video post.
 * @property string $caption The user-defined title of the video post as a UTF-8 string.
 * @property string $description The user-defined detailed description of the video post as a UTF-8 string.
 * @property int $duration The duration of video in milliseconds.
 * @property int $eventId The unique ID of the event where this video post has been posted.
 * @property string $createdAt The creation date and time for the post as a string in ISO 8601 date time format.
 * @property ?string $publishAt Videos are published instantly by default unless draft is set to true. To publish an event in the future, set the date and time using ISO8601 date time format.
 * @property string $thumbnailUrl The full URL of the video thumbnail.
 * @property string $thumbnailUrlSmall The full URL of the small thumbnail of the video (150px x 84px).
 * @property string $m3u8 The m3u8 url of the live/VOD HLS stream (requires secure token authentication).
 * @property array $tags Tags given for the video post in an array.
 */
class Video extends Resource
{

}
