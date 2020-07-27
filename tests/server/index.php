<?php

require_once __DIR__ . '/../../vendor/autoload.php';

class LiveStreamServerStub
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function processGetAccountsRequest(): void
    {
        Flight::json([
            [
                "id" => 18855759,
                "description" => "API Test Account",
                "email" => "apitest@livestream.com",
                "timezone" => "Asia/Kolkata",
                "picture" => [
                    "url" => "https=>//img.new.livestream.com/accounts/00000000011fb74f/c1d97257-82a4-4003-a507-8e1305fc5c85.jpg",
                    "thumbnailUrl" => "https=>//img.new.livestream.com/accounts/00000000011fb74f/c1d97257-82a4-4003-a507-8e1305fc5c85_50x50.jpg"
                ],
                "followers" => [
                    "total" => 100
                ],
                "following" => [
                    "total" => 1
                ],
                "fullName" => "Apitest",
                "shortName" => "apitest",
                "createdAt" => "2016-04-15T06=>59=>07.783Z",
                "draftEvents" => [
                    "total" => 1
                ],
                "privateEvents" => [
                    "total" => 0
                ],
                "upcomingEvents" => [
                    "total" => 2
                ],
                "pastEvents" => [
                    "total" => 10
                ]
            ],
            [
                "id" => 18855760,
                "description" => "API Test Account 2",
                "email" => "apitest2@livestream.com",
                "timezone" => "Asia/Kolkata",
                "picture" => [
                    "url" => "https=>//img.new.livestream.com/accounts/00000000011fb74f/c1d97257-82a4-4003-a507-8e1305fc5c86.jpg",
                    "thumbnailUrl" => "https=>//img.new.livestream.com/accounts/00000000011fb74f/c1d97257-82a4-4003-a507-8e1305fc5c86_50x50.jpg"
                ],
                "followers" => [
                    "total" => 10
                ],
                "following" => [
                    "total" => 12
                ],
                "fullName" => "Apitest2",
                "shortName" => "apitest2",
                "createdAt" => "2016-5-15T06=>59=>07.783Z",
                "draftEvents" => [
                    "total" => 0
                ],
                "privateEvents" => [
                    "total" => 2
                ],
                "upcomingEvents" => [
                    "total" => 4
                ],
                "pastEvents" => [
                    "total" => 1
                ]
            ]
        ], 200);
    }
    public function processGetSpecificAccountRequest(int $accountId): void
    {
        if ($accountId == 18855760) {
            Flight::json([
                "id" => 18855760,
                "description" => "API Test Account 2",
                "email" => "apitest2@livestream.com",
                "timezone" => "Asia/Kolkata",
                "picture" => [
                    "url" => "https=>//img.new.livestream.com/accounts/00000000011fb74f/c1d97257-82a4-4003-a507-8e1305fc5c86.jpg",
                    "thumbnailUrl" => "https=>//img.new.livestream.com/accounts/00000000011fb74f/c1d97257-82a4-4003-a507-8e1305fc5c86_50x50.jpg"
                ],
                "followers" => [
                    "total" => 10
                ],
                "following" => [
                    "total" => 12
                ],
                "fullName" => "Apitest2",
                "shortName" => "apitest2",
                "createdAt" => "2016-5-15T06=>59=>07.783Z",
                "draftEvents" => [
                    "total" => 0
                ],
                "privateEvents" => [
                    "total" => 2
                ],
                "upcomingEvents" => [
                    "total" => 4
                ],
                "pastEvents" => [
                    "total" => 1
                ]
            ]);
            return;
        }

        Flight::notFound();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function processCreateEventRequest(int $accountId): void
    {
        if (!Flight::request()->type == 'application/json') {
            Flight::json([
                'code'    => 400,
                'message' => 'Your request is not properly constructed'
            ], 400);
            return;
        }

        if (!$accountId == 564653) return;

        Flight::json([
            "id" => 5201483,
            "logo" => [
                "url" => "https=>//cdn.livestream.com/newlivestream/poster-default.jpeg",
                "thumbnailUrl" => "https=>//cdn.livestream.com/newlivestream/poster-default.jpeg",
                "smallUrl" => "https=>//cdn.livestream.com/newlivestream/poster-default.jpeg"
            ],
            "description" => Flight::request()->data->description,
            "likes" => [
                "total" => 0
            ],
            "fullName" => Flight::request()->data->fullName,
            "shortName" => Flight::request()->data->shortName,
            "ownerAccountId" => $accountId,
            "viewerCount" => 0,
            "createdAt" => date('c'),
            "startTime" => Flight::request()->data->startTime ?? '',
            "endTime" => Flight::request()->data->endTime ?? '',
            "draft" => Flight::request()->data->draft ?? true,
            "tags" => explode(',', Flight::request()->data->tags ?? ''),
            "isPublic" => Flight::request()->data->isPublic ?? true,
            "isSearchable" => Flight::request()->data->isSearchable ?? true,
            "viewerCountVisible" => Flight::request()->data->viewerCountVisible ?? true,
            "postCommentsEnabled" => Flight::request()->data->postCommentsEnabled ?? true,
            "liveChatEnabled" => Flight::request()->data->liveChatEnabled ?? true,
            "isEmbeddable" => Flight::request()->data->isEmbeddable ?? true,
            "isPasswordProtected" => false,
            "isWhiteLabeled" => true,
            "embedRestriction" => "off",
            "embedRestrictionWhitelist" => [
                "*.lsops.org/*"
            ],
            "embedRestrictionBlacklist" => null,
            "isLive" => false
        ], 200);
    }

    /**
     * Undocumented function
     *
     * @param  integer $accountId
     * @param  integer $eventId
     * @return void
     */
    public function processUpdateEventRequest(int $accountId, int $eventId): void
    {
        if ($accountId != 5637245 || $eventId != 3456343) {
            Flight::json([
                'code'    => 404,
                'message' => ''
            ], 404);
            return;
        }
        Flight::json(json_decode(json_encode(Flight::request()->data)), 200);
    }

    /**
     * Undocumented function
     *
     * @param  integer  $accountId
     * @param  integer  $eventId
     * @return void
     */
    public function processUpdateEventPosterRequest(int $accountId, int $eventId): void
    {
        if ($accountId != 5637245 || $eventId != 5201483) {
            Flight::json([
                'code'    => 404,
                'message' => ''
            ], 404);
            return;
        }

        $file =  file_get_contents("php://input");

        if (strpos($file, 'Content-Type: image/jpeg') === null) {
            Flight::json([
                'code'    => 400,
                'message' => ''
            ], 400);
            return;
        }

        Flight::json([
            "id" => 5201483,
            "logo" => [
                "url" => "https=>//cdn.livestream.com/newlivestream/poster-default.jpeg",
                "thumbnailUrl" => "https=>//cdn.livestream.com/newlivestream/poster-default.jpeg",
                "smallUrl" => "https=>//cdn.livestream.com/newlivestream/poster-default.jpeg"
            ],
            "description" => Flight::request()->data->description,
            "likes" => [
                "total" => 0
            ],
            "fullName" => Flight::request()->data->fullName,
            "shortName" => Flight::request()->data->shortName,
            "ownerAccountId" => $accountId,
            "viewerCount" => 0,
            "createdAt" => date('c'),
            "startTime" => Flight::request()->data->startTime ?? '',
            "endTime" => Flight::request()->data->endTime ?? '',
            "draft" => Flight::request()->data->draft ?? true,
            "tags" => explode(',', Flight::request()->data->tags ?? ''),
            "isPublic" => Flight::request()->data->isPublic ?? true,
            "isSearchable" => Flight::request()->data->isSearchable ?? true,
            "viewerCountVisible" => Flight::request()->data->viewerCountVisible ?? true,
            "postCommentsEnabled" => Flight::request()->data->postCommentsEnabled ?? true,
            "liveChatEnabled" => Flight::request()->data->liveChatEnabled ?? true,
            "isEmbeddable" => Flight::request()->data->isEmbeddable ?? true,
            "isPasswordProtected" => false,
            "isWhiteLabeled" => true,
            "embedRestriction" => "off",
            "embedRestrictionWhitelist" => [
                "*.lsops.org/*"
            ],
            "embedRestrictionBlacklist" => null,
            "isLive" => false
        ], 200);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function processGetDraftEvents(int $accountId): void
    {
        if (!$this->authenticate()) {
            Flight::json([
                'code'    => 401,
                'message' => 'Unauthorized – Your API key is incorrect.'
            ], 404);
            return;
        }

        if ($accountId != 5637245) {
            Flight::json([
                'code'    => 404,
                'message' => 'Not Found – The specified resource could not be found.'
            ], 404);
            return;
        }

        $event = [
            "id" => 5201483,
            "logo" => [
                "url" => "https=>//cdn.livestream.com/newlivestream/poster-default.jpeg",
                "thumbnailUrl" => "https=>//cdn.livestream.com/newlivestream/poster-default.jpeg",
                "smallUrl" => "https=>//cdn.livestream.com/newlivestream/poster-default.jpeg"
            ],
            "description" => Flight::request()->data->description,
            "likes" => [
                "total" => 0
            ],
            "fullName" => Flight::request()->data->fullName,
            "shortName" => Flight::request()->data->shortName,
            "ownerAccountId" => $accountId,
            "viewerCount" => 0,
            "createdAt" => date('c'),
            "startTime" => Flight::request()->data->startTime ?? '',
            "endTime" => Flight::request()->data->endTime ?? '',
            "draft" => Flight::request()->data->draft ?? true,
            "tags" => explode(',', Flight::request()->data->tags ?? ''),
            "isPublic" => Flight::request()->data->isPublic ?? true,
            "isSearchable" => Flight::request()->data->isSearchable ?? true,
            "viewerCountVisible" => Flight::request()->data->viewerCountVisible ?? true,
            "postCommentsEnabled" => Flight::request()->data->postCommentsEnabled ?? true,
            "liveChatEnabled" => Flight::request()->data->liveChatEnabled ?? true,
            "isEmbeddable" => Flight::request()->data->isEmbeddable ?? true,
            "isPasswordProtected" => false,
            "isWhiteLabeled" => true,
            "embedRestriction" => "off",
            "embedRestrictionWhitelist" => [
                "*.lsops.org/*"
            ],
            "embedRestrictionBlacklist" => null,
            "isLive" => false
        ];

        $response = [];

        for ($x = 1; $x <= Flight::request()->query->maxItems; $x++) {
            $response[] = $event;
        }

        Flight::json(['data' => $response], 200);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function  authenticate(): bool
    {
        $auth = $this->get_authorization_header();

        return $this->base64url_decode(explode(' ', $auth)[1]) == 'abc:';
    }

    /**
     * Undocumented function
     *
     * @param string $data
     * @param boolean $strict
     * @return void
     */
    private function base64url_decode(string $data, bool $strict = false)
    {
        $b64 = strtr($data, '-_', '+/');
        return base64_decode($b64, $strict);
    }

    /**
     * Get Authorization Header.
     *
     * @return string|null
     */
    private function get_authorization_header(): ?string
    {
        if (isset($_SERVER['Authorization'])) {
            return trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            return trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();

            // Avoid Surprises.
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));

            if (isset($requestHeaders['Authorization'])) {
                return trim($requestHeaders['Authorization']);
            }
        }
        return null;
    }
}

$stub = new LiveStreamServerStub();

/**
 * Routes
 */
Flight::route('GET /accounts', [$stub, 'processGetAccountsRequest']);
Flight::route('GET /accounts/@acountId', [$stub, 'processGetSpecificAccountRequest']);
Flight::route('POST /accounts/@accountId/events', [$stub, 'processCreateEventRequest']);
Flight::route('PUT /accounts/@accountId/events/@eventId', [$stub, 'processUpdateEventRequest']);
Flight::route('PUT /accounts/@accountId/events/@eventId/logo', [$stub, 'processUpdateEventPosterRequest']);
Flight::route('GET /accounts/@accountId/draft_events', [$stub, 'processGetDraftEvents']);

/**
 * Configurations
 */
Flight::set('flight.log_errors', true);

/**
 * 3, 2, 1 Lift Off!
 */
Flight::start();
