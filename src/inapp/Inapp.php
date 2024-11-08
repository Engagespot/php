<?php

namespace Engagespot\inapp;

use GuzzleHttp\Exception\RequestException;
use Engagespot\EngagespotClient;

class Inapp
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
     * Fetch notifications from the in-app inbox.
     *
     * @param string $userIdentifier The identifier of the user.
     * @param int $pageNo The page number.
     * @param int $limit The limit of notifications per page.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function fetch($userIdentifier, $pageNo = 1, $limit = 20)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'GET',
                $this->client->getBaseUrl() . '/v3/notifications',
                [
                    'pageNo' => $pageNo,
                    'limit' => $limit,
                    'userIdentifier' => $userIdentifier,
                ],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Mark a notification as read.
     *
     * @param string $notificationId The ID of the notification.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function markNotificationAsRead($notificationId)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'PATCH',
                $this->client->getBaseUrl() . '/v3/notifications/' . $notificationId . '/click',
                ['read' => true],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Mark a notification as unseen.
     *
     * @param string $notificationId The ID of the notification.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function markNotificationAsUnseen($notificationId)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'DELETE',
                $this->client->getBaseUrl() . '/v3/notifications/' . $notificationId . '/views',
                [],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Mark a notification as unread.
     *
     * @param string $notificationId The ID of the notification.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function markNotificationAsUnread($notificationId)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'DELETE',
                $this->client->getBaseUrl() . '/v3/notifications/' . $notificationId . '/reads',
                [],
                $this->client->getRequestHeaders()
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    /**
     * Delete a notification.
     *
     * @param string $notificationId The ID of the notification.
     * @return mixed The response from the API.
     * @throws RequestException
     */
    public function deleteNotification($notificationId)
    {
        try {
            return $this->getRequestHandler()->handleRequest(
                'DELETE',
                $this->client->getBaseUrl() . '/v3/notifications/' . $notificationId,
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
