<?php

namespace Engagespot\topics;


use GuzzleHttp\Exception\RequestException;
use Engagespot\EngagespotClient;

class Topics
{
    protected $client;

    public function __construct(EngagespotClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get the request handler instance.
     *
     * @return RequestHandler The request handler instance.
     */
    protected function getRequestHandler()
    {
        return $this->client->requestHandler;
    }

    /**
     * Create a new topic.
     *
     * @param string $name The name of the topic.
     * @param string|null $identifier (Optional) The identifier of the topic. If not provided, it will be generated from the name.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function create($name, $identifier = null)
    {
        try {
            // If identifier is not provided, generate it from the name
            if (empty($identifier)) {
                $identifier = strtolower(str_replace(' ', '-', $name));
            }

            return $this->getRequestHandler()->handleRequest(
                'POST',
                $this->client->getBaseUrl() . '/v3/topics',
                ['name' => $name, 'identifier' => $identifier],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Update an existing topic.
     *
     * @param int $topicId The ID of the topic to update.
     * @param string $name The new name for the topic.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function update($topicId, $name)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'PATCH',
                $this->client->getBaseUrl() . '/v3/topics/' . $topicId,
                ['name' => $name],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Delete a topic.
     *
     * @param int $topicId The ID of the topic to delete.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function delete($topicId)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'DELETE',
                $this->client->getBaseUrl() . '/v3/topics/' . $topicId,
                [],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Subscribe users to a topic.
     *
     * @param int $topicId The ID of the topic to subscribe users to.
     * @param array $users An array of user objects to subscribe. Each user object should have an identifier and channels.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function subscribeUser($topicId, $users)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'POST',
                $this->client->getBaseUrl() . '/v3/topics/' . $topicId . '/users',
                ['users' => $users],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Unsubscribe users from a topic.
     *
     * @param int $topicId The ID of the topic to unsubscribe users from.
     * @param array $users An array of user identifiers to unsubscribe.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function unsubscribeUser($topicId, $users)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'POST',
                $this->client->getBaseUrl() . '/v3/topics/' . $topicId . '/detachUsers',
                ['users' => $users],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Update notification channels for a user in a topic.
     *
     * @param string $identifier The identifier of the user whose channels are to be updated.
     * @param int $topicId The ID of the topic.
     * @param array $channels An array of notification channels for the user.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function updateChannel($identifier, $topicId, $channels)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'PUT',
                $this->client->getBaseUrl() . '/v3/topics/' . $topicId . '/users/' . $identifier,
                ['channels' => $channels],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * List subscriptions of a user to all topics.
     *
     * @param string $identifier The identifier of the user.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function listSubscriptionsOfUser($identifier)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'GET',
                $this->client->getBaseUrl() . '/v3/topics/subscriptions/' . $identifier,
                [],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Handle Guzzle HTTP request exception.
     *
     * @param RequestException $e The Guzzle HTTP request exception.
     * @throws RequestException
     */
    private function handleRequestException(RequestException $e)
    {
        throw $e;
    }
}
