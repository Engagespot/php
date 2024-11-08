<?php

namespace Engagespot\workflows;

use GuzzleHttp\Exception\RequestException;
use Engagespot\EngagespotClient;

class Workflows
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
     * Cancel a running workflow.
     *
     * @param string $identifier The unique identifier of the workflow.
     * @param array|null $data cancellation data.
     * @return mixed The response from the API.
     *
     * @throws \InvalidArgumentException When identifier is empty.
     */
    public function cancelRun($identifier, $data)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException("cancellationKey  required in cancellation data");
        }
        if (empty($identifier)) {
            throw new \InvalidArgumentException('Workflow identifier is required');
        }
        try {
            return $this->client->requestHandler->handleRequest(
                'PATCH',
                $this->client->getBaseUrl() . '/v4/workflows/' . $identifier,
                $data,
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
