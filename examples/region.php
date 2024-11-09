<?php

require __DIR__ . '/../vendor/autoload.php';

use Engagespot\EngagespotClient;

$config = [
    'apiKey' => 'xxx',
    'apiSecret' => 'xxx',
    'dataRegion' => 'eu'
];

// Create an instance of EngagespotClient
$engagespot = new EngagespotClient($config);

$notificationData = [
    'notification' => [
        'workflow' => [
            'identifier' => 'default_welcome_workflow',
        ]
    ],
    'sendTo' => [
        'recipients' => [
            'xxx-uuid'
        ]
    ]
    ];

    try{
$response = $engagespot->send($notificationData);
    }catch(Exception $e){
        echo $e->getMessage();
    }

echo $response;

// Your code to interact with Engagespot API
