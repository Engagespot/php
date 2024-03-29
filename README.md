# Engagespot PHP SDK

The Engagespot PHP SDK enables seamless integration and notification sending via the Engagespot API in PHP applications. Engagespot provides a unified platform for delivering targeted notifications to users through channels like in-app messages, web push, and email.

## Installation

Install the Engagespot PHP SDK using [Composer](https://getcomposer.org/):

```bash
composer require engagespot/php-sdk
```

## Getting Started

### Step 1: Obtain API Credentials

Sign up for an account on [Engagespot](https://www.engagespot.co/) and acquire your API key and API secret.

### Step 2: Initialize EngagespotClient

Include the Engagespot PHP SDK in your PHP code and create an instance of `EngagespotClient` with your API key, API secret, and signing key (if applicable):

here are examples of the two types of initializations for the `EngagespotClient`:

1. **Initialization with individual parameters:**

```php
use Engagespot\EngagespotClient;

$apiKey = 'your-api-key';
$apiSecret = 'your-api-secret';
$signingKey = 'your-signing-key';

// Create an instance of EngagespotClient
$engagespot = new EngagespotClient($apiKey, $apiSecret);
```

In this example, the `EngagespotClient` is initialized with individual parameters for the API key, API secret.

2. **Initialization with an associative array:**

```php
use Engagespot\EngagespotClient;

$config = [
    'apiKey' => 'your-api-key',
    'apiSecret' => 'your-api-secret',
    'signingKey' => 'your-signing-key',
    'baseUrl' => 'https://api.engagespot.co/v3'
];

// Create an instance of EngagespotClient
$engagespot = new EngagespotClient($config);
```

In this example, the `EngagespotClient` is initialized with an associative array that includes the API key, API secret, signing key, and base URL.

Remember to replace `'your-api-key'`, `'your-api-secret'`, and `'your-signing-key'` with your actual Engagespot API credentials. The base URL is optional and defaults to 'https://api.engagespot.co/v3' if not provided. The signing key is also optional and can be omitted if not used.

### Step 3: Sending a Notification


#### Sending a Notification

Prepare notification data and use the `send` method:

### Legacy Payload

```php
$notificationData = [
    'notification' => [
        'title' => 'Sample Title',
        'message' => 'Sample Message',
        'icon' => 'sample-icon',
        'url' => 'https://example.com',
        'templateId' => 1,
    ],
    'override' => [
        'channels' => ['inApp', 'webPush'],
        // other properties you want ot override
    ],
    'recipients' => ['user3@example.com'],
    'category' => 'overrideCategory',
    'data' => [
        // custom data as you needed
        ],
    ],
];

$response = $engagespot->send($notificationData);

// Handle the response as needed
var_dump($response);
```

### Preferred Payload

```php
$notificationData = [
    'notification' => [
        'title' => 'Sample Title',
        'message' => 'Sample Message',
        'icon' => 'sample-icon',
        'url' => 'https://example.com',
        'templateIdentifier' => 'sampleTemplate',
        'category' => 'sampleCategory',
        'data' => [
            // custom data as you need
        ],
    ],
    'sendTo' => [
        'topics' => ['topic1', 'topic2'],
        'recipients' => ['user1@example.com', 'user2@example.com'],
    ],
    'override' => [
        'channels' => ['inApp', 'webPush'],
        // other properties you want to override
    ],
];
```

### Sending the notification

```php
 $response = $engagespot->send($notificationData);
```
### Create OR Update User

```php
use Engagespot\EngagespotClient;

$identifier = 'johndoe@test.com'; // your unique identifier
$profile = [
    'email' => 'johndoe@test.com',
    'any_key' => 'any_value'
];

$engagespot = new EngagespotClient($apiKey, $apiSecret);
$enagagespot->createOrUpdateUser($identifier, $profile);

```
You can add any keyvalue pairs to profile.


#### Generating User Token

Generate a JWT token for a user for authentication:


Note : Remember that for generating user token you must need to Initialize engagespot via associative array  OR by 
```php 
$enagagespot->setSigningKey($signingKey);
```
because signingKey is required for generating user tokens


```php
use Engagespot\EngagespotClient;


$apiKey = 'your-api-key';
$apiSecret = 'your-api-secret';
$signingKey = 'your-signing-key';

// Create an instance of EngagespotClient
$engagespot = new EngagespotClient( [
    'apiKey' => $apiKey,
    'apiSecret' => $apiSecret,
    'signingKey' => $signingKey,
    'baseUrl' => 'https://api.engagespot.co/v3' // optional
]);

OR

// Create an instance of EngagespotClient
$engagespot = new EngagespotClient($apiKey, $apiSecret);
$enagagespot->setSigningKey($signingKey);


// Create JWT token for user
$userIdentifier = 'testuser@example.com';
$token = $engagespot->generateUserToken($userIdentifier);

// Use the generated token as needed
var_dump($token);
```

### Creating Signing Key

You can generate your public-private signing key pair from Engagespot console, and this private key should be the secret signing key for generating user tokens

<img width="698" alt="signing_key-71ae93037d6197a7db8a1894c2293079" src="https://github.com/Engagespot/php/assets/129726530/6dfe590a-fd57-4ef0-a0b7-83cee8470538">

NOTE: When you generate the signing key, Engagespot will store <b>only</b> the public key in our database.
You should download the private key and use it for signing your user tokens. You won't be able to retrieve the private key after this step.


### Additional Configuration

Set additional configuration options if needed:

```php
$engagespot->setConfig('additionalConfig', 'value');
```
You can set SigningKey after initializing `EngagespotClient` by

```php

$signingKey = 'your-signing-key';
$enagagespot->setSigningKey($signingKey);

```

## Exceptions

The SDK throws `\InvalidArgumentException` for missing or invalid parameters during initialization or notification creation.

## Note

Replace placeholder values such as `'your-api-key'`, `'your-api-secret'`, and `'your-signing-key'` with your actual Engagespot API credentials.

For detailed information about Engagespot API parameters, refer to the [Engagespot API documentation](https://documentation.engagespot.co/docs/rest-api#tag/Notifications).

Feel free to explore and contribute to the SDK!
