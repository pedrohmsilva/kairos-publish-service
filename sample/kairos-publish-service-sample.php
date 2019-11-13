<?php

require_once __DIR__ . '/../vendor/autoload.php';

use KairosPublisher\Kairos;
use KairosPublishService\KairosPublishService;
use Illuminate\Support\Facades\Config;

$app = new Laravel\Lumen\Application(dirname(__DIR__));
$app->withFacades();

Config::set('kairos_redis', [[
  'host' => '127.0.0.1',
  'port' => '6379',
]]);

$kairosPublishService = new KairosPublishService(new Kairos);

$data = [];
$event = 'event';
$pubChannel = 'pubChannel';

$result = $kairosPublishService->publishKairos($data, $event, $pubChannel);

print_r($result);
echo PHP_EOL;
