<?php

namespace LiveStream;

use Exception;
use LiveStream\Resources\Account;
use LiveStream\Exceptions\LiveStreamException;

class LiveStream
{
    /**
     * Live Stream API Base URL.
     */
    const BASE_URL = 'https://livestreamapis.com/v3/';

    const ERROR_CODES = [
        400 => 'Bad Request: Your request is not properly constructed.',
        401 => 'Unauthorized: Your API key is incorrect.'
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
     * CURL Request
     *
     * @param  string $endpoint
     * @return 
     */
    private function request(string $endpoint): ?string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::BASE_URL . $endpoint);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ':');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code == 200 || $code == 201) return $response;

        if ($code == 404) return null;

        if ($code <= 199) throw new Exception("A CURL erorr with code '$code', has occurred.");

        throw new LiveStreamException(self::ERROR_CODES[$code]);
    }
}
