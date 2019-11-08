<?php

namespace KairosPublishService;

use KairosPublisher\Kairos;

class KairosPublishService
{
    private $kairos;
    private $connectKairos;

    /**
     * constructor
     * @param Kairos $kairos
     * @return void
     */
    public function __construct(
        Kairos $kairos
    ) {
        $this->kairos = $kairos;
    }
    
    /**
     * publish message in kairos
     * @param array $data
     * @param string $pubChannel
     * @return array
     */
    public function publishKairos(
        array $data,
        string $event,
        string $pubChannel
    ): array {
        if (!$this->connectKairos) {
            $this->connectKairos = $this->kairos->connect(
                $this->getConfig('kairos_redis')
            );
        }
        $message = [
            'data' => $data,
            'event' => $event,
        ];
        return $this->kairos->publish($pubChannel, $message);
    }

    /**
     * @codeCoverageIgnore
     * get laravel config
     * @param string $config
     * @return array
     */
    public function getConfig(
        string $config
    ): array {
        return config($config);
    }
}
