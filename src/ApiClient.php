<?php
declare(strict_types=1);
namespace Vms;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class ApiClient
{
    private $_client;

    public function __construct(Util\RequestOptions $opts)
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());

        $stack->push(Middleware::prepareBody());
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($opts) {
            return $request->withHeader('Authorization', $opts->apiKey);
        }));

        foreach ($opts->headers as $name => $value) {
            $stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($opts, $name, $value) {
                return $request->withHeader($name, $value);
            }));
        }

        $client = new Client(array_merge([
            'base_uri' => $opts->apiBase,
            'handler' => $stack,
        ], $opts->config));

        /** @var HandlerStack $handler */
        $handler = $client->getConfig('handler');
        $handler->push(Middleware::mapResponse(function (\Psr\Http\Message\ResponseInterface $response) {
            return new ApiJsonAwareResponse(
                $response->getStatusCode(),
                $response->getHeaders(),
                $response->getBody(),
                $response->getProtocolVersion(),
                $response->getReasonPhrase()
            );
        }), 'json_decode_middleware');

        $this->_client = $client;
    }

    public function getClient(): \GuzzleHttp\Client
    {
        return $this->_client;
    }

    public function request($method, $uri, $params = []): Response
    {
        if (isset($params['query'])) {
            $uri .= '?' . http_build_query($params['query']);
            unset($params['query']);
        }

        $response = $this->_client->request(strtoupper($method), $uri, $this->buildParams($params));
        if ($response->getStatusCode() >= 400) {
            $json = $response->getBody();
            if ($json instanceof \GuzzleHttp\Psr7\Stream) {
                throw new Error\Api((string) $json . " [$uri] (" . $response->getStatusCode() . ')');
            } else {
                throw new Error\Api($json['error'] . " [$uri] (" . $response->getStatusCode() . ')');
            }
        }

        return $response;
    }

    private function buildParams(array $params)
    {
        if (Vms::$debug) {
            $clientHandler = $this->_client->getConfig('handler');
            // Create a middleware that echoes parts of the request.
            $tapMiddleware = Middleware::tap(function ($request) {
                echo 'Req Content Type: ' . $request->getHeaderLine('Content-Type') . PHP_EOL;
                echo 'Req Body: ' . $request->getBody() . PHP_EOL;
            });

            $params['debug'] = Vms::$debug;
            $params['handler'] = $tapMiddleware($clientHandler);
        }

        return $params;
    }

    /*
    public function request($method, $url, $params, $headers = []): Response
    {
        $response = $this->_client->{$method}($url);
        $this->response = $response;

        if ($response->getStatusCode() > 200) {
            $contents = $response->getBody()->getContents();
            $this->json = json_decode($contents, true);
            throw new Error\Api($this->json['error'] . " [$url]");
        }

        return $response;
    }

    public function get(string $url, array $options = []): self
    {
        $response = $this->_client->get($url, $options);
        $this->contents = $response->getBody()->getContents();
        $this->json = json_decode($this->contents, true);

        if ($response->getStatusCode() > 200) {
            throw new Error\Api($this->json['error'] . " [$url]");
        }

        return $this;
    }

    public function multipart($url, array $params)
    {
        $this->_client->post($url, [
            'multipart' => [$params]
        ]);
    }
    */
}
