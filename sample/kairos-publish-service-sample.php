<?php

require_once __DIR__ . '/../vendor/autoload.php';

use KairosPublisher\Kairos;
use KairosPublishService\KairosPublishService;

$kairosPublishService = new KairosPublishService(new Kairos);

$data = [];
$event = 'event';
$pubChannel = 'pubChannel';

$result = $kairosPublishService->publishKairos($data, $event, $pubChannel);

print_r($result);
echo PHP_EOL;
