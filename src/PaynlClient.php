<?php

namespace Imbue\Paynl;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Imbue\Paynl\Endpoints\PaymentMethodEndpoint;
use Imbue\Paynl\Endpoints\ServiceConfigEndpoint;
use Imbue\Paynl\Exceptions\ApiException;
use Psr\Http\Message\ResponseInterface;

class PaynlClient
{
    public const CLIENT_VERSION = '1.0.0';
    public const API_ENDPOINT = 'https://rest.pay.nl';
    public const API_VERSION = 'v3';

    public const HTTP_GET = 'GET';
    public const HTTP_POST = 'POST';
    public const HTTP_DELETE = 'DELETE';
    public const HTTP_PATCH = 'PATCH';

    /** @var int */
    private const TIMEOUT = 10;

    protected ClientInterface $httpClient;
    protected string $apiEndpoint = self::API_ENDPOINT;
    private array $versionStrings;

    private string $atCode;
    private string $apiToken;
    private string $slCode = '';

    public PaymentMethodEndpoint $paymentMethods;
    public ServiceConfigEndpoint $services;

    /**
     * @param ClientInterface|null $httpClient
     */
    public function __construct(ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?
            $httpClient :
            new Client([
                RequestOptions::TIMEOUT => self::TIMEOUT,
            ]);

        $this->initializeEndpoints();

        $this->addVersionString('Pay.nl/' . self::CLIENT_VERSION);
        $this->addVersionString('PHP/' . phpversion());
    }

    /**
     * @return void
     */
    public function initializeEndpoints()
    {
        $this->paymentMethods = new PaymentMethodEndpoint($this);
        $this->services = new ServiceConfigEndpoint($this);
    }

    /**
     * @return string
     */
    public function getApiEndpoint(): string
    {
        return $this->apiEndpoint;
    }

    public function getSlCode(): string
    {
        return $this->slCode;
    }

    public function setAuth(string $atCode, string $apiToken): void
    {
        $this->atCode = $atCode;
        $this->apiToken = $apiToken;
    }

    public function setSlCode(string $slCode): void
    {
        $this->slCode = $slCode;
    }

    /**
     * @param $versionString
     * @return $this
     */
    private function addVersionString($versionString)
    {
        $this->versionStrings[] = str_replace([" ", "\t", "\n", "\r"], '-', $versionString);
        return $this;
    }

    /**
     * @param      $httpMethod
     * @param      $apiMethod
     * @param null $httpBody
     * @return mixed|null
     * @throws ApiException
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null)
    {
        $url = $this->apiEndpoint . '/' . self::API_VERSION . '/' . $apiMethod;
        return $this->performHttpCallToFullUrl($httpMethod, $url, $httpBody);
    }

    /**
     * @param      $httpMethod
     * @param      $url
     * @param null $httpBody
     * @return mixed|null
     * @throws ApiException
     */
    public function performHttpCallToFullUrl($httpMethod, $url, $httpBody = null)
    {
        if (!$this->atCode) {
            throw new ApiException('You have not set an AT code.');
        }

        if (!$this->apiToken) {
            throw new ApiException('You have not set an API token.');
        }

        $userAgent = implode(' ', $this->versionStrings);

        $headers = [
            'Authorization' => "Basic {$this->getBasicToken()}",
            'User-Agent' => $userAgent,
        ];

        if (function_exists('php_uname')) {
            $headers['X-Pay.nl-Client-Info'] = php_uname();
        }

        $request = new Request($httpMethod, $url, $headers, $httpBody);

        try {
            $response = $this->httpClient->send($request, ['http_errors' => false]);
        } catch (GuzzleException $e) {
            throw ApiException::createFromGuzzleException($e);
        }

        if (!$response) {
            throw new ApiException('Did not receive API response.');
        }

        return $this->parseResponseBody($response);
    }

    /**
     * @param ResponseInterface $response
     * @return mixed|null
     * @throws ApiException
     */
    private function parseResponseBody(ResponseInterface $response)
    {
        $body = (string)$response->getBody();

        if (empty($body)) {
            if ($response->getStatusCode() === 204) {
                return null;
            }

            throw new ApiException('Empty response body returned.', $response->getStatusCode());
        }

        $object = @json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException("Unable to decode response: '{$body}'.", $response->getStatusCode());
        }

        if ($response->getStatusCode() >= 400) {
            throw ApiException::createFromResponse($response, null);
        }

        return $object;
    }

    private function getBasicToken(): string
    {
        return base64_encode("{$this->atCode}:{$this->apiToken}");
    }
}
