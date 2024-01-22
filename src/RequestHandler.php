<?php

namespace Engagespot;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * RequestHandler - A class for handling HTTP requests.
 */
class RequestHandler
{
    private $httpClient;

    /**
     * Constructor for RequestHandler.
     */
    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * Handle an HTTP request.
     *
     * @param string $method  The HTTP method (GET, POST, PUT, DELETE, etc.).
     * @param string $url     The URL to send the request to.
     * @param array  $data    The request data (e.g., JSON payload).
     * @param array  $headers The request headers.
     *
     * @return string The response body.
     */
    public function handleRequest($method, $url, $data, $headers)
    {
        try {
            $options = [
                'headers' => $headers,
                'json' => $data,
            ];
            $response = $this->httpClient->request($method, $url, $options);

            $responseBody = $response->getBody()->getContents();
            return $responseBody;

        } catch (ClientException $e) {

            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                return $responseBody;
            } else {

                return "An error occurred.";
            }
        } catch (GuzzleException $e) {
            return "An error occurred: " . $e->getMessage();
        } catch (\Exception $e) {
            return "An error occurred: " . $e->getMessage();
        }
    }
}
