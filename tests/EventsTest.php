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
    public function testCanSetFullName(): void
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
    public function testCanSetShortName(): void
    {
        $event = new Event("Full Name");

        $event->setShortName("Short Name");

        $this->assertEquals('Short Name', $event->getShortName());
        $this->assertEquals('Short Name', $event->shortName);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanSetStartTime(): void
    {
        $event = new Event("Full Name");

        $event->setStartTime('2020-07-21 17:59:24');

        $this->assertEquals('2020-07-21T17:59:24+00:00', $event->getStartTime());
        $this->assertEquals('2020-07-21T17:59:24+00:00', $event->startTime);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanSetEndTime(): void
    {
        $event = new Event("Full Name");

        $event->setEndTime('2020-07-21 17:59:24');

        $this->assertEquals('2020-07-21T17:59:24+00:00', $event->getEndTime());
        $this->assertEquals('2020-07-21T17:59:24+00:00', $event->endTime);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function canSetDraft(): void
    {
        $event = new Event("Full Name");

        $event->setIsDraft(true);

        $this->assertTrue($event->isDraft());
        $this->assertTrue($event->draft);

        $event->setIsDraft(false);

        $this->assertFalse($event->isDraft());
        $this->assertFalse($event->draft);

        $event->draft = true;

        $this->assertTrue($event->isDraft());
        $this->assertTrue($event->draft);

        $event->draft = false;

        $this->assertFalse($event->isDraft());
        $this->assertFalse($event->draft);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function canSetDescription(): void
    {
        $event = new Event("Full Name");

        $event->setDescription('Description 1');

        $this->assertEquals('Description 1', $event->getDescription());
        $this->assertEquals('Description 1', $event->description);

        $event->description = 'Description 2';

        $this->assertEquals('Description 2', $event->getDescription());
        $this->assertEquals('Description 2', $event->description);
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanCreateEventAndCheckDefaults(): void
    {
        $livestream = new LiveStream('abc');

        $event = new Event("Physics Live Class on Motions.");

        $livestream->createEvent(564653, $event);

        $this->assertEquals('Physics Live Class on Motions.', $event->getFullName());
        $this->assertEquals('Physics Live Class on Motions.', $event->fullName);

        // Test Defaults
        $this->assertTrue($event->isDraft());
        $this->assertTrue($event->draft);

        $this->assertEquals('', $event->getStartTime());
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanCreateEvent(): void
    {
        $livestream = new LiveStream('abc');

        $event = new Event("Physics Live Class on Motions.");

        $date = date('Y-m-d H:i:s');

        $event->setDescription("Motion")
            ->setStartTime($date)
            ->setEndTime($date)
            ->setShortName("Physics Short Name")
            ->setIsDraft(false)
            ->addTag('a')
            ->addTag('a');

        $livestream->createEvent(564653, $event);

        $this->assertEquals('Physics Live Class on Motions.', $event->getFullName());
        $this->assertEquals('Physics Live Class on Motions.', $event->fullName);

        $this->assertEquals('Motion', $event->getDescription());
        $this->assertEquals('Motion', $event->description);

        $this->assertEquals(date('c', strtotime($date)), $event->getStartTime());
        $this->assertEquals(date('c', strtotime($date)), $event->startTime);

        $this->assertEquals(date('c', strtotime($date)), $event->getEndTime());
        $this->assertEquals(date('c', strtotime($date)), $event->endTime);

        $this->assertEquals('Physics Short Name', $event->getShortName());
        $this->assertEquals('Physics Short Name', $event->shortName);

        $this->assertEquals(['a', 'a'], $event->getTags());
        $this->assertEquals(['a', 'a'], $event->tags);

        $this->assertTrue($event->getIsPublic());
        $this->assertTrue($event->isPublic);
    }
}
