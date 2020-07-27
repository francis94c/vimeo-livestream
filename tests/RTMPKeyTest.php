<?php

namespace Tests;

use LiveStream\LiveStream;
use PHPUnit\Framework\TestCase;
use LiveStream\Resources\RTMPKey;

class RTMPKeyTest extends TestCase
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanFetchRtmpKey():void
    {
        $livestream = new LiveStream('abc');

        $key = $livestream->getRtmpKey(5637245, 5201483);

        $this->assertInstanceOf(RTMPKey::class, $key);

        $this->assertEquals('m5m-25d-jr6-7yk?n=1&p=0', $key->id);
        $this->assertEquals('m5m-25d-jr6-7yk?n=1&p=0', $key->getId());

        $this->assertEquals('rtmp://rtmpin.livestreamingest.com/rtmpin', $key->getUrl());
        $this->assertEquals('rtmp://rtmpin.livestreamingest.com/rtmpin', $key->rtmpUrl);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCanResetRtmpKey():void
    {
        $livestream = new LiveStream('abc');

        $key = $livestream->resetRtmpKey(5637245, 5201483);

        $this->assertInstanceOf(RTMPKey::class, $key);

        $this->assertEquals('m5m-25d-jr6-7yk', $key->id);
        $this->assertEquals('m5m-25d-jr6-7yk', $key->getId());

        $this->assertEquals('rtmp://rtmpin.livestreamingest.com/rtmpin', $key->getUrl());
        $this->assertEquals('rtmp://rtmpin.livestreamingest.com/rtmpin', $key->rtmpUrl);
    }
}