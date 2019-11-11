<?php

use \Mockery;
use KairosPublishService\KairosPublishService;
use KairosPublisher\Kairos;
use PHPUnit\Framework\TestCase;

class KairosPublishServiceTest extends TestCase
{
    /**
     * @covers KairosPublishService\KairosPublishService::__construct
     */
    public function testNewKairosPublishService()
    {
        $kairosPublishService = new KairosPublishService(new Kairos);
        $this->assertInstanceOf(KairosPublishService::class, $kairosPublishService);
    }

    /**
     * @covers KairosPublishService\KairosPublishService::publishKairos
     */
    public function testPublishKairos()
    {
        $data = [
            'key' => 'value',
        ];
        $event = 'event';
        $pubChannel = 'pubChannel';

        $kairosMock = Mockery::mock(Kairos::class);

        $kairosMock->shouldReceive('connect')
            ->once()
            ->withAnyArgs()
            ->andReturn(true);

        $kairosMock->shouldReceive('publish')
            ->once()
            ->with($pubChannel, [
                'data' => $data,
                'event' => $event,
            ])
            ->andReturn([]);

        $kairosPublishServiceMock = Mockery::mock(KairosPublishService::class, [ $kairosMock ])
            ->makePartial();
        
        $kairosPublishServiceMock->connectKairos = null;

        $kairosPublishServiceMock->shouldReceive('getConfig')
            ->once()
            ->with('kairos_redis')
            ->andReturn([]);
        
        $result = $kairosPublishServiceMock->publishKairos($data, $event, $pubChannel);
        $this->assertEquals([], $result);
    }
}
