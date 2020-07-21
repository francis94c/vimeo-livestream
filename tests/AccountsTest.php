<?php

declare(strict_types=1);

namespace Tests;

use LiveStream\LiveStream;

use PHPUnit\Framework\TestCase;


final class AccountsTest extends TestCase
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanFetchAccounts(): void
    {
        $livestream = new LiveStream('abc');

        $accounts = $livestream->getAccounts();

        $this->assertCount(2, $accounts);

        $this->assertEquals(18855759, $accounts[0]->id);

        $this->assertEquals(18855760, $accounts[1]->id);
        $this->assertEquals('Apitest2', $accounts[1]->fullName);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanFetchSpecificAccount(): void
    {
        $livestream = new LiveStream('abc');

        $account = $livestream->getAccount(18855760);

        $this->assertEquals(18855760, $account->id);
        $this->assertEquals('Apitest2', $account->fullName);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanReturnNullForNonExistentAcount(): void
    {
        $livestream = new LiveStream('abc');

        $account = $livestream->getAccount(18855762);

        $this->assertNull($account);
    }
}
