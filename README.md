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

$dataRegion = 'us'; // Optional

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

## Data Region
Data Region is an optional parameter that allows you to specify the region where the data is stored. The default region is `us`.
Learn more about [Data Region](https://documentation.engagespot.co/docs/concepts/data-region).
- `dataRegion` (optional): Specify the region for data storage and processing. Available options:
  - `us`: US West region
  - `eu`: EU Central region

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
### Managing In-App Inbox Notifications

In-app inbox notifications are messages that users can view within your application. Here's how you can manage them using the EngagespotClient:

#### 1. Initialization

Before you can interact with the in-app inbox notifications, you need to initialize the EngagespotClient with your API credentials:

```php
use Engagespot\EngagespotClient;

// Your Engagespot API credentials
$apiKey = 'your-api-key';
$apiSecret = 'your-api-secret';

// Create an instance of EngagespotClient
$client = new EngagespotClient($apiKey, $apiSecret);
```

#### 2. Fetching In-App Notifications

You can fetch in-app notifications for a specific user. This retrieves a list of notifications from the in-app inbox.

```php
$client->inapp()->fetch('john_doe_123', 1, 10);
```

- `userIdentifier`: The identifier of the user whose notifications you want to fetch.
- `pageNo` (optional): Page number of the notifications (default is 1).
- `limit` (optional): Maximum number of notifications per page (default is 10).

#### 3. Marking a Notification as Read

You can mark a notification as read once the user has viewed it.

```php
$client->inapp()->markNotificationAsRead('notification_123');
```

- `notificationId`: The ID of the notification to mark as read.

#### 4. Marking a Notification as Unseen

You can mark a notification as unseen to indicate that it hasn't been viewed by the user yet.

```php
$client->inapp()->markNotificationAsUnseen('notification_123');
```

- `notificationId`: The ID of the notification to mark as unseen.

#### 5. Marking a Notification as Unread

You can mark a notification as unread if the user has viewed it but hasn't interacted with it in a meaningful way.

```php
$client->inapp()->markNotificationAsUnread('notification_123');
```

- `notificationId`: The ID of the notification to mark as unread.

#### 6. Deleting a Notification

You can delete a notification from the in-app inbox if it's no longer relevant.

```php
$client->inapp()->deleteNotification('notification_123');
```

- `notificationId`: The ID of the notification to delete.

---

### Managing Topics

Topics allow you to organize users into groups based on their interests or preferences. Here's how you can manage topics using the EngagespotClient:

#### 1. Initialization

Before you can interact with topics, you need to initialize the EngagespotClient with your API credentials:

```php
use Engagespot\EngagespotClient;

// Your Engagespot API credentials
$apiKey = 'your-api-key';
$apiSecret = 'your-api-secret';

// Create an instance of EngagespotClient
$client = new EngagespotClient($apiKey, $apiSecret);
```

#### 2. Creating a Topic

You can create a new topic with a name and an optional identifier. If an identifier is not provided, it will be generated from the name.

```php
$client->topics()->create('New Topic', 'new-topic');
```

- `name`: The name of the topic.
- `identifier` (optional): The identifier of the topic. If not provided, it will be generated from the name.

#### 3. Updating a Topic

You can update the name of an existing topic.

```php
$client->topics()->update(123, 'Updated Topic Name');
```

- `topicId`: The ID of the topic to update.
- `name`: The new name for the topic.

#### 4. Deleting a Topic

You can delete a topic.

```php
$client->topics()->delete(123);
```

- `topicId`: The ID of the topic to delete.

#### 5. Subscribing Users to a Topic

You can subscribe users to a topic.

```php
$users = [
    ['identifier' => 'user1', 'channels' => ['web']],
    ['identifier' => 'user2', 'channels' => ['email', 'push']],
];

$client->topics()->subscribeUser(123, $users);
```

- `topicId`: The ID of the topic to subscribe users to.
- `users`: An array of user objects to subscribe. Each user object should have an identifier and channels.

#### 6. Unsubscribing Users from a Topic

You can unsubscribe users from a topic.

```php
$users = ['user1', 'user2'];

$client->topics()->unsubscribeUser(123, $users);
```

- `topicId`: The ID of the topic to unsubscribe users from.
- `users`: An array of user identifiers to unsubscribe.

#### 7. Updating Notification Channels for a User in a Topic

You can update the notification channels for a user in a topic.

```php
$client->topics()->updateChannel('user1', 123, ['email', 'push']);
```

- `identifier`: The identifier of the user whose channels are to be updated.
- `topicId`: The ID of the topic.
- `channels`: An array of notification channels for the user.

#### 8. Listing Subscriptions of a User to All Topics

You can list the subscriptions of a user to all topics.

```php
$client->topics()->listSubscriptionsOfUser('user1');
```

- `identifier`: The identifier of the user.

---


## Workflows
You can manage workflows using the EngagespotClient: currently, only the cancellation of a running workflow is supported.

### Initialization
Before you can interact with workflows, you need to initialize the EngagespotClient with your API credentials:

```php
use Engagespot\EngagespotClient;

// Your Engagespot API credentials
$apiKey = 'your-api-key';
$apiSecret = 'your-api-secret';

$dataRegion = 'us'; // Optional

// Create an instance of EngagespotClient
$client = new EngagespotClient($apiKey, $apiSecret);
``` 

### Cancel a running workflow

```php
$cancellationData = [
    'cancellationKey' => 'cancellationValue',
    'cancelFor' => [
        'recipients' => ['identifierOne', 'identifierTwo']
    ]

];
$client->workflows()->cancelRun('workflowIdentifier', $cancellationData);
```

- `identifier`: The identifier of the workflow.
- `cancellationData`: The cancellation data.

## Exceptions

The SDK throws `\InvalidArgumentException` for missing or invalid parameters during initialization or notification creation.

## Note

Replace placeholder values such as `'your-api-key'`, `'your-api-secret'`, and `'your-signing-key'` with your actual Engagespot API credentials.

For detailed information about Engagespot API parameters, refer to the [Engagespot API documentation](https://documentation.engagespot.co/docs/rest-api#tag/Notifications).

Feel free to explore and contribute to the SDK!
