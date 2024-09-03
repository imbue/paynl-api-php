<?php

namespace Imbue\Paynl\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Response;
use Throwable;

class ApiException extends Exception
{
    /**
     * Pay.nl status code: https://developer.pay.nl/docs/error-codes
     * @var string
     */
    protected $errorCode;

    /**
     * @var string
     */
    protected $plainMessage;

    /** @var Response */
    protected $response;

    /**
     * @param $message
     * @param $code
     * @param $errorCode
     * @param $request
     * @param Response|null $response
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = '',
        $code = 0,
        $errorCode = null,
        Response $response = null,
        Throwable $previous = null
    ) {
        $this->plainMessage = $message;

        if (!empty($errorCode)) {
            $this->errorCode = (string)$errorCode;
            $message .= ". Error code: {$this->errorCode}";
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param                $guzzleException
     * @param Throwable|null $previous
     * @return ApiException
     * @throws ApiException
     */
    public static function createFromGuzzleException($guzzleException, Throwable $previous = null)
    {
        // Not all Guzzle Exceptions implement hasResponse() / getResponse()
        if (method_exists($guzzleException, 'hasResponse') && method_exists($guzzleException, 'getResponse')) {
            if ($guzzleException->hasResponse()) {
                return static::createFromResponse($guzzleException->getResponse());
            }
        }

        return new static($guzzleException->getMessage(), $guzzleException->getCode(), null, $previous);
    }

    /**
     * @param                $response
     * @param Throwable|null $previous
     * @return ApiException
     * @throws ApiException
     */
    public static function createFromResponse($response, Throwable $previous = null)
    {
        $object = static::parseResponseBody($response);

        $errorCode = null;

        if (!empty($object->code)) {
            $errorCode = $object->code;
        } else {
            if (!empty($object->violations[0]->code)) {
                $errorCode = $object->violations[0]->code;
            }
        }

        $message = 'Error executing API call: ';

        if (!empty($object->title)) {
            $message .= "{$object->title}";
        }

        if (!empty($object->detail)) {
            $message .= " ({$object->detail})";
        }

        return new static(
            $message,
            $response->getStatusCode(),
            $errorCode,
            $response,
            $previous
        );
    }

    /**
     * The Pay.nl status code
     * @return string|null
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getPlainMessage()
    {
        return $this->plainMessage;
    }

    /**
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function hasResponse()
    {
        return $this->response !== null;
    }

    /**
     * @param $response
     * @return mixed
     * @throws ApiException
     */
    protected static function parseResponseBody($response)
    {
        $body = (string)$response->getBody();
        $object = @json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new static("Unable to decode response: '{$body}'");
        }

        return $object;
    }
}

