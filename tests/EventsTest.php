<?php

declare(strict_types=1);

namespace Tests;

use LiveStream\LiveStream;
use LiveStream\Resources\Event;
use PHPUnit\Framework\TestCase;

class EventsTest extends TestCase
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanSetFullName():void
    {
        $event = new Event("Full Name");

        $this->assertEquals('Full Name', $event->getFullName());
        $this->assertEquals('Full Name', $event->fullName);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanSetShortName():void
    {
        $event = new Event("Full Name");

        $event->setShortName("Short Name");

        $this->assertEquals('Short Name', $event->getShortName());
        $this->assertEquals('Short Name', $event->shortName);
    }
}
