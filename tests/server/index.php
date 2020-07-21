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
    public function processGetSpecificAccountRequest(int $accountId):void
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
    public function processCreateEventRequest(): void
    {
    }
}

$stub = new LiveStreamServerStub();

/**
 * Routes
 */
Flight::route('GET /accounts', [$stub, 'processGetAccountsRequest']);
Flight::route('GET /accounts/@acountId', [$stub, 'processGetSpecificAccountRequest']);

/**
 * Configurations
 */
Flight::set('flight.log_errors', true);

/**
 * 3, 2, 1 Lift Off!
 */
Flight::start();
