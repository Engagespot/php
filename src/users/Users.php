<?php

namespace Engagespot\users;


use GuzzleHttp\Exception\RequestException;
use Engagespot\EngagespotClient;

class Users
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
     * Create or update a user profile in Engagespot.
     *
     * @param string $identifier The unique identifier for the user.
     * @param array|null $profile The user profile data.
     *
     * @return mixed The response from the API.
     *
     * @throws \InvalidArgumentException When identifier is empty.
     * @throws RequestException
     */
    public function createOrUpdateUser($identifier, $profile = null)
    {
        if (empty($identifier)) {
            throw new \InvalidArgumentException('Identifier is required');
        }

        try {
            return $this->getRequestHandler()->handleRequest(
                'PUT',
                $this->client->getBaseUrl() . '/v3/users/' . $identifier,
                $profile,
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Delete a user from Engagespot.
     *
     * @param string $identifier The identifier of the user to delete.
     *
     * @return mixed The response from the API.
     *
     * @throws \InvalidArgumentException When identifier is empty.
     * @throws RequestException
     */
    public function delete($identifier)
    {
        if (empty($identifier)) {
            throw new \InvalidArgumentException('Identifier is required');
        }

        try {
            return $this->getRequestHandler()->handleRequest(
                'DELETE',
                $this->client->getBaseUrl() . '/v3/users/' . $identifier,
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
     *
     * @throws RequestException
     */
    private function handleRequestException(RequestException $e)
    {
        throw $e;
    }
}
