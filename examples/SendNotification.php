<?php

use Engagespot\EngagespotClient;

require_once __DIR__ . '/../vendor/autoload.php';

// Your Engagespot API credentials
$apiKey = 'your-api-key';
$apiSecret = 'your-api-secret';

// Create an instance of EngagespotClient
$engagespot = new EngagespotClient($apiKey, $apiSecret);

// Set additional configuration if needed
$engagespot->setConfig('additionalConfig', 'value');

// Prepare data for sending a notification
$notificationData = [
    'notification' => [
        'title' => 'Sample Title',
        'message' => 'Sample Message',
        'icon' => 'sample-icon',
        'url' => 'https://example.com',
        'templateId' => 1,
        'templateIdentifier' => 'sampleTemplate',
        'category' => 'sampleCategory',
        'data' => [
            'attachments' => [
                [
                    'name' => 'attachment1.txt',
                    'contentType' => 'text/plain',
                    'content' => 'This is the content of attachment 1',
                ],
                [
                    'name' => 'attachment2.txt',
                    'contentType' => 'text/plain',
                    'content' => 'This is the content of attachment 2',
                ],
            ],
        ],
        'content' => [
            '/* Add your NotificationContent properties here if defined ' => '',
        ]
    ],
    'sendTo' => [
        'topics' => ['topic1', 'topic2'],
        'recipients' => ['user1@example.com', 'user2@example.com'],
    ],
    'override' => [
        'channels' => ['inApp', 'webPush'],
        'channel' => [
            'email' => [
                'subject' => 'Override Subject',
                'to' => ['override@example.com'],
                'cc' => ['cc@example.com'],
                'bcc' => ['bcc@example.com'],
                'replyTo' => 'reply@example.com',
                'from' => 'from@example.com',
                'body' => 'Override Body',
            ],
        ],
    ],
    'recipients' => ['user3@example.com'],
    'category' => 'overrideCategory',
    'data' => [
        'attachments' => [
            [
                'name' => 'overrideAttachment.txt',
                'contentType' => 'text/plain',
                'content' => 'This is the content of the override attachment',
            ],
        ],
    ],
];


$response = $engagespot->send($notificationData);

var_dump($response);
