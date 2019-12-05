<?php
declare(strict_types=1);
namespace Vms;

class Vms
{
    // @var string The API key to be used for requests.
    public static $apiKey;

    // @var string The base URL for the VMS API.
    public static $apiBase = 'https://vms.sh';

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
     * Debug the requests.
     */
    public static function debug(): void
    {
        self::$debug = true;
    }
}
