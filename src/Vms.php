<?php
declare(strict_types=1);
namespace Vms;

// todo make it work with proxy
define('VMS_API_BASE_PRODUCTION', 'https://api-core.valuemystuff.com');
define('VMS_API_BASE_STAGING', 'https://api-core-staging.vms.sh');

class Vms
{
    // @var string The API key to be used for requests.
    public static $apiKey;

    // @var string The base URL for the VMS API.
    public static $apiBase = VMS_API_BASE_PRODUCTION;

    // @var bool debug requests
    public static $debug = false;

    const VERSION = '1.0.0';

    /**
     * @return string the API key used for requests
     */
    public static function getApiKey(): string
    {
        return self::$apiKey;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey): void
    {
        self::$apiKey = $apiKey;
    }

    /**
     * Sets the staging base URL.
     */
    public static function useStaging(): void
    {
        self::$apiBase = VMS_API_BASE_STAGING;
    }

    /**
     * Sets the production base URL.
     */
    public static function useProduction(): void
    {
        self::$apiBase = VMS_API_BASE_PRODUCTION;
    }

    /**
     * Debug the requests.
     */
    public static function debug(): void
    {
        self::$debug = true;
    }
}
