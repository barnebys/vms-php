<?php
declare(strict_types=1);


namespace Vms\Util;

use Vms\Error;

class RequestOptions
{
    public $headers;
    public $config;
    public $apiKey;
    public $apiBase;

    public function __construct(
        ?string $key = null,
        ?string $base = null,
        array $headers = [],
        array $config = []
    ) {
        $this->apiKey = $key;
        $this->apiBase = $base;
        $this->headers = $headers;
        $this->config = $config;
    }

    public static function parse(?array $options, array $config = ['timeout'  => 10.0])
    {
        if ($options instanceof self) {
            return $options;
        }

        if (is_null($options)) {
            return new RequestOptions(null, null, [], []);
        }

        if (is_array($options)) {
            $headers = [];
            $key = \Vms\Vms::$apiKey;
            $base = \Vms\Vms::$apiBase;
            if (array_key_exists('api_key', $options)) {
                $key = $options['api_key'];
            }
            if (array_key_exists('vms_version', $options)) {
                $headers['Vms-Version'] = $options['vms_version'];
            }
            if (array_key_exists('api_base', $options)) {
                $base = $options['api_base'];
            }
            return new RequestOptions($key, $base, $headers, $config);
        }

        $message = 'The second argument to VMS API method calls is an '
            . 'mandatory per-request apiKey, which must be a string, or '
            . 'per-request options, which must be an array. (HINT: you can set '
            . 'a global apiKey by "Vms::setApiKey(<apiKey>)")';
        throw new Error\Api($message);
    }
}
