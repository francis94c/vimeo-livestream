<?php

namespace LiveStream;

use Exception;

use LiveStream\Resources\Event;
use LiveStream\Resources\RTMPKey;
use LiveStream\Resources\Account;
use LiveStream\Interfaces\Resource;

use LiveStream\Exceptions\LiveStreamException;
use LiveStream\Exceptions\InValidResourceException;

class LiveStream
{
    /**
     * LiveStream Instance
     *
     * @var \LiveStream\LiveStream;
     */
    private static $instance = null;

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
     * API_KEY.
     *
     * @var string
     */
    private $apiKey;

    /**
     * Class Constructor
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Singleton getInstance function.
     *
     * @param  string|null $apiKey
     * @return \LiveStream\LiveStream
     */
    public static function getInstance(?string $apiKey = null): LiveStream
    {
        if (self::$instance == null) {
            self::$instance = new static($apiKey);
        }

        if ($apiKey) self::$instance->apiKey = $apiKey;

        return self::$instance;
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
     * CURL Request
     *
     * @param  string $endpoint
     * @return 
     */
    private function request(
        string $endpoint,
        string $verb = 'get',
        ?Resource $body = null,
        ?array $query = null
    ): ?string {
        $ch = curl_init();

        if (!$ch) throw new Exception("Could not initialize CURL.");

        curl_setopt(
            $ch,
            CURLOPT_URL,
            $this->get_base_url() . $endpoint . ($query ? '?' . http_build_query($query) : '')
        );

        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ':');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($verb != 'get') {
            if ($verb == 'post') curl_setopt($ch, CURLOPT_POST, true);
            if ($verb == 'put') curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            if ($body) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: ' . $body->getContentType()
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body->getResourceBody());
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
