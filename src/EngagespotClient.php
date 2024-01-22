<?php

namespace Engagespot;

use Firebase\JWT\JWT;

/**
 * EngagespotClient - A client for interacting with Engagespot API.
 */
class EngagespotClient
{
    use Configurable;
    protected $requestHandler;

    /**
     * Constructor for EngagespotClient.
     *
     * @param string|array $config Either the API key (string) or an associative array of configuration options.
     * @param string|null $apiSecret The API secret for authentication.
     * @param string|null $baseUrl The base URL for Engagespot API. Default is 'https://api.engagespot.co/v3'.
     * @param string|null $signingKey The signing key for JWT tokens.
     *
     * @throws \InvalidArgumentException When apiKey or apiSecret is empty.
     */
    public function __construct($config, $apiSecret = null, $baseUrl = null, $signingKey = null)
    {
        if (is_array($config)) {
            // Configuration provided as an array
            $this->initializeFromArray($config);
        } else {
            // Configuration provided as individual parameters
            $this->initialize($config, $apiSecret, $baseUrl, $signingKey);
        }

        // Initialize the request handler.
        $this->requestHandler = new RequestHandler();
    }

    /**
     * Initialize the configuration from an associative array.
     *
     * @param array $config An associative array of configuration options.
     */
    private function initializeFromArray(array $config)
    {
        $apiKey = $config['apiKey'] ?? null;
        $apiSecret = $config['apiSecret'] ?? null;
        $baseUrl = $config['baseUrl'] ?? null;
        $signingKey = $config['signingKey'] ?? null;

        $this->initialize($apiKey, $apiSecret, $baseUrl, $signingKey);
    }

    /**
     * Initialize the configuration with individual parameters.
     *
     * @param string $apiKey The API key for authentication.
     * @param string|null $apiSecret The API secret for authentication.
     * @param string|null $baseUrl The base URL for Engagespot API.
     * @param string|null $signingKey The signing key for JWT tokens.
     */
    private function initialize($apiKey, $apiSecret = null, $baseUrl = null, $signingKey = null)
    {
        if (empty($apiKey) || empty($apiSecret)) {
            throw new \InvalidArgumentException('Both apiKey and ApiSecret are required');
        }

        // Set initial configuration options.
        $this->setConfig('apiKey', $apiKey);
        $this->setConfig('apiSecret', $apiSecret);
        $this->setConfig('baseUrl', rtrim($baseUrl ?? 'https://api.engagespot.co/v3', '/'));
        $this->setConfig('signingKey', $signingKey);
    }

    /**
     * Send a notification to Engagespot.
     *
     * @param array $data The notification data.
     *
     * @return mixed The response from the API.
     */
    public function send($data)
    {
        return $this->requestHandler->handleRequest(
            'POST',
            $this->getBaseUrl() . '/notifications',
            $data,
            $this->getRequestHeaders()
        );
    }

    /**
     * Create or update a user profile in Engagespot.
     *
     * @param string $identifier The unique identifier for the user.
     * @param array  $profile    The user profile data.
     *
     * @return mixed The response from the API.
     *
     * @throws \InvalidArgumentException When identifier or profile is empty.
     */
    public function createOrUpdateUser($identifier, $profile)
    {
        if (empty($identifier) || empty($profile)) {
            throw new \InvalidArgumentException('Identifier and profile data are required');
        }

        return $this->requestHandler->handleRequest(
            'PUT',
            $this->getBaseUrl() . '/users/' . $identifier,
            $profile,
            $this->getRequestHeaders()
        );
    }

    /**
     * Generate a JWT token for a user.
     *
     * @param string $identifier The unique identifier for the user.
     *
     * @return string The generated JWT token.
     *
     * @throws \InvalidArgumentException When signing key or user identifier is empty.
     */
    public function generateUserToken($identifier)
    {
        if (empty($identifier) || empty($this->getSigningKey())) {
            throw new \InvalidArgumentException('Both signing key and user identifier are required');
        }

        $entity = 'user';
        $entityId = $identifier;
        $apiKey = $this->getApiKey();
        $signingKey = $this->getSigningKey();

        if (empty($signingKey)) {
            throw new \InvalidArgumentException('Signing key not provided');
        }

        $payload = [
            'sub' => "$entity:$entityId",
            'apiKey' => $apiKey,
        ];

        $token = JWT::encode($payload, $signingKey, 'HS256');

        return $token;
    }

    /**
     * Get request headers including additional configuration options.
     *
     * @return array The request headers.
     */
    private function getRequestHeaders()
    {
        // Basic headers required for Engagespot API.
        $headers = [
            'Content-Type' => 'application/json',
            'X-ENGAGESPOT-API-KEY' => $this->getConfig('apiKey'),
            'X-ENGAGESPOT-API-SECRET' => $this->getConfig('apiSecret'),
        ];

        // Get additional configuration set by the user.
        $additionalConfig = $this->getAllConfig();

        // Remove keys that should not be included in headers.
        $keysToRemove = ['apiKey', 'apiSecret', 'baseUrl', 'signingKey'];
        foreach ($keysToRemove as $key) {
            unset($additionalConfig[$key]);
        }

        // Add remaining configuration to headers.
        foreach ($additionalConfig as $key => $value) {
            $headers[$key] = $value;
        }

        return $headers;
    }

    /**
     * Get all configuration options set by the user.
     *
     * @return array The configuration options.
     */
    public function getAllConfig()
    {
        return $this->config;
    }
}
