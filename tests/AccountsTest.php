<?php 
declare(strict_types=1);

namespace Tests;

use LiveStream\LiveStream;

use PHPUnit\Framework\TestCase;


final class AccountsTest extends TestCase
{
    public function testCanFetchAccounts(): void
    {
        $livestream = new LiveStream('abc');
        
        $accounts = $livestream->getAccounts();

        $this->assertCount(2, $accounts);

        $account = $accounts[0];

        $this->assertEquals(18855759, $account->id);
    }
}
