<?php

declare(strict_types=1);

namespace Tests;

use BadMethodCallException;
use LiveStream\LiveStream;
use PHPUnit\Framework\TestCase;
use LiveStream\Resources\Account;
use LiveStream\Resources\Picture;


final class AccountsTest extends TestCase
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanFetchAccounts(): void
    {
        $accounts = LiveStream::getInstance('abc')->getAccounts();

        $this->assertCount(2, $accounts);

        $this->assertInstanceOf(Account::class, $accounts[0]);
        $this->assertInstanceOf(Account::class, $accounts[1]);

        $this->assertEquals(18855759, $accounts[0]->id);
        $this->assertEquals(18855759, $accounts[0]->getId());

        $this->assertEquals(18855760, $accounts[1]->id);
        $this->assertEquals(18855760, $accounts[1]->getId());
        $this->assertEquals('Apitest2', $accounts[1]->fullName);
        $this->assertEquals('Apitest2', $accounts[1]->getFullName());

        $this->assertInstanceOf(Picture::class, $accounts[0]->picture);
        $this->assertInstanceOf(Picture::class, $accounts[1]->picture);

        $this->expectException(BadMethodCallException::class);

        $accounts[0]->getNonExistentField();

        $this->expectException(BadMethodCallException::class);

        $accounts[1]->okayTheresNoWayThisWouldWork();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanFetchSpecificAccount(): void
    {
        $account = LiveStream::getInstance('abc')->getAccount(18855760);

        $this->assertInstanceOf(Account::class, $account);

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
        $account = LiveStream::getInstance('abc')->getAccount(18855762);

        $this->assertNull($account);
    }
}
