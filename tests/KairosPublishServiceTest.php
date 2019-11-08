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
        $KairosPublishService = new KairosPublishService(new Kairos);
        $this->assertInstanceOf(KairosPublishService::class, $KairosPublishService);
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

        $KairosMock = Mockery::mock(Kairos::class);

        $KairosMock->shouldReceive('connect')
            ->once()
            ->withAnyArgs()
            ->andReturn(true);

        $KairosMock->shouldReceive('publish')
            ->once()
            ->with($pubChannel, [
                'data' => $data,
                'event' => $event,
            ])
            ->andReturn([]);

        $KairosPublishServiceMock = Mockery::mock(KairosPublishService::class, [ $KairosMock ])
            ->makePartial();
        
        $KairosPublishServiceMock->connectKairos = null;

        $KairosPublishServiceMock->shouldReceive('getConfig')
            ->once()
            ->with('kairos_redis')
            ->andReturn([]);
        
        $result = $KairosPublishServiceMock->publishKairos($data, $event, $pubChannel);
        $this->assertEquals([], $result);
    }
}
