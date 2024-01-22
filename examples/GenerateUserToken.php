<?php

use Engagespot\EngagespotClient;

require_once __DIR__ . '/../vendor/autoload.php';

$apiKey = 'your-api-key';
$apiSecret = 'your-api-secret';
$signingKey = 'your-signing-key';

$userIdentifier = 'testuser@example.com';

// Create an instance of EngagespotClient
$engagespot = new EngagespotClient($apiKey, $apiSecret, $baseUrl = null, $signingKey);
$response = $engagespot->generateUserToken($userIdentifier);

var_dump($response);
