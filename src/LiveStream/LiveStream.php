<?php

namespace LiveStream;

use CURLFile;
use Exception;

use LiveStream\Resources\Event;
use LiveStream\Resources\RTMPKey;
use LiveStream\Resources\Account;
use LiveStream\Interfaces\Resource;

use LiveStream\Exceptions\LiveStreamException;
use LiveStream\Exceptions\InValidResourceException;
use LiveStream\Resources\Video;

class LiveStream
{
    /**
     * Live Stream API Base URL.
     */
    const BASE_URL = 'https://livestreamapis.com/v3/';

    /**
     * LiveStream API HTTP Codes.
     */
    const ERROR_CODES = [
        400 => 'Bad Request: Your request is not properly constructed.',
        401 => 'Unauthorized: Your API key is incorrect.',
        403 => 'Forbidden:',
        405 => 'Method Not Allowed: You tried to access a resource with an invalid method.',
        406 => 'Not Acceptable: You requested a format that is not JSON.',
        500 => 'Internal Server Error: We had a problem with our server. Please try again later.',
        503 => 'Service Unavailable: We are temporarily offline for maintanance. Please try again later.'
    ];

    /**
     * API key.
     *
     * @var string
     */
    private $apiKey;

    /**
     * Client ID.
     *
     * @var int
     */
    private $clientId;

    /**
     * Scope.
     *
     * @var string
     */
    private $scope;

    /**
     * Secure access token.
     *
     * @var string
     */
    private $token;

    /**
     * Secure access token timestamp.
     *
     * @var int
     */
    private $tokenTimestamp;

    /**
     * Class Constructor.
     *
     * When only an API key is provided key auth method is used. When an API
     * key, client ID, and scope are provided secure token auth is used.
     *
     * @param string $apiKey
     * @param int|null $clientId
     * @param string|null $scope
     *   Valid scopes are: all, readonly, playback
     *
     * @see https://livestream.com/developers/docs/api/#authentication
     */
    public function __construct(
        string $apiKey,
        ?int $clientId = null,
        ?string $scope = null
    )
    {
        $this->apiKey = $apiKey;
        $this->clientId = $clientId;
        $this->scope = $scope;

        if ($this->clientId !== null && $this->scope !== null) {
            $this->refreshToken();
        }
    }

    /**
     * Get Linked LiveStream Accounts
     *
     * @return array Array of LiveStream Accounts
     */
    public function getAccounts(): array
    {
        $response = $this->request('accounts');

        $accounts = [];

        foreach (json_decode($response) as $account) {
            $accounts[] = Account::fromObject($account);
        }

        return $accounts;
    }

    /**
     * Get Specific Account
     *
     * @param  integer $accountId
     * @return Account|null
     */
    public function getAccount(int $accountId): ?Account
    {
        $response = $this->request("accounts/$accountId");
        if ($response === null) return null;

        return Account::fromObject(json_decode($response));
    }

    /**
     * Create New Event
     *
     * @param  integer $accountId
     * @param  Event $event
     * @return boolean
     */
    public function createEvent(int $accountId, Event &$event): bool
    {
        $event->validate();

        $response = $this->request("accounts/$accountId/events", 'post', $event);

        if ($response === null) return false;

        $event = Event::fromObject(json_decode($response));

        return true;
    }

    /**
     * Update Event.
     *
     * @param  integer $accountId
     * @param  LiveStream\Resources\Event $event
     * @return boolean
     */
    public function updateEvent(int $accountId, Event $event): bool
    {
        $event->validate(true);

        $response = $this->request("accounts/$accountId/events/$event->id", 'put', $event);

        if ($response === null) return false;

        return true;
    }

    /**
     * Delete Event
     *
     * @param  integer $accountId
     * @param  integer $eventId
     *
     * @return boolean
     */
    public function deleteEvent(int $accountId, int $eventId): ?Event
    {
        $response = $this->request("accounts/$accountId/events/$eventId", 'delete');

        if ($response === null) return null;

        return Event::fromObject(json_decode($response));
    }

    /**
     * Update Event Logo.
     *
     * @param  integer $accountId
     * @param  integer $eventId
     * @param  string  $filePath
     * @return boolean
     */
    public function updateEventLogo(int $accountId, int $eventId, string $filePath): Event
    {
        if (!in_array(mime_content_type($filePath), [
            'image/png',
            'image/jpg',
            'image/jpeg',
            'image/gif'
        ])) {
            throw new InValidResourceException('Logo', 'poster (MIME Type must be one of image/png, image/jpg, image/gif)');
        }

        $response = $this->request("accounts/$accountId/events/$eventId/logo", 'put', null, null, [
            'logo' => new CURLFile($filePath, mime_content_type($filePath), basename($filePath))
        ]);

        if ($response == null) return null;

        return Event::fromObject(json_decode($response));
    }

    /**
     * Gets Events by type.
     *
     * @param string $type
     *   Valid values: draft, past, private, or upcoming.
     * @param int $accountId
     * @param int $page
     * @param int $maxItems
     * @param string $order
     *
     * @return array
     *
     * @throws \LiveStream\Exceptions\LiveStreamException
     */
    protected function getEvents(
        string $type,
        int $accountId,
        int $page,
        int $maxItems,
        string $order
    ) {
        $events = [];

        $response = $this->request("accounts/{$accountId}/{$type}_events", 'get', null, [
          'page'     => $page,
          'maxItems' => $maxItems,
          'order'    => $order
        ]);

        if ($response === null) return $events;

        foreach (json_decode($response)->data as $event) {
            $events[] = Event::fromObject($event);
        }

        return $events;
    }

    /**
     * Get Draft Events
     *
     * @param integer $accountId
     * @param integer $page
     * @param integer $maxItems
     * @param string $order
     *
     * @return array
     *
     * @throws \LiveStream\Exceptions\LiveStreamException
     *
     * @see https://livestream.com/developers/docs/api/#get-draft-events
     */
    public function getDraftEvents(
        int $accountId,
        int $page = 1,
        int $maxItems = 10,
        string $order = 'desc'
    ): array {
        return $this->getEvents('draft', $accountId, $page, $maxItems, $order);
    }

    /**
     * Get Past Events
     *
     * @param integer $accountId
     * @param integer $page
     * @param integer $maxItems
     * @param string $order
     *
     * @return array
     *
     * @throws \LiveStream\Exceptions\LiveStreamException
     *
     * @see https://livestream.com/developers/docs/api/#get-past-events
     */
    public function getPastEvents(
        int $accountId,
        int $page = 1,
        int $maxItems = 10,
        string $order = 'desc'
    ): array {
        return $this->getEvents('past', $accountId, $page, $maxItems, $order);
    }

    /**
     * Get Private Events
     *
     * @param integer $accountId
     * @param integer $page
     * @param integer $maxItems
     * @param string $order
     *
     * @return array
     *
     * @throws \LiveStream\Exceptions\LiveStreamException
     *
     * @see https://livestream.com/developers/docs/api/#get-private-events
     */
    public function getPrivateEvents(
        int $accountId,
        int $page = 1,
        int $maxItems = 10,
        string $order = 'asc'
    ): array {
        return $this->getEvents('private', $accountId, $page, $maxItems, $order);
    }

    /**
     * Get Upcoming Events
     *
     * @param integer $accountId
     * @param integer $page
     * @param integer $maxItems
     * @param string $order
     *
     * @return array
     *
     * @throws \LiveStream\Exceptions\LiveStreamException
     *
     * @see https://livestream.com/developers/docs/api/#get-upcoming-events
     */
    public function geUpcomingEvents(
        int $accountId,
        int $page = 1,
        int $maxItems = 10,
        string $order = 'asc'
    ): array {
        return $this->getEvents('upcoming', $accountId, $page, $maxItems, $order);
    }

    /**
     * Get RTMP Key.
     *
     * @param  integer $accountId
     * @param  integer $eventId
     *
     * @return \LiveStream\Resources\RTMPKey|null
     */
    public function getRtmpKey(
        int $accountId,
        int $eventId,
        bool $notifyFollowers = false,
        bool $publishVideo = false,
        bool $saveVideo = false
    ): ?RTMPKey {

        $response = $this->request("accounts/$accountId/events/$eventId/rtmp", 'get', null, [
            'notifyFollowers' => $notifyFollowers,
            'publishVideo'    => $publishVideo,
            'saveVideo'       => $saveVideo
        ]);

        if ($response === null) return null;

        return RTMPKey::fromObject(json_decode($response));
    }

    /**
     * Reset RTMPKey
     *
     * @param  integer $accountId
     * @param  integer $eventId
     * @return \LiveStream\Resources\RTMPKey|null
     */
    public function resetRtmpKey(int $accountId, int $eventId): ?RTMPKey
    {
        $response = $this->request("accounts/$accountId/events/$eventId/rtmp", 'put');

        if ($response === null) return null;

        return RTMPKey::fromObject(json_decode($response));
    }

    /**
     * Gets current live Video for an Event, if one exists.
     *
     * @param int $accountId
     * @param int $eventId
     * @param ?int $offsetPostId
     * @param ?int $older
     * @param ?int $newer
     *
     * @return \LiveStream\Resources\Video|null
     *
     * @see https://livestream.com/developers/docs/api/#get-videos
     *
     * @throws \LiveStream\Exceptions\LiveStreamException
     */
    public function getLiveVideo(
      int $accountId,
      int $eventId,
      ?int $offsetPostId = null,
      ?int $older = null,
      ?int $newer = null
    ): ?Video {
        $video = null;

        $response = $this->request("accounts/$accountId/events/$eventId/videos", 'get', null, [
          'offsetPostId' => $offsetPostId,
          'older'        => $older,
          'newer'        => $newer
        ]);

        if ($response === null) return null;

        $response_data = json_decode($response);

        if ($response_data->live) {
            /** @var \LiveStream\Resources\Video $video */
            $video = Video::fromObject($response_data->live);
        }

        return $video;
    }

    /**
     * Gets URL of a Video's HLS stream (m3u8) file with access token.
     *
     * Requires a secure access token. Generates the URL using the "playback"
     * scope.
     *
     * @param \LiveStream\Resources\Video $video
     *
     * @return string|null
     */
    public function getVideoHlsFileUrl(Video $video): ?string {
        if (!$video->m3u8) return null;

        $token = $this->generateToken('playback');
        $query = [
          'clientId' => $this->clientId,
          'timestamp' => $token['timestamp'],
          'token' => $token['token']
        ];
        return $video->m3u8 . '?' . http_build_query($query);
    }

    /**
     * Gets contents of a Video's HLS stream (m3u8) file.
     *
     * Requires a secure access token.
     *
     * @param \LiveStream\Resources\Video $video
     *
     * @return string|null
     * @throws \LiveStream\Exceptions\LiveStreamException
     */
    public function getVideoHlsFileContents(Video $video): ?string {
        if (!$video->m3u8) return null;

        $endpoint = substr($video->m3u8, strlen(self::BASE_URL));
        return $this->request($endpoint);
    }

    /**
     * Refreshes a secure access token if invalid (5 minute life time).
     *
     * @see https://github.com/Livestream/livestream-api-samples/tree/master/php/secure-token-auth-sample
     */
    private function refreshToken(): void
    {
        $now = round(microtime(true) * 1000);
        if (!$this->tokenTimestamp || round(($now - $this->tokenTimestamp)/1000) > 300) {
            $token = $this->generateToken();
            $this->tokenTimestamp = $token['timestamp'];
            $this->token = $token['token'];
        }
    }

    /**
     * Generates a new token with optional scope override.
     *
     * @param string|null $scope
     *
     * @return array
     */
    private function generateToken(?string $scope = null): array {
        $scope = $scope ?? $this->scope;
        $timestamp = round(microtime(true) * 1000);
        $token = hash_hmac('md5', "{$this->apiKey}:{$scope}:{$timestamp}", $this->apiKey);
        return [
            'timestamp' => (int) $timestamp,
            'scope' => $scope,
            'token' => $token,
        ];
    }

    /**
     * CURL Request
     *
     * @param string $endpoint
     * @param string $verb
     * @param \LiveStream\Interfaces\Resource|null $body
     * @param array|null $query
     * @param array|null $multipartFormData
     *
     * @return string|null
     *
     * @throws \LiveStream\Exceptions\LiveStreamException
     */
    private function request(
        string $endpoint,
        string $verb = 'get',
        ?Resource $body = null,
        ?array $query = null,
        ?array $multipartFormData = null
    ): ?string {
        $ch = curl_init();

        if (!$ch) throw new Exception("Could not initialize CURL.");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if ($this->token && $this->clientId && $this->tokenTimestamp) {
            $this->refreshToken();
            $query['timestamp'] = $this->tokenTimestamp;
            $query['clientId'] = $this->clientId;
            $query['token'] = $this->token;
        }
        else {
            curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ':');
        }

        curl_setopt(
            $ch,
            CURLOPT_URL,
            $this->get_base_url() . $endpoint . ($query ? '?' . http_build_query($query) : '')
        );

        if ($verb != 'get') {
            if ($verb == 'post') curl_setopt($ch, CURLOPT_POST, true);
            if ($verb == 'put') curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            if ($verb == 'delete') curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            if ($body) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: ' . $body->getContentType()
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body->getResourceBody());
            } elseif ($multipartFormData) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: multipart/form-data'
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $multipartFormData);
            }
        }

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($code == 200 || $code == 201) return $response;

        if ($code == 404) return null;

        if ($code <= 199) throw new Exception("A CURL erorr with code '$code', has occurred.");

        if ($code == 403) throw new LiveStreamException(self::ERROR_CODES[$code] . ' ' . json_decode($response)->message);

        throw new LiveStreamException(self::ERROR_CODES[$code]);
    }

    /**
     * Get Base URL.
     *
     * @return string
     */
    private function get_base_url(): string
    {
        return getenv('LIB_ENV') == 'testing' ? 'http://127.0.0.1:3067/' : self::BASE_URL;
    }
}
