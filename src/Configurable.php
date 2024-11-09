<?php

namespace Engagespot;

/**
 * Configurable trait provides methods for managing configuration options.
 */
trait Configurable
{
    /**
     * Configuration storage.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Get the value of a configuration option.
     *
     * @param string $key The configuration key.
     *
     * @return mixed|null The configuration value or null if the key is not set.
     */
    public function getConfig($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : null;
    }

    /**
     * Set a configuration option.
     *
     * @param string $key   The configuration key.
     * @param mixed  $value The configuration value.
     *
     * @return void
     */
    public function setConfig($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * Get the API key.
     *
     * @return string|null The API key or null if not set.
     */
    public function getApiKey()
    {
        return $this->getConfig('apiKey');
    }

    /**
     * Set the API key.
     *
     * @param string $apiKey The API key.
     *
     * @return void
     */
    public function setApiKey($apiKey)
    {
        $this->setConfig('apiKey', $apiKey);
    }

    /**
     * Get the API secret.
     *
     * @return string|null The API secret or null if not set.
     */
    public function getApiSecret()
    {
        return $this->getConfig('apiSecret');
    }

    /**
     * Set the API secret.
     *
     * @param string $apiSecret The API secret.
     *
     * @return void
     */
    public function setApiSecret($apiSecret)
    {
        $this->setConfig('apiSecret', $apiSecret);
    }

    /**
     * Get the base URL.
     *
     * @return string|null The base URL or null if not set.
     */
    public function getBaseUrl()
    {
        $region = $this->getRegion();

        $baseUrl = rtrim($this->getConfig('baseUrl'), '/');

        if ($region) {
            switch ($region) {
                case 'us-west-2':
                    $baseUrl = 'https://api.engagespot.co';
                    break;
                case 'eu-central-1':
                    $baseUrl = 'https://api-eu.engagespot.co';
                    break;
                case 'us':
                    $baseUrl = 'https://api.engagespot.co';
                    break;
                case 'eu':
                    $baseUrl = 'https://api-eu.engagespot.co';
                    break;
                default:
                    $baseUrl = 'https://api.engagespot.co';
                    break;
            }
        }

        return $baseUrl;
    }

    /**
     * Set the base URL.
     *
     * @param string $baseUrl The base URL.
     *
     * @return void
     */
    public function setBaseUrl($baseUrl)
    {
        $this->setConfig('baseUrl', rtrim($baseUrl, '/'));
    }

    /**
     * Get the signing key.
     *
     * @return string|null The signing key or null if not set.
     */
    public function getSigningKey()
    {
        return $this->getConfig('signingKey');
    }

    /**
     * Set the signing key.
     *
     * @param string $signingKey The signing key.
     *
     * @return void
     */
    public function setSigningKey($signingKey)
    {
        $this->setConfig('signingKey', $signingKey);
    }

    /**
     * Get the region.
     *
     * @return string|null The region or null if not set.
     */
    public function getRegion()
    {
        return $this->getConfig('dataRegion');
    }

    /**
     * Set the region.
     *
     * @param string $region The region identifier (e.g., 'us', 'eu').
     *
     * @return void
     */
    public function setRegion($region)
    {
        $this->setConfig('dataRegion', $region);
    }

}
