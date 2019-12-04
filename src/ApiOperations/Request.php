<?php
declare(strict_types=1);

namespace Vms\ApiOperations;

use Vms\ApiClient;
use \GuzzleHttp\Psr7\Response;

trait Request
{
    protected static function _staticRequest(
        string $method,
        string $url,
        array $params = [],
        array $options = []
        ) : Response {
        $opts = \Vms\Util\RequestOptions::parse($options);
        $client = new ApiClient($opts);
        return $client->request($method, $url, $params);
    }


    protected static function _upload($uri, $paths, array $options = []): Response
    {
        $opts = \Vms\Util\RequestOptions::parse($options);
        $client = new ApiClient($opts);

        $multipart = [];

        foreach ($paths as $path) {
            $multipart[] = [
                "name" => basename($path),
                "contents" => fopen($path, "r")
            ];
        }

        return $client->request("post", $uri, ['multipart' => $multipart]);
    }

    /*
     *
     *     public function multipart($url, array $params)
    {
        $this->_client->post($url, [
            'multipart' => [$params]
        ]);
    }
     *
        protected static function _staticRequest(string $method, string $url, ?array $params, ?array $options): array
        {
            $opts = \Vms\Util\RequestOptions::parse($options);

            $baseUrl = isset($opts->apiBase) ? $opts->apiBase : static::baseUrl();
            $client = new ApiClient($opts->apiKey, $baseUrl);

            $response = $client->request($method, $url, $params, $opts->headers);

            return [$response, $opts];
        }

        protected static function _upload($url, $params, ?array $options): array
        {
            $opts = \Vms\Util\RequestOptions::parse($options);

            $baseUrl = isset($opts->apiBase) ? $opts->apiBase : static::baseUrl();
            $client = new ApiClient($opts->apiKey, $baseUrl);

            $response = $client->multipart($url, $params);

            dump($response);
            die;

            //$response = $client->request($method, $url, $params, $opts->headers);

            return [$response, $opts];
        }
    */
}
